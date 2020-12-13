<?php
 require("connection_tonery.php");

$query = "SELECT * FROM tonery_tab";    
$result = mysqli_query($conn, $query);
    
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tonery tabela</title>
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
        }
  
	</style>
</head>

<body>
	<div class="container">
        <header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="/inwentaryzacja/index.php">str. gł</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tonery_tabela.php">tonery tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_toner.php">dodaj toner do magazynu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydaj_toner.php">wydaj toner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_rekord.php">dodaj rekord do bazy SQL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydane_tonery.php">wydane tonery</a>
                </li>
            </ul>
        </header>
        <hr>
        <h3>Tabela z tonerami</h3>
        <table>
            <tr>
                <th>kod</th>
                <th>oznaczenie</th>
                <th>firma</th>
                <th>opis</th>
                <th>ilość</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$row[kod]</td>";
                echo "<td>$row[oznaczenie]</td>";
                echo "<td>$row[firma]</td>";
                echo "<td>$row[opis]</td>";
                echo "<td>$row[ilosc]</td>";
                echo "</tr>";
            }

            ?>
        </table>

    </div>
    <?php
        mysqli_close($conn);
    ?>
</body>
</html>