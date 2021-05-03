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
    <title>Dodaj drukarkę</title>
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
                $ni = test_input(($_POST['NI']));
                if($ni == "") {
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Zostawiłeś puste pole...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    $sql_check = "SELECT id_drukarki FROM drukarki WHERE NI = '$ni'";
                    $sql_check_result = mysqli_query($conn, $sql_check);
                    if(mysqli_num_rows($sql_check_result)){
                        echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Taka nazwa już istnieje i nie może być dodana...</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        $sql = "INSERT INTO drukarki (NI) VALUES ('$ni')";
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
        <h4>Dodaj drukarkę.</h4><br>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
                <label>Nazwa w domenie np. 00P2254</label>
            </div>
            <input type="text" name="NI"><br><br>
            <button class="btn btn-outline-success" type="submit" name="dodaj">Dodaj drukarkę</button>
        </form>
    </div>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>

</html>