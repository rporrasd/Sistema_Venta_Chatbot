<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('connection/config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection

	
	//Sanitize the POST values
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	//Create query
	$qry="SELECT * FROM clientes WHERE correo='$login' AND contraseña='$password'";
	$result=$link->query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = $result->fetch_assoc();
			$_SESSION['SESS_cliente_id'] = $member['cliente_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['nombre'];
			$_SESSION['SESS_LAST_NAME'] = $member['apellidos'];
			session_write_close();
			header("location: Index.php");
			exit();
		}else {
			//Login failed
			header("location: login-failed.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>