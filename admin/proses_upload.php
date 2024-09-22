<?php 

            // menghubungkan dengan koneksi
            $koneksi = mysqli_connect('localhost','root','','db_spp');
            
            // menghubungkan dengan library excel reader
            include "excel_reader.php";
            
            
            // upload file xls
            $target = basename($_FILES['fileexcel']['name']) ;
            move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);
            
            // beri permisi agar file xls dapat di baca
            chmod($_FILES['fileexcel']['name'],0777);
            
            // mengambil isi file xls
            $data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['name'],false);
            // menghitung jumlah baris data yang ada
            $jumlah_baris = $data->rowcount($sheet_index=0);
            
            // jumlah default data yang berhasil di import
            
            for ($i=2; $i<=$jumlah_baris; $i++){
            
                // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
                $nisn     	= $data->val($i, 1);
                $nis        = $data->val($i, 2);
                $nama  		= $data->val($i, 3);
                $id_kelas	= $data->val($i, 4);
                $alamat		= $data->val($i, 5);
                $no_telp	= $data->val($i, 6);
                $id_spp		= $data->val($i, 7);
                $password	= $data->val($i, 8);
            
                if($nisn && $nis && $nama && $id_kelas && $alamat && $no_telp && $id_spp && $password)
                {
                    // input data ke database (table barang)
                    $q1 = mysqli_query($koneksi,"INSERT into siswa values('$nisn','$nis','$nama','$id_kelas','$alamat','$no_telp','$id_spp','$password')");
                    if ($q1) {
                        $sukses     = "Berhasil memasukkan data baru";
                    } else {
                        $error      = "<script>
                        alert('Gagal!');
                        window.location.assign('siswa.php');
                        </script>";
                    }
                }
            }
            
            // hapus kembali file .xls yang di upload tadi
            unlink($_FILES['fileexcel']['name']);
            
            // alihkan halaman ke index.php
            header("location:siswa.php");
            ?>