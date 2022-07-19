<?php
    require_once('auth.php');
?>
<?php
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    
 
    
//retrive categories from the categories table
$categories=$link->query("SELECT * FROM categories")
or die("There are no records to display ... \n" . mysql_error()); 

//retrieve cantidades from the cantidades table
$cantidades=$link->query("SELECT * FROM cantidades")
or die("Something is wrong ... \n" . mysql_error()); 

//retrieve moneda from the moneda table (deleting)
$moneda=$link->query("SELECT * FROM moneda")
or die("Something is wrong ... \n" . mysql_error()); 

//retrieve moneda from the moneda table (updating)
$moneda_1=$link->query("SELECT * FROM moneda")
or die("Something is wrong ... \n" . mysql_error()); 

//retrieve polls from the ratings table
$ratings=$link->query("SELECT * FROM ratings")
or die("Something is wrong ... \n" . mysql_error());

//retrieve timezones from the timezones table (deleting)
$timezones=$link->query("SELECT * FROM timezones")
or die("Something is wrong ... \n" . mysql_error()); 

//retrieve timezones from the timezones table (updating)
$timezones_1=$link->query("SELECT * FROM timezones")
or die("Something is wrong ... \n" . mysql_error());  

//retrieve tables from the tables table
$tables=$link->query("SELECT * FROM tables")
or die("Something is wrong ... \n" . mysql_error());

//retrieve partyhalls from the partyhalls table
$partyhalls=$link->query("SELECT * FROM partyhalls")
or die("Something is wrong ... \n" . mysql_error());

