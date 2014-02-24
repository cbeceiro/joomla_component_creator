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
  $x = "com_$name/administrator";
  
  $rutas = array ();
  $rutas [] = "$x/";
  $rutas [] = "$x/assets/";
  $rutas [] = "$x/assets/css/";
  $rutas [] = "$x/assets/css/component.css";
  $rutas [] = "$x/assets/images/";
  $rutas [] = "$x/controllers/";
  $rutas [] = "$x/controllers/table.php";
  $rutas [] = "$x/controllers/tables.php";
  $rutas [] = "$x/helpers/";
  $rutas [] = "$x/helpers/component.php";
  $rutas [] = "$x/language/";                             //Añadiendo la parte de las traducciónes Ingles y Español
  $rutas [] = "$x/language/en-GB.com_component.ini";
  $rutas [] = "$x/language/en-GB.com_component.sys.ini";
  $rutas [] = "$x/language/es-ES.com_component.ini";
  $rutas [] = "$x/language/es-ES.com_component.sys.ini";
  $rutas [] = "$x/models/";
  $rutas [] = "$x/models/fields/";
  $rutas [] = "$x/models/forms/";
  $rutas [] = "$x/models/forms/table.xml";
  $rutas [] = "$x/models/table.php";
  $rutas [] = "$x/models/tables.php";
  $rutas [] = "$x/sql/";
  $rutas [] = "$x/sql/install.mysql.utf8.sql";
  $rutas [] = "$x/sql/uninstall.mysql.utf8.sql";
  $rutas [] = "$x/tabs/table.php"; ///cambiado el orden para que funcione el algortimo de creación
  $rutas [] = "$x/tabs/"; //cambiado el nombre para que funciones el mismo algoritmo
  $rutas [] = "$x/views/";
  $rutas [] = "$x/views/table/";
  $rutas [] = "$x/views/table/tmpl/";
  $rutas [] = "$x/views/table/tmpl/edit.php";
  $rutas [] = "$x/views/table/tmpl/index.html";
  $rutas [] = "$x/views/table/view.html.php";
  $rutas [] = "$x/views/table/index.html";
  $rutas [] = "$x/views/tables/";
  $rutas [] = "$x/views/tables/tmpl/";
  $rutas [] = "$x/views/tables/tmpl/default.php";
  $rutas [] = "$x/views/tables/tmpl/index.html";
  $rutas [] = "$x/views/tables/view.html.php";
  $rutas [] = "$x/views/tables/index.html";
  $rutas [] = "$x/access.xml";
  $rutas [] = "$x/component.php";
  $rutas [] = "$x/config.xml";
  $rutas [] = "$x/controller.php";
  
  $rutaOK = "";
  // recorro las rutas
  foreach ( $rutas as $r ){
    // condiciones para copias de archivos
    if (strpos ($r, 'tables') !== false){
      $rutaOK = str_replace ('tables', $tabla, $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    elseif (strpos ($r, 'table') !== false){
      $rutaOK = str_replace ('table', singularize ($tabla), $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    elseif (strpos ($r, 'tabs') !== false){
      $rutaOK = str_replace ('tabs', 'tables', $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($rutaOK, str_replace ('table', singularize ($tabla), $r), $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        rename($r,$rutaOK);
      }
    }
    elseif (strpos ($r, 'component') !== false){
      $rutaOK = str_replace ('component', $name, $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    else{
      $rutaOK = $r;
      if (esArchivo ($rutaOK)){
        echo "copiando $r     -->     $rutaOK <br />";
        // duplica($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
    }
  }
  limpiar ($rutas);
}

function replaceFront ($name, $tabla, $campos) {
  $componentsite = 'com_' . $name . '/site/';
  $rutas = array ();
  // creo un array con las rutas de los archivos
  $rutas [] = $componentsite . 'controllers/';
  $rutas [] = $componentsite . 'controllers/table.php';
  $rutas [] = $componentsite . 'controllers/tables.php';
  $rutas [] = $componentsite . 'helpers/';
  $rutas [] = $componentsite . 'helpers/component.php';
  $rutas [] = $componentsite . 'language/';
  $rutas [] = $componentsite . 'models/';
  $rutas [] = $componentsite . 'models/fields/';
  $rutas [] = $componentsite . 'models/forms/';
  $rutas [] = $componentsite . 'models/table.php';
  $rutas [] = $componentsite . 'models/tables.php';
  $rutas [] = $componentsite . 'views/';
  $rutas [] = $componentsite . 'views/table/';
  $rutas [] = $componentsite . 'views/table/tmpl';
  $rutas [] = $componentsite . 'views/table/tmpl/default.xml';
  $rutas [] = $componentsite . 'views/table/tmpl/default.php';
  $rutas [] = $componentsite . 'views/table/tmpl/index.html'; // ruta necesaria para limpiar
  $rutas [] = $componentsite . 'views/table/index.html'; // ruta necesaria para limpiar
  $rutas [] = $componentsite . 'views/table/view.html.php';
  $rutas [] = $componentsite . 'views/tables/';
  $rutas [] = $componentsite . 'views/tables/tmpl/';
  $rutas [] = $componentsite . 'views/tables/tmpl/default.xml';
  $rutas [] = $componentsite . 'views/tables/tmpl/default.php';
  $rutas [] = $componentsite . 'views/tables/tmpl/index.html'; // ruta necesaria para limpiar
  $rutas [] = $componentsite . 'views/tables/view.html.php';
  $rutas [] = $componentsite . 'views/tables/index.html'; // ruta necesaria para limpiar
  $rutas [] = $componentsite . 'component.php';
  $rutas [] = $componentsite . 'controller.php';
  $rutas [] = $componentsite . 'router.php';
  
  $rutaOK = "";
  // recorro las rutas
  foreach ( $rutas as $r ){
    // condiciones para copias de archivos
    if (strpos ($r, 'tables') !== false){
      $rutaOK = str_replace ('tables', $tabla, $r);
      echo "copiando1 $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    elseif (strpos ($r, 'table') !== false){
      $rutaOK = str_replace ('table', singularize ($tabla), $r);
      echo "copiando2 $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    elseif (strpos ($r, 'component') !== false){
      $rutaOK = str_replace ('component', $name, $r);
      echo "copiando $r     -->     $rutaOK <br />";
      if (esArchivo ($rutaOK)){
        duplica ($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
      else{
        if (!file_exists ($rutaOK)) full_copy ($r, $rutaOK);
      }
    }
    else{
      $rutaOK = $r;
      if (esArchivo ($rutaOK)){
        echo "copiando $r  to  $rutaOK <br />";
        // duplica($r, $rutaOK, $name, $tabla);
        replace ($rutaOK, $name, $tabla, $campos);
      }
    }
  }
  limpiar ($rutas);
}

if (!file_exists ('com_' . $name)) full_copy ("com_plantilla", 'com_' . $name);

replaceAdmin ($name, $tabla, $campos);
replaceFront ($name, $tabla, $campos);
rename("com_$name/component.xml","com_$name/$name.xml");
replace("com_$name/$name.xml",$name,$tabla,$campos);



