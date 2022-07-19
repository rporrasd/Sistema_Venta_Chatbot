<?php
    //Start session
    session_start();
    
    //checking connection and connecting to a database
    require_once('connection/config.php');
    //Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    
    $IDEstado = "Finalizado";
     // check if the 'id' variable is set in URL
     if (isset($_GET['id']))
     {
         // get id value
         $id = $_GET['id'];
         
         $resultVal = $link->query("SELECT * FROM carrito WHERE carrito_id = '$id'");
         if(mysqli_num_rows($resultVal)>0)
         {
            foreach ($resultVal as $ids) 
            {
                if ($ids['estado'] == "$IDEstado")
                {
                    header("Location: orders.php");
                }
                else
                {
                    // delete the entry
                    $result = $link->query("UPDATE carrito SET estado = '$IDEstado' WHERE carrito_id = '$id'")
                    or die("There was a problem while removing the food ... \n" . mysql_error()); 

                     // redirect back to the foods page
                     header("Location: orders.php");
                }
            }
         }

     }
     else
     // if id isn't set, redirect back to the foods page
     {
        header("Location: Index.php");
     }
?>