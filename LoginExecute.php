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

        //Jeżeli wysłano formularz "log"
       if(isset($_POST['log']))
       {
           //Jeżeli nazwa użytkownika i hasło nie są puste
           if($_POST['username'] != "" && $_POST['password'] != "")
           {
                    // Sprawdzanie czy w bazie danych znajduje się użytkownik o podanym loginie i haśle
                    $querry = "SELECT * FROM users WHERE username='$_POST[username]' AND password='$_POST[password]' LIMIT 1";
                    $result = $connection-> query($querry);
                    if($result==false)
                        {
                            echo 'bledne polecenie sql: ' . $querry;
                            $connection->close();
                            exit;
                        }
                    $user = $result->fetch_assoc();
                    
                    //Jeżeli uzytkownik istnieje
                    if($user)
                    {		
                        //Rozpoczęcie sesji
                        $_SESSION['loged_user']=$_POST['username'];
                        $_SESSION['loged_user_password'] = $_POST['password'];

                        $_SESSION['servername']= "localhost";
                        $_SESSION['username']= "root";
                        $_SESSION['password']= '';
                        $_SESSION['database_name'] = "Peartree";

                        echo '<script type="text/javascript"> window.location="ChooseTable.php";</script>';
                    }
                    else
                    {
                        echo "<div class='center'> 
                            <p>Błędne dane logowania.</p>";
                            echo "<form method='post' action='Login.php'>
                                <input type='submit' value='Powrót'>
                            </form>
                        </div>";
                    }
           }
            //Jeżeli podano błędne dane logowania
            else
            {
                echo "<div class='center'> 
                    <p>Błędne dane logowania.</p>";
                    echo "<form method='post' action='Login.php'>
                        <input type='submit' value='Powrót'>
                    </form>
                </div>";
            }
    }
    }
?>
</body>
</html>