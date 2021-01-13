<?php
require("connection.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>sprzęt - tabela</title>
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
            <div class="col-lg-12">
                <h4>Sprzęt</h4>
                <form method="POST">
                    <div>
                        <label for="sposob">sortuj po dacie dodania sprzętu do bazy</label>
                    </div>
                    <select name="sposob">
                        <option>DESC</option>
                        <option>ASC</option>
                    </select>
                    <input type="submit" name="show" value="pokaż">
                </form>
        <?php
        if (isset($_POST['show'])) {
            $query = "SELECT * FROM sprzet LEFT JOIN pracownicy 
            ON sprzet.id_pracownika = pracownicy.id_pracownika ORDER BY data_dodania $_POST[sposob]";
            $result = mysqli_query($conn, $query);
        ?>
                <p style="color: green">Aby wyszukać użyj Ctrl + f</p>
                <table>
                    <tr>
                        <th>id sprzętu</th>
                        <th>rodzaj</th>
                        <th>pin</th>
                        <th>model</th>
                        <th>status</th>
                        <th>login</th>
                        <th>NI</th>
                        <th>SN</th>
                        <th>procesor</th>
                        <th>RAM</th>
                        <th>dysk</th>
                        <th>opis</th>
                        <th>data dodania</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$row[id_sprzetu]</td>";
                        echo "<td>$row[rodzaj]</td>";
                        echo "<td>$row[pin]</td>";
                        echo "<td>$row[model]</td>";
                        echo "<td>$row[status_sprz]</td>";
                        echo "<td>$row[login_pracownika]</td>";
                        echo "<td>$row[NI]</td>";
                        echo "<td>$row[SN]</td>";
                        echo "<td>$row[procesor]</td>";
                        echo "<td>$row[ram]</td>";
                        echo "<td>$row[dysk]</td>";
                        echo "<td>$row[opis]</td>";
                        echo "<td>$row[data_dodania]</td>";
                        echo "</tr>";
                    }
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