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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <?php include "header.php"; ?>
</head>
<body>
<?php include "sidebar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col">

          <div class="card">
            
              <div class="card-body">
              
                <h5 class="card-title">Dashboard</h5>
                <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px;">
              <?php
              // Mengambil data dari database
              $sql = "SELECT MONTH(tgl_bayar) as bulan, SUM(jumlah_bayar) as total_pembayaran
              FROM pembayaran
              GROUP BY MONTH(tgl_bayar)";
              $result = mysqli_query($koneksi, $sql);

              $labels = array();
              $data = array();
              while($row = mysqli_fetch_assoc($result)) {
              $labels[] = $row['bulan'];
              $data_pembayaran[] = $row['total_pembayaran'];
              }
              // Membuat array data dan options pada Chart.js
              $data = array(
                'labels' => $labels,
                'datasets' => array(
                  array(
                    'label' => 'Jumlah Transaksi',
                    'data' => $data_pembayaran,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                  )
                )
              );

              $options = array(
                'scales' => array(
                  'yAxes' => array(
                    array(
                      'ticks' => array(
                        'beginAtZero' => true
                      )
                    )
                  )
                )
              );

              ?>
              <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: <?php echo json_encode($data); ?>,
                    options: <?php echo json_encode($options); ?>
                });
              </script>
              </canvas>
              <!-- End Bar CHart -->
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include "footer.php"; ?>
</body>

</html>