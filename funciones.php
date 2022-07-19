<?php
require_once('connection/config.php');
session_start();
date_default_timezone_set('America/Lima');

 function obtenerProductosEnCarrito()
 {
     $bd = obtenerConexionb();
     $flag_0 = 0;
     $cliente_id = $_SESSION['SESS_cliente_id'];
     $sentencia = $bd->prepare("SELECT productos.*, carrito.*, cantidades.*  FROM carrito, productos, cantidades WHERE cliente_id = '$cliente_id' AND flag = '$flag_0' and carrito.prod_id = productos.prod_id and cantidades.cant_id = carrito.cant_id");
     $sentencia->execute();
     return $sentencia->fetchAll();
 }

 function productosTable()
 {
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT * FROM productos");
    $sentencia->execute();
    return $sentencia->fetchAll();
 }

function quitarProductoDelCarrito($idProducto)
{
    $bd = obtenerConexionb();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $sentencia = $bd->prepare("DELETE FROM carrito WHERE cliente_id = ? AND carrito_id = ?");
    return $sentencia->execute([$cliente_id, $idProducto]);
}

function borrarCarrito()
{
    $CartDetails = obtenerCartDetails();
    $bd = obtenerConexionb();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    foreach ($CartDetails as $carro) {  
        $cart_id = $carro->cart_id;
        $sentencia = $bd->prepare("UPDATE cart_details SET flag = '1' WHERE cart_id = ?  and cliente_id = ?");
        $sentencia->execute([$cart_id,$cliente_id]);
    }
    return true;
}

function obtenercantidades()
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT * FROM cantidades");
    $sentencia->execute();
    return $sentencia->fetchAll();
}
function obtenermoneda()
{
    $bd = obtenerConexionb();
    $flag_1 = 1;
    $sentencia = $bd->prepare("SELECT * FROM moneda WHERE flag='$flag_1'");
    $sentencia->execute();
    return $sentencia->fetchAll();
}
function obtenerCartDetails()
{
    $bd = obtenerConexionb();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $flag_0 = 0;
    $sentencia = $bd->prepare("SELECT * FROM carrito WHERE cliente_id = '$cliente_id' AND flag = '$flag_0'");
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function enviar_carrito_compras($prod_id)
{
    $bd = obtenerConexionb();
    $PrecioPlato = obtenerdetallePlato($prod_id);
    $food_precio= $PrecioPlato[0]->prod_price;
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $cant_id = 33;
    $total = $food_precio*1;
    $flag_0 = 0;
        
    //Create INSERT query
    $sentencia = $bd->prepare("INSERT INTO carrito(cliente_id, prod_id, cant_id, total, flag) VALUES(?,?,?,?,?)");
    return $sentencia->execute([$cliente_id,$prod_id,$cant_id,$total,$flag_0]);
}

function obtenerdetallePlato($prod_id)
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT * FROM productos WHERE prod_id='$prod_id'");
    $sentencia->execute();
    return $sentencia->fetchAll();

}
function CrearPedido($totalApagar)
{
    $bd = obtenerConexionb();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $flag_0 = 0;
    $time_stamp = date("H:i:s"); //gets the current time
    $delivery_date = date("Y-m-d"); //gets the current date
    //Create INSERT query
    $sentencia = $bd->prepare("INSERT INTO pedido(cliente_id, flag, time_stamp, precioTotal, delivery_date) VALUES(?,?,?,?,?)");
    $sentencia->execute([$cliente_id, $flag_0, $time_stamp, $totalApagar, $delivery_date]);
    return obtenerPedido();
}

function CocretarPedido($IdPedido)
{
    $bd = obtenerConexionb();
    $productos = obtenerProductosEnCarrito();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    foreach ($productos as $row) {     
        $cart_id = $row->carrito_id;
        $sentencia = $bd->prepare("UPDATE carrito SET flag = '1', estado ='Pendiente', IdPedido =  '$IdPedido' WHERE carrito_id = ?  and cliente_id = ?");
        $sentencia->execute([$cart_id, $cliente_id]);
     }
     return true;
}

function obtenerPedido()
{
    $bd = obtenerConexionb();
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $sentencia = $bd->prepare("SELECT * FROM pedido WHERE cliente_id='$cliente_id'");
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function obtenerDetallePedido($IdPedido)
{
    $bd = obtenerConexionb();
    $flag_0 = 0;
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $sentencia = $bd->prepare("SELECT prod_name,prod_description,prod_price,prod_photo,cant_value,total  FROM carrito,productos,cantidades WHERE carrito.IdPedido='$IdPedido' and carrito.cliente_id='$cliente_id'and carrito.prod_id = productos.prod_id AND carrito.cant_id=cantidades.cant_id");
    $sentencia->execute();
    return $sentencia->fetchAll();
}

// function obtenerProductos()
// {
//     $bd = obtenerConexion();
//     $sentencia = $bd->query("SELECT id, nombre, descripcion, precio FROM productos");
//     return $sentencia->fetchAll();
// }
function productoYaEstaEnCarrito($idProducto)
{
    $ids = obtenerIdsDeProductosEnCarrito();
    foreach ($ids as $id) {
        if ($id['prod_id'] == $idProducto) return true;
    }
    return false;
}

function obtenerIdsDeProductosEnCarrito()
{
    $bd = obtenerConexion();
    $flag_0 = 0;
    $cliente_id = $_SESSION['SESS_cliente_id'];
    $sentencia=$bd->query("SELECT prod_id FROM carrito WHERE cliente_id= '$cliente_id' AND flag='$flag_0'");
    return $sentencia;
}

// function agregarProductoAlCarrito($idProducto)
// {
//     // Ligar el id del producto con el usuario a través de la sesión
//     $bd = obtenerConexion();
//     iniciarSesionSiNoEstaIniciada();
//     $idSesion = session_id();
//     $sentencia = $bd->prepare("INSERT INTO carrito_usuarios(id_sesion, id_producto) VALUES (?, ?)");
//     return $sentencia->execute([$idSesion, $idProducto]);
// }


function iniciarSesionSiNoEstaIniciada()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

 function obtenerVariableDelEntorno($key)
 {
     if (defined("_ENV_CACHE")) {
         $vars = _ENV_CACHE;
     } else {
         $file = "env.php";
         if (!file_exists($file)) {
             throw new Exception("El archivo de las variables de entorno ($file) no existe. Favor de crearlo");
         }
         $vars = parse_ini_file($file);
         define("_ENV_CACHE", $vars);
     }
     if (isset($vars[$key])) {
         return $vars[$key];
     } else {
         throw new Exception("La clave especificada (" . $key . ") no existe en el archivo de las variables de entorno");
     }
 }
function obtenerConexion()
{
    //Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$link) {
        die('Error conexión servidor: ' . mysql_error());
    }
    return $link;
}
function obtenerConexionb()
{
    $password = obtenerVariableDelEntorno("MYSQL_PASSWORD");
    $user = obtenerVariableDelEntorno("MYSQL_USER");
    $dbName = obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
