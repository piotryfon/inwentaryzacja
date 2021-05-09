<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }

    require("connection.php");
    require('navbar.php');

    $query = "SELECT * FROM pracownicy";
    $result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pracownicy - tabela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./style/main.css">
</head>
<body>
    <div class="container">
        <header>
            <?php
                showNavbar();
            ?>
        </header>
        <h4>Pracownicy - tabela</h4>
        <p>Aby wyszukać użyj Ctrl + f</p>
        <table class="table table-dark table-striped">
            <tr class="table-success">
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