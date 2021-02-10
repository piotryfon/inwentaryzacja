<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
require("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>protokół tabela</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style/table.css">
</head>

<body>
	<div class="container">
		<header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <b><a class="nav-link active" href="main.php">str. gł</a></b>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wyszukaj_do_protokolu.php">wyszukaj sprzęt do protokołu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="protokol_tabela.php">protókoł</a>
                </li>
                <li>
				    <b><a class="nav-link" href="/inwentaryzacja/logout.php">Wyloguj się</a></b>
			    </li>
            </ul>
		</header><hr>
        <div id="proto">
            <h5>Protokół przeniesienia sprzętu informatycznego.</h5>
            <form method="post">
            <?php
                $query = "SELECT * FROM protokol";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)){
            ?>
                <table>
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
                    name ="print" value="drukuj tabelę" onclick="printDiv()"><br><hr><br>
            <label>ilość rekordów:</label>
            <input type="text" style="width: 40px" readonly value="<?php echo $iloscRekordow ?>"> 
        </form>
            <a href="wyczysc_protokol.php">
                <input type="submit" class="btn btn-danger" name ="clear" value="wyczyść tabelę">
            </a>
            <br><br>
        <?php
    } else {
        echo '<div class="alert alert-danger" role="alert">Tabela jest pusta!</div>';
    }
    
?>
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
