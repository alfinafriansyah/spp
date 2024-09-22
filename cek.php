<?php
session_start();

// Cek apakah username dan password tersimpan dalam sesi
if(isset($_SESSION['nisn']) && isset($_SESSION['nama'])){
    echo "nisn: ".$_SESSION['nisn']."<br>";
    echo "nama: ".$_SESSION['nama']."<br>";
} else {
    echo "Username dan password tidak tersimpan dalam sesi.";
}
?>