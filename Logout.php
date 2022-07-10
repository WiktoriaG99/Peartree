<?php

session_start();

//Zakończenie sesji
session_destroy();

//Przeniesienie na stronę głowną
header('Location: Login.php');

?>