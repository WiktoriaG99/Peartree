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
    <title>Peartree</title>
</head>
<body>
<?php
    //Jeżeli użytkownik zalogownay
    if (isset ($_SESSION['loged_user']))
    {
        echo '<script type="text/javascript"> window.location="Peartree.php";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> window.location="Login.php";</script>';
    }
?>
</body>
</html>