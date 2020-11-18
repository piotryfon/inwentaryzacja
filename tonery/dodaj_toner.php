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
                <li class="nav-item">
                    <a class="nav-link active" href="dodaj_rekord.php">dodaj rekord</a>
                </li>
            </ul>
        </header>
        <h4>Dodaj toner</h4><br>
        <form method="POST" action="dodaj_toner.php">
            <label>kod</label>
            <input type="text" name="kod">
            <input type="submit" value="dodaj" name="dodaj" />
        </form>
        <?php
        $conn = mysqli_connect("localhost","root","","tonery_db"); 
        if($conn == false){
            die("Brak połączenia z bazą: ".mysqli_connect_error());
        }
      
        if(isset($_POST['dodaj'])){

            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$_POST[kod]'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo "Kod nieprawidłowy";
            } 
            else {
                $query_update = "UPDATE tonery_tab SET ilosc = ilosc+1 WHERE kod = '$_POST[kod]'";
                $result_updete = mysqli_query($conn, $query_update);   
               
                header("location: dodano_toner.php");
            }
        }   
        mysqli_close($conn);
       
        ?>
    </div>
</body>

</html>