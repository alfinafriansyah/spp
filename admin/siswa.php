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

$id = "";
$nisn   = "";
$nis   = "";
$nama   = "";
$kelas   = "";
$alamat   = "";
$no_telp   = "";
$tahun   = "";
$nominal   = "";
$spp = "";
$password = "";
$sukses = "";
$error = "";
if (isset($_POST['tambah'])) { //untuk create
    $nisn   = $_POST['nisn'];
    $nis   = $_POST['nis'];
    $nama   = $_POST['nama'];
    $kelas   = $_POST['kelas'];
    $alamat   = $_POST['alamat'];
    $no_telp   = $_POST['no_telp'];
    $spp   = $_POST['spp'];
    $password   = $_POST['password'];
    
    if ($nisn && $nis && $nama && $kelas && $alamat && $no_telp && $spp && $password) {
        $sql1   = "insert into siswa(nisn,nis,nama,id_kelas,alamat,no_telp,id_spp,password) values ('$nisn','$nis','$nama','$kelas','$alamat','$no_telp','$spp','$password')"; 
        $q1     = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses     = "Berhasil memasukkan data baru";
        } else {
            echo"<script>
            alert('Gagal menambah data baru');
            </script>";
        }
    }
    }
if (isset($_POST['edit'])) { //untuk edit
    $nisn   = $_POST['nisn'];
    $nis   = $_POST['nis'];
    $nama   = $_POST['nama'];
    $kelas   = $_POST['kelas'];
    $alamat   = $_POST['alamat'];
    $no_telp   = $_POST['no_telp'];
    $spp   = $_POST['spp'];
    $password   = $_POST['password'];

    if ($nisn && $nis && $nama && $kelas && $alamat && $no_telp && $spp && $password) {
            $sql1   = "update siswa set nis='$nis', nama='$nama', id_kelas='$kelas', alamat='$alamat', no_telp='$no_telp', id_spp='$spp', password='$password' where nisn='$nisn'";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Data Berhasil diupdate";
            } else {
                echo"<script>
                    alert('Gagal update data');
                    </script>";
            }
        }
    }
