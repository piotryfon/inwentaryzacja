<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Usuń Rekord</title>
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
        </header>
            <h2>Usuwanie rekordu z bazy.</h2>
            <form class="form-group" method="post" >
                <label for="id-input">Podaj "Id" rekordu do usunięcia.</label><br>
                <input type="number" id="id_input" name="id_sprzetu"/> <br>
                <br>
                <button class="btn btn-danger" type="submit" name="delete">USUŃ REKORD</button>
            </form>
            <?php
        
                require("connection.php");
               
                if(isset($_POST['delete'])){
                    $id_sprzetu = $_POST['id_sprzetu'];
                    $query = "DELETE FROM sprzet WHERE id_sprzetu = $id_sprzetu";

                    if($_POST['id_sprzetu'] === ""){
                        echo "Zostawiłeś puste pole."."<br>";
                    } else {
                        if(mysqli_query($conn, $query)){
                            echo "Usunięto rekord.";
                        }else{
                            echo "Coś poszło nie tak!";
                        }
                    }       
                }

                mysqli_close($conn);
            ?>
    </div>
</body>
</html>