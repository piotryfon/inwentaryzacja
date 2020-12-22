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
                    <a class="nav-link active" href="index.php">str. gł</a>
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

        <h3>Aplikacja inwentaryzacyjna.</h3>
        <hr>
        <h5>Tu możesz edytować dane:</h5>
        <ul>
            <a href="edytuj_pracownika.php">
                <li>edytuj pracownika</li>
            </a>
            <a href="edytuj_sprzet.php">
                <li>edytuj sprzęt</li>
            </a>
            <a href="edytuj_status.php">
                <li>edytuj status sprzętu i przypisz do pracownika</li>
            </a>
        </ul>
        <h5>lub skorzystaj z aplikacji inwentaryzującej tonery</h5>
        <ul>
            <a href="tonery/tonery_tabela.php">
                <li>tonery</li>
            </a>
        </ul>

    </div>

</body>

</html>

