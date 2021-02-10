<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dodaj rekord tonery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <header>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <b><a class="nav-link active" href="/inwentaryzacja/main.php">str. gł</a></b>
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
                <li>
				    <b><a class="nav-link" href="/inwentaryzacja/logout.php">Wyloguj się</a></b>
			    </li>
            </ul>
        </header>
        <hr>
        <h4>Dodaj rekord - toner</h4><br>
        <form method="POST" action="dodaj_rekord.php">
            <div class="row">
                <div class="col-lg-5">
                    <div>
                        <label>*kod</label>
                    </div>
                    <input type="text" name="kod"><br><br>
                    <div>
                        <label>oznaczenie</label>
                    </div>
                    <input type="text" name="oznaczenie"><br><br>
                    <div>
                        <label>kolor</label>
                    </div>
                    <input type="text" name="kolor"><br><br>
                </div>
                <div class="col-lg-5">
                    <div>
                        <label>firma</label>
                    </div>
                    <input type="text" name="firma"><br><br>
                    <div>
                        <label>opis</label>
                    </div>
                    <textarea rows="3" cols="30" name="opis"></textarea><br><br>
                    <input type="submit" class="btn btn-success" value="dodaj" name="dodaj" />
                    <p style="color: green">* pole wymagane</p>
                </div>
            </div>
        </form>
        <?php
        require("connection_tonery.php");
      
        if(isset($_POST['dodaj'])){
            $kod = mysqli_real_escape_string($conn, $_REQUEST['kod']);
            $oznaczenie = mysqli_real_escape_string($conn, $_REQUEST['oznaczenie']);
            $kolor = mysqli_real_escape_string($conn, $_REQUEST['kolor']);
            $firma = mysqli_real_escape_string($conn, $_REQUEST['firma']);
            $opis = mysqli_real_escape_string($conn, $_REQUEST['opis']);

            $sql = "INSERT INTO tonery_tab (kod, oznaczenie, kolor, firma, opis) 
            VALUES ('$kod', '$oznaczenie', '$kolor', '$firma', '$opis')";
            if($kod == "") {
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