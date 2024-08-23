<?php

require 'admin/koneksi.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['kodeakses'])) {
  header("Location:login_akses.php");
}

// Menentukan waktu absensi berdasarkan hari
$absen_schedule = [
  'Monday'    => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '13:30:00', 'menunggu_end' => '13:59:59', 'pulang_start' => '14:00:00', 'pulang_tepat_waktu_end' => '16:00:00', 'pulang_end' => '17:00:00'],
  'Tuesday'   => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '13:30:00', 'menunggu_end' => '13:59:59', 'pulang_start' => '14:00:00', 'pulang_tepat_waktu_end' => '16:00:00', 'pulang_end' => '17:00:00'],
  'Wednesday' => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '13:30:00', 'menunggu_end' => '13:59:59', 'pulang_start' => '14:00:00', 'pulang_tepat_waktu_end' => '16:00:00', 'pulang_end' => '17:00:00'],
  'Thursday'  => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '13:30:00', 'menunggu_end' => '13:59:59', 'pulang_start' => '14:00:00', 'pulang_tepat_waktu_end' => '16:00:00', 'pulang_end' => '17:00:00'],
  'Friday'    => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '11:15:00', 'menunggu_end' => '11:44:59', 'pulang_start' => '11:45:00', 'pulang_tepat_waktu_end' => '13:00:00', 'pulang_end' => '16:00:00'],
  'Saturday'  => ['datang_start' => '06:00:00', 'datang_cepat_end' => '06:30:00', 'datang_tepat_waktu_start' => '06:30:01', 'datang_tepat_waktu_end' => '07:30:00', 'datang_end' => '09:00:00', 'menunggu_start' => '09:00:01', 'pulang_cepat_start' => '11:30:00', 'menunggu_end' => '11:59:59', 'pulang_start' => '12:00:00', 'pulang_tepat_waktu_end' => '14:00:00', 'pulang_end' => '16:00:00'],
  'Sunday'    => ['datang_start' => '00:00:00', 'datang_end' => '00:00:00', 'pulang_start' => '00:00:00', 'pulang_end' => '00:00:00'] // Tidak ada absensi di hari Minggu
];

// $result = mysqli_query($conn, "SELECT * FROM 
// siswa INNER JOiN absen on siswa.nis=absen.nis");
date_default_timezone_set('Asia/Makassar');
$tanggal = date("Y-m-d");
$waktu = date("H:i:s");
$hari_ini = date("l");

// Mendapatkan jadwal absensi berdasarkan hari ini
$schedule = $absen_schedule[$hari_ini];

// $result = mysqli_query($conn, "SELECT * FROM siswa 
//                                 INNER JOIN absen ON siswa.nis = absen.nis 
//                                 WHERE absen.tanggal = '$tanggal' 
//                                 ORDER BY absen.waktu DESC");

// $result = mysqli_query($conn, "SELECT siswa.*, jurusan.*
//                                 FROM siswa
//                                 INNER JOIN absen ON siswa.nis = absen.nis 
//                                 INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid
//                                 WHERE absen.tanggal = '$tanggal' 
//                                 ORDER BY absen.waktu DESC");

// $absen_hari_ini = mysqli_query($conn, "SELECT siswa.*, jurusan.*, absen.* FROM siswa INNER JOIN absen ON siswa.nis = absen.nis INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid WHERE absen.tanggal = '$tanggal' ORDER BY absen.waktu DESC");

// $result = mysqli_query($conn, "SELECT siswa.*, jurusan.*, absen.*
//                                 FROM siswa
//                                 INNER JOIN absen ON siswa.nis = absen.nis 
//                                 INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid
//                                 WHERE absen.tanggal = '$tanggal' 
//                                 ORDER BY absen.waktu DESC
//                                 LIMIT 1");

// $result = mysqli_query($conn, "SELECT siswa.*, jurusan.*, absen.*, kelas.*
// FROM siswa 
// INNER JOIN absen ON siswa.nis = absen.nis 
// INNER JOIN jurusan ON siswa.jurusanid = jurusan.jurusanid 
// INNER JOIN kelas ON siswa.kelasid = kelas.kelasid
// WHERE absen.tanggal = '$tanggal' 
// ORDER BY absen.id DESC LIMIT 1");

