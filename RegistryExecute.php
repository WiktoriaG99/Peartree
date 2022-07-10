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
<?php
    //Jeżeli użytkownik zalogownay
    if (isset ($_SESSION['loged_user']))
    {
        echo '<script type="text/javascript"> window.location="Peartree.php";</script>';
    }

    //Jeżeli użytkownik niezalogowany
    else
    {
        $server_name = "localhost";
        $username = "root";
        $password = '';
        $database_name = "Peartree";

        $connection = new mysqli($server_name, $username, $password, $database_name);
        ?>
        <div id='Top'>
		<div id='Logo'>
			<image src='LogoPeartree.png' width='200' heigth='200' alt='Logo Peartree'>
		</div>
		<div id='Top_Right'>	
			<div id='PeartreeNameFull'>
				<p>Peartree</p>
			</div>
		</div>
	</div>
<?php
        //Jeżeli wysłano formularz "reg"
       if(isset($_POST['registry']))
        {
            //Jeżeli nazwa użytkownika, hasło i e-mail nie są puste oraz jeśli hasło i jego powtórzenie są takie same
            if($_POST['username'] != "" && $_POST['password'] != "" && $_POST['re_password'] != "" && $_POST['email'] != "" && $_POST['password']==$_POST['re_password'])
            {
                // Sprawdzanie czy w bazie danych znajduje się już użytkownik o podanym loginie i/lub mailu
                $querry = "SELECT * FROM users WHERE username='$_POST[username]' OR email='$_POST[email]' LIMIT 1";
                $result = $connection-> query($querry);
                if($result==false)
                    {
                        echo 'Błędne polecenie sql: ' . $sql;
                        $connection->close();
                        exit;
                    }
                $user = $result->fetch_assoc();
                
                //Jeżeli uzytkownik nie istnieje
                if(!$user)
                {		
                    //Dodanie użytkownika do bazy danych
                    $querry = "INSERT INTO users (username, password, email)
                    VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['email'] . "')";
                    
                    if ($connection->query($querry) === TRUE) 
                    {
                        echo "<div class='center'> 
                            <p>Pomyślnie zarejestrowano.</p>";
                            echo "<form method='post' action='Login.php'>
                                <input type='submit' value='OK'>
                            </form>
                        </div>";
                    } 
                    else 
                    {
                        echo "<p>Wystąpił  błąd: " . $querry . "</p><br>" . $connection->error;
                    }
                }
                else
                {
                    echo "<div class='center'> 
                        <p>Użytkownik o podanej nazwie użytkownika i/lub adrenie e-mail już istnieje!</p>";
                        echo "<form method='post' action='Registry.php'>
                            <input type='submit' value='Powrót'>
                        </form>
                    </div>";
                }
            }
            else
            {
                echo "<div class='center'> 
                    <p>Podano błędne dane. Spróbuj ponownie z poprawnymi danymi.</p>";
                    echo "<form method='post' action='Registry.php'>
                        <input type='submit' value='Powrót'>
                    </form>
                </div>";
            }
        }
        else
        {
            echo '<script type="text/javascript"> window.location="index.php";</script>'; 
        }
        
    }
?>
</body>
</html>