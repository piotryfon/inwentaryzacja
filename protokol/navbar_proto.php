<?php
    function showNavbarProto() {
        echo '<br>
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent border border-success">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../main.php">Str. główna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wyszukaj_komputer_proto.php">Wyszukaj sprzęt do protokołu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="protokol_komputer.php">Protokół sprzęt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php"><b>Wyloguj się</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br>
        ';
    }
?>