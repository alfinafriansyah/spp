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
include '../config/koneksi.php';
$petugas = $_SESSION['nama_petugas'];
$id_petugas = $_POST['id_petugas'];
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$tgl_bayar = $_POST['tgl_bayar'];
$bulan_dibayar = $_POST['bulan_bayar'];
$tahun_dibayar = $_POST['tahun'];
$id_spp = $_POST['id_spp'];
$jumlah_bayar = $_POST['jumlah_bayar'];

if ($id_petugas && $nisn && $tgl_bayar && $bulan_dibayar && $tahun_dibayar && $id_spp && $jumlah_bayar){
$sql = "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,bulan_dibayar,tahun_dibayar,id_spp,jumlah_bayar) VALUES ('$id_petugas','$nisn','$tgl_bayar','$bulan_dibayar','$tahun_dibayar','$id_spp','$jumlah_bayar')";
$query = mysqli_query($koneksi, $sql);
    if (isset($_POST['cetak'])) {?>
        <style>
    table {
	max-width: 100%;
	max-height: 100%;
    }
    body {
        padding: 5px;
        position: relative;
        width: 95%;
        height: 95%;
    }
    table th,
    table td {
        padding: .625em;
    text-align: center;
    }
    table .kop:before {
        content: ': ';
    }
    .left {
        text-align: left;
    }
    table #caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
    }
    table.border {
    width: 100%;
    border-collapse: collapse
    }

    table.border tbody th, table.border tbody td {
    border: thin solid #000;
    padding: 2px
    }
    .ttd td, .ttd th {
        padding-bottom: 4em;
    }
    </style>
    <div id="printable" class="container">
    <table border="0" cellpadding="0" cellspacing="0" width="485" class="border" style="overflow-x:auto;">
    <thead>
    <tr>
        <td colspan="6" width="485" id="caption">Kwitansi Pembayaran SPP</td>
    </tr>
    <tr>
        <td colspan="2">Petugas</td>
        <td class="left kop"><?php echo $petugas;?></td>
        <td></td>
        <td>Tanggal</td>
        <td class="left kop"><?php echo $tgl_bayar;?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody>
        <tr>
        <th>NISN</th>
        <th>Nama</th>
        <th>Bulan Dibayar</th>
        <th>Tahun Dibayar</th>
        <th colspan="2">Jumlah Bayar</th>
        </tr>
        <tr>
        <td align="right"><?php echo $nisn;?></td>
        <td><?php echo $nama;?></td>
        <td align="right"><?php echo $bulan_dibayar;?></td>
        <td><?php echo $tahun_dibayar;?></td>
        <td colspan="2"><?php echo number_format($jumlah_bayar,2,',','.');?></td>
        </tr>
        <tr>
    </tbody>
    </table>
    </div>
    <script>
    window.print();
    </script>
        <?php
    }else{
        header('location:laporan.php');
    }
}
?>