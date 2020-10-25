<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>edytuj z tabeli</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
    </header>

    <?php
    require("connection.php");
    ?>

    <form method="post">
      <div class="row">
        <div class="col-md-6">
            <div>
              <label>id sprzętu</label>
            </div>
            <input readonly type="text" name='id_sprzetu' value="<?php echo $_POST['id_sprzetu'] ?>"><br>
            <div>
              <label>rodaj</label>
            </div>
            <input readonly type="text" name='rodzaj' value="<?php echo $_POST['rodzaj'] ?>"><br>
            <div>
              <label>model</label>
            </div>
            <input readonly type="text" name='model' value="<?php echo $_POST['model'] ?>"><br>
            <div>
              <label>N/I</label>
            </div>
            <input readonly type="text" name='ni' value="<?php echo $_POST['ni'] ?>"><br>
            <div>
              <label>S/N</label>
            </div>
            <input readonly type="text" name='sn' value="<?php echo $_POST['sn'] ?>"><br>
        </div>
        <div class="col-md-6">
            <div>
              <label>status</label>
            </div>
            <input type="text" name='status_sprz' value="<?php echo $_POST['status_sprz'] ?>"><br>
            <div>
              <label>login</label>
            </div>
            <input readonly type="text" name='login_pracownika' value="<?php echo $_POST['login_pracownika'] ?>"><br>
            <div>
              <label>nowy login</label>
            </div>
            <input type="text" name='nowy_login' value="<?php echo $_POST['login_pracownika'] ?>"><br>
            <div>
              <label>data</label>
            </div>
            <input readonly type="text" name='aktu_data' value="<?php echo date("Y-m-d") ?>"><br><br>
            <input class='btn btn-primary' type="submit" name="submit" value="zatwierdź">
        </div>
      </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
      $query_login = "SELECT login_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
      $result = mysqli_query($conn, $query_login);

      if (mysqli_num_rows($result) === 0) {
        echo '<h3>Nie ma takiego pracownika!</h3>';
      } else {

        $ni = mysqli_real_escape_string($conn, $_REQUEST['ni']);
        $rodzaj = mysqli_real_escape_string($conn, $_REQUEST['rodzaj']);
        $status = mysqli_real_escape_string($conn, $_REQUEST['status_sprz']);
        $login_stary = mysqli_real_escape_string($conn, $_REQUEST['login_pracownika']);
        $login_nowy = mysqli_real_escape_string($conn, $_REQUEST['nowy_login']);
        $data = mysqli_real_escape_string($conn, $_REQUEST['aktu_data']);

        $query_historia = "INSERT INTO sprzet_historia (NI, rodzaj, status_sprz, login_stary, login_nowy, data_zmiany) 
      VALUES ('$ni', '$rodzaj', '$status', '$login_stary', '$login_nowy', '$data')";
        if ($query_historia) {
          mysqli_query($conn, $query_historia);
        }

        $query_login_sprzet = "SELECT id_pracownika FROM pracownicy WHERE login_pracownika = '$_POST[nowy_login]'";
        $result_login_sprzet = mysqli_query($conn, $query_login_sprzet);
        $row_login_sprzet = mysqli_fetch_array($result_login_sprzet);
        $row_na_int = (int)$row_login_sprzet['id_pracownika'];

        $query_update = "UPDATE sprzet SET id_pracownika = $row_na_int, status_sprz = '$_POST[status_sprz]' WHERE id_sprzetu ='" . $_POST['id_sprzetu'] . "'";

        if ($query_update) {
          mysqli_query($conn, $query_update);
          echo '<h3>Zmiany wprowadzone</h3>';
        }
      }
    }
    mysqli_close($conn);
    ?>
  </div>
</body>

</html>