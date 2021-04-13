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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style/protokol.css">
    <title>Protokół wydania sprzętu komputerowego w Centrali NFZ</title>
</head>
<body>
    <div class="container">
        
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <b><a class="nav-link active" href="main.php">str. gł</a></b>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wyszukaj_komputer_proto.php">wyszukaj sprzęt do protokołu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="protokol_komputer.php">protokół wydania sprzętu</a>
                </li>
                <li>
				    <b><a class="nav-link" href="/inwentaryzacja/logout.php">Wyloguj się</a></b>
			    </li>
            </ul>
        <hr>
        <input type="submit" class="btn btn-primary" style="width: 250px" 
                        name ="print" value="drukuj protokół" onclick="printDiv()"><br><br>
        <form method="post">
            <input type="submit" class="btn btn-danger" name ="clear" value="wyczyść protokół">
        </form>
        <hr>
    <?php
        require("connection.php");
        if(isset($_POST['clear'])){
            $sql = "DELETE FROM protokol_wydania_komputera";
            if(mysqli_query($conn, $sql)){
                $sql_AI = "ALTER TABLE protokol_wydania_komputera AUTO_INCREMENT=1";
                mysqli_query($conn, $sql_AI);
                echo '<div class="alert alert-success" role="alert">Dane usunięte.</div>';
            } else echo '<div class="alert alert-danger" role="alert">Coś poszło nie tak!</div>';
        }
        if(isset($_POST['dodaj'])){
            for($i=0;$i<(int)$_POST['rows'];$i++){
                $imie = $_POST['imie'][$i];
                $nazwisko = $_POST['nazwisko'][$i];
                $rodzaj = $_POST['rodzaj'][$i];
                $model = $_POST['model'][$i];
                $procesor = $_POST['procesor'][$i];
                $ram = $_POST['ram'][$i];
                $dysk = $_POST['dysk'][$i];
                $NI = $_POST['NI'][$i];
                $SN = $_POST['SN'][$i];
                $dodatki = $_POST['dodatki'][$i];
                $status = $_POST['status_sprz'][$i];
                $miejsce = $_POST['miejsce'][$i];
                $sql="INSERT INTO protokol_wydania_komputera (imie, nazwisko, rodzaj, model, procesor, ram, dysk, ni, sn, dodatki, status_sprz, miejsce)
                VALUES('$imie', '$nazwisko', '$rodzaj', '$model', '$procesor', '$ram', '$dysk', '$NI', '$SN','$dodatki', '$status', '$miejsce')";
                
                $result=$conn->prepare($sql);
                $result->execute();
                
            }
        }
    ?>
        <div id="proto">
            <div id="main-proto">
                <header>
                    <img src="./img/nfz_logo.jpg" id="nfz-logo"/>
                    <div id="nfz-opis">
                        <h4>Narodowy Fundusz Zdrowia</h4>
                        <h5>Centrala w Warszawie</h5>
                        <h6>Departament Informatyki</h6>
                    </div>
                </header>
                <hr>
            <?php
                $queryName = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt wydawany'";
                $resultName = mysqli_query($conn, $queryName);
                if($dane = mysqli_fetch_array($resultName)){
                    $imie = $dane['imie'];
                    $nazwisko = $dane['nazwisko'];
                    $miejsce = $dane['miejsce'];
            ?>
                <h5>Osoba której powierza się opiekę nad środkiem trwałym:</h5>
                <h4>Nazwisko i imię: <b><?php echo ucfirst($nazwisko)?> <?php echo ucfirst($imie)?></b></h4>
                <h5>Miejsce użytkowania: <?php echo $miejsce?></h5><br>
                <h5>Sprzęt wydany:</h5>
            <?php
                } else {
                    echo '<h4>Brak sprzętu do wydania.</h4><hr>';
                }
            ?>          
            <?php
                $query = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt wydawany'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)){
                ?>
                <table class="tabela-protokol">
                    <tr>
                        <th>rodzaj</th>
                        <th>model</th>
                        <th>procesor</th>
                        <th>RAM</th>
                        <th>dysk</th>
                        <th>numer inwentarzowy</th>
                        <th>numer seryjny</th>
                        <th>dodatkowe wyposażenie</th>
                    </tr>
                <?php
                    while($row = mysqli_fetch_array($result)){     
                ?>
                    <tr>
                        <td><?php echo $row['rodzaj'] ?></td>
                        <td><?php echo $row['model'] ?></td>
                        <td><?php echo $row['procesor'] ?></td>
                        <td><?php echo $row['ram'] ?></td>
                        <td><?php echo $row['dysk'] ?></td>
                        <td><?php echo $row['ni'] ?></td>
                        <td><?php echo $row['sn'] ?></td>
                        <td><?php echo $row['dodatki'] ?></td>
                    </tr>
                    <?php
                        } //while end
                    ?>
                    </table><hr>
                <?php
                    }//if end
                ?>
                <?php
                    $queryZwrot = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt zwracany'";
                    $resultZwrot = mysqli_query($conn, $queryZwrot);
                    if(mysqli_num_rows($resultZwrot)){
                ?>
                    <h5>Osoba zwracająca sprzęt:</h5>
                    <h4>Nazwisko i imię: <b><?php echo ucfirst($nazwisko)?> <?php echo ucfirst($imie)?></b></h4>
                    <h5>Sprzęt zwrócony:</h5>
                    <table class="tabela-protokol">
                        <tr>
                            <th>rodzaj</th>
                            <th>model</th>
                            <th>procesor</th>
                            <th>RAM</th>
                            <th>dysk</th>
                            <th>numer inwentarzowy</th>
                            <th>numer seryjny</th>
                            <th>dodatkowe wyposażenie</th>

                        </tr>
                    <?php
                        while($row = mysqli_fetch_array($resultZwrot)){       
                    ?>
                        <tr>
                            <td><?php echo $row['rodzaj'] ?></td>
                            <td><?php echo $row['model'] ?></td>
                            <td><?php echo $row['procesor'] ?></td>
                            <td><?php echo $row['ram'] ?></td>
                            <td><?php echo $row['dysk'] ?></td>
                            <td><?php echo $row['ni'] ?></td>
                            <td><?php echo $row['sn'] ?></td>
                            <td><?php echo $row['dodatki'] ?></td>
                        </tr>
                    <?php
                        }//while end
                    ?>
                    </table>
                    
                    
                <?php
                    }//end while
                    else 
                    {
                        echo '<h4>Brak sprzętu do zwrócenia.</h4>';
                    }
                ?>
                <div id="sig-container">
                    <div class="sig">Data: <?php echo date("Y-m-d") ?> Podpis osoby wydającej/przyjmującej sprzęt</div> 
                    <div class="sig">Data: <?php echo date("Y-m-d") ?> Podpis osoby otrzymującej/zwracającej sprzęt</div>
                </div>
            </div>
            <footer>
                <p>Narodowy Fundusz Zdrowia | ul. Rakowiecka 26/30 02-528 Warszawa</p>
            </footer>
        </div>
       
    </div><!--end container-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function printDiv(proto) {
            let divElements = document.getElementById('proto').innerHTML;
            let oldPage = document.body.innerHTML;
            document.body.innerHTML = 
                '<html><head><meta charset="UTF-8"><title>Protokół przeniesienia sprzętu komputerowego.</title></head><body>' + 
                divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
        }
        
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        $(document).ready(function(){
            $('td').each(function() {
                let el = $(this);
                if (el.text() === '') {
                    el.text('--------');
                }
            });
        });
    </script>
</body>
</html>