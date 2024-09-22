<?php
session_start();

// memeriksa apakah pengguna sudah login dan merupakan admin
if (!(isset($_SESSION['level']) && $_SESSION['level'] == 'petugas')) {
    // jika bukan admin, maka redirect ke halaman login
    echo"<script>
    alert('Silakan Login Terlebih Dahulu!');
    window.location.assign('../index2.php');
    </script>";
}
include "../config/koneksi.php";
if (isset($_POST['bayar'])){
  $id_petugas = $_POST['id_petugas'];
  $nisn = $_POST['nisn'];
  $tgl_bayar = $_POST['tgl_bayar'];
  $bulan_dibayar = $_POST['bulan_bayar'];
  $tahun_dibayar = $_POST['tahun'];
  $id_spp = $_POST['id_spp'];
  $jumlah_bayar = $_POST['jumlah_bayar'];

  if ($id_petugas && $nisn && $tgl_bayar && $bulan_dibayar && $tahun_dibayar && $id_spp && $jumlah_bayar){
  $sql = "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,bulan_dibayar,tahun_dibayar,id_spp,jumlah_bayar) VALUES ('$id_petugas','$nisn','$tgl_bayar','$bulan_dibayar','$tahun_dibayar','$id_spp','$jumlah_bayar')";
  $query = mysqli_query($koneksi, $sql);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pembayaran</title>
  <?php include "header.php" ?>
</head>
<body>
<?php include "sidebar.php" ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Pembayaran</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

          <div class="card">
              
              <div class="card-body">

              <h5 class="card-title">Pembayaran</h5>
              
              <form method="post" action="bayar.php">
                <div class="mb-3">
                  <label>NISN</label>
                    <select class="form-select" name="nisn" id="nisn" onchange='changeValue(this.value)' data-placeholder="Cari NISN" required>
                      <option></option>
                    <?php
                    $query = mysqli_query($koneksi,"select *from siswa,spp where siswa.id_spp=spp.id_spp");
                    $a = "var nama = new Array();\n;";
                    $b = "var nominal = new Array();\n;";
                    $c = "var tahun = new Array();\n;";
                    $d = "var id_spp = new Array();\n;";
                    foreach ($query as $row){
                      echo '<option name="nisn" value="'.$row['nisn'] . '">' . $row['nisn'] . '</option>';   
                      $a .= "nama['" . $row['nisn'] . "'] = {nama:'" . addslashes($row['nama'])."'};\n";  
                      $b .= "nominal['" . $row['nisn'] . "'] = {nominal:'" . addslashes($row['nominal'])."'};\n";
                      $c .= "tahun['" . $row['nisn'] . "'] = {tahun:'" . addslashes($row['tahun'])."'};\n";
                      $d .= "id_spp['" . $row['nisn'] . "'] = {id_spp:'" . addslashes($row['id_spp'])."'};\n";   } ?>
                    </select>
                </div>
                <div class="mb-3">
                  <label>Nama Siswa</label>
                  <input readonly type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Tanggal Bayar</label>
                  <input type="date" name="tgl_bayar" class="form-control" value="<?php echo date('Y-m-d');?>" required>
                </div>
                <div class="mb-3">
                  <label>Bulan Bayar</label>
                      <select name="bulan_bayar" class="form-control" required>
                        <option value=""> Pilih Bulan Bayar </option>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                      </select>
                </div>
                <div class="mb-3">
                  <label>Tahun Bayar</label>
                  <input readonly type="number" id="tahun" name="tahun" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Jumlah yang harus di bayar</label>
                  <input readonly type="number" id="nominal" name="jumlah_bayar" class="form-control" required>
                </div>
                <!-- id spp -->
                <input type="hidden" id="id_spp" name="id_spp" class="form-control" required>
                <input type="hidden" value="<?php echo $_SESSION['id_petugas']; ?>" id="id_petugas" name="id_petugas" class="form-control" required>
                <div class="mb-3">
                    <button type="submit" name="bayar" value="bayar" class="btn btn-primary">Bayar</button>
                    <button type="submit" name="cetak" value="cetak" class="btn btn-secondary">Bayar & Cetak</button>
                </div>
                </form>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php" ?>
</body>

</html>
<script type="text/javascript">
  $( '#nisn' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
      <?php echo $a; ?>
    <?php echo $b; ?>
    <?php echo $c; ?>
    <?php echo $d; ?>
    function changeValue(nisn) {
      document.getElementById("nama").value = nama[nisn].nama;
      document.getElementById("nominal").value = nominal[nisn].nominal;
      document.getElementById("tahun").value = tahun[nisn].tahun;
      document.getElementById("id_spp").value = id_spp[nisn].id_spp;
    };
</script>