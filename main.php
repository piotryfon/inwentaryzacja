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
    <title>Inwentaryzacja</title>
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
        </header>

        <h3>Aplikacja inwentaryzacyjna.</h3>
        <hr>
        <ul>
            <a href="sprzet_tabela.php">
                <li>sprzęt/pracownik - tabela</li>
            </a>
        </ul>
        <h5>Edytuj dane:</h5>
        <ul>
            <a href="edytuj_pracownika.php">
                <li>edytuj pracownika</li>
            </a>
            <a href="edytuj_sprzet.php">
                <li><b>edytuj sprzęt i przypisz do pracownika</b></li>
            </a>
        </ul>
        <h5>Skorzystaj z aplikacji inwentaryzującej tonery</h5>
        <ul>
            <a href="tonery/tonery_tabela.php">
                <li><b>tonery</b></li>
            </a>
        </ul>
        <h5>Sporządź protokół wydania oraz zwrotu sprzętu komputerowego</h5>
        <ul>
            <a href="wyszukaj_komputer_proto.php">
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
            <a href="#" target="_blank">
                <li>SharePoint - strona główna</li>
            </a>
        </ul>
        <ul>
            <a href="#" target="_blank">
                <li>SharePoint - macierz</li>
            </a>
        </ul>

    </div>

</body>

</html>