//retrieve questions from the questions table
$questions=$link->query("SELECT * FROM questions")
or die("Something is wrong ... \n" . mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Options</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Options </h1>
<a href="profile.php">Perfil</a> | <a href="categories.php">Categorías</a> | <a href="foods.php">Alimentos</a> | <a href="accounts.php">Cuentas</a> | <a href="orders.php">Pedidos</a> | <a href="reservations.php">Reservas</a> | <a href="specials.php">Especiales</a> | <a href="allocation.php">Personal</a> | <a href="messages.php">Mensajes</a> | <a href="options.php">Opciones</a>| <a href="logout.php">Cerrar sesión</a>
</div>
<div id="container">
<table align="center" width="910">
<CAPTION><h3> ADMINISTRAR CATEGORÍAS</h3></CAPTION>
<tr>
<form name="categoryForm" id="categoryForm" action="categories-exec.php" method="post" onsubmit="return categoriesValidate(this)">
<td>
  <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Categoria</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="categoryForm" id="categoryForm" action="delete-category.php" method="post" onsubmit="return categoriesValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Categoria</td>
        <td><select name="category" id="category">
        <option value="select">- selecciona una categoría -
        <?php 
        //loop through categories table rows
        while ($row=mysqli_fetch_array($categories)){
        echo "<option value=$row[category_id]>$row[category_name]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>GESTIONAR CANTIDADES</h3></CAPTION>
<tr>
<form name="quantityForm" id="quantityForm" action="cantidades-exec.php" method="post" onsubmit="return cantidadesValidate(this)">
<td>
  <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Cantidad</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="quantityForm" id="quantityForm" action="delete-quantity.php" method="post" onsubmit="return cantidadesValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Cantidad</td>
        <td><select name="quantity" id="quantity">
        <option value="select">- Selecciona la cantidad -
        <?php 
        //loop through cantidades table rows
        while ($row=mysqli_fetch_array($cantidades)){
        echo "<option value=$row[cant_id]>$row[quantity_value]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>GESTIONAR LAS DIVISAS</h3></CAPTION>
<tr>
<td>
<form name="currencyForm" id="currencyForm" action="moneda-exec.php" method="post" onsubmit="return monedaValidate(this)">
  <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Símbolo/moneda
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</form>
</td>
<td>
<form name="currencyForm" id="currencyForm" action="delete-currency.php" method="post" onsubmit="return monedaValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Símbolo/moneda</td>
        <td><select name="currency" id="currency">
        <option value="select">- Seleccione el tipo de moneda -
        <?php 
        //loop through moneda table rows
        while ($row=mysqli_fetch_array($moneda)){
        echo "<option value=$row[currency_id]>$row[moneda_symbol]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
<td>
<form name="currencyForm" id="currencyForm" action="activate-currency.php" method="post" onsubmit="return monedaValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Símbolo/moneda<</td>
        <td><select name="currency" id="currency">
        <option value="select">- seleccionar una moneda -
        <?php 
        //loop through moneda table rows
        while ($row=mysqli_fetch_array($moneda_1)){
        echo "<option value=$row[currency_id]>$row[moneda_symbol]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Update" value="Activate" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>GESTIONAR CALIFICACIONES</h3></CAPTION>
<tr>
<form name="ratingForm" id="ratingForm" action="ratings-exec.php" method="post" onsubmit="return ratingsValidate(this)">
<td>
  <table width="300" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Nivel de frecuencia</td>
        <td><input type="text" name="name" id="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="ratingForm" id="ratingForm" action="delete-rating.php" method="post" onsubmit="return ratingsValidate(this)">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Nivel de frecuencia</td>
        <td><select name="rating" id="rating">
        <option value="select">- selecciona el nivel -
        <?php 
        //loop through ratings table rows
        while ($row=mysqli_fetch_array($ratings)){
        echo "<option value=$row[rate_id]>$row[rate_name]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>GESTIONAR Zona horaria</h3></CAPTION>
<tr>
<td>
<form name="timezoneForm" id="timezoneForm" action="timezone-exec.php" method="post" onsubmit="return timezonesValidate(this)">
  <table width="250" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Zona horaria</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</form>
</td>
<td>
<form name="timezoneForm" id="timezoneForm" action="delete-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Zona horaria</td>
        <td><select name="timezone" id="timezone">
        <option value="select">- seleccionar Zona horaria
 -
        <?php 
        //loop through timezones table rows
        while ($row=mysqli_fetch_array($timezones)){
        echo "<option value=$row[timezone_id]>$row[timezone_reference]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
<td>
<form name="timezoneForm" id="timezoneForm" action="activate-timezone.php" method="post" onsubmit="return timezonesValidate(this)">
  <table width="250" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Zona horaria</td>
        <td><select name="timezone" id="timezone">
        <option value="select">- seleccionar Zona horaria
 -
        <?php 
        //loop through timezones table rows
        while ($row=mysqli_fetch_array($timezones_1)){
        echo "<option value=$row[timezone_id]>$row[timezone_reference]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Update" value="Activate" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>Administrar TABLAS</h3></CAPTION>
<tr>
<form name="tableForm" id="tableForm" action="tables-exec.php" method="post" onsubmit="return tablesValidate(this)">
<td>
  <table width="350" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Nombre / Número de la tabla</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="tableForm" id="tableForm" action="delete-table.php" method="post" onsubmit="return tablesValidate(this)">
  <table width="350" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>TNombre / Número de la tabla</td>
        <td><select name="table" id="table">
        <option value="select">- seleccione tabla -
        <?php 
        //loop through tables table rows
        while ($row=mysqli_fetch_array($tables)){
        echo "<option value=$row[table_id]>$row[table_name]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>ADMINISTRAR SALONES DE FIESTA</h3></CAPTION>
<tr>
<form name="partyhallForm" id="partyhallForm" action="partyhalls-exec.php" method="post" onsubmit="return partyhallsValidate(this)">
<td>
  <table width="350" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>Party Hall Nombre/Numero</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="partyhallForm" id="partyhallForm" action="delete-partyhall.php" method="post" onsubmit="return partyhallsValidate(this)">
  <table width="370" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>Party Hall Nombre/Numero</td>
        <td><select name="partyhall" id="partyhall">
        <option value="select">- select partyhall -
        <?php 
        //loop through partyhalls table rows
        while ($row=mysqli_fetch_array($partyhalls)){
        echo "<option value=$row[partyhall_id]>$row[partyhall_name]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
<table align="center" width="910">
<CAPTION><h3>GESTIONAR PREGUNTAS</h3></CAPTION>
<tr>
<form name="questionForm" id="questionForm" action="questions-exec.php" method="post" onsubmit="return questionsValidate(this)">
<td>
  <table width="300" border="0" cellpadding="2" cellspacing="0" align="center">
    <tr>
        <td>PREGUNTAS</td>
        <td><input type="text" name="name" class="textfield" /></td>
        <td><input type="submit" name="Insert" value="Agregar" /></td>
    </tr>
  </table>
</td>
</form>
<td>
<form name="questionForm" id="questionForm" action="delete-question.php" method="post" onsubmit="return questionsValidate(this)">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
        <td>PREGUNTAS</td>
        <td><select name="question" id="question">
        <option value="select">- seleccionar pregunta-
        <?php 
        //loop through cantidades table rows
        while ($row=mysqli_fetch_array($questions)){
        echo "<option value=$row[question_id]>$row[question_text]"; 
        }
        ?>
        </select></td>
        <td><input type="submit" name="Delete" value="Eliminar" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
<p>&nbsp;</p>
<hr>
</div>
<?php
    include 'footer.php';
?>
</div>
</body>
</html>
