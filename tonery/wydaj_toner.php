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
            <?php
        
            if(isset($_POST['wydaj_toner'])){
                $kod = test_input($_POST['kod']);
                $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$kod'";
                $result_is_value = mysqli_query($conn, $query_is_value);

                if(mysqli_num_rows($result_is_value)===0){
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Nieprawidłowy kod...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } 
                else {

                    $query_ilosc = "SELECT ilosc from tonery_tab WHERE kod = '$kod'";
                    $result_ilosc = mysqli_query($conn, $query_ilosc);
                    $row = mysqli_fetch_array($result_ilosc);
                    
                    $NI_drukarki = mysqli_real_escape_string($conn, $_REQUEST['NI_drukarki']);
                    if($NI_drukarki===""){
                        echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Nie wybrałeś drukarki...</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        if($row['ilosc'] < 1) {
                            echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Toner lub część nie może być wydana - brak w magazynie...</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
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
            <h4>Wydaj toner</h4><br>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div>
                    <label for="kod">kod</label>
                </div>
                <input type="text" required id="kod" name="kod"><br><br>
                <div>
                    <label for="ni">N/I drukarki</label>
                </div>
                <select id="ni" required name="NI_drukarki" id="ni">
                <option></option>
                <?php
                    while ($row = mysqli_fetch_array($result_drukarki)) {
                        echo "<option>$row[NI]</option>";
                    }
                ?>
                </select>
                <button style="margin-left: 20px" class="btn btn-outline-success" type="submit" name="wydaj_toner">Wydaj toner</button>
            <input class="invisible" type="text" id="data" name="data" value="<?php echo date("Y-m-d") ?>">
            
        </form>
       
    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
</body>

</html>