<?php
require("../konek/koneksi.php");

$id_tugas  = $_POST['id_tugas'];
$id_siswa  = $_POST['id_siswa'];
$jawaban   = $_POST['jawaban']; 
$kelas     = $_POST['kelas'];
$mapel     = $_POST['mapel'];
$datetime  = date('Y-m-d H:i:s');

$file = null;

if (!empty($_FILES['file']['name'])) {
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $id_tugas . '_' . $id_siswa . '.' . $ext;
    $upload_path = '../tugas/' . $file;

    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
        echo "Gagal upload file";
        exit;
    }
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM jawaban_tugas WHERE id_siswa = :id_siswa AND id_tugas = :id_tugas");
$stmt->execute([':id_siswa' => $id_siswa, ':id_tugas' => $id_tugas]);
$count = $stmt->fetchColumn();

if ($count == 0) {
   
    if ($file !== null) {
        $query = "INSERT INTO jawaban_tugas 
                  (id_tugas, id_siswa, kelas, mapel, jawaban, tgl_dikerjakan, file) 
                  VALUES (:id_tugas, :id_siswa, :kelas, :mapel, :jawaban, :tgl_dikerjakan, :file)";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([
            ':id_tugas' => $id_tugas,
            ':id_siswa' => $id_siswa,
            ':kelas' => $kelas,
            ':mapel' => $mapel,
            ':jawaban' => $jawaban,
            ':tgl_dikerjakan' => $datetime,
            ':file' => $file
        ]);
    } else {
        $query = "INSERT INTO jawaban_tugas 
                  (id_tugas, id_siswa, kelas, mapel, jawaban, tgl_dikerjakan) 
                  VALUES (:id_tugas, :id_siswa, :kelas, :mapel, :jawaban, :tgl_dikerjakan)";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([
            ':id_tugas' => $id_tugas,
            ':id_siswa' => $id_siswa,
            ':kelas' => $kelas,
            ':mapel' => $mapel,
            ':jawaban' => $jawaban,
            ':tgl_dikerjakan' => $datetime
        ]);
    }

    echo $success ? "1" : "Gagal insert";
} else {
   
    if ($file !== null) {
        $query = "UPDATE jawaban_tugas 
                  SET kelas = :kelas, mapel = :mapel, jawaban = :jawaban, tgl_dikerjakan = :tgl_dikerjakan, file = :file 
                  WHERE id_siswa = :id_siswa AND id_tugas = :id_tugas";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([
            ':kelas' => $kelas,
            ':mapel' => $mapel,
            ':jawaban' => $jawaban,
            ':tgl_dikerjakan' => $datetime,
            ':file' => $file,
            ':id_siswa' => $id_siswa,
            ':id_tugas' => $id_tugas
        ]);
    } else {
        $query = "UPDATE jawaban_tugas 
                  SET kelas = :kelas, mapel = :mapel, jawaban = :jawaban, tgl_dikerjakan = :tgl_dikerjakan 
                  WHERE id_siswa = :id_siswa AND id_tugas = :id_tugas";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([
            ':kelas' => $kelas,
            ':mapel' => $mapel,
            ':jawaban' => $jawaban,
            ':tgl_dikerjakan' => $datetime,
            ':id_siswa' => $id_siswa,
            ':id_tugas' => $id_tugas
        ]);
    }

    echo $success ? "1" : "Gagal update";
}
?>
