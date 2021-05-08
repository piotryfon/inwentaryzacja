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
    <title>sprzęt - historia</title>
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
            <label for="sposob">sortuj po dacie</label>
            <select name="sposob">
                <option>DESC</option>
                <option>ASC</option>
            </select>
            <button class="btn btn-outline-success" type="submit" name="show">Pokaż historię</button>
        </form><br>
        <?php
        if (isset($_POST['show'])) {
            $query = "SELECT * FROM sprzet_historia ORDER BY data_zmiany $_POST[sposob] LIMIT $_POST[zakres]";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)===0){
                echo'<h4>Tabela jest pusta.</h4>';
            } else {    
            ?>
                <table class="table table-dark table-striped">
                    <tr class="table-success">
                        <th>SN</th>
                        <th>NI</th>
                        <th>rodzaj</th>
                        <th>login</th>
                        <th>status</th>
                        <th>data zmiany</th>
                    </tr>
                    <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>$row[SN]</td>";
                            echo "<td>$row[NI]</td>";
                            echo "<td>$row[rodzaj]</td>";
                            echo "<td>$row[login]</td>";
                            echo "<td>$row[status_sprz]</td>"; 
                            echo "<td>$row[data_zmiany]</td>";
                            echo "</tr>";
                        }    
                    ?>
                </table>
            <?php
            }
        }
        ?>
    </div>
    <?php
        mysqli_close($conn);
    ?>
</body>
</html>