<?php
session_start();
require("konek/koneksi.php");
require("konek/dis.php");

$id_siswa = $_SESSION['id_siswa'] ?? 0;

if ($id_siswa > 0) {
    $id_siswa = intval($id_siswa);
    
    $stmt = $pdo->prepare("UPDATE siswa SET online = 0 WHERE id_siswa = ?");
    $stmt->execute([$id_siswa]);
}

if (isset($_SESSION['soal_acak'])) {
    unset($_SESSION['soal_acak']); 
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

echo "<script>location.href='.';</script>";
exit;
?>
