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
    <title>Logowanie | Peartree</title>
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
	<h1>Logowanie</h1>
	<br>
	<form method="post" action="LoginExecute.php">
		<p>Podaj nazwę użytkownika:</p>
		<input type="text" name="username" max="30" value="">
		<br>
		<br>
		<p>Podaj hasło:</p>
		<input type="password" name="password" max="30" value="">
		<br>
		<br>
		<input type="submit" name="log" value="Zaloguj się">
		<br>
		<p>Nie masz konta? <a href="Registry.php">Zarejestruj się!</a> </p>
	</form>
	</div>
    <?php
        }
    ?>
</body>
</html>