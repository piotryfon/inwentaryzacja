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
	<title>Tonery tabela</title>
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
       
        <div id="tonery">
            <h4>Tabela z tonerami i częściami do drukarek.</h4>
            <table class="table table-dark table-striped">
                
                    <tr class="table-success">
                        <th>kod</th>
                        <th><a href="?orderBy=oznaczenie">oznaczenie</a></th>
                        <th><a href="?orderBy=firma">firma</a></th>
                        <th>kolor</th>
                        <th>opis</th>
                        <th><a href="?orderBy=ilosc">ilość</a></th>
                    </tr>
               
                <?php
                require("connection_tonery.php");
                $query = "SELECT * FROM tonery_tab ORDER BY firma";    
                $result = mysqli_query($conn, $query);

                $orderBy = array('oznaczenie', 'firma', 'ilosc');
                $order = 'type';
                if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                    $order = $_GET['orderBy'];
                    $sql = "SELECT * FROM tonery_tab ORDER BY $order ASC";
                    $result = mysqli_query($conn, $sql);
                }
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>$row[kod]</td>";
                    echo "<td>$row[oznaczenie]</td>";
                    echo "<td>$row[firma]</td>";
                    echo "<td>$row[kolor]</td>";
                    echo "<td>$row[opis]</td>";
                    echo "<td>$row[ilosc]</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div><br>
        <button style="width: 220px" id="drukuj" class="btn btn-primary" onclick="printDiv()">Drukuj tabelę</button>
        <br><hr><br>
    </div>
    <?php
        mysqli_close($conn);
    ?>
    <script type="text/javascript">
        function printDiv(tonery) {
            let divElements = document.getElementById('tonery').innerHTML;
            let oldPage = document.body.innerHTML;  
            document.body.innerHTML = 
                '<html><head><meta charset="UTF-8"><title>Stan tonerów w magazynie.</title></head><body>' + 
                divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
        }
    </script>
</body>
</html>