<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Protokół wydania sprzętu komputerowego w Centrali NFZ</title>
    <style>
        body {
            margin: 0;
        }
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border-bottom: 1px solid #ddd;
        }

        th,
        td {
            padding: 3px 7px 3px 7px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #33A5FF;
            color: white;
        }
        #sig-container {
            display: flex;
            align-content: flex-end;
            align-content: center;
        }
        .sig {
            margin: 200px 100px;
            border: 1px dashed grey;
			box-sizing: border-box;
            padding: 120px 50px 10px 50px;
            font-size: 11px;
        }
        header {
            display: flex;
            flex-direction: row;
        }
        #nfz-logo {
            width: 180px;
        }
        #nfz-opis {
           margin-left: 60px;
        }
        @media print
        {
            @page {
            margin-top: 0;
            margin-bottom: 0;
            }
            body  {
            padding-top: 72px;
            padding-bottom: 72px ;
            }
        } 
        #main-proto {
            border-bottom: 2px solid grey;
            height: 1250px;
        }
        footer {
            text-align: center;
            color: grey;
        }
    </style>

</head>
<body>
    <div class="container">
        
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php"><b>str. gł</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wyszukaj_komputer_proto.php">wyszukaj sprzęt do protokołu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="protokol_komputer.php">protokół wydania sprzętu</a>
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
                <h4>Osoba której powierza się opiekę nad środkiem trwałym:</h4>
                <h5>Nazwisko i imię: <?php echo ucfirst($nazwisko)?> <?php echo ucfirst($imie)?></h5>
                <h5>Miejsce użytkowania: <?php echo $miejsce?></h5><br>
                <h4>Sprzęt wydany:</h4>
            <?php
                } else {
                    echo '<h4>Brak sprzętu do wydania</h4>';
                }
            ?>          
            <?php
                $query = "SELECT * FROM protokol_wydania_komputera WHERE status_sprz = 'sprzęt wydawany'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)){
                ?>
                <table>
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
                    <h4>Sprzęt zwrócony:</h4>
                    <table>
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
                        echo '<h4>Brak sprzętu do zwrócenia</h4>';
                    }
                ?>
                <div id="sig-container">
                    <div class="sig"><?php echo date("Y-m-d") ?> Podpis osoby wydającej sprzęt</div> 
                    <div class="sig"><?php echo date("Y-m-d") ?> Podpis osoby otrzymującej sprzęt</div>
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