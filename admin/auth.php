<?php
	//Start session
	session_start();
	error_reporting(1);
	
	//Check whether the session variable SESS_cliente_id is present or not
	if(!isset($_SESSION['SESS_ADMIN_ID']) || (trim($_SESSION['SESS_ADMIN_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}
?>