<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
    require('navbar.php');
    require("connection.php");
    require("test_input.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>edytuj sprzęt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./style/main.css">
</head>

<body>
    <div class="container">
        <header>
            <?php
                showNavbar();
            ?>
        </header>
        <?php

        if(isset($_POST['edit'])){
                
                $query = "SELECT * FROM sprzet LEFT JOIN pracownicy ON sprzet.id_pracownika = pracownicy.id_pracownika
                        WHERE id_sprzetu = '$_POST[id_sprz]'";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Nieprwidłowe zapytanie";
                }
                $row = mysqli_num_rows($result);
                if ($row < 1) {
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Nie ma takiego sprzętu...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    mysqli_free_result($result);
                } else {

                    while ($row = mysqli_fetch_array($result)) {
            ?>
                        <form method="post" action="edytuj_sprzet_tab.php">
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <div>
                                            <label>ID sprzętu</label>
                                        </div>
                                        <input type="number" name="id" readonly value="<?php echo $row['id_sprzetu'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>rodzaj</label>
                                        </div>
                                        <input type="text" name="rodzaj" class="bg-success text-white" value="<?php echo $row['rodzaj'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>pin</label>
                                        </div>
                                        <input type="text" name="pin" class="bg-success text-white" value="<?php echo $row['pin'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>model</label>
                                        </div>
                                        <input type="text" name="model" class="bg-success text-white" value="<?php echo $row['model'] ?>" />
                                    </div><br>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <div>
                                            <label>N/I</label>
                                        </div>
                                        <input type="text" name="ni" class="bg-success text-white" value="<?php echo $row['NI'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>S/N</label>
                                        </div>
                                        <input type="text" name="sn" class="bg-success text-white" value="<?php echo $row['SN'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>procesor</label>
                                        </div>
                                        <input type="text" name="procesor" class="bg-success text-white" value="<?php echo $row['procesor'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>RAM</label>
                                        </div>
                                        <input type="text" name="ram" class="bg-success text-white" value="<?php echo $row['ram'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>dysk</label>
                                        </div>
                                        <input type="text" name="dysk" class="bg-success text-white" value="<?php echo $row['dysk'] ?>" />
                                    </div><br>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <div>
                                            <label>status</label>
                                        </div>
                                        <select name="status" class="bg-success text-white status">
											<option><?php echo $row['status_sprz'] ?></option>
											<option>magazyn</option>
											<option>nowy</option>
											<option>w przygotowaniu</option>
											<option>do wydania</option>
											<option>wydany</option>
											<option>pożyczony</option>
											<option>prezentacja</option>
                                            <option>NIE RUSZAĆ</option>
                                            <option></option>
										</select>
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>login</label>
                                        </div>
                                        <input type="text" name="login" class="bg-success text-white" value="<?php echo $row['login_pracownika'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>nr faktury</label>
                                        </div>
                                        <input type="text" min="0" max="999" name="nr_faktury" class="bg-success text-white" value="<?php echo $row['nr_faktury'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>opis</label>
                                        </div>
                                        <textarea rows="2" cols="25" type="text" name="opis" class="bg-success text-white"><?php echo $row['opis'] ?></textarea>
                                    </div><br>
                                    <button class="btn btn-outline-warning" type="submit" name="zatwierdz">Zapisz zmiany</button>
                                    <input name="data" class="invisible" value="<?php echo date("Y-m-d") ?>"/>
                                </div>
                            </div>

                        </form>
                        <hr>
            <?php
                    }
                }
            }
        
        if (isset($_POST['zatwierdz'])) {

            $rodzaj = test_input($_POST['rodzaj']);
            $opis = test_input($_POST['opis']);
            $pin = test_input($_POST['pin']);
            $model = test_input($_POST['model']);
            $sn = test_input($_POST['sn']);
            $ni = test_input($_POST['ni']);
            $nr_faktury = test_input($_POST['nr_faktury']);
            $procesor = test_input($_POST['procesor']);
            $ram = test_input($_POST['ram']);
            $dysk = test_input($_POST['dysk']);
            $status = test_input($_POST['status']);
            $login = test_input($_POST['login']);
            $data = $_POST['data'];

            $query_login = "SELECT * FROM pracownicy WHERE login_pracownika = '$_POST[login]'";
			$result_login = mysqli_query($conn, $query_login);

			if (mysqli_num_rows($result_login) === 0) {
                echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Nie ma takiego pracownika lub nieprawidłowa wartość...</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
			} else {
              
                $row_id = '';
                foreach ($result_login as $row) 
                {
                        $row_id = $row['id_pracownika'];
                }
                $row_id = (int)$row_id;
    
                $query = "UPDATE sprzet SET 
                                rodzaj = '$rodzaj', opis = '$opis', pin = '$pin', model = '$model', SN = '$sn', NI = '$ni', nr_faktury = '$nr_faktury',
                                procesor = '$procesor', ram = '$ram', dysk = '$dysk', status_sprz = '$status', id_pracownika = '$row_id'
                            WHERE id_sprzetu ='" . $_POST['id'] . "' ";

                $result = mysqli_query($conn, $query) or die(mysqli_error());
                if ($result) {
                    $query_historia = "INSERT INTO sprzet_historia (SN, NI, rodzaj, status_sprz, login, data_zmiany) 
                        VALUES ('$sn', '$ni', '$rodzaj', '$status', '$login', '$data')";
                        if ($query_historia) {
                            mysqli_query($conn, $query_historia);
                        }
                        echo'<br><div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Poprawnie edytowano sprzęt.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                } else {
                    echo "<h4>Błąd zapytania</h4>";
                }
            }
        }
        ?>
    </div>
    <?php
    mysqli_close($conn);
    ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
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