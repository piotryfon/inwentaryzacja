<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
    require("connection.php");
    require('navbar.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>sprzęt - tabela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="./style/main.css">
</head>
<body>
    <div class="container-fluid">
        <header class="container">
            <?php
                showNavbar();
            ?>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <h4>Sprzęt/pracownik - tabela</h4>
                <table class="table table-dark table-striped">
                    <tr class="table-success"> 
                        <th>id sprzętu</th>
                        <th><a href="?orderBy=rodzaj">rodzaj</a></th>
                        <th>pin</th>
                        <th>model</th>
                        <th><a href="?orderBy=status_sprz">status</a></th>
                        <th><a href="?orderBy=login_pracownika">login</a></th>
                        <th><a href="?orderBy=NI">NI</a></th>
                        <th>SN</th>
                        <th>procesor</th>
                        <th>RAM</th>
                        <th>dysk</th>
                        <th>opis</th>
                        <th><a href="?orderBy=data_dodania">data dodania</a></th>
                    </tr>
                    <?php
                        $sql = 'SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika ORDER BY data_dodania DESC';
                        $result = mysqli_query($conn, $sql);
                        $orderBy = array('rodzaj', 'status_sprz', 'login_pracownika', 'NI', 'data_dodania');
                        $order = 'type';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                            $sql = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika ORDER BY $order DESC";
                            $result = mysqli_query($conn, $sql);
                        }
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