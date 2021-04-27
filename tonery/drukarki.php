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
    <title>Drukarki</title>
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
        <hr>
        <h4>Drukarki</h4><br>
     
        <?php
        
        $query = "SELECT * FROM drukarki";    
        $result = mysqli_query($conn, $query);
        ?>
        <h3>Tabela - drukarki</h3>
        <table class="table table-dark table-striped">
            <tr class="table-success">
                <th>N/I</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$row[NI]</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>