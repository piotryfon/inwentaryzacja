<?php
    function showNavbar() {
        echo '<br>
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent border border-success">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="main.php">Str. główna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tonery/tonery_tabela.php"><b>Tonery - Drukarki</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dodajpracownika.php">Dodaj pracownika</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dodajsprzet.php">Dodaj sprzęt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pracownicy_tabela.php">Pracownicy - tabela</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sprzet_pracownik_tab.php">Sprzęt - pracownik</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Edycja
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="edytuj_sprzet.php">Edytuj sprzęt</a></li>
                                <li><a class="dropdown-item" href="edytuj_pracownika.php">Edytuj pracownika</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><b>Wyloguj się</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br>
        ';
    }
?>