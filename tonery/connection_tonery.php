<?php
    $conn = mysqli_connect("localhost", "root", "", "tonerydb");

    if ($conn == false) {
        die("BRAK POŁĄCZENIA Z BAZĄ DANYCH: " . mysqli_connect_error());
    }
?>