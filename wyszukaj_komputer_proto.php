<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
require("connection.php");
require("test_input.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wyszukaj komputer do protokołu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    .mid-input {
         width: 180px;
    }
    </style>
</head>
<body>
    <div class="container">
    <?php
        $sql = "SELECT * FROM protokol_wydania_komputera";
        $wynik = mysqli_num_rows(mysqli_query($conn, $sql));
        if ((int)$wynik > 0) echo '<div class="alert alert-info" role="alert">Protokół jest w trakcie tworzenia.</div>';
        
    ?>
        <header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <b><a class="nav-link active" href="main.php">str. gł</a></b>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wyszukaj_komputer_proto.php">wyszukaj sprzęt do protokołu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="protokol_komputer.php">protokół wydania sprzętu</a>
                </li>
                <li>
				    <b><a class="nav-link" href="/inwentaryzacja/logout.php">Wyloguj się</a></b>
			    </li>
            </ul><hr>
        </header>
        <h4>Wyszukaj sprzęt do protokołu przekazania i odebrania sprzętu.</h4>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
                    <option value="login_pracownika">login pracownika</option>
                    <option value="NI">N/I sprzętu</option>
                    <option value="SN">S/N sprzętu</option>
				</select>
			</div><br>
			<div>
				<input type="text" name="wartosc" placeholder="Wpisz wartość">
                <input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
			</div>
		</form>
		<hr>
		<br>
        <?php
        if (isset($_POST['search'])) {
            if($_POST['wartosc']===''){
                echo '<h5 style="color: red">Wpisz wartość!</h5>';
            } else {
			$opcjonalna_wartosc = $_POST['opcja'];
			$wartosc_input = test_input($_POST['wartosc']);
			$query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
            if($opcjonalna_wartosc === "wszystko") {
                $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or (SN = '$wartosc_input')";
            }
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)===0){
                    echo '<h5 style="color: red">Brak danych!</h5>';
                }else {
                    ?>
                    <form method="post" action="protokol_komputer.php">
                    <p style="color: green">Imię, nazwisko i miejsce użytkowania sprzętu, pierwszego dodanego rekordu, umieszczone będą w protokole.</p>
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
                                </div>
                                <div class="col-lg-3">
                                    <p>
                                        <label>Procesor:</label><br>
                                        <input type="text" class="mid-input" name="procesor[]" value="<?php echo $row['procesor']?>">
                                    </p>
                                    <p>
                                        <label>RAM:</label><br>
                                        <input type="text" class="mid-input" name="ram[]" value="<?php echo $row['ram']?>">
                                    </p>
                                    <p>
                                        <label>Dysk:</label><br>
                                        <input type="text" class="mid-input" name="dysk[]" value="<?php echo $row['dysk']?>">
                                    </p>
                                </div>
                                <div class="col-lg-3">
                                    <p>
                                        <label>N/I:</label><br>
                                        <input type="text" class="mid-input" name="NI[]" value="<?php echo $row['NI']?>">
                                    </p>
                                    <p>
                                        <label>S/N:</label><br>
                                        <input type="text" class="mid-input" name="SN[]" value="<?php echo $row['SN']?>">
                                    </p>
                                    <p>
                                        <label>Dodatkowe wyposażenie:</label><br>
                                        <textarea type="text" name="dodatki[]" rows="2" cols="20" value=""></textarea>
                                    </p> 
                                    
                                </div>  
                                <input type="button" style="width: 200px" class="btnRemove btn btn-danger" value="Usuń ten rekord"/>
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