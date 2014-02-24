<?php

function replace ($ruta, $name, $tabla, $campos) {
  $com = strtolower ($name);
  $tab = $tabla;
  $comUC = ucwords (strtolower ($name));
  $comu = strtoupper ($name);
  
  replaceCamposView ($ruta, $name, $tabla, $campos);
  
  replaceCamposHeaders ($ruta, $name, $tabla, $campos);
  
  replaceCamposShort ($ruta, $name, $tabla, $campos);
  
  replaceCamposSql ($ruta, $name, $tabla, $campos);
  
  replaceCamposString ($ruta, $name, $tabla, $campos);
  
  replaceCamposForm ($ruta, $name, $tabla, $campos);
  
  replaceCamposXml ($ruta, $name, $tabla, $campos);
  
  replaceCamposList ($ruta, $name, $tabla, $campos);
  
  insertPublishedState ($ruta, $name, $tabla, $campos);
  
  insertCreatedBy ($ruta, $name, $tabla, $campos);
  
  insertLanguage ($ruta, $name, $tabla, $campos);
  
  $content = file_get_contents ($ruta);
  
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower (singularize ($tabla))), $content);
  $content = str_replace ("[tableUs]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[table]", singularize ($tabla), $content);
  $content = str_replace ("[tables]", $tabla, $content);
  $content = str_replace ("[tableUP]", strtoupper (singularize ($tabla)), $content);
  $content = str_replace ("[tableUPs]", strtoupper ($tabla), $content);
  $content = str_replace ("[comu]", $comu, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  
  file_put_contents ($ruta, $content);
}

