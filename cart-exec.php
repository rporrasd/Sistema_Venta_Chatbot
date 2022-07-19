<?php
    require_once('auth.php');
    include_once "funciones.php";
    //Ejecutar carrito de compras
    if (!isset($_POST['id'])) {
        exit("No hay id_producto");
    }
    enviar_carrito_compras($_POST['id']);

    # Saber si reDirecciónamos a tienda o al carrito, esto es porque
    if (isset($_POST["Producto_a_carrito"])) {
        header("Location: index.php");
    } else {
        header("Location: register-failed.php");
    }
 ?>