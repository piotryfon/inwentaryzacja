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
        require("../test_input.php");

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
               
               header("location: dodano_toner.html");
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