<?php

require("connection.php");

$query = "SELECT * FROM pracownicy";
$result = mysqli_query($conn, $query);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pracownicy - tabela</title>
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
        <h3>Pracownicy - tabela</h3>
        <p style="color: green">Aby wyszukać użyj Ctrl + f</p>
        <table>
            <tr>
                <th>id pracownika</th>
                <th>login</th>
                <th>imię</th>
                <th>nazwisko</th>
                <th>departament</th>
                <th>pokój</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$row[id_pracownika]</td>";
                echo "<td>$row[login_pracownika]</td>";
                echo "<td>$row[imie]</td>";
                echo "<td>$row[nazwisko]</td>";
                echo "<td>$row[departament]</td>";
                echo "<td>$row[pokoj]</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
            mysqli_close($conn);
        ?>

    </div>