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
    <title>edytuj sprzęt</title>
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
        <h4>Edytuj sprzęt</h4>
        <hr>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
                <label for="opcja">Wybierz parametr:</label><br>
                <select name="opcja" id="opcja">
                    <option value="wszystko">wszystko</option>
                    <option value="NI">numer inwentarzowy</option>
                    <option value="SN">S/N</option>
                    <option value="rodzaj">rodzaj</option>
                    <option value="opis">opis</option>
                </select>
            </div><br>
            <div>
                <input type="text" name="wartosc" required placeholder="Wpisz wartość">
                <button class="btn btn-outline-success" type="submit" name="search">Znajdź sprzęt</button>
            </div>
        </form>
        <hr>
        <br>

        <?php
        
        if (isset($_POST['search'])) {

            $limit = 60;

            $opcjonalna_wartosc = $_POST['opcja'];
            $wartosc_input = test_input($_POST['wartosc']);
            if($_POST['wartosc']=='') {
                echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Zostawiłeś puste pole...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                $query = "SELECT * FROM sprzet WHERE $opcjonalna_wartosc LIKE '%$wartosc_input%' LIMIT $limit";
                if($opcjonalna_wartosc === "wszystko"){
                    $query = "SELECT * FROM sprzet 
                        WHERE (SN = '$wartosc_input') or (NI LIKE '%$wartosc_input%') or (rodzaj LIKE '%$wartosc_input%') or (opis LIKE '%$wartosc_input%') LIMIT $limit";
                }

                $result = mysqli_query($conn, $query);
                $counter = mysqli_num_rows($result);
                if (!$result) {
                    echo "Nieprwidłowe zapytanie";
                }
              
                if ($counter < 1) {
                    echo'<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Nie ma takiego sprzętu...</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    mysqli_free_result($result);
                } else {
                    
                    ?>

        <form method="POST">
            <p><span style="margin-right: 10px">Ilość wyświetlonych rekordów: <?php echo $counter?></span>
                <button class="btn btn-outline-warning" type="submit" name="submit-all" id="submit-all">Edytuj wszystko</button>
            </p>
            <?php
                
                if($counter >= $limit){
                    echo"<br><div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Uwaga! Ilość znalezionych rekordów przekracza limit. Wyświetlono maksymalną dopuszczalną ilość rekordów: $limit</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            ?>
            
            <hr>

            <?php
                    $c=0;
                    while ($row = mysqli_fetch_array($result)) {
                    $c++;
                    echo "rekord: ".$c;
            ?>

            <div class="row">
                <div class="col-md-4">
                    <div>
                        <div>
                            <label>ID sprzętu</label>
                        </div>
                        <input type="number" name="id_sprzetu[]" id="id_spraętu" readonly
                            value="<?php echo $row['id_sprzetu'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>rodzaj</label>
                        </div>
                        <input type="text" name="rodzaj[]" id="rodzaj" class="bg-success text-white"
                            value="<?php echo $row['rodzaj'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>pin</label>
                        </div>
                        <input type="text" name="pin[]" id="pin" class="bg-success text-white"
                            value="<?php echo $row['pin'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>model</label>
                        </div>
                        <input type="text" name="model[]" id="midel" class="bg-success text-white"
                            value="<?php echo $row['model'] ?>" />
                    </div><br>

                </div>
                <div class="col-md-4">
                    <div>
                        <div>
                            <label>N/I</label>
                        </div>
                        <input type="text" name="ni[]" id="ni" class="bg-success text-white"
                            value="<?php echo $row['NI'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>S/N</label>
                        </div>
                        <input type="text" name="sn[]" id="sn" class="bg-success text-white"
                            value="<?php echo $row['SN'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>procesor</label>
                        </div>
                        <input type="text" name="procesor[]" id="procesor" class="bg-success text-white"
                            value="<?php echo $row['procesor'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>RAM</label>
                        </div>
                        <input type="text" name="ram[]" id="ram" class="bg-success text-white"
                            value="<?php echo $row['ram'] ?>" />
                    </div><br>
                </div>
                <div class="col-md-4">
                    <div>
                        <div>
                            <label>dysk</label>
                        </div>
                        <input type="text" name="dysk[]" id="dysk" class="bg-success text-white"
                            value="<?php echo $row['dysk'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>nr faktury</label>
                        </div>
                        <input type="text" name="nr_faktury[]" id="nr_faktury" class="bg-success text-white"
                            value="<?php echo $row['nr_faktury'] ?>" />
                    </div><br>
                    <div>
                        <div>
                            <label>opis</label>
                        </div>
                        <textarea rows="2" cols="25" type="text" name="opis[]" id="opis"
                            class="bg-success text-white"><?php echo $row['opis'] ?></textarea>
                    </div><br>
                </div>
            </div>
            <hr>
            <?php
                    }
                    ?>
            <input name="counter" class="invisible" value="<?php echo $counter ?>" />
        </form>
        <?php
                    
                }
            }
            
        }
        
        if (isset($_POST['submit-all'])) 
        {
   
        $counter = (int)$_POST['counter'];

        if($counter>0)
        {
            $i=0;
            do 
            {
                
            $rodzaj = test_input($_POST['rodzaj'][$i]);
            $opis = test_input($_POST['opis'][$i]);
            $pin = test_input($_POST['pin'][$i]);
            $model = test_input($_POST['model'][$i]);
            $sn = test_input($_POST['sn'][$i]);
            $ni = test_input($_POST['ni'][$i]);
            $nr_faktury = test_input($_POST['nr_faktury'][$i]);
            $procesor = test_input($_POST['procesor'][$i]);
            $ram = test_input($_POST['ram'][$i]);
            $dysk = test_input($_POST['dysk'][$i]);
                
                $query = "UPDATE sprzet SET 
                            opis = '$opis', rodzaj = '$rodzaj', pin = '$pin', model = '$model', SN = '$sn', NI = '$ni', 
                            nr_faktury = '$nr_faktury', procesor = '$procesor', ram = '$ram', dysk = '$dysk'
                        WHERE id_sprzetu ='".$_POST['id_sprzetu'][$i]."' ";

                $result = mysqli_query($conn, $query);

                $i++;
            
            }  while($i<$counter);
            
                echo'<br><div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Rekordy poprawnie edytowane.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        }
        else
        {
            echo "Coś poszło nie tak...";
        }
    }



        ?>
    </div>
    <?php
    mysqli_close($conn);
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('form').on('focus', 'input[type=number]', function(e) {
            $(this).on('wheel.disableScroll', function(e) {
                e.preventDefault()
            })
        })
        $('form').on('blur', 'input[type=number]', function(e) {
            $(this).off('wheel.disableScroll')
        })
    });
    </script>
</body>

</html>