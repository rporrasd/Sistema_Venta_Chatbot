<?php
	require_once('auth.php');
  include_once "funciones.php";

  $Pedido =obtenerPedido();
  $moneda = obtenermoneda();
  $CartDetails = obtenerCartDetails();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> <?php echo APP_NAME; ?>:Inicio de miembro </title>
    <link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="validation/user.js"></script>
    <script language="JavaScript" src="Js/app.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div id="page">
      <div id="menu">
        <ul>
          <li> <a href="index.php">Inicio</a></li>
        </ul>
      </div>
      <div id="header">
        <div id="company_name"> <?php echo APP_NAME; ?> Restaurante </div>
      </div>
      <div id="center">
        <h1>Bienvenido <?php echo $_SESSION['SESS_FIRST_NAME'];?> </h1>
        <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
          <a href="cart.php">Mi carrito de compras[<?php echo count($CartDetails); ?>]</a> | <a href="logout.php">Salir</a>
          <p>&nbsp;</p>
          <p>Aquí puede ver el historial de pedidos</p>
          <h3>  <a href="Index.php">Realiza mas pedidos</a> </h3>
          <hr>
          <table border="0" width="1500" style="text-align:center;">
            <CAPTION>
              <h2>HISTORIAL DE PEDIDOS</h2>
            </CAPTION>
            <tr>
              <th>Id pedido</th>
              <th>precio total</th>
              <th>Estado de pedido</th>
              <th>Fecha de pedido</th>
              <th>Hora de pedido</th>
              <th>Detalle de pedido</th>
            </tr> 
            <?php
              $symbol=$moneda[0];
              foreach ($Pedido as $pedido) {
           ?> 
            <tr>
              <td> <?php echo $pedido->pedido_id ?> </td>
              <td> <?php echo $symbol->moneda_symbol. $pedido->precioTotal ?> </td>
              <?php 
              if ($pedido->flagEstado== "2"){
				        echo "<td>En Proceso</td>";
	  	        }
	  	        else if ($pedido->flagEstado == "3"){
				        echo "<td>Finalizado</td>";
	  	        }else{
			          echo "<td>Pendiente</td>";
	  	        }
              ?>
              <td> <?php echo $pedido->delivery_date ?> </td> 
              <td> <?php echo $pedido->time_stamp ?> </td> 
              <td>
                <a href="Detallepedido.php?id_pedido=<?php echo $pedido->pedido_id ?>">Detalle</a>
              </td>   
            </tr> 
        <?php } ?>
          </table>
        </div>
      </div> <?php include 'footer.php'; ?>
    </div>
  </body>
</html>