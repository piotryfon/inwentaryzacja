<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("navbar-tonery.php");
    require("connection_tonery.php");
    require("../test_input.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dodaj toner do bazy</title>
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
        <h4>Dodaj toner</h4><br>
        <form method="POST" action="dodaj_toner.php">
            <label>kod</label>
            <input type="text" name="kod">
            <label>ilość:</label>
            <input type="number" name="ilosc" value="1" min="1" max="50" style="width: 60px"/>
            <button class="btn btn-outline-success" type="submit" name="dodaj">Dodaj</button>
        </form>
        <?php
       

        if(isset($_POST['dodaj'])){

            $ilosc = $_POST['ilosc'];
            $kod = test_input($_POST['kod']);
            $query_is_value = "SELECT id FROM tonery_tab WHERE kod = '$kod'";
            $result_is_value = mysqli_query($conn, $query_is_value);

            if(mysqli_num_rows($result_is_value)===0){
                echo '<h5 style="color: red">Nieprawidłowy kod!</h5>';
            } 
            else {
                $query_update = "UPDATE tonery_tab SET ilosc = ilosc + $ilosc WHERE kod = '$kod'";
                $result_updete = mysqli_query($conn, $query_update);   
               
                echo '<script type="text/javascript">
                alert("Dodano toner/część do bazy.");
                </script>';
            }
        }   
        mysqli_close($conn);
       
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        
        $(document).ready(function(){
            $('form').on('focus', 'input[type=number]', function (e) {
                $(this).on('wheel.disableScroll', function (e) {
                e.preventDefault()
                })
            })
                $('form').on('blur', 'input[type=number]', function (e) {
                $(this).off('wheel.disableScroll')
            })
        });

    </script>
</body>

</html>