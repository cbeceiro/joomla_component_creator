<?php
function replace($ruta, $name, $tabla, $campos){


  $com = strtolower ($name);
  $tab = $tabla;
  $comUC = ucwords (strtolower ($name));
  $comu = strtoupper ($name);

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

  $camposstring = "";
  foreach ( $campos as $v ){
    $camposstring .= "'" . $v ['field'] . "', 'a." . $v ['field'] . "', \n";
  }

  $camposform = "";
  foreach ( $campos as $v ){
    $camposform .= '<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel(\'' . $v ['field'] . '\'); ?></div>
				<div class="controls"><?php echo $this->form->getInput(\'' . $v ['field'] . '\'); ?></div>
			</div>';
  }

  $headers = "";
  foreach ( $campos as $v ){
    $headers .= "<th class='left'>
               <?php echo JHtml::_('grid.sort',  'COM_" . $comu . "_" . strtoupper ($tabla) . "S_" . strtoupper ($v ['field']) . "'
                      , 'a." . $v ['field'] . "', \$listDirn, \$listOrder); ?>
               </th>";
  }

  $campossql = "";
  foreach ( $campos as $v ){
    $campossql .= "`" . $v ['field'] . "` " . $v ['type'] . " " . $v ['null'] . " " . $v ['key'] . " " . $v ['default'] . " " . $v ['extra'] . ", ";
  }


  $camposshort = "";
  foreach ( $campos as $v ){
    $camposshort .= "'a." . $v ['field'] . "' => JText::_('JGRID_HEADING_" . strtoupper ($v ['field']) . "'),";
  }

  replaceCamposView($ruta, $name, $tabla, $campos);

  $content = file_get_contents ($ruta);
  if(strpos($ruta,'.xml')) $content = str_replace ("[CAMPOS]", $camposxml, $content);
  else $content = str_replace ("[CAMPOS]", $camposstring, $content);
  $content = str_replace ("[camposshort]", $camposshort, $content);
  $content = str_replace ("[campossql]", $campossql, $content);
  $content = str_replace ("[camposform]", $camposform, $content);
  $content = str_replace ("[headers]", $headers, $content);
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower (singularize($tabla))), $content);
  $content = str_replace ("[tableUs]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[table]", singularize($tabla), $content);
  $content = str_replace ("[tables]",  $tabla, $content);
  $content = str_replace ("[tableUP]", strtoupper (singularize($tabla)), $content);
  $content = str_replace ("[tableUPs]", strtoupper ($tabla), $content);
  $content = str_replace ("[comu]", $comu, $content);
  $content = str_replace ("[comUC]", $comUC, $content);

  $content = str_replace ("[tables]",  $tabla, $content);
  file_put_contents ($ruta, $content);
}

function replaceCamposView($ruta, $name, $tabla, $campos){
  /*
   * <li><?php echo JText::_('COM_GP_FORM_LBL_WINE_ID'); ?>:
  <?php echo $this->item->id; ?></li>
  */

  $aux ="";
  foreach ($campos as $v){
    $aux .= '<li><?php echo JText::_(\'COM_'.strtoupper($name).'_FORM_LBL_'.strtoupper(singularize($tabla)).'_'.strtoupper($v['field']).'\'); ?>:
			<?php echo $this->item->'.$v['field'].'; ?></li>';
  }
  $content = file_get_contents ($ruta);
  $content = str_replace ("[CAMPOS]", $aux, $content);
  file_put_contents ($ruta, $content);
}
