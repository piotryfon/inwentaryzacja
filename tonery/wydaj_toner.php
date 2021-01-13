<?php 
    require("connection_tonery.php");
    $query_drukarki = "SELECT NI FROM drukarki ORDER BY NI ASC";
    $result_drukarki = mysqli_query($conn, $query_drukarki);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Wydaj toner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="/inwentaryzacja/index.php">str. gł</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tonery_tabela.php">tonery tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_toner.php">dodaj toner do magazynu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydaj_toner.php">wydaj toner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_rekord.php">dodaj rekord do bazy SQL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydane_tonery.php">wydane tonery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_drukarke.php">dodaj drukarkę</a>
                </li>
            </ul>
        </header>
        <hr>
        <h4>Wydaj toner</h4><br>
        <form method="POST">
            <div>
                <label for="kod">kod</label>
            </div>
            <input type="text" id="kod" name="kod"><br><br>
            <div>
                <label for="ni">N/I drukarki</label>
            </div>
            <input name="NI_drukarki" id="NI_drukarki"></input>
            <select id="ni" name="NI_drukarki_wybierz">
            <?php
                while ($row = mysqli_fetch_array($result_drukarki)) {
                    echo "<option>$row[NI]</option>";
                }
            ?>
            </select><label><-wybierz z listy lub wpisz nazwę drukarki</label><br><br>
            <div>
                <label for="data">data</label>
            </div>
            <input readonly type="text" id="data" name="data" value="<?php echo date("Y-m-d") ?>"><br><br>
            
            <input type="submit" class="btn btn-success" value="wydaj toner" name="wydaj_toner" />
        </form>
        <?php
    
        if(isset($_POST['wydaj_toner'])){

            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$_POST[kod]'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo '
                <h5 style="color: red">Nieprawidłowy kod!</h5>
                ';
            } 
            else {

                $query_ilosc = "SELECT ilosc from tonery_tab WHERE kod = '$_POST[kod]'";
                $result_ilosc = mysqli_query($conn, $query_ilosc);
                $row = mysqli_fetch_array($result_ilosc);
                
                $NI_drukarki = mysqli_real_escape_string($conn, $_REQUEST['NI_drukarki']);
                if($NI_drukarki===""){
                    echo '
                    <h5 style="color: red">Nie wybrałeś drukarki!</h5>
                    ';
                } else {
                    if($row['ilosc'] < 1) {
                        echo '
                            <h5 style="color: red">Toner nie może być wydany - brak w magazynie!</h5>
                            ';
                    } else {
                        $query_odejmij = "UPDATE tonery_tab SET ilosc = ilosc-1 WHERE kod = '$_POST[kod]'";
                        $result_odejmij = mysqli_query($conn, $query_odejmij);  
                        $query_dodaj_do_wydanych = "INSERT INTO wydane_tonery (kod, NI_drukarki, data_wydania) 
                        VALUES ('$_POST[kod]', '$_POST[NI_drukarki]', '$_POST[data]')"; 
                        $result_wydane = mysqli_query($conn, $query_dodaj_do_wydanych);
                        echo '<script type="text/javascript">
                        alert("Wydano toner / część.");
                        </script>';
                    }  
                }
            }
        }   
        mysqli_close($conn);
       
        ?>
    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        $(document).ready(function(){
            $("select").change(function(){
                $("#NI_drukarki:text").val($("select").val());
            });
        });
    </script>
    
</body>

</html>