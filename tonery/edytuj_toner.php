<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("connection_tonery.php");
    require("navbar-tonery.php");
    require("../test_input.php");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tonery tabela</title>
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
        if(isset($_POST['edit'])){
                
                $query = "SELECT * FROM tonery_tab WHERE id = '$_POST[id]'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Nieprwidłowe zapytanie";
                }
                while ($row = mysqli_fetch_array($result)) {
        ?>
                <form method="post" action="edytuj_toner.php">

                    <div>
                        <div>
                            <label>ID (readonly)</label>
                        </div>
                        <input type="number" name="id" readonly value="<?php echo $row['id'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Kod</label>
                        </div>
                        <input type="text" name="kod" value="<?php echo $row['kod'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Oznaczenie</label>
                        </div>
                        <input type="text" name="oznaczenie" value="<?php echo $row['oznaczenie'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Firma</label>
                        </div>
                        <input type="text" name="firma" value="<?php echo $row['firma'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Kolor</label>
                        </div>
                        <input type="text" name="kolor" value="<?php echo $row['kolor'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Ilość</label>
                        </div>
                        <input type="number" name="ilosc" value="<?php echo $row['ilosc'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>Opis</label>
                        </div>
                        <textarea rows="2" cols="25" type="text" name="opis"><?php echo $row['opis'] ?></textarea>
                    </div><br>
                    <button class="btn btn-outline-warning" type="submit" name="zatwierdz">Zapisz zmiany</button>


                </form>

        <?php
                }
        }
        if (isset($_POST['zatwierdz'])) {
            $kod = test_input($_POST['kod']);
            $oznaczenie = test_input($_POST['oznaczenie']);
            $firma = test_input($_POST['firma']);
            $kolor = test_input($_POST['kolor']);
            $ilosc = $_POST['ilosc'];
            $opis = test_input($_POST['opis']);

            $query = "UPDATE tonery_tab SET kod = '$kod', oznaczenie = '$oznaczenie', firma = '$firma', kolor = '$kolor', ilosc = '$ilosc', opis = '$opis'
            WHERE id ='" . $_POST['id'] . "' ";

            $result = mysqli_query($conn, $query) or die(mysqli_error());

            if($result){
                echo'<br><div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Rekord poprawnie edytowany.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        }


        ?>



    </div>
    <?php
        mysqli_close($conn);
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('form').on('focus', 'input[type=number]', function(e) {
                $(this).on('wheel.disableScroll', function(e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function(e) {
                $(this).off('wheel.disableScroll')
            })
        });
        </script>
</body>
</html>