<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
require("../connection.php");
require("../test_input.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Do protokołu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <style>
    .mid-input {
         width: 150px;
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
        <h4>Wyszukaj sprzęt.</h4>
		<form method="POST">
			<div>
				<label for="opcja">Wybierz parametr:</label><br>
				<select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
					<option value="login_pracownika">login pracownika</option>
                    <option value="NI">N/I sprzętu</option>
                    <option value="SN">S/N sprzętu</option>
                    <option value="pokoj">pokój</option>
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
                    WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or
                    (SN = '$wartosc_input') or (pokoj LIKE '%$wartosc_input%') ORDER BY login_pracownika";
            }
            
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)===0){
                    echo '<h5 style="color: red">Brak danych!</h5>';
                }else {
                    ?>
                    <form method="post">
                        <?php
                        $counter = 0;
                        while($row = mysqli_fetch_array($result)){
                            $counter = $counter + 1;
                            ?>
                            <div>
                                <input type="text" class="mid-input readonly" style="width: 40px" name="lp" value="<?php echo $counter ?>" readonly>
                                <input type="text" class="mid-input" name="login" placeholder="login" value="<?php echo $row['login_pracownika']?>">
                                <input type="text" class="mid-input" name="rodzaj[]" placeholder="rodzaj" value="<?php echo $row['rodzaj']?>">
                                <input type="text" class="mid-input" name="model[]" placeholder="model" value="<?php echo $row['model']?>">
                                <input type="text" class="mid-input" name="NI[]" placeholder="N/I" value="<?php echo $row['NI']?>">
                                <input type="text" class="mid-input" name="SN[]" placeholder="S/N" value="<?php echo $row['SN']?>">
                                <input type="text" style="width: 60px" name="pokoj[]" placeholder="pokój" value="<?php echo $row['pokoj']?>">
                                <input type="button" class="btnRemove btn btn-danger" value="Usuń"/>
                            </div>
                            <br>
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
        if(isset($_POST['dodaj'])){
            for($i=0;$i<(int)$_POST['rows'];$i++){

                $rodzaj = $_POST['rodzaj'][$i];
                $model = $_POST['model'][$i];
                $NI = $_POST['NI'][$i];
                $SN = $_POST['SN'][$i];
                $pokoj = $_POST['pokoj'][$i];
                
                $sql="INSERT INTO protokol(rodzaj, model, ni, sn, pokoj)VALUES('$rodzaj','$model','$NI','$SN','$pokoj')";
                
                $result=$conn->prepare($sql);
                $result->execute();
                header("location: protokol_tabela.php");
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