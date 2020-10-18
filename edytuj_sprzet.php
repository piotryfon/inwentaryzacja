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
                    <a class="nav-link active" href="index.php">str. gł</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajpracownika.php">dodaj pracownika</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dodajsprzet.php">dodaj sprzęt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="edytuj_status.php">zmień status sprzętu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pracownicy_tabela.php">pracownicy - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_pracownik_tab.php">pracownicy/sprzęt - tabela</a>
                </li>
            </ul>
        </header><br>
        <h4>Edycja sprzętu</h4>
        <hr>
        <p>Wyszukaj sprzęt</p>
        <br>
        <form method="post">
            <div>
                <label for="opcja">Wybierz parametr:</label><br>
                <select name="opcja" id="opcja">
                    <option value="NI">numer inwentarzowy</option>
                    <option value="status_sprz">status</option>
                    <option value="rodzaj">rodzaj</option>
                </select>
            </div><br>
            <div>
                <input type="text" name="wartosc" placeholder="Wpisz wartość">
            </div><br>
            <input class="btn btn-primary" type="submit" name="search" value="przeszukaj dane">
        </form>
        <hr>
        <br>

        <?php
        require("connection.php");

        if (isset($_POST['search'])) {
            $opcjonalna_wartosc = $_POST['opcja'];
            $wartosc_input = $_POST['wartosc'];
            $query = "SELECT * FROM sprzet 
					WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";

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
                            <div class="col-lg-6">
                                <div>
                                    <div>
                                        <label>ID sprzętu<label>
                                    </div>
                                    <input type="number" name="id" readonly value="<?php echo $row['id_sprzetu'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>rodzaj<label>
                                    </div>
                                    <input type="text" name="rodzaj" value="<?php echo $row['rodzaj'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>pin<label>
                                    </div>
                                    <input type="text" name="pin" value="<?php echo $row['pin'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>model<label>
                                    </div>
                                    <input type="text" name="model" value="<?php echo $row['model'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>N/I<label>
                                    </div>
                                    <input type="text" name="ni" value="<?php echo $row['NI'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>S/N<label>
                                    </div>
                                    <input type="text" name="sn" value="<?php echo $row['SN'] ?>" />
                                </div><br>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div>
                                        <label>procesor<label>
                                    </div>
                                    <input type="text" name="procesor" value="<?php echo $row['procesor'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>RAM<label>
                                    </div>
                                    <input type="text" name="ram" value="<?php echo $row['ram'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>dysk<label>
                                    </div>
                                    <input type="text" name="dysk" value="<?php echo $row['dysk'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>status<label>
                                    </div>
                                    <input type="text" name="status" value="<?php echo $row['status_sprz'] ?>" />
                                </div><br>
                                <div>
                                    <div>
                                        <label>opis<label>
                                    </div>
                                    <textarea type="text" name="opis"><?php echo $row['opis'] ?></textarea>
                                </div><br>
                                <input class="btn btn-primary" type="submit" value="zatwierdz" name="zatwierdz">
                            </div>
                        </div>

                    </form>
                    <hr>
        <?php
                }
            }
        }
        if (isset($_POST['zatwierdz'])) {

            $query = "UPDATE sprzet SET 
                            rodzaj = '$_POST[rodzaj]', opis = '$_POST[opis]',
                            pin = '$_POST[pin]', model = '$_POST[model]',
                            SN = '$_POST[sn]', NI = '$_POST[ni]',
                            procesor = '$_POST[procesor]', ram = '$_POST[ram]',
                            dysk = '$_POST[dysk]', status_sprz = '$_POST[status]'
                            WHERE id_sprzetu ='" . $_POST['id'] . "' ";

            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<h4>Zmiany wprowadzone</h4>";
            } else {
                echo "<h4>Błąd zapytania</h4>";
            }
        }
        ?>
    </div>
    <?php
    mysqli_close($conn);
    ?>
</body>

</html>