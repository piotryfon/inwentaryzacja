<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>edytuj pracownika</title>
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
                    <a class="nav-link active" href="sprzet_tabela.php">sprzęt - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pracownicy_tabela.php">pracownicy - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="sprzet_pracownik_tab.php">pracownicy/sprzęt - tabela</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="historia.php">historia zmian</a>
                </li>
            </ul>
        </header><br>
        <h4>Edycja pracownika</h4>
        <hr>
        <p>Wyszukaj pracownika</p>
        <br>
        <form method="post">
            <div>
                <label for="opcja">Wybierz parametr:</label><br>
                <select name="opcja" id="opcja">
                    <option value="login_pracownika">login</option>
                    <option value="nazwisko">nazwisko</option>
                    <option value="imie">imię</option>
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
            $query = "SELECT * FROM pracownicy 
					WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";

            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Nieprwidłowe zapytanie";
            }

            while ($row = mysqli_fetch_array($result)) {
        ?>
                <form method="post" action="edytuj_pracownika.php">
                <div class="row">
                    <div class="col-lg-4">
                        <div>
                            <div>
                                <label>ID pracownika<label>
                            </div>
                            <input type="number" name="id" readonly value="<?php echo $row['id_pracownika'] ?>" />
                        </div><br>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <div>
                                <label>login pracownika<label>
                            </div>
                            <input type="text" name="login_pracownika" class="bg-success text-white" value="<?php echo $row['login_pracownika'] ?>" />
                        </div><br>
                        <div>
                            <div>
                                <label>imię<label>
                            </div>
                            <input type="text" name="imie"class="bg-success text-white" value="<?php echo $row['imie'] ?>" />
                        </div><br>
                        <div>
                            <div>
                                <label>nazwisko<label>
                            </div>
                            <input type="text" name="nazwisko" class="bg-success text-white" value="<?php echo $row['nazwisko'] ?>" />
                        </div><br>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <div>
                                <label>departament<label>
                            </div>
                            <input type="text" name="departament" class="bg-success text-white" value="<?php echo $row['departament'] ?>" />
                        </div><br>
                        <div>
                            <div>
                                <label>pokój<label>
                            </div>
                            <input type="text" name="pokoj" class="bg-success text-white" value="<?php echo $row['pokoj'] ?>" />
                        </div><br>
                        <input class="btn btn-primary" type="submit" value="zatwierdz" name="zatwierdz">
                    </div>
                </div>
                </form>
                <hr>
        <?php
            }
        }
        if (isset($_POST['zatwierdz'])) {
           
            $query = "UPDATE pracownicy SET 
                            login_pracownika = '$_POST[login_pracownika]',
                            imie = '$_POST[imie]', nazwisko = '$_POST[nazwisko]',
                            departament = '$_POST[departament]', pokoj = '$_POST[pokoj]'
                            WHERE id_pracownika ='".$_POST['id']."' ";
        
                $result = mysqli_query($conn, $query);
                if ($result){
                    header("location: pracownik_edytowany.html");
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