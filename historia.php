<?php
 require("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>sprzęt - historia</title>
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
        </header><br>
        <h4>Sprzęt - historia zmian</h4>
        <form method="POST">
            <label for="zakres">zakres</label>
            <select name="zakres">
                <option>100</option>
                <option>200</option>
                <option>500</option>
                <option>1000</option>
                <option>5000</option>
            </select>
            <label for="sposob">sposób</label>
            <select name="sposob">
                <option>DESC</option>
                <option>ASC</option>
            </select>
            <input type="submit" name="show" value="pokaż">
        </form>
        <?php
        if (isset($_POST['show'])) {
            $query = "SELECT * FROM sprzet_historia ORDER BY data_zmiany $_POST[sposob] LIMIT $_POST[zakres]";
            $result = mysqli_query($conn, $query);
        ?>
            <table>
                <tr>
                    <th>NI</th>
                    <th>rodzaj</th>
                    <th>status</th>
                    <th>stary login</th>
                    <th>nowy login</th>
                    <th>data zmiany</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>$row[NI]</td>";
                    echo "<td>$row[rodzaj]</td>";
                    echo "<td>$row[status_sprz]</td>";  
                    echo "<td>$row[login_stary]</td>";
                    echo "<td>$row[login_nowy]</td>";
                    echo "<td>$row[data_zmiany]</td>";
                    echo "</tr>";
                }    
                ?>
            </table>
        <?php
        }
        ?>
    </div>
    <?php
        mysqli_close($conn);
    ?>
</body>
</html>