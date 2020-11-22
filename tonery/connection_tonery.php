<?php
    $conn = mysqli_connect("localhost", "root", "", "tonery_db");

    if ($conn == false) {
        die("BRAK POŁĄCZENIA Z BAZĄ DANYCH: " . mysqli_connect_error());
    }
?>