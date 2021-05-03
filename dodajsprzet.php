<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
	require("connection.php");
	require("test_input.php");
	require('navbar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>dodaj sprzet</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
	<link rel="stylesheet" href="./style/main.css">
	<style>
		#identyfikacja{
			border: 1px solid grey;
			box-sizing: border-box;
			width: 222PX;
			padding: 6px;
		}
	</style>
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
	
		$rodzaj = test_input($_POST["rodzaj"]);
		$pin = test_input($_POST["pin"]);
		$model = test_input($_POST["model"]);
		$sn = test_input($_POST["sn"]);
		$ni = test_input($_POST["ni"]);
		$procesor = test_input($_POST["procesor"]);
		$ram = test_input($_POST["ram"]);
		$dysk = test_input($_POST["dysk"]);
		$status = test_input($_POST["status"]);
		$opis = test_input($_POST["opis"]);
		$nr_dostawy = test_input($_POST["nr_dostawy"]);
		$data = test_input($_POST["data"]);
		$login = test_input($_POST["login"]);

	if (($sn === "") or ($ni === "")) {
		echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Zostawiłeś puste pole...</strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
	} else {
		$sql_check = "SELECT * FROM sprzet WHERE (SN = '$sn') OR (NI = '$ni')";
		$sql_check_result = mysqli_query($conn, $sql_check);
		if(mysqli_num_rows($sql_check_result)){
			echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
			<strong>Taki S/N lub N/I już istnieje i nie może być ponownie dodany!</strong>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>';
		} else {
			$query_login = "SELECT * FROM pracownicy WHERE login_pracownika = '$_POST[login]'";
			$result_login = mysqli_query($conn, $query_login);
				
			if (mysqli_num_rows($result_login) === 0) {
				echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Nie ma takiego pracownika lub nieprawidłowa wartość!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
		   } else {
			 
			   $row_id = '';
			   foreach ($result_login as $row) 
			   {
					   $row_id = $row['id_pracownika'];
			   }
			   $row_id = (int)$row_id;
			   
			   $sql = "INSERT INTO sprzet (rodzaj, pin, model, SN, NI, procesor, ram, dysk, status_sprz, opis, nr_dostawy, data_dodania, id_pracownika) 
			   VALUES ('$rodzaj', '$pin', '$model','$sn', '$ni', '$procesor', '$ram', '$dysk', '$status','$opis', '$nr_dostawy', '$data', $row_id)";
			   if (mysqli_query($conn, $sql)) {
				   
				   echo '<script type="text/javascript">
				   alert("Poprawnie dodano sprzęt.");
				   </script>';
			   } else {
				   echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
			   }
			   
		   }
			
		}
		mysqli_close($conn);
	}
}
?>
		<h4>Dodaj sprzęt</h4>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
							<option>telefon</option>
							<option>projektor</option>
							<option>drukarka</option>
							<option>skaner</option>
							<option>głośnik</option>
							<option>pendrive</option>
							<option>zestaw konferencyjny</option>
							<option>inne</option>
						</select>
					</p>
					<p>
						<label for="model">model</label><br>
						<input type="text" name="model" id="model">
					</p>
					<div id="identyfikacja">
						<p>Oba pola muszą być wypełnione.</p>
						<p>
							<label for="ni">N/I</label><br>
							<input type="text" name="ni" id="ni">
						</p>
						<p>
							<label for="sn">S/N</label><br>
							<input type="text" name="sn" id="sn">
						</p>
					</div>
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
						<label for="login">login</label><br>
						<input type="text" name="login" id="login" placeholder="login pracownika" value="magazyn">
					</p>
					<p>
						<label for="opis">opis</label><br>
						<textarea style="width: 250px" name="opis" id="opis"></textarea>
					</p>
					<p>
						<label for="nr_dostawy">nr dostawy</label><br>
						<input type="number" min="0" max="999" name="nr_dostawy" id="nr_dostawy">
					</p>
					<div>
						<label for="data">data</label>
					</div>
					<input readonly type="text" id="data" name="data" value="<?php echo date("Y-m-d") ?>">
					<button class="btn btn-outline-success" type="submit" name="submit">Dodaj sprzęt</button>
				</div>
			</div>
		</form>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
		$(document).ready(function(){
			$('form').on('focus', 'input[type=number]', function (e) {
				$(this).on('wheel.disableScroll', function (e) {
				e.preventDefault()
				})
			})
				$('form').on('blur', 'input[type=number]', function (e) {
				$(this).off('wheel.disableScroll')
			})
		});
    </script>
</body>

</html>