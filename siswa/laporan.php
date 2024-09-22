<?php
session_start();

// memeriksa apakah pengguna sudah login dan merupakan admin
if(!isset($_SESSION['nisn'])){
    // jika bukan admin, maka redirect ke halaman login
    echo"<script>
    alert('Silakan Login Terlebih Dahulu!');
    window.location.assign('../index.php');
    </script>";
}
$nisn = $_SESSION['nisn'];
include "../config/koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Laporan</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Laporan</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

          <div class="card">
            
              <div class="card-body">
              
                <h5 class="card-title">Laporan Pembayaran</h5>
                
                <input class="mb-3" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                
                <table class="table table-bordered table-striped" id="myTable">
                  <thead>
                    <tr>
                        <th>No.</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Bulan Dibayar</th>
                        <th>Tahun Dibayar</th>
                        <th>SPP</th>
                        <th>Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Petugas</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $sql = "select *from pembayaran,siswa,spp,kelas,petugas,kompetensi where pembayaran.nisn='$nisn' and pembayaran.nisn=siswa.nisn and siswa.id_kelas=kelas.id_kelas and pembayaran.id_spp=spp.id_spp and kelas.id_komp=kompetensi.id_komp and pembayaran.id_petugas=petugas.id_petugas order by tgl_bayar asc";
                    $query = mysqli_query($koneksi, $sql);
                    foreach ($query as $data){
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nisn'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['nama_kelas'] ?>-<?= $data['nama_komp']?></td>
                            <td><?= $data['bulan_dibayar'] ?></td>
                            <td><?= $data['tahun_dibayar'] ?></td>
                            <td>Gol. <?= $data['golongan'] ?> | <?= number_format($data['nominal'],2,',','.'); ?></td>
                            <td><?= number_format($data['jumlah_bayar'],2,',','.'); ?></td>
                            <td><?= $data['tgl_bayar'] ?></td>
                            <td><?= $data['nama_petugas'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td");
                    for (j = 0; j < td.length; j++) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                    }
                }
                }                
                </script>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php"; ?>
</body>

</html>