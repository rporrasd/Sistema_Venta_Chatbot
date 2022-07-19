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
    
 
    //retrive promotions from the specials table
    $result=$link->query("SELECT * FROM productos")
    or die("There are no records to display ... \n" . mysql_error()); 
?>
<?php
    //retrive a currency from the moneda table
    //define a default value for flag_1
    $flag_1 = 1;
    $moneda=$link->query("SELECT * FROM moneda WHERE flag='$flag_1'")
    or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Foods</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Administración de Productos </h1>
<a href="Index.php">Inicio</a> |<!--<a href="profile.php">Perfil</a> | <a href="categories.php">Categorías</a> |--> <a href="foods.php">Agregar Productos</a> <!--| <a href="accounts.php">Cuentas</a>--> | <a href="orders.php">Pedidos</a> | <!--<a href="reservations.php">Reservas</a> | <a href="specials.php">Especiales</a> | <a href="allocation.php">Personal</a> | <a href="messages.php">Mensajes</a> | <a href="options.php">Opciones</a> |--> <a href="logout.php">Cerrar sesión</a>
</div>
<div id="container">
<table width="760" align="center">
<CAPTION><h3>Agregar nuevo plato</h3></CAPTION>
<form name="foodsForm" id="foodsForm" action="foods-exec.php" method="post" enctype="multipart/form-data" onsubmit="return foodsValidate(this)">
<tr>
<th> Nombre </ th>
     <th> Descripción </th>
     <th> Precio </th>
     <th> Foto </th>
     <th> Acción (es) </th>
</tr>
<tr>
    <td><input type="text" name="name" id="name" class="textfield" /></td>
    <td><textarea name="description" id="description" class="textfield" rows="2" cols="15"></textarea></td>
    <td><input type="text" name="price" id="price" class="textfield" /></td>

    <td><input type="file" name="photo" id="photo"/></td>
    <td><input type="submit" name="Submit" value="Agregar" /></td>
</tr>
</form>
</table>
<hr>
<table width="950" align="center">
<CAPTION><h3>Platos disponibles</h3></CAPTION>
<tr>
<th> Foto Plato</th>
<th> Nombre de Plato </th>
<th> Descripción de Plato </th>
<th> Precio de Plato </th>
<th> Acción (es) </th>
</tr>

<?php
//loop through all table rows
$symbol=$moneda->fetch_assoc(); //gets active currency
while ($row=mysqli_fetch_array($result)){
echo "<tr>";
echo '<td><img src=../images/'. $row['prod_photo']. ' width="80" height="70"></td>';
echo "<td>" . $row['prod_name']."</td>";
echo "<td>" . $row['prod_description']."</td>";
echo "<td>" . $symbol['moneda_symbol']. "" . $row['prod_price']."</td>";
echo '<td><a href="delete-food.php?id=' . $row['prod_id'] . '">Borrar plato</a></td>';
echo "</tr>";
}
mysqli_free_result($result);
mysqli_close($link);
?>
</table>
<hr>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>