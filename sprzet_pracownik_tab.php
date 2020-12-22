<?php

require("connection.php");

$query3 = "SELECT * FROM sprzet LEFT JOIN pracownicy 
            ON sprzet.id_pracownika = pracownicy.id_pracownika";

$result3 = mysqli_query($conn, $query3);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>sprzęt-pracownik</title>
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
        <div class="row">
            <div class="col-lg-10">
                <h4>Sprzęt - pracownik</h4>
                <table>
                    <tr>
                        <th>id sprzętu</th>
                        <th>rodzaj</th>
                        <th>model</th>
                        <th>N/I</th>
                        <th>S/N</th>
                        <th>login</th>
                        <th>status</th>
                        <th>zmiana</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result3)) {
                        echo "<tr>";
                        echo '<form method="post" action="edytuj_z_tabeli.php">';
                        echo "<td><input style='width: 50px' readonly name='id_sprzetu' value='$row[id_sprzetu]'></td>";
                        echo "<td><input readonly name='rodzaj' value='$row[rodzaj]'></td>";
                        echo "<td><input readonly name='model' value='$row[model]'></td>";
                        echo "<td><input readonly name='ni' value='$row[NI]'></td>";
                        echo "<td><input readonly name='sn' value='$row[SN]'></td>";
                        echo "<td><input readonly name='login_pracownika' value='$row[login_pracownika]'></td>";
                        echo "<td><input readonly name='status_sprz' value='$row[status_sprz]'></td>";
                        echo "<td><input type='submit' name='go' value='zmień'></td>";
                        echo '</form>';
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>


<?php
mysqli_close($conn);
?>