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
$nama   = "";
$sukses = "";
$error = "";
if (isset($_POST['tambah'])) { //untuk create
    $nama   = $_POST['nama'];
    
    if ($nama) {
        $sql1   = "insert into kompetensi (nama_komp) values ('$nama')"; 
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
    $id   = $_POST['id'];
    $nama   = $_POST['nama'];

    if ($nama) {
            $sql1   = "update kompetensi set nama_komp='$nama' where id_komp='$id'";
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
        $sqlhapus = "DELETE FROM kompetensi where id_komp = '$id'";

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

  <title>Kompetensi Keahlian</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kompetensi Keahlian</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

            <div class="card">
            
                <div class="card-body">
              
                <h5 class="card-title">Data Kompetensi Keahlian</h5>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post">
                        <div class="mb-3">
                            <label>Nama Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="nama" autocomplete="off" required>
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
                        <th>Nama Kompetensi Keahlian</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $sql = "select *from kompetensi order by nama_komp asc";
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            foreach($query as $r2) {
                                $id = $r2['id_komp'];
                                $nama   = $r2['nama_komp'];
                            ?>
                                <tr>
                                    <td scope="row"><?php echo $no++; ?></td>
                                    <td scope="row"><?php echo $nama; ?></td>
                                    <td scope="row">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $id; ?>">Edit</button>
                                    <!-- Modal Edit-->
                                        <div class="modal fade" id="editModal<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="" method="post">
                                                <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" autocomplete="off" required>
                                                <div class="mb-3">
                                                    <label>Nama Kompetensi Keahlian</label>
                                                <input type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" autocomplete="off" required>
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
                                        <a onclick = "return confirm('Apakah Anda Yakin Ingin Menghapus Data?')" href = "kompetensi.php?hapus=<?php echo $id;?>" class = "btn btn-danger">Hapus</a>            
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