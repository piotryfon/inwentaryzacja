<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dodaj drukarkę</title>
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
        <h4>Dodaj drukarkę.</h4><br>
        <form method="POST" action="dodaj_drukarke.php">
            <div>
                <label>Nazwa w domenie np. 00p2254</label>
            </div>
            <input type="text" name="NI"><br><br>
            <input type="submit" class="btn btn-success" value="dodaj drukarkę" name="dodaj" style="width: 200px" />
        </form>
        <?php
        require("connection_tonery.php");
      
        if(isset($_POST['dodaj'])){
            $ni = mysqli_real_escape_string($conn, $_REQUEST['NI']);

            $sql = "INSERT INTO drukarki (NI) 
            VALUES ('$ni')";
            if($ni == "") {
                echo '<h3 style="color: red">Zostawiłeś puste pole!</h3>';
            } else {
                if (mysqli_query($conn, $sql)) {
                    echo '<script type="text/javascript">
                            alert("Rekord dodany.")
                        </script>';
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
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