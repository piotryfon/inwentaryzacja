<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: ../index.php");
    }
    require("../connection.php");
    require("navbar_proto.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/protokol.css">
    <title>Protokół wydania sprzętu komputerowego w Centrali NFZ</title>
</head>
<body>
    <div class="container">
        <?php
            showNavbarProto();
        ?>
        <hr>
        <input type="submit" class="btn btn-primary" style="width: 250px" 
                        name ="print" value="drukuj protokół" onclick="printDiv()"><br><br>
        <form method="post">
            <input type="submit" class="btn btn-danger" name ="clear" value="wyczyść protokół">
        </form>
        <hr>
    <?php
        if(isset($_POST['clear'])){
            $sql = "DELETE FROM protokol_wydania_komputera";
            if(mysqli_query($conn, $sql)){
                $sql_AI = "ALTER TABLE protokol_wydania_komputera AUTO_INCREMENT=1";
                mysqli_query($conn, $sql_AI);
                echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Dane usunięte...</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
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
                $uwagi = $_POST['uwagi'][$i];
                $status = $_POST['status_sprz'][$i];
                $miejsce = $_POST['miejsce'][$i];
                $sql="INSERT INTO protokol_wydania_komputera (imie, nazwisko, rodzaj, model, procesor, ram, dysk, ni, sn, status_sprz, miejsce, dodatki, uwagi)
                VALUES('$imie', '$nazwisko', '$rodzaj', '$model', '$procesor', '$ram', '$dysk', '$NI', '$SN', '$status', '$miejsce', '$dodatki','$uwagi')";
                
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
                <h5>Osoba której powierza się opiekę nad środkiem trwałym:
                <b><?php echo ucfirst($nazwisko)?> <?php echo ucfirst($imie)?></b></h5>
                <h5>Miejsce użytkowania: <?php echo $miejsce?></h5>
                <h6>Sprzęt wydany:</h6>
            <?php
                } 
            ?>          
            <?php
                $query = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt wydawany'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)){
                ?>
                <table class="table table-striped">
                    <tr>
                        <th>rodzaj</th>
                        <th>model</th>
                        <th>procesor</th>
                        <th>RAM</th>
                        <th>dysk</th>
                        <th>nr inw.</th>
                        <th>nr seryjny</th>
                        <th>dodatkowe wyposażenie</th>
                        <th>uwagi</th>
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
                        <td><?php echo $row['uwagi'] ?></td>
                    </tr>
                    <?php
                        } //while end
                    ?>
                    </table><br>
                <?php
                    }//if end
                ?>
                <?php
                    $queryZwrot = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt zwracany'";
                    $resultZwrot = mysqli_query($conn, $queryZwrot);
                    if(mysqli_num_rows($resultZwrot)){
                ?>
                    <h5>Osoba zwracająca sprzęt:
                    <b><?php echo ucfirst($nazwisko)?> <?php echo ucfirst($imie)?></b></h5>
                    <h6>Sprzęt zwrócony:</h6>
                    <table class="table table-striped">
                        <tr>
                            <th>rodzaj</th>
                            <th>model</th>
                            <th>procesor</th>
                            <th>RAM</th>
                            <th>dysk</th>
                            <th>nr inw.</th>
                            <th>nr seryjny</th>
                            <th>dodatkowe wyposażenie</th>
                            <th>uwagi</th>
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
                            <td><?php echo $row['uwagi'] ?></td>
                        </tr>
                    <?php
                        }//while end
                    ?>
                    </table>
                    
                    
                <?php
                    }//end while
                ?>
                
            </div><br>
            <footer>
                <div id="sig-container">
                    <div class="sig">Data: <?php echo date("Y-m-d") ?> Podpis osoby wydającej/przyjmującej sprzęt</div> 
                    <div class="sig">Data: <?php echo date("Y-m-d") ?> Podpis osoby otrzymującej/zwracającej sprzęt</div>
                </div><hr style="border: 1px solid black">
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
                '<html><head><meta charset="UTF-8"><title>Protokół wydania/zwrotu sprzętu.</title></head><body>' + 
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
                    el.text('------');
                }
            });
        });
    </script>
</body>
</html>