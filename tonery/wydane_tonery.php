<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Wydane tonery</title>
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
        #big-left-padding {
            padding-left: 60px;
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
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_drukarke.php">dodaj drukarkę</a>
                </li>
            </ul>
        </header>
        <hr>
        <?php
            require("connection_tonery.php");

            $query = "SELECT * FROM wydane_tonery ORDER BY data_wydania DESC LIMIT 50";
            $result = mysqli_query($conn, $query);
            $count_query = "SELECT NI_drukarki, COUNT(*) FROM wydane_tonery
                GROUP BY NI_drukarki ORDER BY COUNT(*) DESC";
            $count_result = mysqli_query($conn, $count_query);
        ?>
        <div class="row">
            <div class="col-lg-6">
            <h4>Statystyka wydanych tonerów</h4><br>
                <table>
                    <tr>
                        <th>drukarka</th>
                        <th>ilość wydanych tonerów</th>
                    </tr>
                    <?php
                    while($row = mysqli_fetch_row($count_result)) {
                        echo "<tr>";
                            echo "<td>$row[0]</td>";
                            echo  "<td id='big-left-padding'>$row[1]</td>";
                        echo "</tr>";
                    }
                ?>
                </table>
            </div>
            <div class="col-lg-6">
            <h4>Tabela z wydanymi tonerami</h4><br>
                <table>
                    <tr>
                        <th>kod</th>
                        <th>N/I drukarki</th>
                        <th>data wydania części</th>
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
            </div>
        </div>
        <?php
            mysqli_close($conn);
        ?>
    </body>
</html>