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
$nama = "";
$komp = "";
$sukses = "";
$error = "";
if (isset($_POST['tambah'])) { //untuk create
    $nama        = $_POST['nama'];
    $komp        = $_POST['komp'];
    
    if ($nama && $komp) {
            $sql1   = "insert into kelas(nama_kelas,id_komp) values ('$nama','$komp')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
if (isset($_POST['edit'])) { //untuk edit
    $id        = $_POST['id'];
    $nama        = $_POST['nama'];
    $komp        = $_POST['komp'];

    if ($nama && $komp) {
            $sql1   = "update kelas set nama_kelas='$nama',id_komp='$komp' where id_kelas = '$id'";
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
if (isset($_GET['hapus'])) { //untuk delete
    $id        = $_GET['hapus'];
    if (!empty($id)){
        $sqlhapus = "DELETE FROM kelas where id_kelas = '$id'";

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

  <title>Kelas</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kelas</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

            <div class="card">
            
                <div class="card-body">
                <h5 class="card-title">Data Kelas</h5>
                <div class="row">
                    <div class="col">
                    <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Data
                        </button>
                    </div>
                </div>
                <!-- Modal Tambah Data -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post">
                        <div class="mb-3">
                        <label>Kelas</label>
                            <select name="nama" class="form-control" required>
                                <option value=""> Pilih Kelas </option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Kompetensi Keahlian</label>
                            <select name="komp" class="form-control" required>
                                <option value=""> Pilih Kompetensi Keahlian </option>
                                <?php
                                $dkomp = mysqli_query($koneksi,"select *from kompetensi order by nama_komp asc");
                                foreach($dkomp as $akomp){
                                ?>
                                <option value="<?php echo $akomp['id_komp'];?>"><?php echo $akomp['nama_komp'];?></option>
                                <?php } ?>
                            </select>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kelas</th>
                        <th>Kompetensi Keahlian</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $sql = "select *from kelas,kompetensi where kelas.id_komp=kompetensi.id_komp order by nama_kelas asc";
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            foreach($query as $r2) {
                                $id   = $r2['id_kelas'];
                                $nama   = $r2['nama_kelas'];
                                $komp   = $r2['nama_komp'];

                            ?>
                                <tr>
                                    <td scope="row"><?php echo $no++; ?></td>
                                    <td scope="row"><?php echo $nama; ?></td>
                                    <td scope="row"><?php echo $komp; ?></td>
                                    <td scope="row">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $id; ?>">Edit</button>
                                    <!-- Modal Edit-->
                                        <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="" method="post">
                                                <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" autocomplete="off">
                                                <div class="mb-3">
                                                    <label>Kelas</label>
                                                    <select name="nama" class="form-control" required>
                                                        <option value=""> Pilih Kelas </option>
                                                        <option value="X" <?php if($r2['nama_kelas'] == "X"){ echo 'selected'; } ?>>X</option>
                                                        <option value="XI" <?php if($r2['nama_kelas'] == "XI"){ echo 'selected'; } ?>>XI</option>
                                                        <option value="XII" <?php if($r2['nama_kelas'] == "XII"){ echo 'selected'; } ?>>XII</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kompetensi Keahlian</label>
                                                    <select name="komp" class="form-control" required>
                                                        <option value=""> Pilih Kompetensi Keahlian </option>
                                                        <?php
                                                        $dkomp = mysqli_query($koneksi,"select *from kompetensi order by nama_komp asc");
                                                        foreach($dkomp as $akomp){
                                                        ?>
                                                        <option value="<?php echo $akomp['id_komp'];?>" <?php if($akomp['id_komp'] == $r2['id_komp']){ echo 'selected'; } ?>><?php echo $akomp['nama_komp'];?></option>
                                                        <?php } ?>
                                                    </select>
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
                                        <a onclick = "return confirm('Apakah Anda Yakin Ingin Menghapus Data?')" href = "kelas.php?hapus=<?php echo $id;?>" class = "btn btn-danger">Hapus</a>            
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php"; ?>
</body>

</html>