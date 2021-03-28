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
    <title>edytuj sprzęt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <header>
            <ul class="nav justify-content-center">

                <li class="nav-item">
                    <b><a class="nav-link active" href="main.php">str. gł</a></b>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajpracownika.php">dodaj pracownika</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajsprzet.php">dodaj sprzęt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pracownicy_tabela.php">pracownicy - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_pracownik_tab.php">sprzęt - pracownik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="historia.php">historia zmian</a>
                </li>
                <li>
				    <b><a class="nav-link" href="logout.php">Wyloguj się</a></b>
			    </li>
            </ul>
        </header><br>
        <h4>Edycja sprzętu</h4>
        <hr>
        <p>Wyszukaj sprzęt</p>
        <br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
                <label for="opcja">Wybierz parametr:</label><br>
                <select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
                    <option value="NI">numer inwentarzowy</option>
                    <option value="SN">S/N</option>
                    <option value="status_sprz">status</option>
                    <option value="rodzaj">rodzaj</option>
                </select>
            </div><br>
            <div>
                <input type="text" name="wartosc" placeholder="Wpisz wartość"> 
                <input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
            </div>
        </form>
        <hr>
        <br>

        <?php
        require("connection.php");
        require("test_input.php");

        if (isset($_POST['search'])) {
            $opcjonalna_wartosc = $_POST['opcja'];
            $wartosc_input = test_input($_POST['wartosc']);
            if($_POST['wartosc']=='') {
                echo "<h4 style='color: red'>Zostawiłeś puste pole...</h4>";
            } else {
                
                $query = "SELECT * FROM sprzet 
                        WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";
                if($opcjonalna_wartosc === "wszystko"){
                    $query = "SELECT * FROM sprzet 
                        WHERE (SN = '$wartosc_input') or (NI LIKE '%$wartosc_input%') or 
                        (status_sprz LIKE '%$wartosc_input%') or (rodzaj LIKE '%$wartosc_input%') or (opis LIKE '%$wartosc_input%')";
                }

                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Nieprwidłowe zapytanie";
                }
                $row = mysqli_num_rows($result);
                if ($row < 1) {
                    echo "Nie ma takiego sprzętu.";
                    mysqli_free_result($result);
                } else {

                    while ($row = mysqli_fetch_array($result)) {
            ?>
                        <form method="post" action="edytuj_sprzet.php">
                            <div class="row">
                                <div class="col-lg-5">
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
                                </div>
                                <div class="col-lg-5">
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
                                    <div>
                                        <div>
                                            <label>status</label>
                                        </div>
                                        <input type="text" name="status" class="bg-success text-white" value="<?php echo $row['status_sprz'] ?>" />
                                    </div><br>
                                    <div>
                                        <div>
                                            <label>nr dostawy</label>
                                        </div>
                                        <input type="number" min="0" max="999" name="nr_dostawy" class="bg-success text-white" value="<?php echo $row['nr_dostawy'] ?>" />
                                    </div><br>
                                    <input class="btn btn-warning" type="submit" value="zapisz zmiany" name="zatwierdz">
                                    <div>
                                        <div>
                                            <label>opis</label>
                                        </div>
                                        <textarea rows="2" cols="25" type="text" name="opis" class="bg-success text-white"><?php echo $row['opis'] ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <hr>
            <?php
                    }
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
            $nr_dostawy = test_input($_POST['nr_dostawy']);
            $procesor = test_input($_POST['procesor']);
            $ram = test_input($_POST['ram']);
            $dysk = test_input($_POST['dysk']);
            $status = test_input($_POST['status']);

            $query = "UPDATE sprzet SET 
                            rodzaj = '$rodzaj', opis = '$opis', pin = '$pin', model = '$model', SN = '$sn', NI = '$ni', nr_dostawy = '$nr_dostawy',
                            procesor = '$procesor', ram = '$ram', dysk = '$dysk', status_sprz = '$status'
                            WHERE id_sprzetu ='" . $_POST['id'] . "' ";

            $result = mysqli_query($conn, $query);
            if ($result) {
                header("location: sprzet_edytowany.html");
            } else {
                echo "<h4>Błąd zapytania</h4>";
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