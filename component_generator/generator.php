<?php
if (empty ($_POST ['prefix'])) $prefix = "";
else $prefix = $_POST ['prefix'];
include_once 'replace.php';
include_once 'helpers.php';
?>

<br />
<br />
<br />

<?php
$name = $_POST ['name'];
$tabla = str_replace ($prefix, "", $_POST ['tabla']);
$campos [] = array ();

$i = 0;
foreach ( $_POST ['fields'] as $v ){
  $campos [$i] ['field'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['types'] as $v ){
  $campos [$i] ['type'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['nulls'] as $v ){
  $campos [$i] ['null'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['keys'] as $v ){
  $campos [$i] ['key'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['defaults'] as $v ){
  $campos [$i] ['default'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['extras'] as $v ){
  $campos [$i] ['extra'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['jtypes'] as $v ){
  $campos [$i] ['jtype'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['lists'] as $v ){
  $campos [$i] ['list'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['forms'] as $v ){
  $campos [$i] ['form'] = $v;
  $i ++;
}
$i = 0;
foreach ( $_POST ['requireds'] as $v ){
  $campos [$i] ['required'] = $v;
  $i ++;
}


function replaceAdmin ($name, $tabla, $campos) {
  
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
  
  $com = ucwords (strtolower ($name));
  $tab = $tabla;
  $ruta = 'com_' . $name . '/administrator/controllers/';
  copy ($ruta . 'controllers.php', $ruta . $tab . 's.php');
  $content = file_get_contents ($ruta . $tab . 's.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . $tab . 's.php', $content);
  copy ($ruta . 'table.php', $ruta . $tab . '.php');
  $content = file_get_contents ($ruta . $tab . '.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[table]", ucwords (strtolower ($tabla)), $content);
  file_put_contents ($ruta . $tab . '.php', $content);

  
  // /helpers
  $com = strtolower ($name);
  $comUC = ucwords (strtolower ($name));
  $comu = strtoupper ($name);
  $ruta = 'com_' . $name . '/administrator/helpers/';
  copy ($ruta . 'component.php', $ruta . $com . '.php');
  $content = file_get_contents ($ruta . $com . '.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comu]", $comu, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  file_put_contents ($ruta . $com . '.php', $content);

  
  // /models
  
  // model
  $ruta = 'com_' . $name . '/administrator/models/';
  $plantilla = $ruta . 'form.php';
  copy ($plantilla, $ruta . $tabla . '.php');
  $content = file_get_contents ($ruta . $tabla . '.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comu]", $comu, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . $tabla . '.php', $content);
  
  // models
  $camposstring = "";
  foreach ( $campos as $v ){
    $camposstring .= "'" . $v ['field'] . "', 'a." . $v ['field'] . "', \n";
  }
  
  $plantilla = $ruta . 'forms.php';
  copy ($plantilla, $ruta . $tabla . 's.php');
  $content = file_get_contents ($ruta . $tabla . 's.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comu]", $comu, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[CAMPOS]", $camposstring, $content);
  file_put_contents ($ruta . $tabla . 's.php', $content);
  
  // /models/forms
  $ruta = 'com_' . $name . '/administrator/models/forms/';
  $plantilla = $ruta . 'table.xml';
  copy ($plantilla, $ruta . $tabla . '.xml');
  $content = file_get_contents ($ruta . $tabla . '.xml');
  $content = str_replace ("[CAMPOS]", $camposxml, $content);
  file_put_contents ($ruta . $tabla . '.xml', $content);

  
  // /tables
  $ruta = 'com_' . $name . '/administrator/tables/';
  $plantilla = $ruta . 'table.php';
  copy ($plantilla, $ruta . $tabla . '.php');
  $content = file_get_contents ($ruta . $tabla . '.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . $tabla . '.php', $content);

  
  // views
  $ruta = 'com_' . $name . '/administrator/views/';
  if (!file_exists ($ruta . $tabla)) mkdir ($ruta . $tabla);

  if (!file_exists ($ruta . $tabla . 's')) mkdir ($ruta . $tabla . 's');

  
  // views/table
  $ruta = 'com_' . $name . '/administrator/views/' . $tabla . '/';
  $rutap = 'com_' . $name . '/administrator/views/table/';
  $plantilla = $rutap . 'index.html';
  copy ($plantilla, $ruta . 'index.html');
  $plantilla = $rutap . 'view.html.php';
  copy ($plantilla, $ruta . 'view.html.php');
  $content = file_get_contents ($ruta . 'view.html.php');
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[tableUP]", strtoupper ($tabla), $content);
  $content = str_replace ("[comu]", $comu, $content);
  file_put_contents ($ruta . 'view.html.php', $content);
  
  // views/table/tmpl
   if (!file_exists ($ruta . 'tmpl')) mkdir ($ruta . 'tmpl');
  $ruta = 'com_' . $name . '/administrator/views/' . $tabla . '/tmpl/';
  $rutap = 'com_' . $name . '/administrator/views/table/tmpl/';
  $plantilla = $rutap . 'index.html';
  copy ($plantilla, $ruta . 'index.html');
  $plantilla = $rutap . 'edit.php';
  copy ($plantilla, $ruta . 'edit.php');
  $content = file_get_contents ($ruta . 'edit.php');
  
  /*
   * <div class="control-group"> <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div> <div class="controls"><?php echo $this->form->getInput('state'); ?></div> </div>
   */
  $camposform = "";
  foreach ( $campos as $v ){
    $camposform .= '<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel(\'' . $v ['field'] . '\'); ?></div>
				<div class="controls"><?php echo $this->form->getInput(\'' . $v ['field'] . '\'); ?></div>
			</div>';
  }
  
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[camposform]", $camposform, $content);
  file_put_contents ($ruta . 'edit.php', $content);
  
  // views/tables
  $ruta = 'com_' . $name . '/administrator/views/' . $tabla . 's/';
  $rutap = 'com_' . $name . '/administrator/views/tables/';
  $plantilla = $rutap . 'index.html';
  copy ($plantilla, $ruta . 'index.html');
  $plantilla = $rutap . 'view.html.php';
  copy ($plantilla, $ruta . 'view.html.php');
  $content = file_get_contents ($ruta . 'view.html.php');
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[tableU]", ucwords (strtolower ($tabla)), $content);
  $content = str_replace ("[tableUP]", strtoupper ($tabla), $content);
  $content = str_replace ("[comu]", $comu, $content);
  /*
   * 'a.id' => JText::_('JGRID_HEADING_ID'), 'a.ordering' => JText::_('JGRID_HEADING_ORDERING'), 'a.state' => JText::_('JSTATUS'), 'a.checked_out' => JText::_('COM_GP_WINES_CHECKED_OUT'), 'a.checked_out_time' => JText::_('COM_GP_WINES_CHECKED_OUT_TIME'), 'a.created_by' => JText::_('COM_GP_WINES_CREATED_BY'), 'a.title' => JText::_('COM_GP_WINES_TITLE'), 'a.breeding' => JText::_('COM_GP_WINES_BREEDING'),
   */
  $camposshort = "";
  foreach ( $campos as $v ){
    $camposshort .= "'a." . $v ['field'] . "' => JText::_('JGRID_HEADING_" . strtoupper ($v ['field']) . "'),";
  }
  $content = str_replace ("[camposshort]", $camposshort, $content);
  file_put_contents ($ruta . 'view.html.php', $content);
  
  // views/tables/tmpl
    if (!file_exists ($ruta . 'tmpl'))mkdir ($ruta . 'tmpl');
  $ruta = 'com_' . $name . '/administrator/views/' . $tabla . 's/tmpl/';
  $rutap = 'com_' . $name . '/administrator/views/tables/tmpl/';
  $plantilla = $rutap . 'index.html';
  copy ($plantilla, $ruta . 'index.html');
  $plantilla = $rutap . 'default.php';
  copy ($plantilla, $ruta . 'default.php');
  $content = file_get_contents ($ruta . 'default.php');
  
  /*
   * <th class='left'> <?php echo JHtml::_('grid.sort', 'COM_GP_WINES_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?> </th> <th class='left'> <?php echo JHtml::_('grid.sort', 'COM_GP_WINES_TITLE', 'a.title', $listDirn, $listOrder); ?> </th> <th class='left'> <?php echo JHtml::_('grid.sort', 'COM_GP_WINES_BREEDING', 'a.breeding', $listDirn, $listOrder); ?> </th>
   */
  $headers = "";
  foreach ( $campos as $v ){
    $headers .= "<th class='left'>
               <?php echo JHtml::_('grid.sort',  'COM_" . $comu . "_" . strtoupper ($tabla) . "S_" . strtoupper ($v ['field']) . "'
                      , 'a." . $v ['field'] . "', \$listDirn, \$listOrder); ?>
               </th>";
  }
  $content = str_replace ("[headers]", $headers, $content);
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . 'default.php', $content);
  
  // administrator
  $ruta = 'com_' . $name . '/administrator/';
  $content = file_get_contents ($ruta . 'access.xml');
  $content = str_replace ("[com]", $com, $content);
  file_put_contents ($ruta . 'access.xml', $content);
  
  if(file_exists($ruta . 'component.php'))
    rename ($ruta . 'component.php', $ruta . $name . '.php');
  $content = file_get_contents ($ruta . $name . '.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  file_put_contents ($ruta . $name . '.php', $content);
  
  $content = file_get_contents ($ruta . 'config.xml');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comu]", $comu, $content);
  file_put_contents ($ruta . 'config.xml', $content);
  
  $content = file_get_contents ($ruta . 'controller.php');
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comUC]", $comUC, $content);
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . 'controller.php', $content);
  
  // assets
  $ruta = 'com_' . $name . '/administrator/assets/css/';
  if(file_exists($ruta . 'component.css'))
    rename ($ruta . 'component.css', $ruta . $name . '.css');
  $content = file_get_contents ($ruta . $name . '.css');
  $content = str_replace ("[table]", $tabla, $content);
  file_put_contents ($ruta . $name . '.css', $content);
  
  // component
  $ruta = 'com_' . $name . '/';
  if(file_exists($ruta . 'component.xml'))
    rename ($ruta . 'component.xml', $ruta . $name . '.xml');
  $content = file_get_contents ($ruta . $name . '.xml');
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[com]", $com, $content);
  $content = str_replace ("[comu]", $comu, $content);
  file_put_contents ($ruta . $name . '.xml', $content);
  
  // sql
  $ruta = 'com_' . $name . '/administrator/sql/';
  $content = file_get_contents ($ruta . 'install.mysql.utf8.sql');
  
  /*
   * `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, field type null key default extra
   */
  $campossql = "";
  foreach ( $campos as $v ){
    $campossql .= "`" . $v ['field'] . "` " . $v ['type'] . " " . $v ['null'] . " " . $v ['key'] . " " . $v ['default'] . " " . $v ['extra'] . ", ";
  }
  $content = str_replace ("[campossql]", $campossql, $content);
  $content = str_replace ("[table]", $tabla, $content);
  $content = str_replace ("[com]", $com, $content);
  file_put_contents ($ruta . 'install.mysql.utf8.sql', $content);
}

function replaceFront($name, $tabla, $campos) {
  $componentsite = 'com_' . $name . '/site/';
  $rutas = array();
  //creo un array con las rutas de los archivos
  $rutas[] = $componentsite. 'controllers/';
  $rutas[] = $componentsite. 'controllers/table.php';
  $rutas[] = $componentsite. 'controllers/tables.php';
  $rutas[] = $componentsite. 'helpers/';
  $rutas[] = $componentsite. 'helpers/component.php';
  $rutas[] = $componentsite. 'language/';
  $rutas[] = $componentsite. 'models/';
  $rutas[] = $componentsite. 'models/fields/';
  $rutas[] = $componentsite. 'models/forms/';
  $rutas[] = $componentsite. 'models/table.php';
  $rutas[] = $componentsite. 'models/tables.php';
  $rutas[] = $componentsite. 'views/';
  $rutas[] = $componentsite. 'views/table/';
  $rutas[] = $componentsite. 'views/table/tmpl';
  $rutas[] = $componentsite. 'views/table/tmpl/default.xml';
  $rutas[] = $componentsite. 'views/table/tmpl/default.php';
  $rutas[] = $componentsite. 'views/table/tmpl/index.html';  //ruta necesaria para limpiar
  $rutas[] = $componentsite. 'views/table/index.html';  //ruta necesaria para limpiar
  $rutas[] = $componentsite. 'views/table/view.html.php';
  $rutas[] = $componentsite. 'views/tables/';
  $rutas[] = $componentsite. 'views/tables/tmpl/';
  $rutas[] = $componentsite. 'views/tables/tmpl/default.xml';
  $rutas[] = $componentsite. 'views/tables/tmpl/default.php';
  $rutas[] = $componentsite. 'views/tables/tmpl/index.html'; //ruta necesaria para limpiar
  $rutas[] = $componentsite. 'views/tables/view.html.php';
  $rutas[] = $componentsite. 'views/tables/index.html'; //ruta necesaria para limpiar
  $rutas[] = $componentsite. 'component.php';
  $rutas[] = $componentsite. 'controller.php';
  $rutas[] = $componentsite. 'router.php';
  
  $rutaOK = "";
  //recorro las rutas
  foreach($rutas as $r){
    // condiciones para copias de archivos
    if(strpos($r, 'tables') !== false){
      $rutaOK = str_replace('tables', $tabla, $r);
      echo "copiando1 $r     -->     $rutaOK <br />";
      if(esArchivo($rutaOK)){
        duplica($r, $rutaOK, $name, $tabla);
        replace($rutaOK,$name,$tabla,$campos);
      }
      else{
        if(!file_exists($rutaOK)) full_copy($r,$rutaOK);
      }
    }
    elseif(strpos($r, 'table') !== false){
      $rutaOK = str_replace('table', singularize($tabla), $r);
      echo "copiando2 $r     -->     $rutaOK <br />";
      if(esArchivo($rutaOK)){
          duplica($r, $rutaOK, $name, $tabla);
          replace($rutaOK,$name,$tabla,$campos);
      }
      else{
        if(!file_exists($rutaOK)) full_copy($r,$rutaOK);
      }
    }
    elseif(strpos($r, 'component') !== false){
      $rutaOK = str_replace('component', $name, $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if(esArchivo($rutaOK)){
        duplica($r, $rutaOK, $name, $tabla);
        replace($rutaOK,$name,$tabla,$campos);
      }
      else{
        if(!file_exists($rutaOK)) full_copy($r,$rutaOK);
      }
    }
    else {
      $rutaOK = $r;
      if(esArchivo($rutaOK)){
        echo "copiando $r  to  $rutaOK <br />";
        //duplica($r, $rutaOK, $name, $tabla);
        replace($rutaOK,$name,$tabla,$campos);
      }
    }
  }
  limpiar($rutas);
}

function eliminar($ruta){
  if(strpos($ruta,'view.html.php') !== false || strpos($ruta,'default') !== false
  || strpos($ruta,'controller.php') !== false || strpos($ruta,'router') !== false)
    return false;
  if(!file_exists($ruta)) return false;
  return true;
}

function limpiar($rutas){
  $rutas = array_reverse($rutas);
  foreach($rutas as $r){
    if(esArchivo($r) || strpos($r,"index.html") !== false){
      if(eliminar($r)) unlink($r);
    }
    elseif(strpos($r,'/table/') !== false || strpos($r,'/tables/') !== false
          || strpos($r,'/tmpl/') !== false){
      rmdir($r);
    }
  }
}

if (!file_exists ('com_' . $name)) full_copy ("com_plantilla", 'com_' . $name);

replaceAdmin($name, $tabla, $campos);
replaceFront($name, $tabla, $campos);


