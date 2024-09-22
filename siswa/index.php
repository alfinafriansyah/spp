<?php
session_start();

// Cek apakah session sudah tersedia
if(!isset($_SESSION['nisn'])){
    // Jika belum tersedia, maka arahkan pengguna ke halaman login
    echo"<script>
    alert('Silakan Login Terlebih Dahulu!');
    window.location.assign('../index.php');
    </script>";
}

include "../config/koneksi.php";
$nisn = $_SESSION['nisn'];
if (isset($_POST['simpan'])) { //untuk edit
  $password   = $_POST['password'];

  if ($password) {
          $sql1   = "update siswa set password='$password' where nisn='$nisn'";
          $q1     = mysqli_query($koneksi, $sql1);
          if ($q1) {
              $sukses     = "Data Berhasil diupdate";
          } else {
              $error      = "Gagal update data";
          }
      }
  } else {
      $error = "Silakan masukkan semua data";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profil</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

          <div class="card">
            
              <div class="card-body">
              
                <h5 class="card-title">Profil Siswa</h5>
                <?php                
                $sql = "select *from siswa,spp,kelas,kompetensi where siswa.id_kelas=kelas.id_kelas and siswa.id_spp=spp.id_spp and kelas.id_komp=kompetensi.id_komp and nisn='$nisn'";
                $query = mysqli_query($koneksi, $sql);
                foreach ($query as $row){
                ?>
                <form method="post" action="">
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">NISN :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['nisn']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">NIS :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['nis']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Nama :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['nama']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Kelas :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['nama_kelas']?>-<?= $row['nama_komp']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Alamat :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['alamat']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">No. Telepon :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['no_telp']?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">SPP :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $row['tahun']?> | Gol. <?= $row['golongan']?> | <?= number_format($row['nominal'],2,',','.');?>">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Password :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" name="password" value="<?= $row['password']?>">
                  </div>
                </div>
                <div class="mb-3">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ganti Password
                </button>
                <!-- Modal Ganti PAssword -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form class="needs-validation" novalidate action="" method="post">
                        <div class="mb-3">
                            <label>Password Lama</label>
                        <input disabled type="text" class="form-control" autocomplete="off" value="<?= $row['password']?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Password Baru</label>
                        <input type="text" class="form-control" name="password" autocomplete="off" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- Modals End -->
                </div>
                </form>
                <?php } ?>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php"; ?>
</body>

</html>