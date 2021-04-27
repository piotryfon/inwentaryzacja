<?php
    function show_navbar(){
        echo'
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
                            <a class="nav-link active" aria-current="page" href="/inwentaryzacja/main.php">Str. główna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tonery_tabela.php">Tonery tabela</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wydaj_toner.php">Wydaj toner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wydane_tonery.php">Wydane tonery</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Dodaj
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="dodaj_toner.php">Dodaj toner</a></li>
                                <li><a class="dropdown-item" href="dodaj_drukarke.php">Dodaj drukarkę</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="dodaj_rekord.php">Dodaj rekord do bazy SQL</a></li>
                            </ul>
                        </li>
                        <li class="nav-item" style="margin-left: 300px">
                            <a class="nav-link" href="/inwentaryzacja/logout.php"><b>Wyloguj się</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br>';
    }
?>