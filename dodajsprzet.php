<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>dodaj sprzet</title>
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
			</ul>
		</header>
		<h3>Dodaj sprzęt</h3>
		<p style="color: green">Sprzęt aytomatycznie doda się jako użytkownik "magazyn".<br>
		 Jeżeli jest z nowej dostawy, dla ułatwienia wyszukiwania zaznacz status "nowy".</p>
		<form method="post">
			<div class="row">
				<div class="col-md-4">
					<p>
						<label for="rodzaj">rodzaj</label><br>
						<select id="rodzaj" name="rodzaj">
							<option>AiO</option>
							<option>laptop</option>
							<option>komputer stacjonarny</option>
							<option>monitor</option>
							<option>kamera</option>
							<option>słuchawki z mikrofonem</option>
							<option>projektor</option>
							<option>drukarka</option>
							<option>inne</option>
						</select>
					</p>
					<p>
						<label for="model">model</label><br>
						<input type="text" name="model" id="model">
					</p>
					<p>
						<label for="ni">N/I</label><br>
						<input type="text" name="ni" id="ni">
					</p>
					<p>
						<label for="sn">*S/N (gdy brak wpisz N/I)</label><br>
						<input type="text" name="sn" id="sn">
					</p>
				</div>
				<div class="col-md-4">
					<p>
						<label for="pin">pin</label><br>
						<input type="text" name="pin" id="pin">
					</p>
					<p>
						<label for="procesor">procesor</label><br>
						<input type="text" name="procesor" id="procesor">
					</p>
					<p>
						<label for="ram">RAM</label><br>
						<select id="ram" name="ram">
							<option>brak</option>
							<option>4 GB</option>
							<option>8 GB</option>
							<option>16 BG</option>
							<option>32 GB</option>
						</select>
					</p>
					<p>
						<label for="dysk">dysk</label><br>
						<input type="text" name="dysk" id="dysk">
					</p>
				</div>
				<div class="col-md-4">
					<p>
						<label for="status">status</label><br>
						<select id="status" name="status">
							<option>nowy</option>
							<option>magazyn</option>
							<option>w przygotowaniu</option>
							<option>do wydania</option>
							<option>wydany</option>
							<option>pożyczony</option>
							<option>prezentacja</option>
						</select>
					</p>
					<p>
						<label for="opis">opis</label><br>
						<textarea style="width: 250px" name="opis" id="opis"></textarea>
					</p>
					<div>
						<label for="data">data</label>
					</div>
					<input readonly type="text" id="data" name="data" value="<?php echo date("Y-m-d") ?>">
					<input class="btn btn-primary" type="submit" name="submit" value="submit">
					<p style="color: green">* pole wymagane</p>
				</div>
			</div>
		</form>
		<?php

		require("connection.php");

		if (isset($_POST['submit'])) {
			$rodzaj = mysqli_real_escape_string($conn, $_REQUEST['rodzaj']);
			$pin = mysqli_real_escape_string($conn, $_REQUEST['pin']);
			$model = mysqli_real_escape_string($conn, $_REQUEST['model']);
			$sn = mysqli_real_escape_string($conn, $_REQUEST['sn']);
			$ni = mysqli_real_escape_string($conn, $_REQUEST['ni']);
			$procesor = mysqli_real_escape_string($conn, $_REQUEST['procesor']);
			$ram = mysqli_real_escape_string($conn, $_REQUEST['ram']);
			$dysk = mysqli_real_escape_string($conn, $_REQUEST['dysk']);
			$status = mysqli_real_escape_string($conn, $_REQUEST['status']);
			$opis = mysqli_real_escape_string($conn, $_REQUEST['opis']);
			$data = mysqli_real_escape_string($conn, $_REQUEST['data']);

			if ($sn == "") {
				echo '<h5 style="color: red">Zostawiłeś puste pole.</h5>';
			} else {
				$sql_check = "SELECT id_sprzetu FROM sprzet WHERE SN = '$sn'";
				$sql_check_result = mysqli_query($conn, $sql_check);
				if(mysqli_num_rows($sql_check_result)){
					echo "<h5 style='color: red'>Taki S/N już istnieje i nie może być ponownie dodany!</h5>";
				} else {
					$sql = "INSERT INTO sprzet (rodzaj, pin, model, SN, NI, procesor, ram, dysk, status_sprz, opis, data_dodania) 
					VALUES ('$rodzaj', '$pin', '$model','$sn', '$ni', '$procesor', '$ram', '$dysk', '$status','$opis', '$data')";
					if (mysqli_query($conn, $sql)) {
						header("location: sprzet_dodany.html");
					} else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				mysqli_close($conn);
			}
		}
		?>

	</div>
	<script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>

</html>