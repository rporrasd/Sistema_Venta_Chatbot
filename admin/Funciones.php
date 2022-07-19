<?php
require_once('connection/config.php');

 function DescargaExcel()
{
    $bd = obtenerConexion();
    $sentencia=$bd->query("SELECT pedido.pedido_id, pedido.delivery_date ,clientes.cliente_id, clientes.nombre, clientes.apellidos, clientes.Dirección, clientes.telefono, productos.prod_name, productos.prod_price, carrito.total, carrito.carrito_id, carrito.estado, cantidades.cant_value FROM clientes, carrito, cantidades, productos, pedido WHERE clientes.cliente_id=carrito.cliente_id and productos.prod_id=carrito.prod_id and pedido.pedido_id=carrito.IdPedido AND carrito.cant_id=cantidades.cant_id");

	header('Content-Type: text/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename=data.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('ID_de_pedido', 'Fecha_de_entrega', 'ID_de_Cliente', 'Nombres', 'Apellidos', 'Direcin','emp_id', 'Telefono', 'Nombre_Producto', 'Precio_unitario', 'Precio_Total', 'Estado', 'Cantidad'));

	while($fetch = $sentencia->fetch_assoc()){
		fputcsv($output, $fetch);
	}
	
	fclose($output);
    return true;
 }

function DetalleOrdenesCarritoAdmin()
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT s.carrito_id as carritoid, f.pedido_id as IdPedido, c.cliente_id as IdCliente, c.nombre as nombreCli, c.apellidos as apellidoCli, c.Dirección as direccionCli, c.telefono as telefonoCli, p.prod_name as nombreProd, p.prod_price as precioProd, g.cant_value as cantidadProd, s.total as TotalProd, f.delivery_date as fechaVentaProd, s.estado as estadoProd FROM carrito s LEFT JOIN clientes c ON s.cliente_id = c.cliente_id LEFT JOIN productos p ON s.prod_id = p.prod_id LEFT JOIN cantidades g ON g.cant_id = s.cant_id LEFT JOIN pedido f ON f.pedido_id = s.IdPedido ORDER BY f.delivery_date DESC");
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

function Bucar_mayores_ventas()
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT p.prod_name as Nombre, COUNT(s.carrito_id) AS TotalVenta, SUM(g.cant_value) AS TotalCantidad FROM carrito s LEFT JOIN productos p ON p.prod_id = s.prod_id LEFT JOIN cantidades g ON g.cant_id = s.cant_id WHERE s.flag = 1 GROUP BY s.prod_id ORDER BY SUM(g.cant_value) DESC LIMIT 10");
    $sentencia->execute();
    return $sentencia->fetchAll();
}
function Buscar_prod_vendidos_recientemente()
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT COUNT(f.pedido_id) as cantidad, SUM(f.precioTotal) as totalVenta, f.delivery_date as fechaVenta FROM pedido f GROUP BY f.delivery_date ORDER BY f.delivery_date DESC LIMIT 10;");
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function Buscar_Top_ventas_cliente()
{
    $bd = obtenerConexionb();
    $sentencia = $bd->prepare("SELECT c.correo as Cliente, SUM(f.precioTotal) as totalVenta FROM pedido f LEFT JOIN clientes c ON f.cliente_id = c.cliente_id GROUP BY c.correo ORDER BY totalVenta DESC LIMIT 10");
    $sentencia->execute();
    return $sentencia->fetchAll();
}
// function PedidoEnProceso($OrderId)
// {
    // $bd = obtenerConexion();
    // echo "document.write('Hola');";
    // $sentencia=$bd->query("UPDATE carrito SET flag2 = '2' WHERE order_id = '$OrderId'");
    // return $sentencia;
// }

// function PedidoFinalizado($OrderId)
// {
//     $bd = obtenerConexion();

//     $sentencia=$bd->query("UPDATE carrito SET flag2 = '3' WHERE order_id = '$OrderId'");
//     return $sentencia;
// }

// analisis
 /*--------------------------------------------------------------*/
 /* Función para encontrar el producto de mayor venta

 /*--------------------------------------------------------------*/
//   function find_higest_saleing_product($limit){
//      global $db;
//      $db = obtenerConexion();
//      $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
//      $sql .= " FROM sales s";
//      $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
//     $sql .= " GROUP BY s.product_id";
//      $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
//      return $db->query($sql);
//    }

 /*--------------------------------------------------------------*/
 /* Función para mostrar ventas recientes
 $recent_sales    = find_recent_sale_added('5')
 /*--------------------------------------------------------------*/
//  function find_recent_sale_added($limit){
//     global $db;
//     $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
//     $sql .= " FROM sales s";
//     $sql .= " LEFT JOIN products p ON s.product_id = p.id";
//     $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
//     return find_by_sql($sql);
//   }
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
