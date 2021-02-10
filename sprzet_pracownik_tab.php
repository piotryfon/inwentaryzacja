<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
require("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sprzęt/pracownik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style/table.css">
    <style>
        input {
            max-width: 165px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
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
        </header>
        <br>
        <h4>Wyszukaj pracownika lub sprzęt</h4>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
					<option value="login_pracownika">login pracownika</option>
                    <option value="NI">N/I sprzętu</option>
                    <option value="SN">S/N sprzętu</option>
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
	if (isset($_POST['search'])) {
            if($_POST['wartosc']===''){
                echo '<h5 style="color: red">Wpisz wartość!</h5>';
            } else {
			$opcjonalna_wartosc = $_POST['opcja'];
			$wartosc_input = $_POST['wartosc'];
			$query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
            if($opcjonalna_wartosc === "wszystko") {
                $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or
                    (SN LIKE '%$wartosc_input%')";
            }
           
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)===0){
            echo '<h5 style="color: red">Brak danych!</h5>';
        }else {
        ?>
        <table>
            <tr>
                <th>id sprzętu</th>
                <th>rodzaj</th>
                <th>model</th>
                <th>pin</th>
                <th>procesor</th>
                <th>ram</th>
                <th>dysk</th>
                <th>N/I</th>
                <th>S/N</th>
                <th>login</th>
                <th>status</th>
                <th>opis</th>
                <th>data dodania <br> sprzętu do bazy</th>
            </tr>
        <?php
			while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$row[id_sprzetu]</td>";
                echo "<td>$row[rodzaj]</td>";
                echo "<td>$row[model]</td>";
                echo "<td>$row[pin]</td>";
                echo "<td>$row[procesor]</td>";
                echo "<td>$row[ram]</td>";
                echo "<td>$row[dysk]</td>";
                echo "<td>$row[NI]</td>";
                echo "<td>$row[SN]</td>";
                echo "<td>$row[login_pracownika]</td>";
                echo "<td>$row[status_sprz]</td>";
                echo "<td>$row[opis]</td>";
                echo "<td>$row[data_dodania]</td>";
                echo "</tr>";
            }
		?>
        </table>
        <?php
            }
        }
    }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>

