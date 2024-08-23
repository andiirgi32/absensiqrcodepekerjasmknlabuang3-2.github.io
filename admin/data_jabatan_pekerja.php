<?php
include "koneksi.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
  header("Location:../login.php");
} else if (!isset($_SESSION['kodeakses'])) {
  header("Location:../login_akses.php");
}

// Check for theme in session or cookies
if (isset($_SESSION['theme'])) {
  $theme = $_SESSION['theme'];
} elseif (isset($_COOKIE['theme'])) {
  $theme = $_COOKIE['theme'];
  $_SESSION['theme'] = $theme;
} else {
  $theme = 'default';
}
?>

<?php
if ($_SESSION['role'] != "Admin" && $_SESSION['role'] != "Kepala Sekolah" && $_SESSION['role'] != "Kepala Tata Usaha" && $_SESSION['role'] != "STAF") {
  header("Location:index.php");
  exit();
}

// if (!isset($_GET['jabatanid']) || !isset($_GET['namakelas']) || !isset($_GET['pangkatid'])) {
//   echo '<script>history.go(-1);</script>';
//   exit();
// }

date_default_timezone_set('Asia/Makassar');
$TanggalHariIni = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="logo/smkn_labuang.png" rel="icon">
  <title>Ruang<?= $_SESSION['role'] ?> - Absensi Harian</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
  <!-- <link rel="stylesheet" href="css/iconbootstrap.css"> -->
  <link rel="stylesheet" href="css/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="css/sweetalert.css">
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/sweetalert.min.js"></script>

  <?php if ($theme == 'default') : ?>
    <link rel="stylesheet" href="theme/default.css">
  <?php elseif ($theme == 'theme1') : ?>
    <link rel="stylesheet" href="theme/theme1.css">
  <?php elseif ($theme == 'theme2') : ?>
    <link rel="stylesheet" href="theme/theme2.css">
  <?php elseif ($theme == 'theme3') : ?>
    <link rel="stylesheet" href="theme/theme3.css">
  <?php elseif ($theme == 'theme4') : ?>
    <link rel="stylesheet" href="theme/theme4.css">
  <?php elseif ($theme == 'theme5') : ?>
    <link rel="stylesheet" href="theme/theme5.css">
  <?php endif; ?>

  <style>
    .berita-user-profile {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      position: relative;
      left: 50%;
      transform: translateX(-50%);
    }

    .berita-user-profile-utama {
      width: 125px;
      height: 125px;
      border-radius: 50%;
      object-fit: cover;
      /* position: relative;
            left: 50%;
            transform: translateX(-50%); */
    }

    .berita-user-profile-nav {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .space-between-body {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      min-height: 100vh;
    }

    .navbar-fixed {
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1;
    }

    .container-margin {
      margin-top: 100px;
    }

    .space-between-card {
      display: flex;
      justify-content: space-between;
      flex-direction: column;
      min-height: 100%;
    }

    .container-grid {
      display: grid;
      grid-template-areas: 'tentang-akun' 'semua-post';
    }

    .tentang-akun {
      grid-area: tentang-akun;
    }

    .semua-post {
      grid-area: semua-post;
    }

    /* =============================================================== */
    a {
      text-decoration: none;
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
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

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

  <div class="dropdown position-fixed bottom-0 star-0 mb-3 ml-3 me-3 bd-mode-toggle">
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

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light bg-body-tertiary accordion" id="accordionSidebar">
      <a class="sidebar-brand bg-sidebar-theme d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="logo/smkn_labuang.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-2">SMKN Labuang</div>
      </a>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Modal Pop Up
      </div>
      <li class="nav-item">
        <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#cetakHarian">
          <i class="fas fa-fw fa-print"></i>
          <span>Cetak</span></a>
      </li>
      <?php
      if ($_SESSION['role'] == "Admin") {
      ?>
        <li class="nav-item">
          <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#buatQRCode">
            <i class="fas fa-fw fa-qrcode"></i>
            <span>Buat QR Code</span></a>
        </li>
      <?php
      }
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Halaman
      </div>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php">
          <i class="fas fa-fw fa-qrcode"></i>
          <span>E-Absensi</span></a>
      </li>
      <?php
      if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Kepala Sekolah" || $_SESSION['role'] == "Kepala Tata Usaha" || $_SESSION['role'] == "STAF") {
      ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Daftar Absensi Card
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTableAbsensiPelajar" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Card Absensi</span>
          </a>
          <div id="collapseTableAbsensiPelajar" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="card py-2 collapse-inner rounded">
              <h6 class="collapse-header">Absensi Pekerja</h6>
              <a class="collapse-item" style="border: 0px;" href="absensi_harian.php">
                Absensi Harian
              </a>
              <a class="collapse-item" href="absensi_bulanan.php">
                Absensi Bulanan
              </a>
            </div>
          </div>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Daftar Absensi table
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTableAbsensiPekerjaTable" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Table Absensi</span>
          </a>
          <div id="collapseTableAbsensiPekerjaTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="card py-2 collapse-inner rounded">
              <h6 class="collapse-header">Absensi Pekerja</h6>
              <a class="collapse-item" style="border: 0px;" href="table_absensi_harian.php">
                Absensi Harian
              </a>
              <a class="collapse-item" href="table_absensi_mingguan.php">
                Absensi Mingguan
              </a>
            </div>
          </div>
        </li>
      <?php
      }
      ?>
      <?php
      if ($_SESSION['role'] == "Admin") {
      ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Features 001
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
          </a>
          <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="card py-2 collapse-inner rounded">
              <h6 class="collapse-header">Tables</h6>
              <a class="collapse-item" href="table_jabatan.php">Table Jabatan</a>
              <a class="collapse-item" href="table_pangkat.php">Table Pangkat</a>
              <a class="collapse-item" href="table_Golongan.php">Table Golongan</a>
              <a class="collapse-item" href="table_pekerja.php">Table Pekerja</a>
              <a class="collapse-item" href="table_aksesmasuk.php">Table Akses</a>
              <a class="collapse-item" href="table_outprint.php">Table Out Print</a>
              <a class="collapse-item" href="table_user.php">Table User</a>
            </div>
          </div>
        </li>
      <?php
      }
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features 002
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTablePekerja" aria-expanded="true" aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables Pekerja</span>
        </a>
        <div id="collapseTablePekerja" class="collapse show" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="card py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tables</h6>
            <?php
            $selectedjabatanid = isset($_GET['jabatanid']) ? $_GET['jabatanid'] : '';
            $sql_kelas = mysqli_query($conn, "SELECT * FROM jabatan");
            while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
              $activeClass = ($data_kelas['jabatanid'] == $selectedjabatanid) ? 'active btn-light' : '';
            ?>
              <a class="collapse-item <?= $activeClass ?>" href="data_jabatan_pekerja.php?jabatanid=<?= $data_kelas['jabatanid'] ?>&jabatan=<?= $data_kelas['jabatan'] ?>"><?= $data_kelas['jabatan'] ?></a>
            <?php
            }
            ?>
          </div>
        </div>
      </li>
      <!-- <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div> -->
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column bg-body-tertiary">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <div class="nav-link dropdown-toggle">
                <i class="fas fa-user-tie fa-fw text-user"></i>&nbsp;
                <div class="text-user"><?= $_SESSION['role'] ?></div>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                $fotoPath = 'fotouser/' . $_SESSION['fotouser'];
                // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
                if (!file_exists($fotoPath) || empty($_SESSION['fotouser'])) {
                  $fotoPath = 'default/user.png'; // Ganti dengan path gambar default
                }
                ?>
                <img class="img-profile rounded-circle" src="<?= $fotoPath ?>" style="max-width: 60px; object-fit: cover;">
                <span class="ml-2 d-none d-lg-inline text-user small"><?= $_SESSION['namalengkap'] ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#myProfile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#setting">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal" id="buttonModalLogout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid bg-body-tertiary" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0">DataTable <?= $_GET['jabatan'] ?></h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item" aria-current="page">Tables</li>
              <li class="breadcrumb-item active" aria-current="page">DataTable <?= $_GET['jabatan'] ?></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Table <?= $_GET['jabatan'] ?></h6>
                  <?php
                  if ($_SESSION['role'] == "Admin") {
                  ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#tambahPekerja" class="btn btn-primary btn-sm"><i class="bi bi-file-earmark-plus-fill"></i></a>
                  <?php
                  }
                  ?>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-striped table-hover" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Foto</th>
                        <th>Jabatan</th>
                        <th>Pangkat/Golongan</th>
                        <th>Jenis Kelamin</th>
                        <?php
                        if ($_SESSION['role'] == "Admin") {
                        ?>
                          <th>Aksi</th>
                        <?php
                        }
                        ?>
                      </tr>
                    </thead>
                    <tfoot class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Foto</th>
                        <th>Jabatan</th>
                        <th>Pangkat/Golongan</th>
                        <th>Jenis Kelamin</th>
                        <?php
                        if ($_SESSION['role'] == "Admin") {
                        ?>
                          <th>Aksi</th>
                        <?php
                        }
                        ?>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $jabatanid = $_GET['jabatanid'];
                      $sql = mysqli_query($conn, "SELECT pekerja.*, pangkat.*, jabatan.*, golongan.* FROM pekerja INNER JOIN pangkat ON pekerja.pangkatid=pangkat.pangkatid INNER JOIN jabatan ON pekerja.jabatanid=jabatan.jabatanid INNER JOIN golongan ON pekerja.golonganid=golongan.golonganid WHERE pekerja.jabatanid='$jabatanid' ORDER BY pekerja.nama ASC");
                      $no = 1;
                      while ($data = mysqli_fetch_array($sql)) {
                        $fotoPath = 'fotopekerja/' . $data['fotopekerja'];
                        // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
                        if (!file_exists($fotoPath) || empty($data['fotopekerja'])) {
                          $fotoPath = 'default/user.png'; // Ganti dengan path gambar default
                        }

                        // Ubah nilai pangkat dan golongan jika "Tidak Memiliki"
                        $pangkat = $data['pangkat'] == "Tidak Memiliki" ? "-" : $data['pangkat'];
                        $golongan = $data['golongan'] == "Tidak Memiliki" ? "-" : $data['golongan'];

                        // Ganti nilai NIP dengan tanda "-" jika bukan nomor
                        // $nip = is_numeric($data['nip']) ? $data['nip'] : "-";
                        $nipCleaned = str_replace(' ', '', $data['nip']);
                        $nip = is_numeric($nipCleaned) ? $data['nip'] : "-";
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $nip ?></td>
                          <td><img src="<?= $fotoPath ?>" alt="<?= $data["nama"]; ?>" width="150px"></td>
                          <td><?= $data['jabatan'] ?></td>
                          <td><?= $pangkat ?>/<?= $golongan ?></td>
                          <td><?= $data['jk'] ?></td>
                          <?php
                          if ($_SESSION['role'] == "Admin") {
                          ?>
                            <td>
                              <a href="" data-bs-toggle="modal" data-bs-target="#editPekerja<?= $data['idpekerja'] ?>" class="btn btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
                              <form action="hapus_pekerja.php?idpekerja=<?= $data['idpekerja'] ?>" method="post" onsubmit="return confirm('Apakah kamu yakin ingin menghapusnya?')" style="display: inline;">
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                              </form>
                            </td>
                          <?php
                          }
                          ?>
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
          <!--Row-->

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form class="modal-content" action="../logout.php" method="post">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="margin: 0; padding: 0; display: flex; justify-content: center; align-items: center;">
                  <img src="default/Tak berjudul28_20240708190427.png" alt="" style="width: 90%;">
                </div>
                <div class="modal-footer" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                  <div class="h5 mb-3">Apa Jawaban Anda?</div>
                  <div style="display: flex; align-items: center;">
                    <button type="submit" class="btn btn-primary mr-2" id="logoutButton">I'm Sure</button>
                    <div class="h5 mx-2">Atau</div>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Not Sure</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <script>
            $(document).ready(function() {
              $('#logoutModal').on('shown.bs.modal', function() {
                // $('#focusInput').trigger('focus');
                document.addEventListener('keydown', function(event) {
                  if (event.key === 'Enter') {
                    document.getElementById('logoutButton').click();
                  }
                }, {
                  once: true
                });
              });

              document.addEventListener('keydown', function(event) {
                if (event.key === 'Alt') {
                  document.addEventListener('keydown', function(event) {
                    if (event.key === '/') {
                      document.getElementById('buttonModalLogout').click();
                    }
                  }, {
                    once: true
                  });
                }
              });
            });
          </script>
          <!-- Akhir Modal Logout -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-navbar">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;
              <?= date("Y") ?> i RPL UPTD SMK Negeri Labuang
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <?php
  if ($_SESSION['hakakses'] == "Dilarang") {
    echo "<script type='text/javascript'>
        setTimeout(function () { 
          swal({
                  title: 'Anda Dilarang Untuk Mengakses Halaman Ini',
                  text:  'Silahkan Hubungi Admin Utama Untuk Meminta Izin Akses!',
                  type: 'error',
                  timer: 5000,
                  showConfirmButton: false
              });   
        });  
        window.setTimeout(function(){ 
      window.location.replace('../index.php');
    } ,5000); 
        </script>";
  }
  ?>

  <!-- Modal Scrollable -->
  <div class="modal fade" id="cetakHarian" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" id="printForm" method="post" target="_blank">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="bi bi-printer-fill"></i> Cetak (Masukan Data)</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="tanggal">Tanggal</label>
          <input type="date" class="form-control mb-2" id="tanggal" name="tanggal" placeholder="klik dan ketik disini..." required value="<?= date("Y-m-d") ?>">

          <label for="outprintid">Cetak Keluar Sebagai:</label>
          <select name="outprintid" id="outprintid" class="form-control mb-2" required>
            <option value="">Pilihan</option>
            <?php
            $sql_outprint = mysqli_query($conn, "SELECT * FROM outprint");
            while ($data_outprint = mysqli_fetch_array($sql_outprint)) {
            ?>
              <option value="<?= $data_outprint['outprintid'] ?>"><?= $data_outprint['outprintas'] ?></option>
            <?php
            }
            ?>
          </select>

          <label for="printOption">Pilih Hasil Print</label>
          <select name="printOption" id="printOption" class="form-control mb-2" required>
            <option value="hasil_print_mingguan.php">Hasil Print Mingguan</option>
            <option value="hasil_print_harian.php">Hasil Print Harian</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Tampikan" class="btn btn-success">
          <button type="reset" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <script>
    document.getElementById('printForm').addEventListener('submit', function(event) {
      var printOption = document.getElementById('printOption').value;
      this.action = printOption;
    });
  </script>

  <!-- Modal Scrollable -->
  <div class="modal fade" id="tambahPekerja" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <form class="modal-content" action="proses_pekerja.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Pekerja <?= $_GET['jabatan'] ?></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
          <label for="inputFotoUser" style="display: block; text-align: center;" class="mb-3">
            <img src="default/user.png" alt="" class="foto-user-profile card" id="imgFotoUser" style="width: 35%; margin: auto;">
          </label>
          <input type="file" name="fotopekerja" id="inputFotoUser" class="form-control" hidden>
          <script>
            let imgFotoUser = document.getElementById("imgFotoUser");
            let inputFotoUser = document.getElementById("inputFotoUser");

            inputFotoUser.onchange = function() {
              imgFotoUser.src = URL.createObjectURL(inputFotoUser.files[0]);
            }
          </script>
          <label for="nama">Nama</label>
          <input type="text" class="form-control mb-2" id="nama" name="nama" placeholder="klik dan ketik disini...">
          <label for="nip">NIP</label>
          <input type="text" class="form-control mb-2" id="nip" name="nip" placeholder="klik dan ketik disini...">
          <p class="text-danger">
            Jika pekerja belum punya NIP, maka bisa menggunakan Nama atau yang lain
          </p>
          <script>
            document.getElementById('nip').addEventListener('input', function() {
              // Mengganti semua karakter yang bukan angka atau spasi dengan string kosong
              // this.value = this.value.replace(/[^0-9 ]/g, '');

              // Mengganti spasi berturut-turut dengan satu spasi
              this.value = this.value.replace(/\s{2,}/g, ' ');
            });
          </script>
          <input type="hidden" name="jabatanid" id="jabatanid" class="form-control" value="<?= $_GET['jabatanid'] ?>">
          <label for="pangkatid">Pangkat</label>
          <select name="pangkatid" id="pangkatid" class="form-control mb-2">
            <option value="">Tidak Ada</option>
            <?php
            $sql_kelas = mysqli_query($conn, "SELECT * FROM pangkat");
            while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
            ?>
              <option value="<?= $data_kelas['pangkatid'] ?>"><?= $data_kelas['pangkat'] ?></option>
            <?php
            }
            ?>
          </select>
          <label for="golonganid">Golongan</label>
          <select name="golonganid" id="golonganid" class="form-control mb-2">
            <option value="">Tidak Ada</option>
            <?php
            $sql_kelas = mysqli_query($conn, "SELECT * FROM golongan");
            while ($data_kelas = mysqli_fetch_array($sql_kelas)) {
            ?>
              <option value="<?= $data_kelas['golonganid'] ?>"><?= $data_kelas['golongan'] ?></option>
            <?php
            }
            ?>
          </select>
          <label for="jk">Jenis Kelamin</label>
          <select name="jk" id="jk" class="form-control mb-2" required>
            <option value="">Pilihan</option>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <label for="outprintid">Masuk Daftar Cetak Absensi Sebagai:</label>
          <select name="outprintid" id="outprintid" class="form-control mb-2" required>
            <option value="">Pilihan</option>
            <?php
            $sql_outprint = mysqli_query($conn, "SELECT * FROM outprint");
            while ($data_outprint = mysqli_fetch_array($sql_outprint)) {
            ?>
              <option value="<?= $data_outprint['outprintid'] ?>"><?= $data_outprint['outprintas'] ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Tambahkan" class="btn btn-success">
          <button type="reset" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <?php
  foreach ($sql as $index => $data) {
    $fotoPath = 'fotopekerja/' . $data['fotopekerja'];
    // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
    if (!file_exists($fotoPath) || empty($data['fotopekerja'])) {
      $fotoPath = 'default/user.png'; // Ganti dengan path gambar default
    }
  ?>
    <!-- Modal Scrollable -->
    <div class="modal fade" id="editPekerja<?= $data['idpekerja'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <form class="modal-content" action="update_pekerja.php" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Pekerja <?= $_GET['jabatan'] ?></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label for="inputFoto2_<?= $index ?>" style="display: block; text-align: center;" class="mb-3">
              <img src="<?= $fotoPath ?>" alt="" class="foto-user-profile card" id="imgFoto2_<?= $index ?>" style="width: 35%; margin: auto;">
            </label>
            <input type="file" name="fotopekerja" id="inputFoto2_<?= $index ?>" class="form-control" hidden>
            <label for="nama">Nama</label>
            <input type="text" class="form-control mb-2" id="nama" name="nama" placeholder="klik dan ketik disini..." value="<?= $data['nama'] ?>">
            <label for="nip<?= $index ?>">NIP</label>
            <input type="text" class="form-control mb-2" id="nip<?= $index ?>" name="nip" placeholder="klik dan ketik disini..." value="<?= $data['nip'] ?>">
            <p class="text-danger">
              Jika pekerja belum punya NIP, maka bisa menggunakan Nama atau yang lain
            </p>
            <script>
              document.getElementById('nip<?= $index ?>').addEventListener('input', function() {
                // Mengganti semua karakter yang bukan angka atau spasi dengan string kosong
                // this.value = this.value.replace(/[^0-9 ]/g, '');

                // Mengganti spasi berturut-turut dengan satu spasi
                this.value = this.value.replace(/\s{2,}/g, ' ');
              });
            </script>
            <input type="hidden" name="jabatanid" id="jabatanid" class="form-control" value="<?= $_GET['jabatanid'] ?>">
            <input type="hidden" name="idpekerja" id="idpekerja" class="form-control" value="<?= $data['idpekerja'] ?>">
            <label for="pangkatid">Pangkat</label>
            <select name="pangkatid" id="pangkatid" class="form-control mb-2">
              <?php
              // Query untuk mengambil semua kelas
              $sql_jurusan = mysqli_query($conn, "SELECT * FROM pangkat");

              // Mengambil nilai jabatanid_wali dari $data
              $pangkatid_wali = $data['pangkatid'];

              // Query untuk memeriksa apakah jabatanid_wali ada dalam tabel kelas
              $sql_jurusan_wali = mysqli_query($conn, "SELECT * FROM pangkat WHERE pangkatid='$pangkatid_wali'");

              // Jika jabatanid dalam $data adalah 0, tampilkan opsi "Tidak Ada" dan semua kelas
              if ($data['pangkatid'] == 0) {
              ?>
                <option value="" selected>Tidak Ada</option>
                <?php
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['pangkatid'] ?>"><?= $data_jurusan['pangkat'] ?></option>
                <?php
                }
              } else if (mysqli_num_rows($sql_jurusan_wali) == 0) {
                // Jika pangkatid_wali tidak ditemukan dalam tabel kelas, tampilkan "Data Error"
                ?>
                <option value="" selected>Data Error</option>
                <?php
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['pangkatid'] ?>"><?= $data_jurusan['pangkat'] ?></option>
                <?php
                }
                ?>
                <option value="">Tidak Ada</option>
                <?php
              } else if (mysqli_num_rows($sql_jurusan) > 0) {
                // Jika ada kelas dalam tabel kelas, tampilkan semua kelas dan tandai kelas yang dipilih
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['pangkatid'] ?>" <?php if ($data_jurusan['pangkatid'] == $data['pangkatid']) {
                                                                      echo 'selected';
                                                                    } ?>><?= $data_jurusan['pangkat'] ?></option>
                <?php
                }
                ?>
                <option value="">Tidak Ada</option>
              <?php
              }
              ?>
            </select>
            <label for="golonganid">Golongan</label>
            <select name="golonganid" id="golonganid" class="form-control mb-2">
              <?php
              // Query untuk mengambil semua kelas
              $sql_jurusan = mysqli_query($conn, "SELECT * FROM golongan");

              // Mengambil nilai jabatanid_wali dari $data
              $golonganid_wali = $data['golonganid'];

              // Query untuk memeriksa apakah jabatanid_wali ada dalam tabel kelas
              $sql_jurusan_wali = mysqli_query($conn, "SELECT * FROM golongan WHERE golonganid='$golonganid_wali'");

              // Jika jabatanid dalam $data adalah 0, tampilkan opsi "Tidak Ada" dan semua kelas
              if ($data['golonganid'] == 0) {
              ?>
                <option value="" selected>Tidak Ada</option>
                <?php
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['golonganid'] ?>"><?= $data_jurusan['golongan'] ?></option>
                <?php
                }
              } else if (mysqli_num_rows($sql_jurusan_wali) == 0) {
                // Jika golonganid_wali tidak ditemukan dalam tabel kelas, tampilkan "Data Error"
                ?>
                <option value="" selected>Data Error</option>
                <?php
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['golonganid'] ?>"><?= $data_jurusan['golongan'] ?></option>
                <?php
                }
                ?>
                <option value="">Tidak Ada</option>
                <?php
              } else if (mysqli_num_rows($sql_jurusan) > 0) {
                // Jika ada kelas dalam tabel kelas, tampilkan semua kelas dan tandai kelas yang dipilih
                while ($data_jurusan = mysqli_fetch_array($sql_jurusan)) {
                ?>
                  <option value="<?= $data_jurusan['golonganid'] ?>" <?php if ($data_jurusan['golonganid'] == $data['golonganid']) {
                                                                        echo 'selected';
                                                                      } ?>><?= $data_jurusan['golongan'] ?></option>
                <?php
                }
                ?>
                <option value="">Tidak Ada</option>
              <?php
              }
              ?>
            </select>
            <label for="jk">Jenis Kelamin</label>
            <select name="jk" id="jk" class="form-control mb-2">
              <?php
              if ($data['jk'] == "Laki-Laki") {
              ?>
                <option value="<?= $data['jk'] ?>"><?= $data['jk'] ?></option>
                <option value="Perempuan">Perempuan</option>
              <?php
              } else if ($data['jk'] == "Perempuan") {
              ?>
                <option value="<?= $data['jk'] ?>"><?= $data['jk'] ?></option>
                <option value="Laki-Laki">Laki-Laki</option>
              <?php
              }
              ?>
            </select>
            <label for="outprintid">Masuk Daftar Cetak Absensi Sebagai:</label>
            <select name="outprintid" id="outprintid" class="form-control mb-2" required>
              <option value="">Pilihan</option>
              <?php
              $sql_outprint = mysqli_query($conn, "SELECT * FROM outprint");
              while ($data_outprint = mysqli_fetch_array($sql_outprint)) {
              ?>
                <option value="<?= $data_outprint['outprintid'] ?>" <?php
                                                                    if ($data_outprint['outprintid'] == $data['outprintid']) {
                                                                      echo 'selected';
                                                                    }
                                                                    ?>><?= $data_outprint['outprintas'] ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Ubah" class="btn btn-success">
            <button type="reset" class="btn btn-danger">Hapus</button>
          </div>
        </form>
      </div>
    </div>
    <!-- End Modal Scrollable -->
  <?php
  }
  ?>

  <script>
    <?php foreach ($sql as $index => $data) { ?>
      let imgFoto2_<?= $index ?> = document.getElementById("imgFoto2_<?= $index ?>");
      let inputFoto2_<?= $index ?> = document.getElementById("inputFoto2_<?= $index ?>");

      inputFoto2_<?= $index ?>.onchange = function() {
        imgFoto2_<?= $index ?>.src = URL.createObjectURL(inputFoto2_<?= $index ?>.files[0]);
      }
    <?php } ?>
  </script>

  <!-- Modal Scrollable -->
  <div class="modal fade" id="buatQRCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form id="qrcode-form" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Buat QR-Code</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <style>
          #qrcode {
            margin-top: 20px;
          }

          #qrcode canvas {
            width: 100%;
            /* Set the width you want here */
            max-width: 300px;
            /* Optional: set a max width */
            height: auto;
            /* Maintain the aspect ratio */
            /* margin: 0 auto; */
          }

          #qrcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
          }
        </style>
        <div class="modal-body">
          <div class="form-group">
            <label for="text">Kode Akses</label>
            <input class="form-control" type="text" id="text" placeholder="Enter text" required>
          </div>
          <div class="form-group">
            <label for="logo">Pilih Gambar Anda</label>
            <input class="form-control" type="file" id="logo" accept="image/*">
          </div>
          <div id="error-message" style="color: red; display: none;">Logo must be a square image (1:1 aspect ratio).</div>
          <div id="qrcode-container" style="display: none; text-align: center;">
            <div id="qrcode"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="download-btn" class="btn btn-warning" style="display:none;">Download QR Code</button>
          <button type="submit" class="btn btn-success">Generate QR Code</button>
          <button type="reset" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Modal Scrollable -->
  <div class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" action="update_profile.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Profile Saya</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
          <!-- <form action="update_user.php" method="post" enctype="multipart/form-data"> -->
          <?php
          $userid = $_SESSION['userid'];
          $sql = mysqli_query($conn, "SELECT * FROM user WHERE userid='$userid'");
          while ($data = mysqli_fetch_array($sql)) {
            $fotoPath = 'fotouser/' . $data['fotouser'];
            // Jika file tidak ada atau nama file tidak valid, gunakan gambar default
            if (!file_exists($fotoPath) || empty($data['fotouser'])) {
              $fotoPath = 'default/user.png'; // Ganti dengan path gambar default
            }
          ?>
            <input type="text" class="form-control mb-2" id="userid" name="userid" placeholder="klik dan ketik disini..." value="<?= $data['userid'] ?>" hidden required>
            <label for="inputFoto" style="display: block;" class="mb-3">
              <img src="<?= $fotoPath ?>" alt="" class="berita-user-profile" id="imgFoto">
            </label>
            <input type="file" name="fotouser" id="inputFoto" class="form-control" hidden>
            <label for="username">Username</label>
            <input type="text" class="form-control mb-2" id="username" name="username" placeholder="klik dan ketik disini..." value="<?= $data['username'] ?>" required>
            <script>
              // Add event listener to the Username input field
              $('#username').on('input', function() {
                var username = $(this).val();
                // Convert to lowercase and remove spaces
                username = username.toLowerCase().replace(/\s+/g, '');
                $(this).val(username);
              });
            </script>
            <label for="password">Password</label>
            <input type="password" class="form-control mb-2" id="password" name="password" placeholder="klik dan ketik disini..." value="<?= $data['password'] ?>" minlength="8" required>
            <input type="checkbox" id="show-password"> <label for="show-password">Tampilkan Sandi</label>
            <label for="email" style="display: block;">Email</label>
            <input type="email" class="form-control mb-2" id="email" name="email" placeholder="klik dan ketik disini..." value="<?= $data['email'] ?>" required>
            <label for="namalengkap">Nama Lengkap</label>
            <input type="text" class="form-control mb-2" id="namalengkap" name="namalengkap" placeholder="klik dan ketik disini..." value="<?= $data['namalengkap'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="nip" name="nip" placeholder="klik dan ketik disini..." value="<?= $data['nip'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="jabatanid" name="jabatanid" placeholder="klik dan ketik disini..." value="<?= $data['jabatanid'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="pangkatid" name="pangkatid" placeholder="klik dan ketik disini..." value="<?= $data['pangkatid'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="golonganid" name="golonganid" placeholder="klik dan ketik disini..." value="<?= $data['golonganid'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="hakakses" name="hakakses" placeholder="klik dan ketik disini..." value="<?= $data['hakakses'] ?>" required>
            <input type="hidden" class="form-control mb-2" id="idpekerja" name="idpekerja" placeholder="klik dan ketik disini..." value="<?= $data['idpekerja'] ?>" required>
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control mb-2" id="alamat" cols="30" rows="5" placeholder="klik dan ketik disini..." required><?= $data['alamat'] ?></textarea>
            <input type="text" class="form-control mb-2" id="role" name="role" placeholder="klik dan ketik disini..." value="<?= $data['role'] ?>" hidden required>
          <?php
          }
          ?>
          <!-- </form> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Ubah" class="btn btn-success">
          <button type="reset" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Modal Scrollable -->
  <div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <form class="modal-content" action="change_theme.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="bi bi-gear-wide-connected"></i> Pengaturan</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="theme">Pilih Tema:</label>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="themeDefault" value="default" <?php if ($theme == 'default') echo 'checked'; ?>>
            <label class="form-check-label" for="themeDefault">
              <img src="theme/images/Tak berjudul20_20240608002134.png" alt="Default Tema" class="img-thumbnail" style="width: 50%;"> Default Tema
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme1" value="theme1" <?php if ($theme == 'theme1') echo 'checked'; ?>>
            <label class="form-check-label" for="theme1">
              <img src="theme/images/Tak berjudul20_20240608002241.png" alt="Biru & Biru Langit" class="img-thumbnail" style="width: 50%;"> Biru & Biru Langit
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme2" value="theme2" <?php if ($theme == 'theme2') echo 'checked'; ?>>
            <label class="form-check-label" for="theme2">
              <img src="theme/images/Tak berjudul20_20240608002352.png" alt="Orange & Kuning" class="img-thumbnail" style="width: 50%;"> Orange & Kuning
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme3" value="theme3" <?php if ($theme == 'theme3') echo 'checked'; ?>>
            <label class="form-check-label" for="theme3">
              <img src="theme/images/Tak berjudul20_20240608002447.png" alt="Hijau & Hijau Muda" class="img-thumbnail" style="width: 50%;"> Hijau & Hijau Muda
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme4" value="theme4" <?php if ($theme == 'theme4') echo 'checked'; ?>>
            <label class="form-check-label" for="theme4">
              <img src="theme/images/Tak berjudul20_20240608002529.png" alt="Merah & Merah Muda" class="img-thumbnail" style="width: 50%;"> Merah & Merah Muda
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="theme" id="theme5" value="theme5" <?php if ($theme == 'theme5') echo 'checked'; ?>>
            <label class="form-check-label" for="theme5">
              <img src="theme/images/Tak berjudul20_20240608002628.png" alt="Ungu & Lavender" class="img-thumbnail" style="width: 50%;"> Ungu & Lavender
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-success" data-bs-dismiss="modal">Ubah Tema</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Scrollable -->

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
  <!-- <script src="js/demo/chart-area-demo.js"></script> -->
  <script src="js/ruang-admin.min.js"></script>

  <script src="js/image.js"></script>
  <script src="js/navbar.js"></script>
  <script src="js/bootstrap.js"></script>

  <script>
    document.getElementById('show-password').addEventListener('change', function() {
      var passwordInput = document.getElementById('password');
      if (this.checked) {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  </script>

  <script>
    // Add event listener to the Username input field
    $('#username').on('input', function() {
      var username = $(this).val();
      // Convert to lowercase and remove spaces
      username = username.toLowerCase().replace(/\s+/g, '');
      $(this).val(username);
    });
  </script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

  <script src="js/qrcode.js"></script>
  <script src="js/qrcode.min.js"></script>

</body>

</html>