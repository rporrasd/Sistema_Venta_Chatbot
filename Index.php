<?php
require_once('connection/config.php');
include_once "funciones.php";
error_reporting(1);
$moneda = obtenermoneda();
$foodDetails = productosTable();
$productos = obtenerProductosEnCarrito();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> <?php echo APP_NAME; ?>:Inicio </title>
    <link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="page">
      <header>
        <div id="menu">
          <ul>
            <li>
              <i class="fa-solid fa-file-user"></i>
              <a href="member-index.php">Mi cuenta</a>
            </li>
            <?php
	          if(!isset($_SESSION['SESS_cliente_id']) || (trim($_SESSION['SESS_cliente_id']) == '')) {
            ?>
            <li>
              <i class="fa-solid fa-user"></i>
              <a href="Login.php">Ingresa</a>
            </li>
            <li>
              <i class="fa-solid fa-id-card"></i>
              <a href="Login-register.php">Registrate</a>
            </li>
        <?php } ?>
            <li>
              <i class="fa-solid fa-cart-shopping"></i>
              <a href="cart.php">Mi Carrito de Compras (<?php echo count($productos)?>)</a>
            </li>
          </ul>
        </div>
        <div id="header" class="stretchX">
          <div id="company_name"> <?php echo APP_NAME; ?> Restaurante </div>
        </div>
        <h1>
          <center> Bienvenido al Restaurante de raúl!</center>
        </h1>
      </header>
      <div id="center">
      <table width="860" height="auto" style="text-align:center;"> <?php
          $symbol=$moneda[0];
          foreach ($foodDetails as $producto) {
          ?> <tr>
                <div class="card">
                    <img src="images/<?php echo $producto->prod_photo; ?>" width="300" height="211">
                    <h4> <?php echo $producto->prod_name ?> </h4>
                    <p> <?php echo $producto->prod_description ?> </p>
                    <p> <?php echo $symbol->moneda_symbol. $producto->prod_price?> </p> <?php 
                    if (productoYaEstaEnCarrito($producto->prod_id)) 
                    { ?> 
                        <i class="fa fa-check"></i>&nbsp;En su carrito </span>
                        </form> 
              <?php } 
                    else 
                    { ?> 
                        <form action="cart-exec.php" method="post">
                          <input type="hidden" name="id" value=" <?php echo $producto->prod_id ?>">
                          <input type="hidden" name="Producto_a_carrito">
                          <button class="button is-primary">
                                <i class="fa fa-cart-plus"></i>&nbsp;Agregar al carrito
                            </button>
                          </button>
                        </form>
                  </div>    
              <?php } ?> <?php 
            } ?>
          </tr>
        </table>
        <script src="https://kit.fontawesome.com/a2dd6045c4.js"></script>
        <script src="//code.tidio.co/0kaviwg07iwmeir8bt3zkh6odhofinzf.js" async></script>
        <script language="JavaScript" src="validation/user.js"></script>
      </div> 
    </div><?php include 'footer.php'; ?>
  </body>
</html>