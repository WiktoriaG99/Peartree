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
    <title>Dodaj tabelę | Peartree</title>
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

        //Stworzenie tabeli z kolumną id
        if(isset($_POST['create_table_submit']))
        {
            /*
            $sql_querry = "CREATE TABLE " . $_POST['new_table_name'] . 
            " (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY)";
            */

            $sql_querry = "CREATE TABLE " . $_POST['new_table_name'] . 
            " (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY," .
            " peartree_character VARCHAR(30)," .
            " peartree_line VARCHAR(2000)," .
            " peartree_start_conversation VARCHAR(1000)," . 
            " peartree_link VARCHAR(200)," .
            " peartree_image VARCHAR(200)," .
            " peartree_weather VARCHAR(200), " .
            " peartree_friendship_level VARCHAR(20))";

            $wynik_create_table = $connection -> query($sql_querry);

			if($wynik_create_table==false)
			{
				//echo 'Błędne polecenie sql: ' . $sql_querry;

                echo "<script language='javascript'>";
                echo 'alert("Wystąpił błąd podczas tworzenia tabeli.\nSprawdź wprowadzone dane.");';
                echo "</script>";
			}
			else
            {
                //Pobranie ID obecnie zalogowanego użytkownika
                $sql_querry = "SELECT id FROM users WHERE username = '" . $_SESSION['loged_user'] . "'";
                $result = $connection -> query($sql_querry);
                if($result==false)
                {
                    echo 'bledne polecenie sql: ' . $sql_querry;
                    $connection->close();
                    exit;
                }
                //Przypisanie ID do zmiennej
                while ($row = mysqli_fetch_array($result)) 
                {
                    $loged_user_id = $row[0];
                }

                $sql_querry  = "INSERT INTO user_table_connection (id_user, table_name) VALUES ('" . $loged_user_id ."','" . $_POST['new_table_name'] . "')";
                $result = $connection -> query($sql_querry);
                if($result==false)
                {
                    echo 'bledne polecenie sql: ' . $sql_querry;
                    $connection->close();
                    exit;
                }
                echo "<script language='javascript'>";
                echo 'alert("Utworzono tabelę.");';
                echo 'window.location.replace("ChooseTable.php");';
                echo "</script>";
            }
        }
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
<?php
        echo"<div class='center'>
        <form method='post'>
            <label>Wprowadź nazwę tabeli:</label>
            </br>
            <input type='text' name='new_table_name' value='' placeholder='Nazwa tabeli...'>
            </br>
            <input type='submit' name='create_table_submit' value='Stwórz tabelę'>
        </form>";

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