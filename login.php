<?php

session_start();

$error='';

if (isset($_POST['submit'])) {

    if (empty($_POST['password'])) {
        $error = "Jedno z pól jest puste";

    } else {

        $password = $_POST['password'];

        if ($password === '1111') { 

            $_SESSION['login_user'] = true; 
            header("location: main.php"); 

        } else {

            $error = "Nieprawidłowe hasło";

        }
    }
}
?>