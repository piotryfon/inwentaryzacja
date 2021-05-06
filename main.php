<?php
    session_start();

    if(isset($_SESSION['login_user']) == false) {
        header("location: index.php");
    }
    require('navbar.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inwentaryzacja</title>
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
        </header>

        <h4>Aplikacja inwentaryzacyjna.</h4>
        <hr>
        <ul>
            <a href="sprzet_tabela.php">
                <li>sprzęt/pracownik - tabela</li>
            </a>
        </ul>
        <h5>Sporządź protokół wydania oraz zwrotu sprzętu komputerowego</h5>
        <ul>
            <a href="protokol/wyszukaj_komputer_proto.php">
                <li><b>wybierz sprzęt do protokołu</b></li>
            </a>
        </ul>
        <h5>Sporządź protokół przeniesienia sprzętu komputerowego</h5>
        <ul>
            <a href="przeprowadzka/wyszukaj_do_protokolu.php">
                <li>wybierz sprzęt do przeniesienia</li>
            </a>
        </ul>
        <h5>Przydatne linki</h5>
        <ul>
            <a href="" target="_blank">
                <li>SharePoint - strona główna</li>
            </a>
        </ul>
        <ul>
            <a href="" target="_blank">
                <li>SharePoint - macierz</li>
            </a>
        </ul>

    </div>

</body>

</html>

