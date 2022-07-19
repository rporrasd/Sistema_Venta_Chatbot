<?php
    include_once "funciones.php";
    //Ejecutar carrito de compras

	$ID_pedido = CrearPedido($_POST['idTotal']);
    $symbol = end( $ID_pedido );
    // var_dump($symbol);
	$pedido= CocretarPedido($symbol->pedido_id);
    borrarCarrito();
    # Saber si reDirecciónamos a tienda o al carrito, esto es porque
    if ($pedido) {
        header("Location: member-index.php");
    } else {
        header("Location: register-failed.php");
    }
 ?>