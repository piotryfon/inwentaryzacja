<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
require("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>protokół tabela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <style>
        @media print
            {
            @page {
            margin-top: 0;
            margin-bottom: 0;
            }
            body  {
            padding-top: 50px;
            padding-bottom: 50px;
            font-size: 10px;
            }
            .sig {
                font-size: 10px;
            }
        } 
    </style>
</head>

<body>
	<div class="container">
		<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent border border-success">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../main.php">Str. główna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wyszukaj_do_protokolu.php">Wyszukaj sprzęt do protokołu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="protokol_tabela.php">Protokół sprzęt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php"><b>Wyloguj się</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
		</header><br>
        <div id="proto">
            <h5>Protokół przeniesienia sprzętu informatycznego.</h5>
            <?php
                if(isset($_POST['clear'])){
                    $sql = "DELETE FROM protokol";
                    if(mysqli_query($conn, $sql)){
                        $sql_AI = "ALTER TABLE protokol AUTO_INCREMENT=1";
                        mysqli_query($conn, $sql_AI);
                        echo'<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Dane usunięte...</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else echo '<div class="alert alert-danger" role="alert">Coś poszło nie tak!</div>';
                }
            ?>
            <form method="post" action="protokol_tabela.php">
            <?php
                $query = "SELECT * FROM protokol";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)){
            ?>
                <table class="table table-striped">
                    <tr>
                        <th>rodzaj</th>
                        <th>model</th>
                        <th>numer inwentarzowy</th>
                        <th>numer seryjny</th>
                        <th>pokój</th>
                    </tr>
            <?php
                while($row = mysqli_fetch_array($result)){       
            ?>
                    <tr>
                        <td><?php echo $row['rodzaj'] ?></td>
                        <td><?php echo $row['model'] ?></td>
                        <td><?php echo $row['ni'] ?></td>
                        <td><?php echo $row['sn'] ?></td>
                        <td><?php echo $row['pokoj'] ?></td>
                    </tr>
            <?php
                }
                $iloscRekordow = mysqli_num_rows($result);
            ?>
                </table>
            </div>
            <br>
            <input type="submit" class="btn btn-primary" style="width: 250px" 
                    name ="print" value="drukuj tabelę" onclick="printDiv()">
            <label>ilość rekordów:</label>
            <input type="text" style="width: 40px" readonly value="<?php echo $iloscRekordow ?>"> 
        </form><hr>
        <form method="POST" action="protokol_tabela.php">
            <input type="submit" class="btn btn-danger" name ="clear" value="wyczyść tabelę">
        </form>
        <?php
    } else {
        echo'<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Tabela jest pusta.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    mysqli_close($conn);
?>
    <br><br><br>
    </div>
    <script type="text/javascript">
        function printDiv(proto) {
            let divElements = document.getElementById('proto').innerHTML;
            let oldPage = document.body.innerHTML;
            document.body.innerHTML = 
                '<html><head><meta charset="UTF-8"><title>Protokół przeniesienia sprzętu komputerowego.</title></head><body>' + 
                divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
        }
    </script>
</body>
</html>
