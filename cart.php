<?php
    require_once('auth.php');
    include_once "funciones.php";

    $productos = obtenerProductosEnCarrito();
    $CartDetails = obtenerCartDetails();
    $quantityes = obtenercantidades();
    $moneda = obtenermoneda();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title> <?php echo APP_NAME ?>:Shopping Cart </title>
      <script type="text/javascript" src="swf/swfobject.js"></script>
      <link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
      <script language="JavaScript" src="validation/user.js"></script>
      <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    </head>
    <body>
      <div id="page">
        <div id="menu">
          <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="member-index.php">Mi cuenta</a></li>
          </ul>
        </div>
        <div id="header">
          <div id="company_name"> <?php echo APP_NAME ?> Restaurante </div>
        </div>
        <div id="center">
          <h3>MI CARRITO DE COMPRAS</h3>
          <hr>
          <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
          <table width="1500" height="auto" style="text-align:center;">
            <tr>
                <!-- <th>Id</th> -->
                <th>Foto</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Selecciona otra cantidad</th>
                <th>Quitar</th>
            </tr>
            <?php
                    $total = 0;
                    $symbol=$moneda[0];
                    foreach ($productos as $producto) {
                        $total += $producto->total;
                    ?>
                        <tr>
                            <td><?php echo '<a href=images/'. $producto->prod_photo. ' alt="click to view full image" target="_blank"><img src=images/'. $producto->prod_photo. ' width="100" height="90"></a></td>'?></td>
                            <td><?php echo $producto->prod_name ?></td>
                            <td><?php echo $producto->prod_description ?></td>
                            <td><?php echo $symbol->moneda_symbol. $producto->prod_price?></td>
                            <td><?php echo $producto->cant_value ?></td>
                            <td><?php echo $symbol->moneda_symbol.   $producto->total?></td>
                            <td>
                              <form action="update-quantity.php" method="post">
                              <select name="quantity" id="quantity">
                              <option value="select">- seleccionar -</option>
                              <?php
                              foreach($quantityes  as $key => $value){
                                ?>
                                  <option value="<?=$value->cant_id?>"><?=$value->cant_value?></option>";
                                <?php 
                                } 
                                ?>
                              </select>
                              <input type="hidden" name="item" value="<?php echo $producto->carrito_id ?>">
                               <button class="button is-info">
                                      <i class="fas fa-bookmark"></i>
                              </button>
                              </form>
                            </td>
                            <td>
                                <form action="eliminar_del_carrito.php" method="post">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto->carrito_id ?>">
                                    <input type="hidden" name="reDirecciónar_carrito">
                                    <button class="button is-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>                     
                        <?php } ?>
                        </tr>
                <tfoot>
                    <tr>
                        <td colspan="2" class="is-size-4 has-text-right"><strong>Total</strong></td>
                        <td colspan="2" class="is-size-4">
                        <?php echo $symbol->moneda_symbol?> <?php echo number_format($total, 2) ?>
                        </td>
                    </tr>
                </tfoot>
          </table>
          <?php 
          if(count($productos)>0)
          {?>
            <form action="PasarelaPago.php" method="post">
            <input type="hidden" name="idTotal" value=" <?php echo $total ?>">
            <button class="button is-success is-large">
               <i class="fa fa-check"></i>&nbsp;Terminar compra
            </button>
            </form>
    <?php  }?>
            <h3>
              <a href="index.php">Seguir comprando!</a>
            </h3>
          </div>
        </div> 
        <?php include 'footer.php'; ?>
      </div>
    </body>
  </html>