function replaceCamposShort ($ruta, $name, $tabla, $campos) {
  $camposshort = "";
  foreach ( $campos as $v ){
    $camposshort .= "'a." . $v ['field'] . "' => JText::_('JGRID_HEADING_" . strtoupper ($v ['field']) . "'),";
  }
  
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposshort]", $camposshort, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposSql ($ruta, $name, $tabla, $campos) {
  $campossql = "";
  foreach ( $campos as $v ){
    if ($v ['default'] != "") $def = "DEFAULT '" . $v ['default'] . "'";
    else $def = "";
    $campossql .= "`" . $v ['field'] . "` " . $v ['type'] . " " . ($v ['null'] == 'NO' ? "NOT NULL" : "NULL") . " " . $def . ",";
  }
  
  $content = file_get_contents ($ruta);
  $content = str_replace ("[campossql]", $campossql, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposHeaders ($ruta, $name, $tabla, $campos) {
  $headers = "";
  foreach ( $campos as $v ){
    if ($v ['field'] == 'ordering'){
      $headers .= '<th width="1%" class="nowrap center hidden-phone">
				<?php echo JHtml::_(\'grid.sort\', \'<i class="icon-menu-2"></i>\', \'a.ordering\', 
                $listDirn, $listOrder, null, \'asc\', \'JGRID_HEADING_ORDERING\'); ?>
			  </th>';
    }
    elseif ($v ['field'] == 'id'){
      $headers .= '<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_(\'grid.sort\', \'JGRID_HEADING_ID\', \'a.id\', $listDirn, $listOrder); ?>
					</th>';
    }
    elseif ($v ['field'] == 'state' || $v ['field'] == 'published'){
      $headers .= '<th width="1%" class="nowrap center">
						<?php echo JHtml::_(\'grid.sort\', \'JSTATUS\', \'a.state\', $listDirn, $listOrder); ?>
					</th>';
    }
    else{
      $headers .= "<th class='left'>
               <?php echo JHtml::_('grid.sort',  'COM_" . strtoupper ($name) . "_" . strtoupper ($tabla) . "_" . strtoupper ($v ['field']) . "'
                      , 'a." . $v ['field'] . "', \$listDirn, \$listOrder); ?>
               </th>";
    }
  }
  
  $content = file_get_contents ($ruta);
  $content = str_replace ("[headers]", $headers, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposForm ($ruta, $name, $tabla, $campos) {
  $camposform = "";
  foreach ( $campos as $v ){
    
    $camposform .= '<div class="control-group">
		      		<div class="control-label"><?php echo $this->form->getLabel(\'' . $v ['field'] . '\'); ?></div>
				  <div class="controls"><?php echo $this->form->getInput(\'' . $v ['field'] . '\'); ?></div>
			 </div>';
  }
  
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposform]", $camposform, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposXml ($ruta, $name, $tabla, $campos) {
  $camposxml = "";
  foreach ( $campos as $key => $value ){
    switch ($value ['jtype']) {
      case 'text' :
        $camposxml .= '<field name="' . $value ['field'] . '" type="text" default="' . strtoupper ($value ['default']) . '"
  	             label="COM_' . strtoupper ($name) . '_FORM_LBL_' . strtoupper ($tabla) . '_' . strtoupper ($value ['field']) . '" readonly="true" class="readonly"
                 description="JGLOBAL_FIELD_' . strtoupper ($value ['field']) . '_DESC" />';
        break;
      default :
        $camposxml .= '<field name="' . $value ['field'] . '" type="textarea" default="' . strtoupper ($value ['default']) . '"
  	             label="COM_' . strtoupper ($name) . '_FORM_LBL_' . strtoupper ($tabla) . '_' . strtoupper ($value ['field']) . '" readonly="false" class="readonly"
                 description="JGLOBAL_FIELD_' . strtoupper ($value ['field']) . '_DESC" />';
    }
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposxml]", $camposxml, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposString ($ruta, $name, $tabla, $campos) {
  $camposstring = "";
  foreach ( $campos as $v ){
    $camposstring .= "'" . $v ['field'] . "', 'a." . $v ['field'] . "', \n";
  }
  
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposstring]", $camposstring, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposView ($ruta, $name, $tabla, $campos) {
  $aux = "";
  foreach ( $campos as $v ){
    $aux .= '<li><?php echo JText::_(\'COM_' . strtoupper ($name) . '_FORM_LBL_' . strtoupper (singularize ($tabla)) . '_' . strtoupper ($v ['field']) . '\'); ?>:
			<?php echo $this->item->' . $v ['field'] . '; ?></li>';
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[CAMPOS]", $aux, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposList ($ruta, $name, $tabla, $campos) {
  $aux = "";
  foreach ( $campos as $v ){
    if ($v ['field'] == 'title'){
      $aux .= "<?php if (\$canEdit) : ?>
                  <td>
					<a href=\"<?php echo JRoute::_('index.php?option=com_[com]&task=[table].edit&id='.(int) \$item->id); ?>\">
	  				<?php echo \$this->escape(\$item->" . $v ['field'] . "); ?></a>
		  		<?php else : ?>
			  		<?php echo \$this->escape(\$item->" . $v ['field'] . "); ?>
				<?php endif; ?>
				</td>";
    }
    elseif ($v ['field'] == 'id'){
      $aux .= '<td class="center hidden-phone">
      			<?php echo $item->id; ?>
      		   </td>';
    }
    elseif ($v ['field'] == 'state' || $v ['field'] == 'published'){
      $aux .= '</td><td class="center">
						<?php echo JHtml::_(\'jgrid.published\', $item->state, $i, \'[tables].\', $canChange, \'cb\'); ?>
				</td>';
    }
    elseif ($v ['field'] == 'ordering'){
      $aux .= "<?php if (isset(\$this->items[0]->ordering)): ?>
					<td class=\"order nowrap center hidden-phone\">
					<?php
                    if (\$canChange):
                            \$disableClassName = '';
                            \$disabledLabel = '';
                            if (!\$saveOrder):
                              \$disabledLabel = JText::_ ('JORDERINGDISABLED');
                              \$disableClassName = 'inactive tip-top';
                            
                    						endif;
                            ?>
                    						<span
                    							class=\"sortable-handler hasTooltip <?php echo \$disableClassName?>\"
                    							title=\"<?php echo \$disabledLabel?>\"> <i class=\"icon-menu\"></i>
                    			</span> <input type=\"text\" style=\"display: none\" name=\"order[]\"
                    							size=\"5\" value=\"<?php echo \$item->ordering;?>\"
                    							class=\"width-20 text-area-order \" />
                    					<?php else : ?>
                    					<span class=\"sortable-handler inactive\"> <i class=\"icon-menu\"></i>
                    					</span>
                    				<?php endif; ?>
                    				</td>
                                   <?php endif; ?>";
    }
    else{
      $aux .= '<td>
                <?php echo $item->' . $v ['field'] . '; ?>
			   </td>';
    }
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposlist]", $aux, $content);
  file_put_contents ($ruta, $content);
}

function insertPublishedState ($ruta, $name, $tabla, $campos) {
  $aux = "// No hay estado ";
  foreach ( $campos as $v ){
    if ($v ['field'] == 'published' || $v ['field'] == 'state'){
      $aux = "\$published = \$this->getState('filter.state');
                if (is_numeric(\$published)) {
                \$query->where('a." . $v ['field'] . " = '.(int) \$published);
                } else if (\$published === '') {
                \$query->where('(a." . $v ['field'] . " IN (0, 1))');
                }";
      break;
    }
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[statefilter]", $aux, $content);
  file_put_contents ($ruta, $content);
}

function insertCreatedBy ($ruta, $name, $tabla, $campos) {
  $aux = "// No hay createdby";
  foreach ( $campos as $v ){
    if ($v ['field'] == 'created_by'){
      $aux = "// Join over the user field 'created_by'
		\$query->select('created_by.name AS created_by');
		\$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');";
      break;
    }
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[createdby]", $aux, $content);
  file_put_contents ($ruta, $content);
}

function insertLanguage ($ruta, $name, $tabla, $campos) {
  $aux  = 'COM_' . strtoupper ($name) . '_TITLE_' . strtoupper ($tabla) . '="'.$tabla.'"';
  $aux .= "\n".'COM_' . strtoupper ($name) . '_TITLE_LIST_VIEW_' . strtoupper ($tabla) . ' = "' . $tabla . '"';
  $aux .= "\n".'COM_' . strtoupper ($name) . '_TITLE_LIST_VIEW_' . strtoupper ($tabla) . '_DESC="Show a list of ' . $tabla . '"';
  $aux .= "\n".'COM_' . strtoupper ($name) . '_TITLE_ITEM_VIEW_' . strtoupper (singularize ($tabla)) . '= "Single ' . singularize ($tabla) . '"';
  $aux .= "\n".'COM_' . strtoupper ($name) . '_TITLE_ITEM_VIEW_' . strtoupper (singularize ($tabla)) . '_DESC = "Show a specific ' . singularize ($tabla) .'"';
  
  foreach ( $campos as $v ){
    $aux .= "\n".'COM_' . strtoupper ($name) . '_' . strtoupper ($tabla) . '_' . strtoupper ($v ['field']) . '= "' . strtoupper ($v ['field']) . '"';
    $aux .= "\n".'COM_' . strtoupper ($name) . '_FORM_LBL_'. strtoupper (singularize ($tabla)) . '_' . strtoupper ($v ['field']) . ' = "' . strtoupper ($v ['field']) . '"';
    $aux .= "\n".'COM_' . strtoupper ($name) . '_FORM_DESC_' . strtoupper (singularize ($tabla)) . '_' . strtoupper ($v ['field']) . ' = " "';
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[language]", $aux, $content);
  file_put_contents ($ruta, $content);
}
