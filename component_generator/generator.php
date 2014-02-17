<?php
if (empty ($_POST ['prefix'])) $prefix = "";
else $prefix = $_POST ['prefix'];
?>

<br />
<br />
<br />

<?php
$name = $_POST ['name'];
$tabla = str_replace($prefix,"",$_POST ['tabla']);
$campos [] = array ();

$i=0;
foreach($_POST['fields'] as $v){
  $campos[$i]['field'] = $v;
  $i++;
}
$i=0;
foreach($_POST['types'] as $v){
  $campos[$i]['type'] = $v;
  $i++;
}
$i=0;
foreach($_POST['nulls'] as $v){
  $campos[$i]['null'] = $v;
  $i++;
}
$i=0;
foreach($_POST['keys'] as $v){
  $campos[$i]['key'] = $v;
  $i++;
}
$i=0;
foreach($_POST['defaults'] as $v){
  $campos[$i]['default'] = $v;
  $i++;
}
$i=0;
foreach($_POST['extras'] as $v){
  $campos[$i]['extra'] = $v;
  $i++;
}
$i=0;
foreach($_POST['jtypes'] as $v){
  $campos[$i]['jtype'] = $v;
  $i++;
}
$i=0;
foreach($_POST['lists'] as $v){
  $campos[$i]['list'] = $v;
  $i++;
}
$i=0;
foreach($_POST['forms'] as $v){
  $campos[$i]['form'] = $v;
  $i++;
}
$i=0;
foreach($_POST['requireds'] as $v){
  $campos[$i]['required'] = $v;
  $i++;
}

// Ya tengo un array para cada campo en $campos[];
/*
 * [fields] => id [types] => int(11) unsigned [nulls] => NO [keys] => PRI [defaults] => [extras] => auto_increment [jtypes] => text [lists] => y [forms] => y [requireds] => n
 */

$camposxml = "";
foreach ( $campos as $key => $value ){
  switch ($value ['jtype']) {
    case 'text' :
      $camposxml .= '<field name="' . $value ['field'] . '" type="text" default="' . strtoupper ($value ['default']) . '" 
  	             label="COM_' . strtoupper ($name) . '_FORM_LBL_'.strtoupper($tabla).'_' . strtoupper ($value ['field']) . '" readonly="true" class="readonly"
                 description="JGLOBAL_FIELD_' . strtoupper ($value ['field']) . '_DESC" /> ';
      break;
    default :
      $camposxml = "este es otro tipo de campo";
  }
}

function full_copy ($source, $target) {
  if (is_dir ($source)){
    @mkdir ($target);
    $d = dir ($source);
    while (FALSE !== ($entry = $d->read ())){
      if ($entry == '.' || $entry == '..'){
        continue;
      }
      $Entry = $source . '/' . $entry;
      if (is_dir ($Entry)){
        full_copy ($Entry, $target . '/' . $entry);
        continue;
      }
      copy ($Entry, $target . '/' . $entry);
    }
    $d->close ();
  }
  else{
    copy ($source, $target);
  }
}


if (!file_exists ('com_' . $name)) full_copy ("com_plantilla", 'com_' . $name);

// Escribo campoxml en el archivo forms strreplace("[CAMPOS]",$campoxml,$archivoForms);
$ruta = 'com_' . $name . '/administrator/models/forms/';
$rutap = 'com_plantilla/administrator/models/forms/';
$plantilla = $rutap . 'table.xml';
copy ($plantilla, $ruta . $tabla.'.xml');
$content = file_get_contents ($ruta . $tabla.'.xml');
file_put_contents ($ruta . $tabla.'.xml', str_replace ("[CAMPOS]", $camposxml, $content));

//   /controllers
$com = ucwords(strtolower($name));
$tab = ucwords(strtolower($tabla));
$ruta = 'com_' . $name . '/administrator/controllers/';
copy ($ruta.'controllers.php',$ruta . $tabla.'.xml');
$content = file_get_contents ($ruta . $tabla.'.xml');
file_put_contents ($ruta . $tabla.'.xml', str_replace ("[CAMPOS]", $camposxml, $content));