if (isset($_GET['hapus'])) { //untuk delete
    $id        = $_GET['hapus'];
    if (!empty($id)){
        $sqlhapus = "DELETE FROM siswa where nisn = '$id'";

        if ($koneksi->query($sqlhapus) === false){
            echo"<script>
                alert('Gagal menghapus data');
                </script>";
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

  <title>Siswa</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Siswa</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

            <div class="card">
                
                <div class="card-body">
                
                    <h5 class="card-title">Data Siswa</h5>
                    <div class="row">
                        <div class="col">
                        <button type="button" class="btn btn-primary btn-sm float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah Data
                            </button>
                            <!-- Modal Tambah Data -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form class="needs-validation" novalidate action="" method="post">
                                    <div class="mb-3">
                                        <label>NISN</label>
                                    <input type="text" id="nisn" class="form-control" name="nisn" autocomplete="off" minlength="10" maxlength="10" pattern="[0-9]+" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>NIS</label>
                                    <input type="text" id="nis" class="form-control" name="nis" autocomplete="off" pattern="[0-9]+" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Nama</label>
                                    <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" pattern="[A-Za-z]+" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Kelas</label>
                                        <select name="kelas" class="form-control" required>
                                            <option value=""> Pilih Kelas </option>
                                            <?php
                                            $dkelas = mysqli_query($koneksi,"select *from kelas,kompetensi where kelas.id_komp=kompetensi.id_komp order by nama_kelas asc");
                                            foreach($dkelas as $akelas){
                                            ?>
                                            <option value="<?php echo $akelas['id_kelas']?>"><?php echo $akelas['nama_kelas'];?>-<?php echo $akelas['nama_komp'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Alamat</label>
                                    <input type="text" class="form-control" name="alamat" autocomplete="off" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>No. Telpon</label>
                                    <input type="text" id="telp" class="form-control" name="no_telp" autocomplete="off" minlength="10" maxlength="13" pattern="[0-9]+" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>SPP</label>
                                        <select name="spp" class="form-control" required>
                                            <option value=""> Pilih SPP </option>
                                            <?php
                                            $dspp = mysqli_query($koneksi,"select *from spp order by golongan asc");
                                            foreach($dspp as $aspp){
                                            ?>
                                            <option value="<?php echo $aspp['id_spp'];?>">Gol. <?php echo $aspp['golongan'];?> | <?php echo $aspp['tahun'];?> | <?php echo number_format($aspp['nominal'],2,',','.'); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password</label>
                                    <input type="text" class="form-control" name="password" autocomplete="off" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="tambah" value="Tambah" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modals End -->

                            <button class="btn btn-outline-dark btn-sm float-end me-1 mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload File</button>
                            <!-- Modal Upload Data -->
                            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form enctype="multipart/form-data" action="proses_upload.php" method="post">
                                    <div class="mb-3">
                                        <label>Upload File Excel (.xls)</label>
                                    <input type="file" class="form-control" name="fileexcel" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modals End -->

                            <input class="col-3 mb-3" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                        </div>
                    </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm" id="myTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>No. Telpon</th>
                        <th>SPP</th>
                        <th>Password</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $sql = "select *from siswa,spp,kelas,kompetensi where siswa.id_kelas=kelas.id_kelas and siswa.id_spp=spp.id_spp and kelas.id_komp=kompetensi.id_komp order by nama asc";
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            foreach($query as $r2) {
                                $nisn   = $r2['nisn'];
                                $nis   = $r2['nis'];
                                $nama   = $r2['nama'];
                                $kelas   = $r2['nama_kelas'];
                                $komp = $r2['nama_komp'];
                                $alamat   = $r2['alamat'];
                                $no_telp   = $r2['no_telp'];
                                $nominal   = $r2['nominal'];
                                $golongan = $r2['golongan'];
                                $password   = $r2['password'];

                            ?>
                                <tr>
                                    <td scope="row"><?php echo $no++; ?></td>
                                    <td scope="row"><?php echo $nisn; ?></td>
                                    <td scope="row"><?php echo $nis; ?></td>
                                    <td scope="row"><?php echo $nama; ?></td>
                                    <td scope="row"><?php echo $kelas; ?>-<?php echo $komp; ?></td>
                                    <td scope="row"><?php echo $alamat; ?></td>
                                    <td scope="row"><?php echo $no_telp; ?></td>
                                    <td scope="row">Gol. <?php echo $golongan; ?>-<?php echo number_format($nominal,2,',','.');?></td>
                                    <td scope="row"><?php echo $password; ?></td>
                                    <td scope="row">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $nisn; ?>">Edit</button>
                                    <!-- Modal Edit-->
                                        <div class="modal fade" id="editModal<?php echo $nisn;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form class="needs-validation" novalidate action="" method="post">
                                                <div class="mb-3">
                                                    <label>NISN</label>
                                                <input type="text" id="nisn" class="form-control" name="nisn" readonly value="<?php echo $nisn; ?>" autocomplete="off" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>NIS</label>
                                                <input type="text" id="nis" class="form-control" name="nis" value="<?php echo $nis; ?>" autocomplete="off" pattern="[0-9]+" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama</label>
                                                <input type="text" id="nama" class="form-control" name="nama" value="<?php echo $nama; ?>" autocomplete="off" pattern="[A-Za-z]+" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kelas</label>
                                                    <select name="kelas" class="form-control" required>
                                                        <option value=""> Pilih Kelas </option>
                                                        <?php
                                                        $dkelas = mysqli_query($koneksi,"select *from kelas,kompetensi where kelas.id_komp=kompetensi.id_komp order by nama_kelas asc");
                                                        foreach($dkelas as $akelas){
                                                        ?>
                                                        <option value="<?php echo $akelas['id_kelas']?>" <?php if($akelas['id_kelas'] == $r2['id_kelas']){ echo 'selected'; } ?>><?php echo $akelas['nama_kelas'];?>-<?php echo $akelas['nama_komp'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Alamat</label>
                                                <input type="text" class="form-control" name="alamat" value="<?php echo $alamat; ?>" autocomplete="off" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>No. Telpon</label>
                                                <input type="text" id="telp" class="form-control" name="no_telp" value="<?php echo $no_telp; ?>" autocomplete="off" minlength="10" maxlength="13" pattern="[0-9]+" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>SPP</label>
                                                    <select name="spp" class="form-control" required>
                                                        <option value=""> Pilih SPP </option>
                                                        <?php
                                                        $dspp = mysqli_query($koneksi,"select *from spp order by golongan asc");
                                                        foreach($dspp as $aspp){
                                                        ?>
                                                        <option value="<?php echo $aspp['id_spp'];?>" <?php if($aspp['id_spp'] == $r2['id_spp']){ echo 'selected'; } ?>>Gol. <?php echo $aspp['golongan'];?> | <?php echo $aspp['tahun'];?> | <?php echo number_format($aspp['nominal'],2,',','.'); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Password</label>
                                                <input type="text" class="form-control" name="password" value="<?php echo $password; ?>" autocomplete="off" required>
                                                </div>                                        
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="edit" value="edit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modals End -->
                                        <a onclick = "return confirm('Apakah Anda Yakin Ingin Menghapus Data?')" href = "siswa.php?hapus=<?php echo $nisn;?>" class = "btn btn-danger">Hapus</a>            
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
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
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php"; ?>
</body>

</html>