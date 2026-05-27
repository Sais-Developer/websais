<?php
require("../konek/koneksi.php"); 

$ids      = $_POST['ids'] ?? '';
$tanggal  = date('Y-m-d');

function compressImage($source, $destination, $quality) { 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime'];  

    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            return false; 
    }

    imagejpeg($image, $destination, $quality); 
    imagedestroy($image);
    return $destination;
}

$uploadPath = "../images/fotopkl/";

if (!is_dir($uploadPath)) {
    if (!mkdir($uploadPath, 0777, true)) {
        echo json_encode(['status'=>'error', 'message'=>'Gagal membuat folder upload']);
        exit;
    }
}

if (!empty($_FILES["file"]["name"])) {

    $ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    $allowTypes = ['jpg','png','jpeg','gif'];

    if (in_array($ext, $allowTypes)) {

        $fileName = $ids . '-' . time() . '.' . $ext;
        $imageUploadPath = $uploadPath . $fileName;

        $imageTemp = $_FILES["file"]["tmp_name"];
        $compressedImage = compressImage($imageTemp, $imageUploadPath, 50);

        if ($compressedImage) {

            $sql = "UPDATE pkl_jurnal 
                    SET foto_jurnal = :foto 
                    WHERE idsiswa = :idsiswa AND tanggal = :tanggal";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':foto'     => $fileName,
                ':idsiswa'  => $ids,
                ':tanggal'  => $tanggal
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status'=>'success', 'message'=>'Foto berhasil diupdate']);
            } else {
                echo json_encode(['status'=>'error', 'message'=>'Tidak ada data yang diupdate']);
            }

        } else {
            echo json_encode(['status'=>'error', 'message'=>'Gagal mengompres gambar']);
        }

    } else {
        echo json_encode(['status'=>'error', 'message'=>'Tipe file tidak diperbolehkan']);
    }

} else {
    echo json_encode(['status'=>'error', 'message'=>'File tidak ditemukan']);
}
?>