$filter_jabatan = isset($_GET['filter_jabatan']) ? $_GET['filter_jabatan'] : '';
$result = "SELECT pekerja.*, pangkat.*, absen.*, jabatan.*, golongan.*
        FROM pekerja 
        INNER JOIN absen ON pekerja.nip = absen.nip 
        INNER JOIN pangkat ON pekerja.pangkatid = pangkat.pangkatid 
        INNER JOIN jabatan ON pekerja.jabatanid = jabatan.jabatanid
        INNER JOIN golongan ON pekerja.golonganid = golongan.golonganid
        WHERE absen.tanggal = '$tanggal'";

if (!empty($filter_jabatan)) {
  $result .= " AND jabatan.jabatan = '$filter_jabatan'";
}

if ($hari_ini == "Sunday") {
  $result .= " ORDER BY absen.id DESC LIMIT 1";
} else if ($waktu >= $schedule['datang_start'] && $waktu <= $schedule['pulang_cepat_start']) {
  $result .= " ORDER BY absen.id DESC LIMIT 1";
} else {
  $result .= " ORDER BY absen.waktupulang DESC LIMIT 1";
}

$result_sql = mysqli_query($conn, $result);

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="admin/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QRSCANN</title>
  <style>
    .navbar-fixed {
      position: fixed;
      width: 100%;
      z-index: 3;
      top: 0;
    }

    .container-margin-top {
      margin-top: 50px;
    }

    .space-between-page {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      min-height: 100vh;
    }

    .space-between-card-2 {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      height: 100%;
    }

    .foto-user-profile-nav {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>
  <link rel="stylesheet" href="admin/css/bootstrap.css">
  <link rel="icon" href="admin/logo/smkn_labuang.png">

</head>

<body class="space-between-page">
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>

  <nav class="navbar navbar-expand-lg bg-primary navbar-dark navbar-fixed">
    <div class="container">
      <a class="navbar-brand" href="#">E-Absensi</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pilihan
            </a>
            <ul class="dropdown-menu">
              <?php
              if (isset($_SESSION['userid'])) {
              ?>
                <li><a class="dropdown-item" href="admin/index.php">Dashboard</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                <li><a class="dropdown-item" href="keluar_akses.php">Kunci</a></li>
              <?php
              } else {
              ?>
                <li><a class="dropdown-item" href="login.php">Login</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="keluar_akses.php">Kunci</a></li>
              <?php
              }
              ?>
              <!-- <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="admin/register.php">Register</a></li> -->
            </ul>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button> -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="admin/logo/smkn_labuang.png" class="nav-link" style="margin: 0; padding: 0;"><b>UPTD SMK Negeri Labuang</b> <img src="admin/logo/smkn_labuang.png" alt="" class="foto-user-profile-nav"></a>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </nav>


  <div class="container bg-body-tertiary py-3 mb-5 container-margin-top">
    <h2 class="text-center display-6 fw-bold">Silahkan Absen dengan Scan QR Code Anda</h2>
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card bg-body-tertiary shadow rounded-3 p-3 border-0">

          <!-- code pesan Gagal -->
          <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          -->

          <!-- code pesan berhasil -->
          <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> -->

          <video id="preview"></video>
          <style>
            .image-1 {
              position: absolute;
              bottom: 16px;
              left: -1.5px;
              z-index: 1;
              width: 20%;
              transform: scaleX(-1);
            }

            .scan_here {
              position: absolute;
              bottom: 17.5px;
              left: 100px;
              z-index: 1;
            }

            .scan_here.h5 {
              padding: 0 3px;
              margin: 0;
            }
          </style>
          <img src="admin/default/image-1.png" alt="" class="image-1">
          <div class="scan_here h5 card">Scan Here!</div>
          <form action="take_foto.php" method="POST" id="form">

            <input type="hidden" name="nip" id="nip">

            <input type="hidden" name="tanggal" value="<?php date_default_timezone_set('Asia/Makassar');
                                                        echo date("Y-m-d"); ?>">

          </form>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12" style="overflow-x: auto;">
        <!-- <div class="> -->
        <table class="table table-striped table-bordered table-hover" style="width: 1200px;">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Foto</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Pangkat/Golongan</th>
              <th>Jenis Kelamin</th>
              <th>Tanggal</th>
              <th>Waktu Datang</th>
              <th>Waktu Pulang</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nama</th>
              <th>Foto</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Pangkat/Golongan</th>
              <th>Jenis Kelamin</th>
              <th>Tanggal</th>
              <th>Waktu Datang</th>
              <th>Waktu Pulang</th>
            </tr>
          </tfoot>
          <tbody>
            <?php while ($key = mysqli_fetch_assoc($result_sql)) : ?>
              <?php
              $fotoPath = 'admin/fotopekerja/' . $key['fotopekerja'];
              // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
              if (!file_exists($fotoPath) || empty($key['fotopekerja'])) {
                $fotoPath = 'admin/default/user.png'; // Ganti dengan path gambar default
              }
              // Mendapatkan jam absen dari data
              // $jam_absen = strtotime($key["waktu"]);
              // $jam_tepat_waktu = strtotime("07:30:00");
              $tanggal_dari_database = $key["tanggal"];

              // Ubah format tanggal menggunakan strtotime() dan date()
              $tanggal_baru = date('d-m-Y', strtotime($tanggal_dari_database));

              $pangkat = $key['pangkat'] == "Tidak Memiliki" ? "-" : $key['pangkat'];
              $golongan = $key['golongan'] == "Tidak Memiliki" ? "-" : $key['golongan'];
              $nipCleaned = str_replace(' ', '', $key['nip']);
              $nip = is_numeric($nipCleaned) ? $key['nip'] : "-";

              $ket_tak_absen = '';
              if ($key['keterangantakabsen'] == 'Sakit') {
                $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-warning card';
              } elseif ($key['keterangantakabsen'] == 'Dinas Luar') {
                $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-secondary card';
              } elseif ($key['keterangantakabsen'] == 'Alpa') {
                $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-danger card';
              } elseif ($key['keterangantakabsen'] == 'Izin') {
                $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-primary card';
              }
              ?>
              <tr>
                <td width="200px"><?= $key["nama"]; ?></td>
                <td width="150px"><img src="<?= $fotoPath ?>" alt="<?= $key["nama"]; ?>" width="150px"></td>
                <td width="100px"><?= $nip; ?></td>
                <td width="100px"><?= $key["jabatan"]; ?></td>
                <td width="105px"><?= $pangkat; ?>/<?= $golongan; ?></td>
                <td width="125px"><?= $key["jk"]; ?></td>
                <td width="140px"><?= $tanggal_baru; ?></td>
                <td width="280px">
                  <?php
                  if ($key["waktudatang"] != "00:00:00") {
                  ?>
                    <?= $key["waktudatang"]; ?> WITA
                    <!-- <?php
                          if ($key["keterangandatang"] == "Datang Tepat Waktu") {
                          ?>
                      <b class="text-success"><?= $key['keterangandatang'] ?></b>
                    <?php
                          } elseif ($key["keterangandatang"] == "Datang Terlambat") {
                    ?>
                      <b class="text-danger"><?= $key['keterangandatang'] ?></b>
                    <?php
                          } elseif ($key["keterangandatang"] == "Datang Cepat") {
                    ?>
                      <b class="text-warning"><?= $key['keterangandatang'] ?></b>
                    <?php
                          }
                    ?> -->
                    <?php
                    if ($key["keterangandatang"] == "Hadir") {
                    ?>
                      <b class="text-success"><?= $key['keterangandatang'] ?></b>
                    <?php
                    } else {
                    ?>
                      -
                    <?php
                    }
                    ?>
                    <img src="admin/fotobuktidatang/<?= $key['fotodatang'] ?>" alt="" style="width: 100%;">
                  <?php
                  } else if ($key["keterangantakabsen"] != "") {
                  ?>
                    <div class="<?= $ket_tak_absen ?>">
                      <?php echo $key['keterangantakabsen']; ?>
                    </div>
                  <?php
                  } else {
                  ?>
                    ___
                  <?php
                  }
                  ?>
                </td>
                <td width="280px">
                  <?php
                  if ($key["waktupulang"] != "00:00:00") {
                  ?>
                    <?= $key["waktupulang"]; ?> WITA
                    <!-- <?php
                          if ($key["keteranganpulang"] == "Pulang Tepat Waktu") {
                          ?>
                      <b class="text-success"><?= $key['keteranganpulang'] ?></b>
                    <?php
                          } elseif ($key["keteranganpulang"] == "Pulang Terlambat") {
                    ?>
                      <b class="text-danger"><?= $key['keteranganpulang'] ?></b>
                    <?php
                          } elseif ($key["keteranganpulang"] == "Pulang Cepat") {
                    ?>
                      <b class="text-warning"><?= $key['keteranganpulang'] ?></b>
                    <?php
                          }
                    ?> -->
                    <?php
                    if ($key["keteranganpulang"] == "Pulang Tepat Waktu") {
                    ?>
                      <b class="text-success"><?= $key['keteranganpulang'] ?></b>
                    <?php
                    } else {
                    ?>
                      -
                    <?php
                    }
                    ?>
                    <img src="admin/fotobuktipulang/<?= $key['fotopulang'] ?>" alt="" style="width: 100%;">
                  <?php
                  } else if ($key["keterangantakabsen"] != "") {
                  ?>
                    <div class="<?= $ket_tak_absen ?>">
                      <?php echo $key['keterangantakabsen']; ?>
                    </div>
                  <?php
                  } else {
                  ?>
                    ___
                  <?php
                  }
                  ?>
                </td>
                <!-- Menambahkan keterangan berdasarkan jam absen -->
                <!-- <td width="100px"> -->
                <?php
                // $jam_absen <= $jam_tepat_waktu ? "Datang Tepat Waktu" : "Lambat";
                ?>
                <!-- </td> -->
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <!-- </div> -->
      </div>
    </div>
    <p class="h4 mt-5">Yang Absen Hari ini</p>
    <form action="#absensi_harian" method="GET">
      <div class="input-group mb-3">
        <!-- Hapus input tanggal -->
        <select class="form-select" name="filter_jabatan">
          <option value="">Semua Jabatan</option>
          <?php
          // Query untuk mendapatkan daftar kelas
          $sql_kelas = mysqli_query($conn, "SELECT * FROM jabatan");
          while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
          ?>
            <!-- Opsi untuk setiap kelas -->
            <option value="<?= $data_kelas['jabatan'] ?>" <?php echo isset($_GET['filter_jabatan']) && $_GET['filter_jabatan'] == $data_kelas['jabatan'] ? 'selected' : ''; ?>>
              <?= $data_kelas['jabatan'] ?>
            </option>
          <?php
          }
          ?>
        </select>
        <button type="submit" class="btn btn-primary">Cari</button>
      </div>
    </form>

    <div class="row">
      <?php
      // Tambahkan filter_jabatan ke dalam query jika ada yang dipilih
      $filter_jabatan = isset($_GET['filter_jabatan']) ? $_GET['filter_jabatan'] : '';
      $sql = "SELECT pekerja.*, pangkat.*, absen.*, jabatan.*, golongan.*
        FROM pekerja 
        INNER JOIN absen ON pekerja.nip = absen.nip 
        INNER JOIN pangkat ON pekerja.pangkatid = pangkat.pangkatid 
        INNER JOIN jabatan ON pekerja.jabatanid = jabatan.jabatanid
        INNER JOIN golongan ON pekerja.golonganid = golongan.golonganid
        WHERE absen.tanggal = '$tanggal'";

      // Jika filter_jabatan tidak kosong, tambahkan kondisi ke dalam query
      if (!empty($filter_jabatan)) {
        $sql .= " AND jabatan.jabatan = '$filter_jabatan'";
      }

      if ($hari_ini == "Sunday") {
        $sql .= " ORDER BY absen.id DESC";
      } else if ($waktu >= $schedule['datang_start'] && $waktu <= $schedule['pulang_cepat_start']) {
        $sql .= " ORDER BY absen.id DESC";
      } else {
        $sql .= " ORDER BY absen.waktupulang DESC";
      }

      $absen_hari_ini = mysqli_query($conn, $sql);

      while ($semua_hari_ini = mysqli_fetch_array($absen_hari_ini)) :

        $fotoPath = 'admin/fotopekerja/' . $semua_hari_ini['fotopekerja'];
        // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
        if (!file_exists($fotoPath) || empty($semua_hari_ini['fotopekerja'])) {
          $fotoPath = 'admin/default/user.png'; // Ganti dengan path gambar default
        }

        $tanggal_dari_database = $semua_hari_ini["tanggal"];

        // Ubah format tanggal menggunakan strtotime() dan date()
        $tanggal_baru = date('d-m-Y', strtotime($tanggal_dari_database));

        $pangkat = $semua_hari_ini['pangkat'] == "Tidak Memiliki" ? "-" : $semua_hari_ini['pangkat'];
        $golongan = $semua_hari_ini['golongan'] == "Tidak Memiliki" ? "-" : $semua_hari_ini['golongan'];

        $nipCleaned = str_replace(' ', '', $semua_hari_ini['nip']);
        $nip = is_numeric($nipCleaned) ? $semua_hari_ini['nip'] : "-";

        $ket_tak_absen = '';
        if ($semua_hari_ini['keterangantakabsen'] == 'Sakit') {
          $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-warning card';
        } elseif ($semua_hari_ini['keterangantakabsen'] == 'Dinas Luar') {
          $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-secondary card';
        } elseif ($semua_hari_ini['keterangantakabsen'] == 'Alpa') {
          $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-danger card';
        } elseif ($semua_hari_ini['keterangantakabsen'] == 'Izin') {
          $ket_tak_absen = 'p-2 fw-bolder text-center text-bg-primary card';
        }
      ?>
        <div class="col-xl-6 col-xl-6 mb-3">
          <div class="card space-between-card-2">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="<?= $fotoPath ?>" class="img-fluid rounded-start" alt="..." style="height: 100%; object-fit: cover;">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?= $semua_hari_ini['nama'] ?></h5>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">NIP: <?= $nip ?></li>
                    <li class="list-group-item">Jabatan: <?= $semua_hari_ini['jabatan'] ?></li>
                    <li class="list-group-item">Pangkat/Golongan: <?= $pangkat ?>/<?= $golongan ?></li>
                    <li class="list-group-item">Jenis Kelamin: <?= $semua_hari_ini['jk'] ?></li>
                    <li class="list-group-item">Tanggal: <?= $tanggal_baru ?></li>
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-auto">
                          Datang:
                        </div>
                        <div class="col-6" style="margin-left: -20px;">
                          <?php
                          if ($semua_hari_ini["waktudatang"] != "00:00:00") {
                          ?>
                            <?= $semua_hari_ini['waktudatang'] ?> WITA
                            <br>
                            <!-- ( -->
                            <!-- <?php
                                  if ($semua_hari_ini["keterangandatang"] == "Datang Tepat Waktu") {
                                  ?>
                              <b class="text-success"><?= $semua_hari_ini['keterangandatang'] ?></b>
                            <?php
                                  } elseif ($semua_hari_ini["keterangandatang"] == "Datang Terlambat") {
                            ?>
                              <b class="text-danger"><?= $semua_hari_ini['keterangandatang'] ?></b>
                            <?php
                                  } elseif ($semua_hari_ini["keterangandatang"] == "Datang Cepat") {
                            ?>
                              <b class="text-warning"><?= $semua_hari_ini['keterangandatang'] ?></b>
                            <?php
                                  }
                            ?> -->
                            <?php
                            if ($semua_hari_ini["keterangandatang"] == "Hadir") {
                            ?>
                              <b class="text-success"><?= $semua_hari_ini['keterangandatang'] ?></b>
                            <?php
                            } else {
                            ?>
                              -
                            <?php
                            }
                            ?>
                            <!-- ) -->
                          <?php
                          } else if ($semua_hari_ini["keterangantakabsen"] != "") {
                          ?>
                            <div class="<?= $ket_tak_absen ?>">
                              <?php echo $semua_hari_ini['keterangantakabsen']; ?>
                            </div>
                          <?php
                          } else {
                          ?>
                            -
                          <?php
                          }
                          ?>
                        </div>
                        <?php
                        if ($semua_hari_ini["waktudatang"] != "00:00:00") {
                        ?>
                          <div class="col-4" style="padding: 0; margin: 0; margin-left: -10px;">
                            <img src="admin/fotobuktidatang/<?= $semua_hari_ini['fotodatang'] ?>" alt="" style="width: 100%;">
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-auto">
                          Pulang:
                        </div>
                        <div class="col-6" style="margin-left: -20px;">
                          <?php
                          if ($semua_hari_ini["waktupulang"] != "00:00:00") {
                          ?>
                            <?= $semua_hari_ini['waktupulang'] ?> WITA
                            <br>
                            <!-- ( -->
                            <!-- <?php
                                  if ($semua_hari_ini["keteranganpulang"] == "Pulang Tepat Waktu") {
                                  ?>
                              <b class="text-success"><?= $semua_hari_ini['keteranganpulang'] ?></b>
                            <?php
                                  } elseif ($semua_hari_ini["keteranganpulang"] == "Pulang Terlambat") {
                            ?>
                              <b class="text-danger"><?= $semua_hari_ini['keteranganpulang'] ?></b>
                            <?php
                                  } elseif ($semua_hari_ini["keteranganpulang"] == "Pulang Cepat") {
                            ?>
                              <b class="text-warning"><?= $semua_hari_ini['keteranganpulang'] ?></b>
                            <?php
                                  }
                            ?> -->
                            <?php
                            if ($semua_hari_ini["keteranganpulang"] == "Pulang Tepat Waktu") {
                            ?>
                              <b class="text-success"><?= $semua_hari_ini['keteranganpulang'] ?></b>
                            <?php
                            } else {
                            ?>
                              -
                            <?php
                            }
                            ?>
                            <!-- ) -->
                          <?php
                          } else if ($semua_hari_ini["keterangantakabsen"] != "") {
                          ?>
                            <div class="<?= $ket_tak_absen ?>">
                              <?php echo $semua_hari_ini['keterangantakabsen']; ?>
                            </div>
                          <?php
                          } else {
                          ?>
                            -
                          <?php
                          }
                          ?>
                        </div>
                        <?php
                        if ($semua_hari_ini["waktupulang"] != "00:00:00") {
                        ?>
                          <div class="col-4" style="padding: 0; margin: 0; margin-left: -10px;">
                            <img src="admin/fotobuktipulang/<?= $semua_hari_ini['fotopulang'] ?>" alt="" style="width: 100%;">
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      endwhile;
      ?>
    </div>
    <?php
    if ($hari_ini == "Sunday") {
    ?>
      <div class="col-12">
        <div class="alert alert-danger" role="alert">
          Absensi Tidak Dilaksanakan Karena Hari Ini Hari Minggu, libur. Absensi Kembali Dilaksanakan Pada Hari Senin
        </div>
      </div>
    <?php
    }
    ?>
  </div>

  <div class="container-fluid py-3 bg-primary text-center">
    <b class="text-light">Copyright © <?= date("Y") ?> i Team RPL SMKN Labuang</b>
  </div>

  <!-- <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
  <script type="text/javascript" src="admin/js/instascan.min.js"></script>

  <script type="text/javascript">
    let scanner = new Instascan.Scanner({
      video: document.getElementById('preview')
    });
    scanner.addListener('scan', function(content) {
      console.log(content);
    });
    Instascan.Camera.getCameras().then(function(cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[0]);
      } else {
        console.error('No cameras found.');
      }
    }).catch(function(e) {
      console.error(e);
    });

    scanner.addListener('scan', function(c) {
      document.getElementById('nip').value = c;
      document.getElementById('form').submit();
    })
  </script>

  <script src="admin/js/bootstrap.js"></script>

</body>

</html>