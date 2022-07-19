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
    
 
 
     // check if the 'id' variable is set in URL
     if (isset($_GET['id']))
     {
         // get id value
         $id = $_GET['id'];
         
         // delete the entry
         $result = $link->query("DELETE FROM productos WHERE prod_id='$id'")
         or die("There was a problem while removing the food ... \n" . mysql_error()); 
         
         // redirect back to the foods page
         header("Location: foods.php");
         }
     else
     // if id isn't set, redirect back to the foods page
     {
        header("Location: foods.php");
     }
 
?>