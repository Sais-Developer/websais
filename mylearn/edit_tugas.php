<?php
require("../konek/koneksi.php"); 

$id          = $_POST['id'];
$id_mapel    = $_POST['mapel'];
$guru        = $_POST['guru'];
$tugas       = $_POST['isitugas'];
$judul       = $_POST['judul'];
$tgl_mulai   = $_POST['tgl_mulai'];
$tgl_selesai = $_POST['tgl_selesai'];
$kelas       = serialize($_POST['kelas']);

$allowed_ext = ['jpg', 'png', 'docx', 'pdf', 'xlsx'];
$file        = null;

$upload_dir = '../tugas/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES['file']['name'])) {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        die("Ekstensi file tidak didukung");
    }

    $path = $upload_dir . $file;
    if (!move_uploaded_file($temp, $path)) {
        die("Gagal upload file");
    }

    $sql = "UPDATE tugas SET 
                mapel = ?, 
                guru = ?, 
                kelas = ?, 
                judul = ?, 
                tugas = ?, 
                tgl_mulai = ?, 
                tgl_selesai = ?, 
                file = ?
            WHERE id_tugas = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_mapel, $guru, $kelas, $judul, $tugas, $tgl_mulai, $tgl_selesai, $file, $id]);

} else {
    $sql = "UPDATE tugas SET 
                mapel = ?, 
                guru = ?, 
                kelas = ?, 
                judul = ?, 
                tugas = ?, 
                tgl_mulai = ?, 
                tgl_selesai = ?
            WHERE id_tugas = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_mapel, $guru, $kelas, $judul, $tugas, $tgl_mulai, $tgl_selesai, $id]);
}

echo "OK";
?>
