<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
    require("connection.php");
    require("test_input.php");
    require('navbar.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sprzęt/pracownik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./style/main.css">
</head>
<body>
    <header class="container">
        <?php
            showNavbar();
        ?>
    </header>
    <div class="container-fluid">
        
        <br>
        <div class="container">
            <h4>Wyszukaj pracownika lub sprzęt</h4>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div>
                    <label for="opcja">Wybierz parametr:</label><br>
                    <select name="opcja" id="opcja">
                        <option value="wszystko">wszystko</option>
                        <option value="nr_dostawy">nr dostawy</option>
                        <option value="login_pracownika">login pracownika</option>
                        <option value="NI">N/I sprzętu</option>
                        <option value="SN">S/N sprzętu</option>
                        <option value="model">model</option>
                        <option value="rodzaj">rodzaj</option>
                        <option value="status_sprz">status</option>
                    </select>
                </div><br>
                <div>
                    <input type="text" name="wartosc" required placeholder="Wpisz wartość">
                    <button class="btn btn-outline-success" type="submit" name="search">Znajdź sprzęt</button>
                </div>
            </form>
        </div>
		<hr>
		<br>
        
		<?php
            if (isset($_POST['search'])) {
                    if($_POST['wartosc']===''){
                        echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Zostawiłeś puste pole...</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                    $opcjonalna_wartosc = $_POST['opcja'];
                    $wartosc_input = test_input($_POST['wartosc']);
                    $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                            WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
                    if($opcjonalna_wartosc === "wszystko") {
                        $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                            WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or 
                            (SN = '$wartosc_input') or (model LIKE '%$wartosc_input%') or (status_sprz LIKE '%$wartosc_input%') or (rodzaj LIKE '%$wartosc_input%')";
                    }
                
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)===0){
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Brak danych...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
        ?>
        <table class="table table-dark table-striped">
            <tr class="table-success">
                <th>id sprzętu</th>
                <th>rodzaj</th>
                <th>model</th>
                <th>pin</th>
                <th>procesor</th>
                <th>ram</th>
                <th>dysk</th>
                <th>N/I</th>
                <th>S/N</th>
                <th>login</th>
                <th>status</th>
                <th>nr dostawy</th>
                <th>opis</th>
                <th>data dodania sprzętu</th>
                <th>edycja</th>
            </tr>
        <?php
			while ($row = mysqli_fetch_array($result)) {
                echo '<form method="POST" action="edytuj_sprzet_tab.php">';
                    echo "<tr>";
                    ?>
                        <td><input style="width: 55px" readonly name="id_sprz" value="<?php echo $row['id_sprzetu']?>" /></td>
                        <td><?php echo $row['rodzaj'] ?></td>
                        <td><?php echo $row['model'] ?></td>
                        <td><?php echo $row['pin'] ?></td>
                        <td><?php echo $row['procesor'] ?></td>
                        <td><?php echo $row['ram'] ?></td>
                        <td><?php echo $row['dysk'] ?></td>
                        <td><?php echo $row['NI'] ?></td>
                        <td><?php echo $row['SN'] ?></td>
                        <td><?php echo $row['login_pracownika'] ?></td>
                        <td><?php echo $row['status_sprz'] ?></td>
                        <td><?php echo $row['nr_dostawy'] ?></td>
                        <td><?php echo $row['opis'] ?></td>
                        <td><?php echo $row['data_dodania'] ?></td>
                        <td><?php echo '<button class="btn btn-outline-warning" type="submit" name="edit">Edytuj</button>' ?></td>
                    <?php
                    echo "</tr>";
                echo '</form>';
            }
		?>
        </table>
        <?php
            }
        }
    }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>

