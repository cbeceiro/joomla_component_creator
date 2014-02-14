<?php
$server = $_POST ['server'];
if (empty ($_POST ['pass'])) $pass = "";
else $pass = $_POST ['pass'];
$user = $_POST ['user'];
$db = $_POST ['db'];

if (empty ($_POST ['prefix'])) $prefix = "";
else $prefix = $_POST ['prefix'];

$link = mysqli_connect ($server, $user, $pass, $db) or die (mysqli_error ($link));

$resultado = mysqli_query($link, "show tables");

echo '<form action="campos.php" method="post">';
echo '<ul>';
while ($fila = mysqli_fetch_array ($resultado)){
  $row = $fila[0];
  $tabla [] = $row;
  echo '<li>
          <input type="checkbox" name="tabla['.str_replace($prefix,"",$row).']" value="'.$row.'" /> 
          <label>'. str_replace($prefix,"",$row) .'</label>
        </li>';
}
echo '</ul>';
echo '<input type="submit" />';
echo '<input type="hidden" name="server" value="'.$server.'"/>';
echo '<input type="hidden" name="pass" value="'.$pass.'"/>';
echo '<input type="hidden" name="user" value="'.$user.'"/>';
echo '<input type="hidden" name="db" value="'.$db.'"/>';
echo '<input type="hidden" name="prefix" value="'.$prefix.'"/>';
echo '</form>';