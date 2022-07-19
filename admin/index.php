<?php
	require_once('auth.php');
    include_once "funciones.php";
    $anaVentasRes = Bucar_mayores_ventas();
    $mayoresventas = Buscar_prod_vendidos_recientemente();
    $topventas = Buscar_Top_ventas_cliente();
?>
<?php
//checking connection and connecting to a database
require_once('connection/config.php');
//Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
//pedidos realizados
$orders_placed=$link->query("SELECT * FROM carrito")
or die("There are no records to count ... \n" . mysql_error());

//pedidos En proceso
$tables_reserved=$link->query("SELECT * FROM carrito WHERE estado='En proceso'")
or die("There are no records to count ... \n" . mysql_error());

//pedidos Finalizados
$partyhalls_reserved=$link->query("SELECT * FROM carrito WHERE estado='Finalizado'")
or die("There are no records to count ... \n" . mysql_error());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Index</title>
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
<h1>Panel de control del administrador</h1>
<a href="Index.php">Inicio</a> |<a href="foods.php">Agregar Productos</a> | <a href="orders.php">Pedidos</a> | <a href="logout.php">Cerrar sesión</a>
</div>

<div id="container">
<table width="1000" align="center" style="text-align:center">
<CAPTION><h3 align="center">Monitor de pedidos</h3></CAPTION>
<tr>
    <th> Realizados</th>
    <th> Procesados</th>
    <th> Pendientes </th>
    <th> En Proceso</th>
    <th> Finalizados </th>
</tr>
<?php
        $result2=mysqli_num_rows($orders_placed);     
        $result5=mysqli_num_rows($tables_reserved);
        $result6=mysqli_num_rows($partyhalls_reserved);
        $result3=$result5 + $result6;
        $result4=$result2-($result5 + $result6);

        echo "<tr align=>";
            echo "<td>" . $result2."</td>";
            echo "<td>" . $result3."</td>";
            echo "<td>" . $result4."</td>";
            echo "<td>" . $result5."</td>";
            echo "<td>" . $result6."</td>";
        echo "</tr>";
?>
</table>
</div>


<div id="container">
<div class="row">
<h3 align="center">Análisis</h3>
   <div class="col-md-4">
     <div class="panel panel-default">

       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Productos más vendidos</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed" ALIGN="right">
          <thead>
           <tr>
             <th>Producto</th>
             <th>Cantidad en pedidos</th>
             <th>Cantidad total de unidades en pedidos</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($anaVentasRes as  $product_sold): ?>
              <tr>
                <td><?php echo $product_sold->Nombre; ?></td>
                <td><?php echo $product_sold->TotalVenta ; ?></td>
                <td><?php echo $product_sold->TotalCantidad ; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>



<canvas id="myChart"></canvas>
<script src="chart.js"></script>
<?php
      $nombres = array_column($anaVentasRes, 'Nombre');
      $Ventas = array_column($anaVentasRes, 'TotalVenta');
      $Cantidad = array_column($anaVentasRes, 'TotalCantidad');
      ?>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'doughnut',
    data:{
	datasets: [{
		data: <?php echo json_encode($Cantidad) ?>,
		backgroundColor: ['#42a5f5', 'red', 'green','blue','violet'],
		label: 'Comparacion de navegadores'}],
		labels: <?php echo json_encode($nombres) ?>},
    options: {responsive: true}
});
</script>

         </div>
     </div>
   </div>

   <div class="col-md-4">
     <div class="panel panel-default">

       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Ingresos de pedidos x fecha</span>
         </strong>
       </div>

       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed" ALIGN="center">
          <thead>
           <tr>
           <th>Fecha de venta</th>
             <th>Cantidad en pedidos</th>
             <th>Total Ingresos</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($mayoresventas as  $product_sold): ?>
              <tr>
              <td><?php echo $product_sold->fechaVenta ; ?></td>
                <td><?php echo $product_sold->cantidad ; ?></td>
                <td><?php echo number_format($product_sold->totalVenta, 2) ; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>
         </div>
         
         <canvas id="grafica"></canvas>
    <script type="text/javascript">
      <?php
      $Etiquet = array_column($mayoresventas, 'fechaVenta');
      $Ventas = array_column($mayoresventas, 'totalVenta');
      ?>
        // Obtener una referencia al elemento canvas del DOM
        const $grafica = document.querySelector("#grafica");
        // Pasaamos las etiquetas desde PHP
        const etiquetas = <?php echo json_encode($Etiquet) ?>;
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const Totalcantidad = {
            label: "Cantidad en pedidos",
            // Pasar los datos igualmente desde PHP
            data: <?php echo json_encode($Ventas) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
            borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };
        
        new Chart($grafica, {
            type: 'line', // Tipo de gráfica
            data: {
                labels: etiquetas,
                datasets: [
                  Totalcantidad,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });
        </script>

     </div>
   </div>


<div class="col-md-4">
     <div class="panel panel-default">

       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Top ventas x cliente</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed" ALIGN="right">
          <thead>
           <tr>
             <th>Correo del cliente</th>
             <th>Total vendido</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($topventas as  $product_sold): ?>
              <tr>
                <td><?php echo $product_sold->Cliente; ?></td>
                <td><?php echo $product_sold->totalVenta ; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>


         </div>
     </div>
   </div>
</div>

</div>
</body>
</html>
