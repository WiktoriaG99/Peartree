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
    <title>Wybierz tabelę | Peartree</title>
</head>
<body>
<?php
    //Jeżeli użytkownik zalogownay
    if (isset ($_SESSION['loged_user']))
    {
        //Wylogowanie
        if(isset($_POST['logout']))
        {
            session_destroy();
            echo '<script type="text/javascript"> window.location="Login.php";</script>';
        }	    

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

        //Pobranie wszystkich tabel przypisanych do użytkownika o danym ID
        $sql_querry = "SELECT table_name FROM user_table_connection WHERE id_user= " . $loged_user_id;
        $result = $connection -> query($sql_querry);
    
        if($result==false)
        {
            echo 'bledne polecenie sql: ' . $sql_querry;
            $connection->close();
            exit;
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
							echo "<form method='post' action='EditAccount.php'>
								<input type='submit' name='edit_account' value='Konto'>
							</form>";
							?>
						</li>
                        <li class="navigation-item">
							<?php
                            echo "<form method='post' action='AddTable.php'>
                                <input type='submit' name='add_table' value='Dodaj tabelę'>
                            </form>";
							?>
						</li>
					</ul>
			</div>
		</div>
	</div>
        <?php
            $number_of_tables = mysqli_num_rows($result);
            echo"<div class='center' id='ChooseTable'>
                <form method='post'>
                    <label>Wybierz tabelę:</label>
                    </br>
                    <select name='choosed_table'>";
                    while ($table = mysqli_fetch_array($result)) 
                    {
                        echo"<option value='" . $table[0] . "'>" . $table[0] . "</option>";
                    }
                    echo"</select>
                    </br>
                    <input type='submit' name='choosed_table_submit' value='Wybierz'>
                </form>
                </div>";
        }

        //Przypisanie aktualnej tabeli do zmiennej $SESSION
        if(isset($_POST['choosed_table_submit']))
		{
			$_SESSION['table']=$_POST['choosed_table'];
            $_SESSION['query'] = "SELECT * FROM " . $_POST['choosed_table'];
            echo '<script type="text/javascript"> window.location="Peartree.php";</script>';

		}    
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