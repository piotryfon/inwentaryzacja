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
    <title>edytuj pracownika</title>
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
                <button class="btn btn-outline-success" type="submit" name="search">Znajdź pracownika</button>
            </div>
        </form>
        <hr>
        <br>

        <?php
        if (isset($_POST['search'])) {
            
            $opcjonalna_wartosc = $_POST['opcja'];
            $wartosc_input = test_input($_POST['wartosc']);
            if($_POST['wartosc']=='') {
                echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Zostawiłeś puste pole...</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {

                $query = "SELECT * FROM pracownicy 
                        WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%'";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Nieprwidłowe zapytanie";
                }

                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <form method="post" action="edytuj_pracownika.php" accept-charset="utf-8" enctype="multipart/form-data">
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
							       <div>
                                <div>
                                    <label>Wybierz protokół przekazania sprzętu (MAX 4 MB)<label>
                                </div>                           
							  	<input type="file" name="pdf_file" accept=".pdf"/>
								<input type="hidden" name="MAX_FILE_SIZE" value="67108864"/> 						  
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
                            <button class="btn btn-outline-warning" type="submit" name="zatwierdz">Zapisz zmiany</button>						
                        </div>
                    </div>
                    </form>
                    <hr>
            <?php
                }
            }
        }
		
		
		if (isset($_POST['zatwierdz']) && !empty($_FILES['pdf_file']['name']) && isset($_POST['id']))
		{		
			$login = test_input($_POST['login_pracownika']);			
			$date = date("Y/m/d"); 			
			$filename = $login . ' ' . $date;			
			$file_tmp = $_FILES['pdf_file']['tmp_name'];

			require_once __DIR__ ."/include/function.php";
			
			addProtocolToDatabase($file_tmp, $_POST['id'], $login, $file_tmp);
			
			$login = test_input($_POST['login_pracownika']);
						$imie = test_input($_POST['imie']);
						$nazwisko = test_input($_POST['nazwisko']);
						$pokoj = test_input($_POST['pokoj']);
						$departament = test_input($_POST['departament']);
						$query = "UPDATE pracownicy SET login_pracownika = '$login', imie = '$imie', nazwisko = '$nazwisko', departament = '$departament', pokoj = '$pokoj'
                        WHERE id_pracownika ='".$_POST['id']."' ";
       
						$result = mysqli_query($conn, $query);
						if ($result)
						{
							echo '<script type="text/javascript">
							alert("Poprawnie edytowano pracownika.");
							</script>';
						} else  {
									echo "<h4>Błąd zapytania</h4>";
								}
			
		}
		
		else
			{
				    if (isset($_POST['zatwierdz'])) 
					{
						$login = test_input($_POST['login_pracownika']);
						$imie = test_input($_POST['imie']);
						$nazwisko = test_input($_POST['nazwisko']);
						$pokoj = test_input($_POST['pokoj']);
						$departament = test_input($_POST['departament']);
						$query = "UPDATE pracownicy SET login_pracownika = '$login', imie = '$imie', nazwisko = '$nazwisko', departament = '$departament', pokoj = '$pokoj'
                        WHERE id_pracownika ='".$_POST['id']."' ";
       
						$result = mysqli_query($conn, $query);
						if ($result)
						{
							echo '<script type="text/javascript">
							alert("Poprawnie edytowano pracownika.");
							</script>';
						} else  {
									echo "<h4>Błąd zapytania</h4>";
								}
                }	
			}
			
		    ?>
    </div>
    <?php
    mysqli_close($conn);
    ?>
</body>

</html>