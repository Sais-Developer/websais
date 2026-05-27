<?php
require("../konek/koneksi.php"); 

$id_mapel   = $_POST['mapel'];
$guru       = $_POST['guru'];
$tugas      = $_POST['isitugas'];
$judul      = $_POST['judul'];
$tgl_mulai  = $_POST['tgl_mulai'];
$tgl_selesai= $_POST['tgl_selesai'];
$kelas      = serialize($_POST['kelas']);

$allowed_ext = ['jpg', 'png', 'jpeg', 'docx', 'pdf', 'xlsx', 'pptx', 'ppt', 'doc', 'mp4', '3gp'];
$file = null;

$upload_dir = '../tugas/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES['file']['name'])) {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        exit("Ekstensi tidak diizinkan");
    }

    $path = $upload_dir . $file;
    if (!move_uploaded_file($temp, $path)) {
        exit("Gagal upload file");
    }
}

try {
    if ($file) {
        $sql = "INSERT INTO tugas (mapel, kelas, guru, judul, tugas, tgl_mulai, tgl_selesai, file)
                VALUES (:mapel, :kelas, :guru, :judul, :tugas, :tgl_mulai, :tgl_selesai, :file)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mapel'      => $id_mapel,
            ':kelas'      => $kelas,
            ':guru'       => $guru,
            ':judul'      => $judul,
            ':tugas'      => $tugas,
            ':tgl_mulai'  => $tgl_mulai,
            ':tgl_selesai'=> $tgl_selesai,
            ':file'       => $file
        ]);
    } else {
        $sql = "INSERT INTO tugas (mapel, kelas, guru, judul, tugas, tgl_mulai, tgl_selesai)
                VALUES (:mapel, :kelas, :guru, :judul, :tugas, :tgl_mulai, :tgl_selesai)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mapel'      => $id_mapel,
            ':kelas'      => $kelas,
            ':guru'       => $guru,
            ':judul'      => $judul,
            ':tugas'      => $tugas,
            ':tgl_mulai'  => $tgl_mulai,
            ':tgl_selesai'=> $tgl_selesai
        ]);
    }

    echo "OK";

} catch (PDOException $e) {
    echo "Gagal menyimpan: " . $e->getMessage();
}
