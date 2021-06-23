<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("connection_tonery.php");
    require("navbar-tonery.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Usuń toner</title>
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
        <hr>
        <h4>Usuń toner</h4><br>
        <form method="POST">
            <label>kod</label>
            <input type="text" required name="kod">
            <input type="submit" class="btn btn-danger" value="usuń toner" name="usun"/>
        </form>
        <?php
        
      
        if(isset($_POST['usun'])){

            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$_POST[kod]'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo '<h5 style="color: red">Nieprawidłowy kod!</h5>';
            } 
            else {
                $query_ilosc = "SELECT ilosc from tonery_tab WHERE kod = '$_POST[kod]'";
                $result_ilosc = mysqli_query($conn, $query_ilosc);
                $row = mysqli_fetch_array($result_ilosc);
                if($row['ilosc'] < 1) {
                    echo '
                        <h5 style="color: red">Toner nie może być usunięty - brak w magazynie!</h5>
                        ';
                } else {
                    $query_update = "UPDATE tonery_tab SET ilosc = ilosc - 1 WHERE kod = '$_POST[kod]'";
                    $result_updete = mysqli_query($conn, $query_update);   
                    echo '<script type="text/javascript">
                    alert("Usunięto toner.");
                    </script>';
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