<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tonery</title>
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
                    <a class="nav-link active" href="tonery_tabela.php">tonety tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_toner.php">dodaj toner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydaj_toner.php">wydaj toner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_rekord.php">dodaj rekord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydane_tonery.php">wydane tonery</a>
                </li>
            </ul>
        </header>
        <h4>Tabela z wydanymi tonerami</h4><br>

        <?php
            require("connection_tonery.php");

            $query = "SELECT * FROM wydane_tonery";

            $result = mysqli_query($conn, $query);
        ?>
        <table>
            <tr>
                <th>kod</th>
                <th>N/I drukarki</th>
                <th>data wydania tonera</th>
            </tr>
        <?php
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                    echo "<td>$row[kod]</td>";
                    echo "<td>$row[NI_drukarki]</td>";
                    echo "<td>$row[data_wydania]</td>";
                echo "</tr>";
            }
        ?>
        </table>
        <?php
            mysqli_close($conn);
        ?>
    </body>
</html>