<?php 
    $conn = mysqli_connect("localhost","root","","tonery_db"); 
        if($conn == false){
            die("Brak połączenia z bazą: ".mysqli_connect_error());
        }
    $query_drukarki = "SELECT NI FROM drukarki";
    $result_drukarki = mysqli_query($conn, $query_drukarki);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tonery</title>
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
                    <a class="nav-link active" href="tonery_tabela.php">tonety tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_toner.php">dodaj toner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wydaj_toner.php">wydaj toner</a>
                </li>

            </ul>
        </header>
        <h4>Wydaj toner</h4><br>
        
        <form method="POST" action="wydaj_toner.php">
            <div>
                <label for="kod">kod</label>
            </div>
            <input type="text" id="kod" name="kod"><br><br>
            <div>
                <label for="ni">N/I drukarki</label>
            </div>
            <select id="ni" name="NI_drukarki">
            <?php
                while ($row = mysqli_fetch_array($result_drukarki)) {
                    echo "<option>$row[NI]</option>";
                }
            ?>
            </select><br><br>
            <div>
                <label for="data">data</label>
            </div>
            <input readonly type="text" id="data" name="data" value="<?php echo date("Y-m-d") ?>"><br><br>
            
            <input type="submit" value="wydaj toner" name="wydaj_toner" />
        </form>
        <?php
       
      
        if(isset($_POST['wydaj_toner'])){

            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$_POST[kod]'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo "Kod nieprawidłowy";
            } 
            else {

                $query_ilosc = "SELECT ilosc from tonery_tab WHERE kod = '$_POST[kod]'";
                $result_ilosc = mysqli_query($conn, $query_ilosc);
                $row = mysqli_fetch_array($result_ilosc);
                
                if($row['ilosc'] < 1) {
                    echo "Brak tonera!";
                } else {
                    $query_odejmij = "UPDATE tonery_tab SET ilosc = ilosc-1 WHERE kod = '$_POST[kod]'";
                    $result_odejmij = mysqli_query($conn, $query_odejmij);  
                    $query_dodaj_do_wydanych = "INSERT INTO wydane_tonery (kod, NI_drukarki, data_wydania) 
                    VALUES ('$_POST[kod]', '$_POST[NI_drukarki]', '$_POST[data]')"; 
                    $result_wydane = mysqli_query($conn, $query_dodaj_do_wydanych);
               
                    header("location: wydano_toner.php");
                }  
            }
        }   
        mysqli_close($conn);
       
        ?>
    </div>
</body>

</html>