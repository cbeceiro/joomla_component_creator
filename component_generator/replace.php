<?php

function replace ($ruta, $name, $tabla, $campos) {
  $com = strtolower ($name);
  $tab = $tabla;
  $comUC = ucwords (strtolower ($name));
  $comu = strtoupper ($name);

  replaceCamposView ($ruta, $name, $tabla, $campos);
  replaceCamposHeaders($ruta, $name, $tabla, $campos);
  replaceCamposShort($ruta, $name, $tabla, $campos);
  replaceCamposSql($ruta, $name, $tabla, $campos);
  replaceCamposString($ruta, $name, $tabla, $campos);
  replaceCamposForm($ruta, $name, $tabla, $campos);
  replaceCamposXml($ruta, $name, $tabla, $campos);
  replaceCamposList ($ruta, $name, $tabla, $campos);
  
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
    $campossql .= "`" . $v ['field'] . "` " . $v ['type'] . " " . $v ['null'] . " " . $v ['key'] . " " . $v ['default'] . " " . $v ['extra'] . ", ";
  }

  $content = file_get_contents ($ruta);
  $content = str_replace ("[campossql]", $campossql, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposHeaders ($ruta, $name, $tabla, $campos) {
  $headers = "";
  foreach ( $campos as $v ){
    $headers .= "<th class='left'>
               <?php echo JHtml::_('grid.sort',  'COM_" . strtoupper($name) . "_" . strtoupper ($tabla) . "S_" . strtoupper ($v ['field']) . "'
                      , 'a." . $v ['field'] . "', \$listDirn, \$listOrder); ?>
               </th>";
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
                 description="JGLOBAL_FIELD_' . strtoupper ($value ['field']) . '_DESC" /> \n';
        break;
      default :
        $camposxml = "este es otro tipo de campo";
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
    if($v['field'] == 'name' || $v['field'] == 'title'){
      $aux .= "<?php if (\$canEdit) : ?>
					<a href=\"<?php echo JRoute::_('index.php?option=com_[com]&task=[table].edit&id='.(int) \$item->id); ?>\">
	  				<?php echo \$this->escape(\$item->".$v['field']."); ?></a>
		  		<?php else : ?>
			  		<?php echo \$this->escape(\$item->".$v['field']."); ?>
				<?php endif; ?>
				</td>";
    }
    else{
      $aux .= '<td>
                <?php echo $item->'.$v['field'].'; ?>
			   </td>';
    }
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[camposlist]", $aux, $content);
  file_put_contents ($ruta, $content);
}
