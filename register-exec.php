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
		die('Falla de conexón de servidor: ' . mysql_error());
	}

	//Sanitize the POST values
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$login = $_POST['login'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
    $question_id = $_POST['question'];
    $answer = $_POST['answer'];
	$Dirección = $_POST['cDirección'];
	$telefono = $_POST['fono'];

    //check whether an account with a given email exists
    $qry_select="SELECT * FROM clientes WHERE correo='$login'";
    $result_select=$link->query($qry_select);
    if(mysqli_num_rows($result_select)>0){
        header("location: register-failed.php");
        exit();
    }
    else{
	    //Create INSERT query
	    $qry = "INSERT INTO clientes(nombre, apellidos, correo, contraseña, telefono, Dirección, documento_id,numeroDoc) VALUES('$fname','$lname','$login','$password','$telefono','$Dirección','$question_id','$answer')";
	    $result = @$link->query($qry);

	    //Check whether the query was successful or not
	    if($result) {
		    header("location: register-success.php");
		    exit();
	    }else {
			
		    die("Something went wrong.\n Our team is working on it at the  moment.\n Please try again after some few minutes.");
	    }
    }
?>