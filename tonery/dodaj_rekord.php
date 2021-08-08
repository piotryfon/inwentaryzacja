<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("connection_tonery.php");
    require("../test_input.php");
    require("navbar-tonery.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dodaj rekord tonery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <div class="container">
        <header>
        <?php
            show_navbar();
         ?>
        </header>
        <?php
            if(isset($_POST['dodaj'])){
                $kod = test_input($_POST['kod']);
                $oznaczenie = test_input($_POST['oznaczenie']);
                $kolor = test_input($_POST['kolor']);
                $firma = test_input($_POST['firma']);
                $opis = test_input($_POST['opis']);

                $sql = "INSERT INTO tonery_tab (kod, oznaczenie, kolor, firma, opis) 
                VALUES ('$kod', '$oznaczenie', '$kolor', '$firma', '$opis')";
                if($kod == "") {
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Zostawiłeś puste pole...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    $query = "SELECT * FROM tonery_tab WHERE kod = '$kod'";
                    $res = mysqli_query($conn, $query);
                    if(mysqli_num_rows($res)>0){
                        echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Taki kod już istnieje w bazie i nie może być ponownie dodany!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
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
            }
            mysqli_close($conn);
       ?>
        <h4>Dodaj rekord - toner</h4><br>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="row">
                <div class="col-lg-5">
                    <div>
                        <label>*kod</label>
                    </div>
                    <input type="text" required name="kod"><br><br>
                    <div>
                        <label>*oznaczenie</label>
                    </div>
                    <input type="text" required name="oznaczenie"><br><br>
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
                    <button class="btn btn-outline-success" type="submit" name="dodaj">Dodaj</button>
                    <p style="color: green">* pole wymagane</p>
                </div>
            </div>
        </form>
       
    </div>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>

</html>