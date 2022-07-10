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
    <title>Dodaj kolumnę | Peartree</title>
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
        
        $current_table = $_SESSION['table'];

        if($current_table==NULL)
        {
            echo '<script type="text/javascript"> window.location="ChooseTable.php";</script>';
        }
        
        $connection = new mysqli($server_name, $username, $password, $database_name);
    
        if(mysqli_connect_errno()!=0)
        {
            echo 'Blad polaczenia: ' . mysqli_connect_error();
            exit;
        }

        if(isset($_POST['add_column_submit']))
        {
            $sql = "ALTER TABLE " . $current_table .  " ADD " . $_POST['column_name'] . " " . $_POST['column_type'] ."(" . $_POST['column_lenght']
            . ") NULL";
            
            $result_add_column = $connection -> query($sql);

			if($result_add_column==false)
			{
				echo 'Błędne polecenie sql: ' . $sql;

                echo "<script language='javascript'>";
                echo 'alert("Wystąpił błąd podczas dodawania kolumny.\nSprawdź wprowadzone dane.");';
                echo "</script>";
			}
			else
            {
                echo "<script language='javascript'>";
                echo 'alert("Dodano kolumnę do tabeli");';
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
                            echo"<form method='post' action='Peartree.php'>
                            <input type='submit' value='Powrót'>
                            </form>";
                        ?>
						</li>

					</ul>
			</div>
		</div>
	</div>
<?php
        echo"
        <div class='center'>
        <form method='post'>
            <label>Wprowadź nazwę kolumny:</label>
            </br>
            <input type='text' name='column_name' value='' placeholder='Nazwa kolumny...'>
            </br>
            <label>Wybierz typ danych:</label>
            </br>
            <select name='column_type'>
                <option value='VARCHAR' selected>Varchar</option>
                <option value='INT'>Int</option>
                <option value='TEXT'>Text</option>
                <option value='FLOAT'>Float</option>
            </select>
            </br>
            <label>Wprowadź długość:</label>
            </br>
            <input type='number' name='column_lenght' value='' placeholder='Np. 10...' min='1' max='5000'>
            </br>
			<input type='submit' name='add_column_submit' value='Dodaj kolumnę'>
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