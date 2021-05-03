<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
	require('navbar.php');
	require("connection.php");
	require("test_input.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>dodaj pracownika</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
	<link rel="stylesheet" href="./style/main.css">
</head>

<body>
	<div class="container">
		<header>
			<?php
				showNavbar();
			?>
		</header>
		<?php
		
		if (isset($_POST['submit'])) {
		
				$login_pracownika = test_input($_POST["login_pracownika"]);
				$imie = test_input($_POST["imie"]);
				$nazwisko = test_input($_POST["nazwisko"]);
				$departament = test_input($_POST["departament"]);
				$pokoj = test_input($_POST["pokoj"]);
			  
			if ($login_pracownika == "") {
				echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Zostawiłeś puste pole...</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';
			} else {
				$sql_check = "SELECT id_pracownika FROM pracownicy WHERE login_pracownika = '$login_pracownika'";
				$sql_check_result = mysqli_query($conn, $sql_check);
				if(mysqli_num_rows($sql_check_result)) {
					echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Taki login już istnieje i nie może być ponownie dodany!</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>';
				} else {
					$sql = "INSERT INTO pracownicy (login_pracownika, imie, nazwisko, departament, pokoj) VALUES ('$login_pracownika', '$imie', '$nazwisko','$departament','$pokoj')";
					if (mysqli_query($conn, $sql)) {
						echo '<script type="text/javascript">
						alert("Dodano pracownika.");
						</script>';
					} else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
			}
		}
		mysqli_close($conn);
		?>
		<h4>Dodaj pracownika</h4>
		<p>Zanim dodasz pracownika, sprawdź czy taki login istnieje w 
		<a href="pracownicy_tabela.php">pracownicy-tabela</a>.</p>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="row">
				<div class="col-md-4 offset-4">
					<p>
						<label for="login_pracownika">*login:</label><br>
						<input type="text" name="login_pracownika" id="login_pracownika">
					</p>
					<p>
						<label for="imie">imie:</label><br>
						<input type="text" name="imie" id="imie">
					</p>
					<p>
						<label for="nazwisko">nazwisko:</label><br>
						<input type="text" name="nazwisko" id="nazwisko">
					</p>
				</div>
				<div class="col-md-4">
					<p>
						<label for="departament">departament:</label><br>
						<input type="text" name="departament" id="departament">
					</p>
					<p>
						<label for="pokoj">pokój:</label><br>
						<input type="text" name="pokoj" id="pokoj">
					</p>
					<button class="btn btn-outline-success" type="submit" name="submit">Dodaj pracownika</button>
					<p>* pole wymagane</p>
				</div>
			</div>
		</form>

		
	</div>
	<script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>

</html>