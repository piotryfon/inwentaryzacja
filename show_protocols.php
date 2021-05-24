<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
    
    require("connection.php");
    require('navbar.php');
	
	//wyświetlanie protokołów w zależności do ID pracownika
	if(isset($_POST["submit"]))
	{
	$id_pracownika_post = $_POST["submit"];
    $query = "SELECT * FROM protocol_transmission where id_pracownika = $id_pracownika_post";
//	$query = "SELECT * FROM protocol_transmission"; 
    $result = mysqli_query($conn, $query);
	};
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
   
        <table class="table table-dark table-striped">
            <tr class="table-success">
			<form method="post" action="show_protocol.php">
                <th>id protokołu</th>
                <th>Nazwa protokołu</th>
                <th>Data utworzenia protokołu</th>
				<th>wyświetl ptotokół</th>
            </tr>
            <?php
		
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$row[id]</td>";
                echo "<td>$row[protocol_name]</td>";
                echo "<td>$row[protocol_date]</td>";
				echo "<td><button class='btn btn-outline-success' type='submit' name='submit_id_protokolu' value='$row[id]'>wyświetl</button></td>";				
                echo "</tr>";			
            }
            ?>
			</form>		
        </table>
        <?php
            mysqli_close($conn);
        ?>
    </div>