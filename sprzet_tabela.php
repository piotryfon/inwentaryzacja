<?php
require("connection.php");
$query = "SELECT * FROM sprzet";
$result = mysqli_query($conn, $query);
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
        <div class="row">
            <div class="col-lg-10">
                <h4>Sprzęt</h4>
                <table>
                    <tr>
                        <th>rodzaj</th>
                        <th>pin</th>
                        <th>model</th>
                        <th>NI</th>
                        <th>SN</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$row[rodzaj]</td>";
                        echo "<td>$row[pin]</td>";
                        echo "<td>$row[model]</td>";
                        echo "<td>$row[NI]</td>";
                        echo "<td>$row[SN]</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>
                    <?php
                    
                    ?>
            </div>
        </div>
    </div>
</body>

</html>
<?php
mysqli_close($conn);
?>