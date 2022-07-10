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
    <title>Konto | Peartree</title>
</head>
<body>
<?php
    //Jeżeli użytkownik zalogownay
    if (isset ($_SESSION['loged_user']))
    {
        $server_name = $_SESSION['servername'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $database_name = $_SESSION['database_name'];

        $connection = new mysqli($server_name, $username, $password, $database_name);

        if(mysqli_connect_errno()!=0)
        {
            echo 'Blad polaczenia: ' . mysqli_connect_error();
            exit;
        }

        //Wylogowanie
        if (isset($_POST['logout'])) 
        {
            session_destroy();
            echo '<script type="text/javascript"> window.location="Login.php";</script>';
        }

        //Pobieranie danych zalogowanego użytkownika
        $querry = "SELECT * FROM users WHERE username='$_SESSION[loged_user]'";
        $result = $connection-> query($querry);
        if($result==false)
            {
                echo 'Błędne polecenie sql: ' . $sql;
                $connection->close();
                exit;
            }
        $user = $result->fetch_assoc();

		
		//Przypisanie danych z bazy danych do zmiennych
		$email_var = $user['email'];


?>
        <div id='Top'>
		<div id='Logo'>
			<image src='LogoPeartree.png' width='200' heigth='200' alt='Logo Peartree'>
		</div>
		<div id='Top_Right'>	
			<div id='PeartreeName'>
				<p>Peartree</p>
			</div>
			<div id='Panel_user'>
					<ul class="navigation">
						<li class="navigation-item">
							<?php
							echo "<form method='post'>
								<input type='submit' name='logout' value='Wyloguj się'>
							</form>";
							?>
						</li>
                        <li class="navigation-item">
							<?php
							echo "<form method='post' action='Peartree.php'>
								<input type='submit' value='Powrót'>
							</form>";
							?>
						</li>
					</ul>
			</div>
		</div>
	</div>
    <div class='center'>
        <h1>Dane konta</h1>
        <br>
        <p>Adres e-mail:</p>
        <?php
            echo "<p>$email_var</p>";
        ?>

        <form method="post" action="EditAccountExecute.php">
            <p>Nazwa użytkownika:</p>
            <?php
            echo"<input type='text' name='username' max='30' value='" . $_SESSION['loged_user'] . "'>";
            ?>
            <br>
            <br>
            <input type="submit" name = "change_username" value="Zmień nazwę użytkownika">
            <br>
        </form>

        <form method="post" action="EditAccountExecute.php">
            <p>Podaj stare hasło:</p>
            <input type="password" name="old_password" max="30" value="">
            <br>
            <br>
            <p>Podaj nowe hasło:</p>
            <input type="password" name="new_password" max="30" value="">
            <br>
            <br>
            <p>Powtórz nowe hasło:</p>
            <input type="password" name="re_new_password" max="30" value="">
            <br>
            <br>
            <input type="submit" name = "change_password" value="Zmień hasło">
            <br>
            <br>
            <br>
        </form>
    </div>
<?php
    }
    else
    {
?>
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
        <div class='center'>
            <p>Zaloguj się, aby uzyskać dostęp do zasobów.</p>
            <form method='post' action='Login.php'>
                <input type='submit' value='Zaloguj się'>
            </form>
        </div>
<?php
    }
?>
</body>
</html>