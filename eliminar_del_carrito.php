<?php
/*_______________
/ Muuuuuuuuuuuuuuuu \
\                   /
 -------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
*/ ?>
<?php
include_once "funciones.php";
if (!isset($_POST["id_producto"])) {
    exit("No hay id_producto");
}
quitarProductoDelCarrito($_POST["id_producto"]);
# Saber si reDirecciónamos a tienda o al carrito, esto es porque
# llamamos a este archivo desde la tienda y desde el carrito
if (isset($_POST["reDirecciónar_carrito"])) {
    header("Location: cart.php");
} else {
    header("Location: register-failed.php");
}