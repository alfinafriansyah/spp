<?php 
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"select * from petugas where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

	$data = mysqli_fetch_assoc($login);

	// cek jika user login sebagai admin
	if($data['level']=="admin"){

		// buat session login dan username
		$_SESSION['id_petugas'] = $data['id_petugas'];
		$_SESSION['nama_petugas'] = $data['nama_petugas'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['level'] = "admin";
		// alihkan ke halaman dashboard admin
		header("location:../admin");

	// cek jika user login sebagai pegawai
	}else if($data['level']=="petugas"){
		// buat session login dan username
		$_SESSION['id_petugas'] = $data['id_petugas'];
		$_SESSION['nama_petugas'] = $data['nama_petugas'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['level'] = "petugas";
		// alihkan ke halaman dashboard pegawai
		header("location:../petugas");

	}
}else{

	// alihkan ke halaman login kembali
echo"<script>
alert('Maaf Login Gagal, Mohon Coba Lagi');
window.location.assign('../index2.php');
</script>";
}

?>