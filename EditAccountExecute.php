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
								<input type='submit' value='Powrót'>
							</form>";
							?>
						</li>
					</ul>
			</div>
		</div>
	</div>
    <div class='center'>
<?php

       if(isset($_POST['change_username']))
        {
            
           //Jeżeli nazwa użytkownika nie jest pusta
           if($_POST['username'] != "")
           {
            $querry = "UPDATE users SET username ='" .$_POST['username']
            ."' WHERE username='" . $_SESSION['loged_user']."'";
            
                if ($connection->query($querry) === TRUE) 
                {
                  $_SESSION['loged_user'] = $_POST['username'];
                  echo "<p>Zmieniono nazwę użytkownika.</p>";
                  echo '</br>';
                  echo '</br>';
                } 
                else 
                {
                  echo "<p>Error: " . $querry . "<br></p>" . $connection->error;
                }
            }
            else
            {
                echo"<p>Podano błędne dane lub pole jest puste.</p>";
            }
        }
        if(isset($_POST['change_password']))
        {
            //Jeżeli pola hasła nie są puste
            if($_POST['old_password'] != "" && $_POST['new_password']!="" && $_POST['re_new_password'] !="" && $_POST['new_password']==$_POST['re_new_password'])
            {
                $querry = "UPDATE users SET password ='" .$_POST['new_password']
                ."' WHERE username='" . $_SESSION['loged_user']."'";
                if ($connection->query($querry) === TRUE) 
                {
                  echo "<p>Zmieniono hasło.</p>";
                  echo '</br>';
                  echo '</br>';
                } 
                else 
                {
                  echo "<p>Error: " . $querry . "<br></p>" . $connection->error;
                }
            }
            else
            {
                echo"<p>Podano błędne dane lub pola są puste.</p>";
            }
         }
    }
    else
    {
        echo '<script type="text/javascript"> window.location="index.php";</script>';
    }
?>
</div>
</body>
</html>