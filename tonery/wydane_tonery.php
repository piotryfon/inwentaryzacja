<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("connection_tonery.php");
    require("navbar-tonery.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Wydane tonery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <div class="container">
        <header>
            <?php
                show_navbar();
            ?>
        </header>
      
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
                <table class="table table-dark table-striped">
                    <tr class="table-success">
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
                <table class="table table-dark table-striped">
                    <tr class="table-success">
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