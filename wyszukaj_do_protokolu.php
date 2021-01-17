<?php
require("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Do protokołu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
     
    </style>
</head>
<body>
    <div class="container">
        <header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">str. gł</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajpracownika.php">dodaj pracownika</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajsprzet.php">dodaj sprzęt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pracownicy_tabela.php">pracownicy - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_pracownik_tab.php">pracownicy/sprzęt - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="historia.php">historia zmian</a>
                </li>
            </ul>
        </header>
        <h4>Wyszukaj pracownika lub sprzęt</h4>
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
			</div><br>
			<input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
		</form>
		<hr>
		<br>
        <?php
        if (isset($_POST['search'])) {
            if($_POST['wartosc']===''){
                echo '<h5 style="color: red">Wpisz wartość!</h5>';
            } else {
			$opcjonalna_wartosc = $_POST['opcja'];
			$wartosc_input = $_POST['wartosc'];
			$query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
            if($opcjonalna_wartosc === "wszystko") {
                $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                    WHERE (login_pracownika LIKE '%$wartosc_input%') or (NI LIKE '%$wartosc_input%') or
                    (SN LIKE '%$wartosc_input%')";
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
                                <input type="text" style="width: 40px" name="lp" value="<?php echo $counter ?>" readonly="">
                                <input type="text" name="rodzaj[]" value="<?php echo $row['rodzaj']?>">
                                <input type="text" name="model[]" value="<?php echo $row['model']?>">
                                <input type="text" name="NI[]" value="<?php echo $row['NI']?>">
                                <input type="text" name="SN[]" value="<?php echo $row['SN']?>">
                                <input type="text" style="width: 60px" name="pokoj[]" value="<?php echo $row['pokoj']?>">
                                <input type="button" class="btnRemove btn btn-danger" value="Remove"/>
                            </div>
                            <br>
                        <?php
                        }
                        ?>
                    <label>ilość rekordów:</label>
                    <input type="text" style="width: 40px" name="rows" id="selected-rows" readonly value="<?php echo mysqli_num_rows($result)?>">
                    <input type="submit" name="dodaj" value="dodaj do protokołu">
                    </form>
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