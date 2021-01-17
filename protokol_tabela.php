<?php
require("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>protokół tabela</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border-bottom: 1px solid #ddd;
        }

        th,
        td {
            padding: 3px 7px 3px 7px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #33A5FF;
            color: white;
            text-align: center;
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
        <h5>Protokół</h5>
        <form method="post">
        <?php
            $query = "SELECT * FROM protokol";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)){
        ?>
            <table>
                <tr>
                    <th>rodzaj</th>
                    <th>model</th>
                    <th>numer inwentarzowy</th>
                    <th>numer seryjny</th>
                    <th>pokój</th>
                </tr>
        <?php
            while($row = mysqli_fetch_array($result)){       
        ?>
                <tr>
                    <td><?php echo $row['rodzaj'] ?></td>
                    <td><?php echo $row['model'] ?></td>
                    <td><?php echo $row['ni'] ?></td>
                    <td><?php echo $row['sn'] ?></td>
                    <td><?php echo $row['pokoj'] ?></td>
                </tr>
        <?php
            }
            $iloscRekordow = mysqli_num_rows($result);
        ?>
            </table><br>
            <label>ilość rekordów:</label>
            <input type="text" style="width: 40px" readonly value="<?php echo $iloscRekordow ?>">
            <input type="submit" class="btn btn-danger" style="width: 200px" name ="clear" value="wyczyść tabelę">
        </form>    
            <br><br>
        <?php
    } else {
        echo '<div class="alert alert-danger" role="alert">Tabela jest pusta!</div>';
    }
    if(isset($_POST['clear'])){
        $sql = "DELETE FROM protokol";
        if(mysqli_query($conn, $sql)){
            $sql_AI = "ALTER TABLE protokol AUTO_INCREMENT=1";
            mysqli_query($conn, $sql_AI);
            header("Refresh:0; url=protokol_tabela.php");
        } else echo '<div class="alert alert-danger" role="alert">Coś poszło nie tak!</div>';
    }
?>
    </div>
</body>
</html>
