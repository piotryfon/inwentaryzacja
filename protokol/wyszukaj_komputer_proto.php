<?php

    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
require("../connection.php");
require("../test_input.php");
require("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wyszukaj komputer do protokołu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/main.css">
    <style>
    .mid-input {
         width: 180px;
    }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <?php
                showNavbar();
            ?>
        </header>
        <?php
            $sql = "SELECT * FROM protokol_wydania_komputera";
            $wynik = mysqli_num_rows(mysqli_query($conn, $sql));
            if ((int)$wynik > 0) {
                echo'<br><div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Protokół jest w trakcie tworzenia...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        ?>
        <h4>Wyszukaj sprzęt do protokołu przekazania i odebrania sprzętu.</h4>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
                    <option value="login_pracownika">login pracownika</option>
                    <option value="NI">N/I sprzętu</option>
                    <option value="SN">S/N sprzętu</option>
                    <option value="rodzaj">rodzaj</option>
				</select>
			</div><br>
			<div>
				<input type="text" name="wartosc" placeholder="Wpisz wartość">
                <button class="btn btn-outline-success" type="submit" name="search">Znajdź sprzęt</button>
			</div>
		</form>
		<hr>
		<br>
        <?php
        if (isset($_POST['search'])) {
            if($_POST['wartosc']===''){
                echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Wpisz wartość...</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
			$opcjonalna_wartosc = $_POST['opcja'];
			$wartosc_input = test_input($_POST['wartosc']);
			$query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
            if($opcjonalna_wartosc === "wszystko") {
                $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE (login_pracownika LIKE '%$wartosc_input%') or (rodzaj LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or (SN = '$wartosc_input') ";
            }
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)===0){
                    echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Nie znaleziono takiego sprzętu...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }else {
                    ?>
                    <form method="post" action="protokol_komputer.php">
                    <p style="color: red">Imię, nazwisko i miejsce użytkowania sprzętu, pierwszego dodanego rekordu, umieszczone będą w protokole.</p>
                        <?php
                        $counter = 0;
                        while($row = mysqli_fetch_array($result)){
                            $counter = $counter + 1;
                            ?>
                            <div class="row">
                                <div class="col-lg-3">
                                    <p>
                                        <label>Miejsce użytkowania sprzętu</label>
                                        <input type="text" class="bg-dark text-white" value="Centrala NFZ" name="miejsce[]"/>
                                    </p>
                                        <label>Wybierz wydanie lub zwrot</label>
                                        <select name="status_sprz[]" class="bg-dark text-white">
                                            <option>sprzęt wydawany</option>
                                            <option>sprzęt zwracany</option>
                                        </select><br><br>
                                    <p>
                                        <label>Imię:</label><br>
                                        <input type="text" class="mid-input bg-dark text-white" name="imie[]" value="<?php echo $row['imie']?>">
                                    </p>
                                    <p>
                                        <label>Nazwisko:</label><br>
                                        <input type="text" class="mid-input bg-dark text-white" name="nazwisko[]" value="<?php echo $row['nazwisko']?>">
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    <p>
                                        <label>Rodzaj sprzętu:</label><br>
                                        <input type="text" class="mid-input" name="rodzaj[]" value="<?php echo $row['rodzaj']?>">
                                    </p>
                                    <p>
                                        <label>Model:</label><br>
                                        <input type="text" class="mid-input" name="model[]" value="<?php echo $row['model']?>">
                                    </p>
                                    <p>
                                        <label>Procesor:</label><br>
                                        <input type="text" class="mid-input" name="procesor[]" value="<?php echo $row['procesor']?>">
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    <p>
                                        <label>RAM:</label><br>
                                        <input type="text" class="mid-input" name="ram[]" value="<?php echo $row['ram']?>">
                                    </p>
                                    <p>
                                        <label>Dysk:</label><br>
                                        <input type="text" class="mid-input" name="dysk[]" value="<?php echo $row['dysk']?>">
                                    </p>
                                    <p>
                                        <label>N/I:</label><br>
                                        <input type="text" class="mid-input" name="NI[]" value="<?php echo $row['NI']?>">
                                    </p>
                                    <p>
                                        <label>S/N:</label><br>
                                        <input type="text" class="mid-input" name="SN[]" value="<?php echo $row['SN']?>">
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    
                                    <p>
                                        <label>Dodatkowe wyposażenie:</label><br>
                                        <textarea type="text" name="dodatki[]" rows="3" cols="20"></textarea>
                                    </p> 
                                    <p>
                                        <label>Uwagi:</label><br>
                                        <textarea type="text"  name="uwagi[]" rows="3" cols="20"></textarea>
                                    </p>
                                </div>  
                                <input type="button" style="width: 200px" class="btnRemove btn btn-danger" value="Usuń z protokołu"/>
                            </div>
                            <hr>
                        <?php
                        }
                        ?>
                    <label>ilość rekordów:</label>
                    <input type="text" style="width: 40px" name="rows" id="selected-rows" readonly value="<?php echo mysqli_num_rows($result)?>">
                    <input type="submit" name="dodaj" class="btn btn-success" value="dodaj do protokołu">
                    </form>
                    <br><hr><br>
                    <?php
                    
                }
            }
        }
      
        mysqli_close($conn);
        ?>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            let selRows = $('#selected-rows').val();
            console.log(selRows)
            let newAmountRows;
            $('body').on('click','.btnRemove',function() {
                $(this).closest('div').remove();
                selRows = selRows - 1;
                let newAmountRows = selRows;
                console.log(newAmountRows);
                $("#selected-rows:text").val(newAmountRows);
            });
        });	
    </script>
</body>
</html>