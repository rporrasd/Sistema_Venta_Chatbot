<?php
require_once('auth.php');
include_once "funciones.php";
$totalApagar = $_POST['idTotal'];
$productos = obtenerProductosEnCarrito($totalApagar);
$moneda = obtenermoneda();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> <?php echo APP_NAME ?>:Login </title>
    <link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="validation/user.js"></script>
  </head>
  <body>
    <div>
      <div id="menu">
        <ul>
          <li>
            <a href="index.php">Inicio</a>
          </li>
      </div>
    </div>
    <div class='container'>
      <div class='window'>
        <div class='order-info'>
          <div class='order-info-content'>
            <h2>Resumen del pedido</h2> 
            <div class='line'></div>
            <table width="450" height="auto" style="text-align:center;">
            <tr>
                <th>Foto</th>
                <th>Plato</th>
                <th>Precio y cantidad</th>
                <th>Subtotal</th>
            </tr>
            <?php      
            $symbol=$moneda[0]; //gets active currency       
            foreach ($productos as $producto) {
             $total += $producto->total;
              ?> 
                <tr>
                  <td> <?php echo '<a href=images/'. $producto->prod_photo. ' alt="click to view full image" target="_blank"><img src=images/'. $producto->prod_photo. ' width="50" height="40"></a></td>'?> </td>
                  <td>
                      <?php echo $producto->prod_name ?>
                  </td>
                  <td>   
                      <?php echo $symbol->moneda_symbol. $producto->prod_price?> <br> <?php echo $producto->cant_value ?> Unidades        
                  </td>
                  <td>
                    <br> <?php echo $symbol->moneda_symbol.   $producto->total?>
                  </td>
                </tr>
        <?php } ?> 
        </table> 
            <div class='line'></div>
            <div class='total'>
              <span style='float:left;'>TOTAL</span>
              <span style='float:right; text-align:right;'> <?php echo $symbol->moneda_symbol. $totalApagar?> </span>
            </div>
          </div>
        </div>
        <div class='credit-info'>
          <div class='credit-info-content'>
            <img src='https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png' height='80' class='credit-card-image' id='credit-card-image'></img> Número de tarjeta <input class='input-field'></input> Titular de la tarjeta <input class='input-field'></input>
            <table class='half-input-table'>
              <tr>
                <td> Fecha de vencimiento <input class='input-field'></input>
                </td>
                <td>CVC <input class='input-field'></input>
                </td>
              </tr>
            </table>
            <form action="billing-exec.php" method="post">
                <input type="hidden" name="idTotal" value=" <?php echo $total ?>">
                <button class='pay-btn'>
                   <i class="fa fa-check"></i>&nbsp;Pagar
                </button>
          </form>
          </div>
        </div>
      </div>
    </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>