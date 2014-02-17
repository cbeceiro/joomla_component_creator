<?php
print_r($_POST);

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

$t = $_POST['tabla'];

echo '<form action="generator.php" method="post">';
echo '<input type="hidden" name="name" value="'.$_POST['name'].'" />';
$fields = mysqli_query ($link, "describe " . $t);
echo '<input type="hidden" name="tabla" value="'.$t.'"/>';
echo '<input type="hidden" name="prefix" value="'.$prefix.'"/>';
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
  $i=0;
  while ($field = mysqli_fetch_array ($fields)){
       
    echo '<tr>
            <input type="hidden" name="ids[]" value="'.$i.'" />
            <td>'.$field['Field'].'</td>
                <input type="hidden" name="fields[]" value="'.$field['Field'].'" />
            <td>'.$field['Type'].'</td>
                <input type="hidden" name="types[]" value="'.$field['Type'].'" />
            <td>'.$field['Null'].'</td>
                <input type="hidden" name="nulls[]" value="'.$field['Null'].'" />
            <td>'.$field['Key'].'</td>
                <input type="hidden" name="keys[]" value="'.$field['Key'].'" />
            <td>'.$field['Default'].'</td>
                <input type="hidden" name="defaults[]" value="'.$field['Default'].'" />
            <td>'.$field['Extra'].'</td>
                <input type="hidden" name="extras[]" value="'.$field['Extra'].'" />
            <td>
              <select name="jtypes[]">
                <option value ="text">Texto</option>
                <option value ="otroTipo">otroTipo</option>
              </select>
            </td>
            <td>
              <input type="radio" name="lists['.$i.']" value="y">Si
              <input type="radio" name="lists['.$i.']" value="n">No
            </td>
            <td>
              <input type="radio" name="forms['.$i.']" value="y">Si
              <input type="radio" name="forms['.$i.']" value="n">No
            </td>
            <td>
              <input type="radio" name="requireds['.$i.']" value="y">Si
              <input type="radio" name="requireds['.$i.']" value="n">No
            </td>
          </tr>';
    $i++;
  }
  echo '</tbody> <br /> <hr />';


echo '<input type="submit" />';
echo '</form>';
