<?php ?>
<!DOCTYPE html>
<html>
<head>
<title>Component Generator</title>
<meta charset="UTF-8">
</head>
<body>
  <form action="tablas.php" method="post">
    <label>Name: </label>
    <input type="text" name="name" value="" /><br/>
    <label>Nombre a mostrar: </label>
    <input type="text" name="sname" value="" /><br/>
    <label>Descripción: </label>
    <input type="text" name="description" value="" /><br/>
    <label>Icono: </label>
    <input type="file" name="icon" value="" /><br/>
    <label>Versión del componente: </label>
    <input type="text" name="version" value="" /><br/>
    <label>Versión de Joomla!: </label>
    <input type="text" name="jversion" value="3.0" /><br/>
    <label>Idioma: </label>
    <input type="text" name="languages" value="Español ES_es" /><br/>
    <label>Derechos de autor: </label>
    <input type="text" name="copyright" value="Libre" /><br/>
    <label name="license">Licencia: </label>
    <input type="text" name="license" value="Libre" /><br/>
    <label name="author">Autor: </label>
    <input type="text" name="author" value="" /><br/>
    <label name="email">Email del autor: </label>
    <input type="text" name="email" value="" /><br/>
    <label name="web">Web del autor: </label>
    <input type="text" name="web" value="" /><br/>
    <label name="server">ruta bbdd </label>
    <input type="text" name="server" value="localhost" /><br/>
    <label name="pass">contraseña bbdd: </label>
    <input type="text" name="pass" value="" /><br/>
    <label name="user">usuario bbdd: </label>
    <input type="text" name="user" value="root" /><br/>
    <label name="db">bbdd: </label>
    <input type="text" name="db" value="gp" /><br/>
    <label name="prefix">Prefijo de las tablas: </label>
    <input type="text" name="prefix" value="jos_gp_" /><br/>
    <input type="submit" />
    
  </form>
</body>
</html>