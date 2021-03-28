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
        <h4>Edycja pracownika</h4>
        <hr>
        <p>Wyszukaj pracownika</p>
        <br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
                            <input class="btn btn-warning" type="submit" value="zapisz zmiany" name="zatwierdz">
                        </div>
                    </div>
                    </form>
                    <hr>
            <?php
                }
            }
        }
        if (isset($_POST['zatwierdz'])) {
         
           $login = test_input($_POST['login_pracownika']);
           $imie = test_input($_POST['imie']);
           $nazwisko = test_input($_POST['nazwisko']);
           $departament = test_input($_POST['pokoj']);
           $pokoj = test_input($_POST['departament']);
            $query = "UPDATE pracownicy SET login_pracownika = '$login', imie = '$imie', nazwisko = '$nazwisko', departament = '$departament', pokoj = '$pokoj'
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