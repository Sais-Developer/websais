<?php
require("../konek/koneksi.php");

$id       = $_POST['id'];
$id_mapel = $_POST['mapel'];
$guru     = $_POST['guru'];
$materi   = $_POST['isimateri'];
$judul    = $_POST['judul'];
$sampai   = $_POST['sampai'];
$youtube  = $_POST['youtube'];
$kelas    = serialize($_POST['kelas']);

$allowed_ext = ['jpg', 'png', 'docx', 'pdf', 'xlsx'];
$file = null;
$upload_dir = '../materi/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES['file']['name'])) {
    $file_name = $_FILES['file']['name'];
    $temp      = $_FILES['file']['tmp_name'];
    $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        exit("Ekstensi file tidak didukung");
    }

    $target_path = $upload_dir . $file_name;

    if (!move_uploaded_file($temp, $target_path)) {
        exit("Gagal upload file");
    }

    $query = "UPDATE materi SET 
                mapel = :mapel, 
                kelas = :kelas, 
                guru = :guru, 
                judul = :judul, 
                isimateri = :isimateri, 
                sampai = :sampai, 
                youtube = :youtube, 
                file = :file
              WHERE idm = :idm";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':mapel'    => $id_mapel,
        ':kelas'    => $kelas,
        ':guru'     => $guru,
        ':judul'    => $judul,
        ':isimateri'=> $materi,
        ':sampai'   => $sampai,
        ':youtube'  => $youtube,
        ':file'     => $file_name,
        ':idm'      => $id
    ]);
} else {
    $query = "UPDATE materi SET 
                mapel = :mapel, 
                kelas = :kelas, 
                guru = :guru, 
                judul = :judul, 
                isimateri = :isimateri, 
                sampai = :sampai, 
                youtube = :youtube
              WHERE idm = :idm";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':mapel'    => $id_mapel,
        ':kelas'    => $kelas,
        ':guru'     => $guru,
        ':judul'    => $judul,
        ':isimateri'=> $materi,
        ':sampai'   => $sampai,
        ':youtube'  => $youtube,
        ':idm'      => $id
    ]);
}

echo "OK";
?>
