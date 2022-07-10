<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_style.css">
    <title>Rejestracja | Peartree</title>
</head>
<body>

<div id='Top'>
		<div id='Logo'>
			<image src='LogoPeartree.png' width='200' heigth='200' alt='Logo Peartree'>
		</div>
		<div id='Top_Right'>	
			<div id='PeartreeName'>
				<p>Peartree</p>
			</div>
			<div id='Panel_user'>
			</div>
		</div>
	</div>

<div class="center" >
    <?php
        //Jeżeli użytkownik zalogownay
        if (isset ($_SESSION['loged_user']))
        {
			echo '<script type="text/javascript"> window.location="Peartree.php";</script>';
        }
        else
        {
    ?>
	<h1>Rejestacja</h1>
	<br>
	<form method="post" action="RegistryExecute.php">
        <p>Podaj adres e-mail:</p>
		<input type="text" name="email" max="30" value="">
		<br>
        <br>
		<p>Podaj nazwę użytkownika:</p>
		<input type="text" name="username" max="30" value="">
		<br>
		<br>
		<p>Podaj hasło:</p>
		<input type="password" name="password" max="30" value="">
		<br>
		<br>
        <p>Powtórz hasło:</p>
		<input type="password" name="re_password" max="30" value="">
		<br>
		<br>
		<input type="submit" name = "registry" value="Zarejestruj się">
        <br>
        <p>Masz już konto? <a href="Login.php">Zaloguj się!</a> </p>
	</form>
	</div>
    <?php
        }
    ?>
</body>
</html>