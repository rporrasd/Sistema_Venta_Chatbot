<?php
	require_once('auth.php');
  include_once "funciones.php";
  $result=DetalleOrdenesCarritoAdmin();
  $moneda = obtenermoneda();
  $anaVentasRes = Bucar_mayores_ventas();
  $mayoresventas = Buscar_prod_vendidos_recientemente();
  $topventas = Buscar_Top_ventas_cliente();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orders</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<link rel="stylesheet" href="libs/css/main.css" />
</head>
<body>
<div id="page">

<div id="header">
<h1>Gestión de pedidos </h1>
<a href="Index.php">Inicio</a> |<a href="foods.php">Agregar Productos</a>| <a href="orders.php">Pedidos</a> | <a href="logout.php">Cerrar sesión</a>
</div>

<div id="container">
<table border="0" width="1500px" align="center">
<CAPTION><h3>LISTA DE PEDIDOS</h3></CAPTION>
<tr>
<th> ID de pedido </th>
<th> ID de Cliente </th>
<th> Nombres</th>
<th> Dirección </th>
<th> Teléfono </th>
<th> Nombre de plato </th>
<th> Precio del plato </th>
<th> Cantidad </th>
<th> Costo total </th>
<th> Fecha de entrega </th>
<th> Estado de pedido</th>
<th> Acciones (s) </th>
</tr>

<?php
    $symbol=$moneda[0];
    foreach ($result as $producto) {
      ?>
      <tr>
      <td><?php echo $producto->IdPedido ?></td>
      <td><?php echo $producto->IdCliente ?></td>
      <td><?php echo $producto->nombreCli. $producto->apellidoCli?></td>
      <td><?php echo $producto->direccionCli ?></td>
      <td><?php echo $producto->telefonoCli ?></td>
      <td><?php echo $producto->nombreProd ?></td>
      <td><?php echo $symbol->moneda_symbol.   $producto->precioProd?></td>
      <td><?php echo $producto->cantidadProd ?></td>
      <td><?php echo $symbol->moneda_symbol.   $producto->TotalProd?></td>
      <td><?php echo $producto->fechaVentaProd ?></td>
      <td><?php echo $producto->estadoProd ?></td>
      <td><a href="PedidoProceso.php?id=<?php echo $producto->carritoid ?>"style="color:#FF0000;">En proceso</a></td>
      <td><a href="PedidosFin.php?id=<?php echo $producto->carritoid ?>"style="color:#FF0000;">Finalizado</a></td>
      </tr>
      <?php
    }
    ?>
</table>
<td>
    <form action="Descarga.php" method="post">
      <button class="button is-success is-large">
        <i class="fa fa-check"></i>&nbsp;Exportar
       </button>
      </form>
</td>   
</div>
</body>
</html>