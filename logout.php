<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_cliente_id']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pizza-Inn:Logged Out</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
  <div id="menu"><ul>
  <li><a href="index.php">Inicio</a></li>
  <li><a href="cart.php">Mi Carrito de Compras</a></li>
  <li><a href="member-index.php">Mi cuenta</a></li>
  </ul>
  </div>
<div id="header">
  <div id="logo"> <a href="index.php" class="blockLink"></a></div>
  <div id="company_name">Restaurante</div>
</div>
<div id="center">
<h1>Desconectado </h1>
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
<p>&nbsp;</p>
<div class="error">Has sido desconectado.</div>
<p>Para iniciar sesión de nuevo por favor Haga clic <a href="Login.php">aquí</a> o <a href="login-register.php">registrarse</a>. </p>
</div>
</div>
<?php include 'footer.php'; ?>
</div>
</div>
</body>
</html>
