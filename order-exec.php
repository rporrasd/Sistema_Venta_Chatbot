<?php
	//Start session
	//session_start();
	
	require_once('auth.php');
	
	//Include database connection details
	require_once('connection/config.php');
	
	//Connect to mysql server
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	

	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
     
    //get cliente_id from session
    $cliente_id = $_SESSION['SESS_cliente_id'];
    
    //checks whether the member has a billing address setup
    //get the billing_id from the billing_details table based on the cliente_id in auth.php
    $qry_select=$link->query("SELECT * FROM billing_details WHERE cliente_id='$cliente_id'")
    or die("The system is experiencing technical issues.\n Our team is working on it.\nPlease try again after some few minutes.");

	if(mysqli_num_rows($qry_select)== 0 && isset($_GET['id']))
	{
 		//define default values for flag_0
 		$flag_0 = 0;

 		//retrieve questions from the questions table
 		$questions=$link->query("SELECT * FROM clientes  WHERE cliente_id ='$cliente_id';")
 		or die("Algo está mal ... \n" . mysql_error());

 		$data = $questions->fetch_array();

		// check if the 'id' variable is set in URL
		if (isset($_GET['id']))
		{
			// get id value
			$id = $_GET['id'];

			//Sanitize the POST values
			$StreetAddress = $data['Dirección'];
			$BoxNo = $data['login'];
			$MobileNo = $data['telefono'];

			if(isset($BoxNo))
			{
				$mystring = mb_strlen($BoxNo);
				if($mystring > 15)
				{
					$BoxNo = substr ( $BoxNo, 0, 15);
				}
			}
			//Create INSERT query
			$qry_billdet = "INSERT INTO billing_details(cliente_id,Street_Address,P_O_Box_No,City,Mobile_No,Landline_No) VALUES('$cliente_id','$StreetAddress','$BoxNo','$StreetAddress','$MobileNo','$MobileNo')";
			$link->query($qry_billdet);
		}
	}

    $qry_select=$link->query("SELECT * FROM billing_details WHERE cliente_id='$cliente_id'")
    or die("The system is experiencing technical issues.\n Our team is working on it.\nPlease try again after some few minutes.");
    if(mysqli_num_rows($qry_select) > 0 && isset($_GET['id']))
	{
	        //get cart_id
	        $id = $_GET['id'];
            
	        //define default values for flag_0 and flag_1
            $flag_0 = 0;
            $flag_1 = 1;
            
            //retrive a timezone from the timezones table
            $timezones=$link->query("SELECT * FROM timezones WHERE flag='$flag_1'")
            or die("Something is wrong. \n Our team is working on it at the moment.\n Please check back after some few minutes.");
            
            $row=mysqli_fetch_assoc($timezones); //gets retrieved row
            
            $active_reference = $row['timezone_reference']; //gets active timezone
            
           // date_default_timezone_set($active_reference); //sets the default timezone for use
            
            $time_stamp = date("H:i:s"); //gets the current time
            
    	$delivery_date = date("Y-m-d"); //gets the current date
	        
	    //storing the billing_id into a variable
	    $row=mysqli_fetch_array($qry_select);
	    $billing_id=$row['billing_id'];

	    $staff = 4;
	        
	    //Create INSERT query
	     $qry_create = "INSERT INTO carrito(cliente_id,billing_id,cart_id,delivery_date,staffID,flag,time_stamp) VALUES('$cliente_id','$billing_id','$id','$delivery_date','$staff','$flag_0','$time_stamp')";
	     $link->query($qry_create);
            
        //Create UPDATE query (updates flag value in the cart_details table)
	    $qry_update = "UPDATE cart_details SET flag='$flag_1' WHERE cart_id='$id' AND cliente_id='$cliente_id'";
        $link->query($qry_update);
		
	     header("location: member-index.php");
		    
    }
	else 
	{
	     header("location: billing-alternative.php"); //redirects to billing-alternative.php if not setup
	}
?>