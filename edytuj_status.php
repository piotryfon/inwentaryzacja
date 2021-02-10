<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>edytuj status sprzętu</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<style>
	
	</style>
</head>

<body>
	<div class="container">
		<header>
			<ul class="nav justify-content-center">

				<li class="nav-item">
					<b><a class="nav-link active" href="main.php">str. gł</a></b>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="dodajpracownika.php">dodaj pracownika</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="dodajsprzet.php">dodaj sprzęt</a>
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
				<li class="nav-item">
                    <a class="nav-link active" href="historia.php">historia zmian</a>
                </li>
				<li>
				    <b><a class="nav-link" href="logout.php">Wyloguj się</a></b>
			    </li>
			</ul>
		</header><br>
		<h4>Edycja przypisania użytkownika do sprzętu.</h4>
		<hr>
		<p style="color: green">Tu możesz wyszukać sprzęt następnie przypisać do niego pracownika oraz zmienić status sprzętu.</p>
		<br>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
					<option value="wszystko">wszystko</option>
					<option value="NI">N/I sprzętu</option>
					<option value="SN">S/N sprzętu</option>
					<option value="login_pracownika">login pracownika</option>
				</select>
			</div><br>
			<div>
				<input type="text" name="wartosc" placeholder="Wpisz wartość">
			</div><br>
			<input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
		</form>
		<hr><br>
		<?php
		require("connection.php");

		if (isset($_POST['search'])) {
			if($_POST['wartosc']===''){
				echo'Nie wpisałeś żadnej wartości.';
			} else {
				$opcjonalna_wartosc = $_POST['opcja'];
				$wartosc_input = $_POST['wartosc'];
				$query = "SELECT * FROM sprzet LEFT JOIN pracownicy 
								ON sprzet.id_pracownika = pracownicy.id_pracownika
								WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
				 if($opcjonalna_wartosc === "wszystko") {
					$query = "SELECT * FROM sprzet LEFT JOIN pracownicy 
								ON sprzet.id_pracownika = pracownicy.id_pracownika
								WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or
								(SN LIKE '%$wartosc_input%')";
				}
				$result = mysqli_query($conn, $query);

				if(mysqli_num_rows($result)===0){
					echo '<h5 style="color: red">Nie znalezoino rekordów o takiej wartości.</h5>';
				} else {

					while ($row = mysqli_fetch_array($result)) {
					?>
						<form method="POST" action="edytuj_status.php">
							<div class="row">
								<div class="col-md-6">
									<div>
										<div>
											<label>ID sprzętu</label>
										</div>
										<input type="text" name="id_sprzetu" readonly value="<?php echo $row['id_sprzetu'] ?>" />
									</div><br>
									<div>
										<div>
											<label>N/I</label>
										</div>
										<input type="text" name="ni" readonly value="<?php echo $row['NI'] ?>" />
									</div><br>
									<div>
										<div>
											<label>S/N</label>
										</div>
										<input type="text" name="sn" readonly value="<?php echo $row['SN'] ?>" />
									</div><br>
									<div>
										<div>
											<label>rodzaj</label>
										</div>
										<input type="text" name="rodzaj" readonly value="<?php echo $row['rodzaj'] ?>" />
									</div><br>
									<div>
										<div>
											<label>pin</label>
										</div>
										<input type="text" name="pin" readonly value="<?php echo $row['pin'] ?>" />
									</div><br>
								</div>
								<div class="col-md-6">
									<div>
										<div>
											<label>status</label>
										</div>
										<select name="status" class="bg-success text-white status">
											<option><?php echo $row['status_sprz'] ?></option>
											<option>magazyn</option>
											<option>nowy</option>
											<option>w przygotowaniu</option>
											<option>do wydania</option>
											<option>wydany</option>
											<option>pożyczony</option>
											<option>prezentacja</option>
										</select>
									</div><br>
									<div>
										<form method="post">
											<div>
												<label>login</label>
											</div>
											<input type="text" readonly name="login_pracownika" value="<?php echo $row['login_pracownika'] ?>" /><br><br>
											<div>
												<label>wpisz nowy login lub "magazyn" albo "nfz"</label>
											</div>
											<input type="text" name="nowy_login" value="" class="bg-success text-white" /><br><br>
											<div>
												<label>opis</label>
											</div>
											<textarea rows="4" cols="30" name="opis" class="bg-success text-white"><?php echo $row['opis'] ?></textarea>
											<div>
												<label>data</label>
											</div>
											<input type="text" readonly name="aktu_data" value="<?php echo date("Y-m-d") ?>" />
											<input class="btn btn-primary" type="submit" name="zatwierdz" value="zatwierdź">
										</form>
									</div><br>
								</div>
							</div>
						</form>
						<hr>
					<?php
					}
				}
			}
		}
		if (isset($_POST['zatwierdz'])) {
			$query_login = "SELECT login_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
			$result = mysqli_query($conn, $query_login);

			if (mysqli_num_rows($result) === 0) {
				 echo '<h5 style="color: red">Nie ma takiego pracownika lub nieprawidłowa wartość!</h5>';
			} else {
				$sn = mysqli_real_escape_string($conn, $_REQUEST['sn']);
				$ni = mysqli_real_escape_string($conn, $_REQUEST['ni']);
				$rodzaj = mysqli_real_escape_string($conn, $_REQUEST['rodzaj']);
				$status = mysqli_real_escape_string($conn, $_REQUEST['status']);
				$login_stary = mysqli_real_escape_string($conn, $_REQUEST['login_pracownika']);
				$login_nowy = mysqli_real_escape_string($conn, $_REQUEST['nowy_login']);
				$opis = mysqli_real_escape_string($conn, $_REQUEST['opis']);
				$data = mysqli_real_escape_string($conn, $_REQUEST['aktu_data']);
				
				$query_historia = "INSERT INTO sprzet_historia (SN, NI, rodzaj, status_sprz, login_stary, login_nowy, data_zmiany) 
				VALUES ('$sn', '$ni', '$rodzaj', '$status', '$login_stary', '$login_nowy', '$data')";
				if ($query_historia) {
					mysqli_query($conn, $query_historia);
				}

				$query_login_sprzet = "SELECT id_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
				$result_login_sprzet = mysqli_query($conn, $query_login_sprzet);
				$row_login_sprzet = mysqli_fetch_array($result_login_sprzet);
				$row_na_int = (int)$row_login_sprzet['id_pracownika'];

				$query_update = "UPDATE sprzet SET id_pracownika = $row_na_int, status_sprz = '$_POST[status]', opis = '$_POST[opis]' WHERE id_sprzetu ='" . $_POST['id_sprzetu'] . "'";

				if ($query_update) {
					mysqli_query($conn, $query_update);
					header("location: status_zmieniony.html");
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