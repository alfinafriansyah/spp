<?php 
include '../config/koneksi.php';
include 'header.php';
?>



<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Pembayaran SPP</title>
    <div class="col-12">
      <h3><center>Laporan Pembayaran SPP</center></h3>
    </div>
    <div class="card-body">             
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
            $sql = "select *from pembayaran,siswa,spp,kelas,petugas,kompetensi where pembayaran.nisn=siswa.nisn and siswa.id_kelas=kelas.id_kelas and pembayaran.id_spp=spp.id_spp and kelas.id_komp=kompetensi.id_komp and pembayaran.id_petugas=petugas.id_petugas order by tgl_bayar asc";
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
    </div>
<script>
 window.print();
</script>
  <!-- /.content
  </div>-->
  <!-- /.content-wrapper -->
  <?php 
include 'footer.php';
  ?>
</html>