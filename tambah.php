<?php
require("konek/koneksi.php");
require("konek/function.php");
require("konek/crud.php");

$domain = $_SERVER['HTTP_HOST'];
$licenseFile = __DIR__ . "/assets/plugins/backup/license.key";

if (!is_dir(__DIR__ . "/assets/plugins/backup")) {
    mkdir(__DIR__ . "/assets/plugins/backup", 0777, true);
}
$toastMessage = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = trim($_POST['serial']);

    function format_serial_grouped($s, $group = 4, $sep = '-') {
        $s = preg_replace('/[^A-F0-9]/i', '', $s);
        $parts = str_split($s, $group);
        return implode($sep, $parts);
    }

    function normalize_serial($s) {
        return strtoupper(str_replace(['-', ' '], '', $s));
    }

    function generateSerialRaw($domain) {
        return strtoupper(substr(sha1($domain), 0, 16));
    }

    function isSerialValidForDomain($inputSerial, $domain) {
        $input_raw = normalize_serial($inputSerial);
        $expected_raw = generateSerialRaw($domain);
        return ($input_raw === $expected_raw);
    }

    if (isSerialValidForDomain($user_input, $domain)) {
        $raw = generateSerialRaw($domain);
        $grouped = format_serial_grouped($raw);
        $expired = date("Y-m-d", strtotime("+1 year"));
        $data = ['domain'=>$domain, 'serial'=>$grouped, 'expired'=>$expired];
        file_put_contents($licenseFile, json_encode($data));

        $toastMessage = "<script>
            iziToast.success({
            title: 'Sukses',
			message: 'Aktivasi Berhasil',
			titleColor: '#FFFF00',
			messageColor: '#fff',
			backgroundColor: 'rgba(0, 0, 0, 0.5)',
			progressBarColor: '#FFFF00',
			position: 'topRight'
            });
            setTimeout(function(){ window.location='login.php'; }, 1500);
        </script>";

    } else {
        $toastMessage = "<script>
            iziToast.info(
			{
			title: 'Gagal',
			message: 'Serial Number Tidak Benar',
			titleColor: '#FFFF00',
			messageColor: '#fff',
			backgroundColor: 'rgba(0, 0, 0, 0.5)',
			progressBarColor: '#FFFF00',
			position: 'topRight'				  
			});
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AKTIVASI</title>
  <link href="<?= $baseurl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet' href="<?= $baseurl ?>/siswa/login.css">
  <link rel='stylesheet' href="<?= $baseurl ?>/assets/izitoast/css/iziToast.min.css">
  <script src="<?= $baseurl ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/images/login.png">
</head>
<body>

<div class="login-container">
  <div class="login-card">
    <img src="images/login.png" alt="Logo" class="logo-form">
    <h5 class="form-title">AKTIVASI SANDIK</h5>
	<p style="color:red">Lisensi Sudah Expired, Silahkan Aktivasi Kembali</p>
    <form method="post">
      <div class="mb-3 text-start">
        <label class="form-label">Domain</label>
        <input type="text" class="form-control" value="<?=htmlspecialchars($domain)?>" readonly>
      </div>
      <div class="mb-3 text-start">
        <label class="form-label">Serial Number</label>
        <input type="text" name="serial" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-login w-100 py-2" style="color:white">AKTIVASI</button>
    </form>
    <p class="small-muted">© <?= date('Y') ?> Sistem Aplikasi Pendidik - Sandik</p>

   <script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src='<?= $baseurl; ?>/assets/izitoast/js/iziToast.min.js'></script>
    <?= $toastMessage ?> 
  </div>
</div>
</body>
</html>
