<?php
//checking connection and connecting to a database
require_once('connection/config.php');
error_reporting(1);
//Connect to mysql server
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    
//retrieve questions from the documento table
$documento=$link->query("SELECT * FROM documento")
or die("Something is wrong ... \n" . mysql_error());
?>
<?php
//setting-up a remember me cookie
    if (isset($_POST['Submit'])){
        //setting up a remember me cookie
        if($_POST['remember']) {
            $year = time() + 31536000;
            setcookie('remember_me', $_POST['login'], $year);
        }
        else if(!$_POST['remember']) {
            if(isset($_COOKIE['remember_me'])) {
                $past = time() - 100;
                setcookie(remember_me, gone, $past);
            }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo APP_NAME ?>:Login</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
  <div id="menu"><ul>
  <li><a href="index.php">Inicio</a></li>
  </ul>
  </div>
<div id="header">

  <div id="company_name"><?php echo APP_NAME ?> Restaurante</div>
</div>
<div id="center">
  <h1>Registrarse</h1>
  <table align="center">
    <tr align="center">
        <hr>
        <td style="text-align:center;">
            <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px;">
            <form id="loginForm" name="loginForm" method="post" action="register-exec.php" onsubmit="return registerValidate(this)">
              <table width="450" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr>
                    <td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Crea tu nueva cuenta</td>
                </tr>
                <tr>
                  <th>Nombre </th>
                  <td><font color="#FF0000">* </font><input name="fname" type="text" class="textfield" id="fname" /></td>
                </tr>
                <tr>
                  <th>Apellidos </th>
                  <td><font color="#FF0000">* </font><input name="lname" type="text" class="textfield" id="lname" /></td>
                </tr>
                <tr>
                  <th width="124">Correo electrónico</th>
                  <td width="168"><font color="#FF0000">* </font><input name="login" type="text" class="textfield" id="login" /></td>
                </tr>
                <tr>
                  <th>contraseña</th>
                  <td><font color="#FF0000">* </font><input name="password" type="password" class="textfield" id="password" /></td>
                </tr>
                <tr>
                  <th>Confirmar contraseña</th>
                  <td><font color="#FF0000">* </font><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
                </tr>
                <tr>
                  <th>Teléfono</th>
                  <td><font color="#FF0000">* </font><input name="fono" type="text" class="textfield" id="fono" /></td>
                </tr>    
                <tr>
                  <th>Dirección</th>
                  <td><font color="#FF0000">* </font><input name="cDirección" type="text" class="textfield" id="cDirección" /></td>
                </tr> 
                <tr>
                  <th>Tipo de documento</th>
                    <td><font color="#FF0000">* </font><select name="question" id="question">
                    <option value="select">- seleccionar Documento -
                    <?php 
                    //loop through cantidades table rows
                    while ($row=mysqli_fetch_array($documento)){
                    echo "<option value=$row[documento_id]>$row[documento_text]"; 
                    }
                    ?>
                    </select></td>
                </tr>
                <tr>
                  <th>Número de documento</th>
                  <td><font color="#FF0000">* </font><input name="answer" type="text" class="textfield" id="answer" /></td>
                </tr>
                <tr>
                <td colspan="2"><!--<input type="reset" value="Clear Fields"/>-->
                <input type="submit" name="Submit" value="Registrar" /></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
              </table>
            </form>
            </div>
            <p>Si ya tienes una cuenta <a href="login.php">inicie sesión aqui</a>. </p>
        </td>
    </tr>
</table>
<hr>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>
