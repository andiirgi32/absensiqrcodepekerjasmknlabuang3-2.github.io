<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/sweetalert.css">
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <link rel="icon" href="logo/smkn_labuang.png">
</head>

<body>

</body>

</html>
<?php

include "koneksi.php";
session_start();

$idpekerja = $_POST['idpekerja'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jabatanid = $_POST['jabatanid'];
$pangkatid = $_POST['pangkatid'];
$jk = $_POST['jk'];
$outprintid = $_POST['outprintid'];

if ($_FILES['fotopekerja']['name'] != "") {
  $rand = rand();
  $ekstensi = array("png", "jpg", "jpeg", "gif");
  $namafile = $_FILES['fotopekerja']['name'];
  $ukuran = $_FILES['fotopekerja']['size'];
  $ext = pathinfo($namafile, PATHINFO_EXTENSION);

  if (!in_array($ext, $ekstensi)) {
    echo "<script type='text/javascript'>
        setTimeout(function () { 
          swal({
                  title: 'Data Gagal Diubah',
                  text:  'Silahkan Coba Lagi!',
                  type: 'error',
                  timer: 3000,
                  showConfirmButton: true
              });   
        });  
        window.setTimeout(function(){ 
          window.history.go(-1);
        } ,900); 
        </script>";
  } else {
    if ($ukuran < 204488000) {
      $sql = mysqli_query($conn, "SELECT fotopekerja FROM pekerja where idpekerja='$idpekerja'");
      $data = mysqli_fetch_array($sql);
      $fotopekerja = $data['fotopekerja'];
      unlink("fotopekerja/$fotopekerja");

      $xx = $rand . '_' . $namafile;
      move_uploaded_file($_FILES['fotopekerja']['tmp_name'], 'fotopekerja/' . $rand . '_' . $namafile);
      mysqli_query($conn, "UPDATE pekerja SET nip='$nip', nama='$nama', fotopekerja='$xx', jabatanid='$jabatanid', pangkatid='$pangkatid', jk='$jk', outprintid='$outprintid' where idpekerja='$idpekerja'");
      echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Data Berhasil Diubah',
                        text:  'Data Segera Ditampilkan!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
              });  
              window.setTimeout(function(){ 
                window.history.go(-1);
              } ,900); 
              </script>";
    } else {
      echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Ukuran Gambar Terlalu Besar',
                        text:  'Silahkan Cari Gambar Lain Atau Perkecil Size Gambar!',
                        type: 'warning',
                        timer: 3000,
                        showConfirmButton: true
                    });   
              });  
              window.setTimeout(function(){ 
                window.history.go(-1);
              } ,900); 
              </script>";
    }
  }
} else {
  mysqli_query($conn, "UPDATE pekerja SET nip='$nip', nama='$nama', jabatanid='$jabatanid', pangkatid='$pangkatid', jk='$jk', outprintid='$outprintid' where idpekerja='$idpekerja'");
  echo "<script type='text/javascript'>
              setTimeout(function () { 
                swal({
                        title: 'Data Berhasil Diubah',
                        text:  'Data Segera Ditampilkan!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    });   
              });  
              window.setTimeout(function(){ 
                window.history.go(-1);
              } ,900); 
              </script>";
}
?>