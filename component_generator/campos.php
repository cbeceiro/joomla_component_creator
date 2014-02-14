<?php
$server = $_POST ['server'];
if (empty ($_POST ['pass'])) $pass = "";
else $pass = $_POST ['pass'];
$user = $_POST ['user'];
$db = $_POST ['db'];

if (empty ($_POST ['prefix'])) $prefix = "";
else $prefix = $_POST ['prefix'];

$link = mysqli_connect ($server, $user, $pass, $db) or die (mysqli_error ($link));
echo '<style> 
        .normal {
          width: 1000px;
          border: 1px solid #000;
        }
        .normal th, .normal td {
           border: 1px solid #000;
        }
      </style>';



foreach ( $_POST ['tabla'] as $id => $value ){
  $tabla [$id] = $value;
}


echo '<form action="generator.php" method="post">';
foreach ( $tabla as $t ){
  $fields = mysqli_query ($link, "describe " . $t);
  echo '<table class="normal"> <caption><strong>'.$t.'</strong></caption>';
  echo '<thead>
          <th>Campo</th>
          <th>Tipo</th>
          <th>Obligatorio</th>
          <th>Key</th>
          <th>Por defecto</th>
          <th>Extra</th>
          <th>Tipo en Joomla!</th>
          <th>Lista</th>
          <th>Formulario</th>
          <th>Obligatorio</th>
        </thead>
        <tbody>';
  while ($field = mysqli_fetch_array ($fields)){
    $campos ['Field'] = $field['Field'];
    $campos ['Type'] = $field['Type'];
    $campos ['Null'] = $field['Null'];
    $campos ['Key'] = $field['Key'];
    $campos ['Default'] = $field['Default'];
    $campos ['Extra'] = $field['Extra'];
    
    echo '<tr>
            <td>'.$field['Field'].'</td>
                <input type="hidden" name="field" value="'.str_replace($prefix,"",$t).$field['Field'].'" />
            <td>'.$field['Type'].'</td>
            <td>'.$field['Null'].'</td>
            <td>'.$field['Key'].'</td>
            <td>'.$field['Default'].'</td>
            <td>'.$field['Extra'].'</td>
            <td>
              <select name="jtype">
                <option value ="text">Texto</option>
                <option value ="otroTipo">otroTipo</option>
              </select>
            </td>
            <td>
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'list" value="y">Si
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'list" value="n">No
            </td>
            <td>
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'form" value="y">Si
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'form" value="n">No
            </td>
            <td>
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'required" value="y">Si
              <input type="radio" name="'.str_replace($prefix,"",$t).$field['Field'].'required" value="n">No
            </td>
          </tr>';
  }
  echo '</tbody> <br /> <hr />';
}

echo '<input type="submit" />';
echo '</form>';
