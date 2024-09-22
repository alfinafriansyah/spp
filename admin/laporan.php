<?php
session_start();

// memeriksa apakah pengguna sudah login dan merupakan admin
if (!(isset($_SESSION['level']) && $_SESSION['level'] == 'admin')) {
    // jika bukan admin, maka redirect ke halaman login
    echo"<script>
    alert('Silakan Login Terlebih Dahulu!');
    window.location.assign('../index2.php');
    </script>";
}

include "../config/koneksi.php";
if (isset($_GET['hapus'])) { //untuk delete
    $id        = $_GET['hapus'];
    if (!empty($id)){
        $sqlhapus = "DELETE FROM pembayaran where id_pembayaran = '$id'";

        if ($koneksi->query($sqlhapus) === false){
            trigger_error("Periksa Perintah SQL Manual Anda : " . $sqlhapus . "Error : " . $koneksi->error, E_USER_ERROR);
        }
        else {
            
        }
    }
}
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
                <div class="row">
                  <div class="col">
                    <input class="ml-1 mb-3" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                    
                    <a class="btn btn-primary float-end mb-3" href="print_laporan.php">Cetak</a>
                  </div>
                </div>
                <div class="table-responsive">
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
                          <th>Hapus</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $sql = "SELECT*FROM pembayaran,siswa,kelas,spp,petugas,kompetensi WHERE pembayaran.nisn=siswa.nisn AND siswa.id_kelas=kelas.id_kelas AND pembayaran.id_spp=spp.id_spp AND pembayaran.id_petugas=petugas.id_petugas AND kelas.id_komp=kompetensi.id_komp ORDER BY tgl_bayar DESC";
                      $query = mysqli_query($koneksi, $sql);
                      foreach ($query as $data){ 
                        $id = $data['id_pembayaran'];
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
                              <td>
                                <a  href="print_kwitansi.php?id=<?= $data['id_pembayaran'] ?>" class='btn btn-primary'>Cetak</a>
                                <a  onclick = "return confirm('Apakah Anda Yakin Ingin Menghapus Data?')" href="laporan.php?hapus=<?= $data['id_pembayaran'] ?>" class='btn btn-danger'>Hapus</a>
                              </td>
                          </tr>
                      <?php } ?>
                      </tbody>
                  </table>
                </div>
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