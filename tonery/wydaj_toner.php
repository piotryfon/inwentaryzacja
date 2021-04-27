<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("connection_tonery.php");
    require("../test_input.php");
    require("navbar-tonery.php");
    $query_drukarki = "SELECT NI FROM drukarki ORDER BY NI ASC";
    $result_drukarki = mysqli_query($conn, $query_drukarki);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Wydaj toner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/main.css">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <header>
        <?php
            show_navbar();
         ?>
        </header>
      
        <h4>Wydaj toner</h4><br>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
            <button class="btn btn-outline-success" type="submit" name="wydaj_toner">Wydaj toner</button>
        </form>
        <?php
    
        if(isset($_POST['wydaj_toner'])){
            $kod = test_input($_POST['kod']);
            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$kod'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo '
                <h5 style="color: red">Nieprawidłowy kod!</h5>
                ';
            } 
            else {

                $query_ilosc = "SELECT ilosc from tonery_tab WHERE kod = '$kod'";
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
                        $query_odejmij = "UPDATE tonery_tab SET ilosc = ilosc-1 WHERE kod = '$kod'";
                        $result_odejmij = mysqli_query($conn, $query_odejmij);  
                        $query_dodaj_do_wydanych = "INSERT INTO wydane_tonery (kod, NI_drukarki, data_wydania) 
                        VALUES ('$kod', '$_POST[NI_drukarki]', '$_POST[data]')"; 
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