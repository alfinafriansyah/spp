<?php 
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$nisn = $_POST['nisn'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"select * from siswa where nisn='$nisn' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

	$data = mysqli_fetch_assoc($login);

    // buat session login dan username
    $_SESSION['nisn'] = $data['nisn'];
    $_SESSION['nama'] = $data['nama'];
    // alihkan ke halaman dashboard admin
    header("location:../siswa");

	}else{

		// alihkan ke halaman login kembali
    echo"<script>
    alert('Maaf Login Gagal, Mohon Coba Lagi');
    window.location.assign('../index.php');
    </script>";
}


?>