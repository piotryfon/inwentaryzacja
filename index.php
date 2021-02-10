<?php
require('login.php');

if (isset($_SESSION['login_user'])) {
    header("location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logowanie</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
	integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>

	<div class="container">
        <br>
		<h3><em>Zaloguj się do aplikacji inwentaryzacyjnej HelpDesk</em></h3>
		<form action="" method="post">
            <label>Hasło:</label><br>
            <input name="password" placeholder="Hasło" type="password"><br>
            <br>
            <input class="btn btn-success" name="submit" type="submit" value="Zaloguj się">
            <br><br>
            <span><?php echo $error; ?></span>
        </form>	
	</div>

</body>
</html>