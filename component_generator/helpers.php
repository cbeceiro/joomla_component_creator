<?php
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

function esArchivo($ruta){
  if(strpos($ruta,'.php') !== false)
    return true;
  elseif(strpos($ruta,'.xml') !== false)
    return true;
  elseif(strpos($ruta,'.css') !== false)
    return true;
  elseif(strpos($ruta,'.sql') !== false)
    return true;
  else return false;
}

function recorreEstructura($dir){

  $directorio=opendir($dir);
  echo "<b>Directorio actual:</b><br>$dir<br>";
  echo "<b>Archivos:</b><br>";
  while ($archivo = readdir($directorio)) {
    if($archivo == '.' || $archivo == '..');
    elseif(is_dir("$dir/$archivo"))
    echo "<a href=\"?dir=$dir/$archivo\">$archivo</a><br>";
    else echo "$archivo<br>";
  }
  closedir($directorio);
}

function singularize($word)
{
  $singular = array (
    '/(quiz)zes$/i' => '\1',
    '/(matr)ices$/i' => '\1ix',
    '/(vert|ind)ices$/i' => '\1ex',
    '/^(ox)en/i' => '\1',
    '/(alias|status)es$/i' => '\1',
    '/([octop|vir])i$/i' => '\1us',
    '/(cris|ax|test)es$/i' => '\1is',
    '/(shoe)s$/i' => '\1',
    '/(o)es$/i' => '\1',
    '/(bus)es$/i' => '\1',
    '/([m|l])ice$/i' => '\1ouse',
    '/(x|ch|ss|sh)es$/i' => '\1',
    '/(m)ovies$/i' => '\1ovie',
    '/(s)eries$/i' => '\1eries',
    '/([^aeiouy]|qu)ies$/i' => '\1y',
    '/([lr])ves$/i' => '\1f',
    '/(tive)s$/i' => '\1',
    '/(hive)s$/i' => '\1',
    '/([^f])ves$/i' => '\1fe',
    '/(^analy)ses$/i' => '\1sis',
    '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
    '/([ti])a$/i' => '\1um',
    '/(n)ews$/i' => '\1ews',
    '/s$/i' => '',
  );

  $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

  $irregular = array(
    'person' => 'people',
    'man' => 'men',
    'child' => 'children',
    'sex' => 'sexes',
    'move' => 'moves');

  $lowercased_word = strtolower($word);
  foreach ($uncountable as $_uncountable){
    if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
      return $word;
    }
  }

  foreach ($irregular as $_plural=> $_singular){
    if (preg_match('/('.$_singular.')$/i', $word, $arr)) {
      return preg_replace('/('.$_singular.')$/i', substr($arr[0],0,1).substr($_plural,1), $word);
    }
  }

  foreach ($singular as $rule => $replacement) {
    if (preg_match($rule, $word)) {
      return preg_replace($rule, $replacement, $word);
    }
  }

  return $word;
}

function duplica($source, $dest, $name, $tabla){
  if (strpos($dest,'view.html.php') !== false  || strpos($dest,'default') !== false
   || strpos($dest,'controller.php') !== false || strpos($dest,'router') !== false
   || strpos($dest,'edit.php') !== false       || strpos($dest,'install.mysql.utf8.sql') !== false
   || strpos($dest,'access.xml') !== false     || strpos($dest,'config.xml') !== false)
    //rename($source, $dest);
    ;
  else copy($source, $dest);
}

function eliminar($ruta){
  if(strpos($ruta,'controller.php') !== false || strpos($ruta,'router') !== false
     || strpos($ruta,'install.mysql.utf8.sql') !== false   || strpos($ruta,'access.xml') !== false     
     || strpos($ruta,'config.xml') !== false)
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