<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dodaj toner</title>
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
            </ul>
        </header>
        <hr>
        <h4>Dodaj toner</h4><br>
        <form method="POST" action="dodaj_toner.php">
            <label>kod</label>
            <input type="text" name="kod">
            <label>ilość:</label>
            <input type="number" name="ilosc" value="1" min="1" max="50" style="width: 60px"/>
            <input type="submit" class="btn btn-success" value="dodaj" name="dodaj"/>
        </form>
        <?php
        require("connection_tonery.php");
      
        if(isset($_POST['dodaj'])){

            $ilosc = mysqli_real_escape_string($conn, $_REQUEST['ilosc']);

            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$_POST[kod]'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo "Kod nieprawidłowy";
            } 
            else {
                $query_update = "UPDATE tonery_tab SET ilosc = ilosc + $ilosc WHERE kod = '$_POST[kod]'";
                $result_updete = mysqli_query($conn, $query_update);   
               
                echo "<h4>Dodano toner do magazynu.</h4>";
            }
        }   
        mysqli_close($conn);
       
        ?>
    </div>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>

</html>