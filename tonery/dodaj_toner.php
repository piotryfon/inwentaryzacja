<?php

$conn = mysqli_connect("localhost","root","","tonery_db"); 

if(isset($_POST['dodaj'])){
    
    $kod_skan = $_POST['kod']; 
    if($kod_skan == ""){
        echo "Zostawiłeś puste pole".'<br><a href="dodaj_toner_form.php">wróć</a>';
    }
                
    if($conn == false){
        die("Brak połączenia z bazą: ".mysqli_connect_error());
    }
    $query1 = "UPDATE tonery_tab SET ilosc = ilosc+1 WHERE kod = $kod_skan";
    $result1 = mysqli_query($conn, $query1);         
    $query2 = "SELECT ilosc from tonery_tab WHERE kod = $kod_skan";
    
    $result2 = mysqli_query($conn, $query2) or die("Dupa");
        
                
    while($row = mysqli_fetch_array($result2)){
        echo "STAN: ".$row['ilosc'].'<br><a href="dodaj_toner_form.php">wróć</a>';
    }
}    

    mysqli_close($conn);
?>