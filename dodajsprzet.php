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
					<a class="nav-link active" href="edytuj_status.php">znajdź i edytuj</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
				</li>
			</ul>
		</header>
		<h3>Dodaj sprzęt</h3>

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
							<option>drukarka</option>
							<option>kamera</option>
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
						<label for="sn">S/N</label><br>
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
						<select id="procesor" name="procesor">
							<option>brak</option>
							<option>i3</option>
							<option>i5</option>
							<option>i7</option>
							<option>i9</option>
						</select>
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
							<option>wydany</option>
							<option>pożyczony</option>
							<option>magazyn</option>
							<option>prezentacja</option>
						</select>
					</p>
					<p>
						<label for="opis">opis</label><br>
						<textarea style="width: 250px" name="opis" id="opis"></textarea>
					</p>
					<input class="btn btn-primary" type="submit" name="submit" value="submit">
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


			if ($sn == "") {

				echo '<p>Zostawiłeś pusta pole</p>';
			} else {
				$sql = "INSERT INTO sprzet (rodzaj, pin, model, SN, NI, procesor, ram, dysk, status_sprz, opis) 
				VALUES ('$rodzaj', '$pin', '$model','$sn', '$ni', '$procesor', '$ram', '$dysk', '$status','$opis')";
				if (mysqli_query($conn, $sql)) {
					echo '<h3>Rekord został dodany</h3>';
				} else {
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
				mysqli_close($conn);
			}
		}
		?>

	</div>
</body>

</html>