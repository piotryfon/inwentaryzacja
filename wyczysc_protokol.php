
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>wyczyść tabelę</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    .mid-input {
         width: 150px;
    }
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
                    <a class="nav-link active" href="wyszukaj_do_protokolu.php">wyszukaj sprzęt do protokołu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="protokol_tabela.php">protokół</a>
                </li>
            </ul>
        </header><hr>
   
    <h4>Wyczyść tabelę - protokół</h4>
  
    <form method="post">
        <input type="submit" class="btn btn-danger" name ="clear" value="wyczyść tabelę">
    </form>
        <?php
            require("connection.php");
            if(isset($_POST['clear'])){
                $sql = "DELETE FROM protokol";
                if(mysqli_query($conn, $sql)){
                    $sql_AI = "ALTER TABLE protokol AUTO_INCREMENT=1";
                    mysqli_query($conn, $sql_AI);
                    echo '<div class="alert alert-success" role="alert">Tabela jest już pusta.</div>';
                } else echo '<div class="alert alert-danger" role="alert">Coś poszło nie tak!</div>';
            }
        ?>
    </div>
</body>
</html>
    


