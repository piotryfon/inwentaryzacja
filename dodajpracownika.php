<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>dodaj pracownika</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<header>
			<ul class="nav justify-content-center">

				<li class="nav-item">
					<a class="nav-link active" href="index.php">str. gł</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="dodajpracownika.php">dodaj pracownika</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="dodajsprzet.php">dodaj sprzęt</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="edytuj_status.php">znajdź i edytuj</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
				</li>
			</ul>
		</header>
		<h3>Dodaj pracownika</h3>

		<form method="post">
			<div class="row">
				<div class="col-md-4 offset-4">
					<p>
						<label for="login_pracownika">login:</label><br>
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
					<input class="btn btn-primary" type="submit" name="submit" value="submit" />
				</div>
			</div>
		</form>

		<?php
		require("connection.php");

		if (isset($_POST['submit'])) {
			$login_pracownika = mysqli_real_escape_string($conn, $_REQUEST['login_pracownika']);
			$imie = mysqli_real_escape_string($conn, $_REQUEST['imie']);
			$nazwisko = mysqli_real_escape_string($conn, $_REQUEST['nazwisko']);
			$departament = mysqli_real_escape_string($conn, $_REQUEST['departament']);
			$pokoj = mysqli_real_escape_string($conn, $_REQUEST['pokoj']);

			if ($login_pracownika == "" or $imie == "") {

				echo '<p>Zostawiłeś puste pole</p>';
			} else {
				$sql = "INSERT INTO pracownicy (login_pracownika, imie, nazwisko, departament, pokoj) VALUES ('$login_pracownika', '$imie', '$nazwisko','$departament','$pokoj')";
				if (mysqli_query($conn, $sql)) {
					echo '<h3>Rekrd został dodany</h3>';
				} else {
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
			}
		}
		mysqli_close($conn);
		?>
	</div>
</body>

</html>