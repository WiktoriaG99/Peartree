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
    <title>Usuń tabelę | Peartree</title>
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

        if(isset($_POST['delete_table_submit']))
        {
            $sql_querry = "DROP TABLE " . $current_table;
            $result_delete_table = $connection -> query($sql_querry);

			if($result_delete_table==false)
			{
				echo 'Błędne polecenie sql_querry: ' . $sql_querry;
                echo "<script language='javascript'>";
                echo 'alert("Wystąpił błąd podczas usuwania tabeli.");';
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

                $sql_querry = "DELETE FROM user_table_connection WHERE id_user='" . $loged_user_id . "' AND table_name='" . $current_table . "'";
                $result = $connection -> query($sql_querry);

                if($result==false)
                {
                    echo 'Błędne polecenie sql_querry: ' . $sql_querry;
                    echo "<script language='javascript'>";
                    echo 'alert("Wystąpił błąd podczas usuwania tabeli.");';
                    echo "</script>";
                }
                else
                {
                    echo "<script language='javascript'>";
                    echo 'alert("Usunięto tabelę.");';
                    $_SESSION['table'] = NULL;
                    echo 'window.location.replace("ChooseTable.php");';
                    echo "</script>";
                }
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
					</ul>
			</div>
		</div>
	</div>
    <div class='center'>
<?php
        echo" <p>Czy na pewno chcesz usunąć tabelę o nazwie: " . $current_table . "</p>";

        echo"<form method='post'>
            <input type='submit' name='delete_table_submit' value='Tak, usuń'>
            </form>
        ";

        echo"<form method='post' action='Peartree.php'>
            <input type='submit' value='Nie, powróć'>
            </form>
        ";
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
    </div>
</body>
</html>