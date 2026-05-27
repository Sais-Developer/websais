<?php
require("../konek/koneksi.php"); 

$id_mapel = $_POST['mapel'];
$guru     = $_POST['guru'];
$materi   = htmlspecialchars($_POST['isimateri'], ENT_QUOTES, 'UTF-8');
$judul    = htmlspecialchars($_POST['judul'], ENT_QUOTES, 'UTF-8');
$sampai   = $_POST['sampai'];
$youtube  = htmlspecialchars($_POST['youtube'], ENT_QUOTES, 'UTF-8');
$kelas    = serialize($_POST['kelas']); 

$allowed_ext = ['jpg','png','jpeg','docx','pdf','xlsx','pptx','ppt','doc','mp4','3gp'];
$file = '';

$upload_dir = '../materi/';
if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

if (!empty($_FILES['file']['name'])) {
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) {
        echo "Ekstensi tidak diizinkan";
        exit;
    }
    $file = uniqid('materi_', true) . '.' . $ext;
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $file)) {
        echo "Gagal upload file";
        exit;
    }
}

try {
    $dari = date('Y-m-d');
    $stmt = $pdo->prepare("INSERT INTO materi (mapel, kelas, guru, judul, isimateri, dari, sampai, youtube, file) 
                           VALUES (:mapel, :kelas, :guru, :judul, :materi, :dari, :sampai, :youtube, :file)");
    
    $stmt->bindParam(':mapel', $id_mapel);
    $stmt->bindParam(':kelas', $kelas);
    $stmt->bindParam(':guru', $guru);
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':materi', $materi);
    $stmt->bindParam(':dari', $dari);
    $stmt->bindParam(':sampai', $sampai);
    $stmt->bindParam(':youtube', $youtube);
    $stmt->bindParam(':file', $file);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Gagal insert data: " . $errorInfo[2];
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
