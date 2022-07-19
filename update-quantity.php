<?php
    //Start session
    session_start();
    
    require_once('auth.php');
    
    //Include database connection details
    require_once('connection/config.php');
    
    //Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    
    
    if(isset($_POST['quantity']) && isset($_POST['item']))
        {
            //get cant_id
            $cant_id = $_POST['quantity'];
                
            //get cliente_id from session
            $cliente_id = $_SESSION['SESS_cliente_id'];
            
            //get cart_id
            $cart_id = $_POST['item'];
            //$cart_id = 5;
            
            //get the quantity value based on cant_id
            $qry_select=$link->query("SELECT * FROM cantidades WHERE cant_id='$cant_id'")
            or die("The system is experiencing technical issues. Please try again after some few minutes.");
            
            //storing the quantity_value into a variable
            $row=mysqli_fetch_array($qry_select);
            $quantity_value=$row['cant_value'];
            
            //get the price of a food based on cart_details and productos tables
            $result=$link->query("SELECT * FROM productos,carrito WHERE carrito.cliente_id='$cliente_id' AND carrito.flag='$flag_0' AND carrito.prod_id=productos.prod_id AND carrito.carrito_id='$cart_id'") or die("A problem has occured ... \n" . "Our team is working on it at the moment ... \n" . "Please check back after few hours."); 
             // var_dump($symbol);
            //storing the value of food price into a variable
            $row=mysqli_fetch_array($result);
            $prod_price=$row['prod_price'];
            
            //perform a simple calculation to get a total value of a food based on quantity_value and prod_price
            $total = $quantity_value * $prod_price;
            
            //Create UPDATE query (updates total and cant_id in the cart based on cart_id and cliente_id)
            $qry_update = "UPDATE carrito SET cant_id='$cant_id', total='$total' WHERE carrito_id='$cart_id' AND cliente_id='$cliente_id'";
            $link->query($qry_update);
            
            if($qry_update){
                header("location: cart.php");
            }
            else{
                //Do nothing
            }
            
        }else {
            die("Something went wrong! Our technical team are working on solving the problem. Please try again after few minutes.");
        }
?>