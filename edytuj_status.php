<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>edytuj status sprzętu</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<style>
		.green{
			color: green;
		}

	</style>
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
					<a class="nav-link active" href="edytuj_status.php">zmień status sprzętu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
				</li>
				<li class="nav-item">
                    <a class="nav-link active" href="pracownicy_tabela.php">pracownicy - tabela</a>
				</li>
				<li class="nav-item">
                    <a class="nav-link active" href="sprzet_pracownik_tab.php">pracownicy/sprzęt - tabela</a>
                </li>
			</ul>
		</header><br>
		<h4>Edycja przypisania użytkownika do sprzętu.</h4> <hr>
		<p>Tu możesz wyszukać sprzęt następnie przypisać do niego pracownika oraz zmienić status sprzętu.</p>

		<br>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
					<option value="NI">N/I sprzętu</option>
					<option value="login_pracownika">login pracownika</option>
				</select>
			</div><br>
			<div>
				<input type="text" name="wartosc" placeholder="Wpisz wartość">
			</div><br>
			<input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
		</form>
		<hr>
		<br>

		<?php
		require("connection.php");

		if (isset($_POST['search'])) {
			$opcjonalna_wartosc = $_POST['opcja'];
			$wartosc_input = $_POST['wartosc'];
			$query = "SELECT * FROM sprzet LEFT
							JOIN pracownicy 
            				ON sprzet.id_pracownika = pracownicy.id_pracownika
							WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";

			$result = mysqli_query($conn, $query);
			if (!$result) {
				echo "Nieprwidłowe zapytanie";
			}

			while ($row = mysqli_fetch_array($result)) {
		?>
				<form method="POST" action="edytuj_status.php">
					<div>
						<div>
							<label>ID sprzętu<label>
						</div>
						<input type="text" name="id_sprzetu" readonly value="<?php echo $row['id_sprzetu'] ?>" />
					</div><br>
					<div>
						<div>
							<label>N/I<label>
						</div>
						<input type="text" name="ni" readonly value="<?php echo $row['NI'] ?>" />
					</div><br>
					<div>
						<div>
							<label>rodzaj<label>
						</div>
						<input type="text" name="rodzaj" readonly value="<?php echo $row['rodzaj'] ?>" />
					</div><br>
					<div>
						<div>
							<label>pin<label>
						</div>
						<input type="text" name="pin" readonly value="<?php echo $row['pin'] ?>" />
					</div><br>
					<div>
						<div>
							<label>status<label>
						</div>
						<select id="status" name="status" class="green">
							<option><?php echo $row['status_sprz'] ?></option>
							<option>magazyn</option>
							<option>wydany</option>
							<option>pożyczony</option>
							<option>prezentacja</option>
						</select>
					</div><br>
					<div>
						<div>
							<label>login<label>
						</div>
						<input type="text" readonly name="login_pracownika" value="<?php echo $row['login_pracownika'] ?>" />
						<input type="text" name="nowy_login" value="nowy login" class="green"/><br><br>
						<div>
							<label>data<label>
						</div>
						<input type="text" readonly name="aktu_data"  value="<?php echo date("Y-m-d")?>" />
						<input class="btn btn-primary" type="submit" name="zatwierdz" value="zatwierdź" >
					</div><br>
				</form>
				<hr>
		<?php
			}
		}
		if (isset($_POST['zatwierdz'])) {
			$query_login = "SELECT login_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
			$result = mysqli_query($conn, $query_login);

			if (mysqli_num_rows($result) === 0) {
				echo '<h3>Nie ma takiego pracownika!</h3>';
				
			} else {
				
				$ni = mysqli_real_escape_string($conn, $_REQUEST['ni']);
				$rodzaj = mysqli_real_escape_string($conn, $_REQUEST['rodzaj']);
				$status = mysqli_real_escape_string($conn, $_REQUEST['status']);
				$login_stary = mysqli_real_escape_string($conn, $_REQUEST['login_pracownika']);
				$login_nowy = mysqli_real_escape_string($conn, $_REQUEST['nowy_login']);
				$data = mysqli_real_escape_string($conn, $_REQUEST['aktu_data']);

				$query_historia = "INSERT INTO sprzet_historia (NI, rodzaj, status_sprz, login_stary, login_nowy, data_zmiany) 
				VALUES ('$ni', '$rodzaj', '$status', '$login_stary', '$login_nowy', '$data')";
				if($query_historia) {
					mysqli_query($conn, $query_historia);
				}

				$query_login_sprzet = "SELECT id_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
				$result_login_sprzet = mysqli_query($conn, $query_login_sprzet);
				$row_login_sprzet = mysqli_fetch_array($result_login_sprzet);
				$row_na_int = (int)$row_login_sprzet['id_pracownika'];

				$query_update = "UPDATE sprzet SET id_pracownika = $row_na_int, status_sprz = '$_POST[status]' WHERE id_sprzetu ='" . $_POST['id_sprzetu'] . "'";

				if ($query_update) {
					mysqli_query($conn, $query_update);
					echo '<h3>Zmiany wprowadzone</h3>';
				}
			}
		}
		?>
	</div>
	<?php
	mysqli_close($conn);
	?>
</body>

</html>