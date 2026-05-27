<?php
error_reporting(0);

$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/", trim($uri, "/"));

// nama folder aplikasi
$app_folder = "data";

$baseurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $app_folder;

// buang nama folder dari URL
if (isset($pageurl[0]) && $pageurl[0] === $app_folder) {
    array_shift($pageurl);
}

$pg = $pageurl[0] ?? '';
$ac = $pageurl[1] ?? '';
$id = $pageurl[2] ?? 0;

$host     = 'localhost';
$username = 'root';
$password = '';
$database = 'cbt';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    $db = $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pengaturan WHERE id_aplikasi = ? LIMIT 1");
    $stmt->execute([1]);
    $setting = $stmt->fetch();

    if (!empty($setting['waktu'])) {
        date_default_timezone_set($setting['waktu']);
    } else {
        date_default_timezone_set("Asia/Jakarta");
    }

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

$semester = $setting['semester'] ?? '';
$tapel    = $setting['tp'] ?? '';
$tanggal  = date('Y-m-d');
$waktumu  = date('Y-m-d H:i:s');
$bulan    = date('m');
$tahun    = date('Y');