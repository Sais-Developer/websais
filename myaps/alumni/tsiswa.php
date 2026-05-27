<?php
require("../../konek/koneksi.php");  

$pg = $_GET['pg'] ?? '';
$dirFoto = "../../images/fotoalumni/";

if (!is_dir($dirFoto)) mkdir($dirFoto, 0777, true);

function uploadFoto($field, $dir)
{
    if (empty($_FILES[$field]['name'])) return false;

    $allowed = ['jpg','jpeg','png'];
    $file    = $_FILES[$field];
    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) return false;

    $new  = uniqid("alumni_") . "." . $ext;
    $dest = $dir . $new;

    return move_uploaded_file($file['tmp_name'], $dest) ? $new : false;
}

if ($pg == 'edit') {

    $id_alumni = $_POST['id'] ?? '';
    $sql = "UPDATE alumni 
            SET tahun_masuk = :tahun_masuk,
                nowa = :nowa, status = :status, nama_instansi = :nama_instansi
            WHERE id_alumni = :id_alumni";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tahun_masuk' => $_POST['masuk'] ?? '',
        ':nowa'        => $_POST['nowa'] ?? '',
		':status'        => $_POST['status'] ?? '',
		':nama_instansi' => $_POST['instansi'] ?? '',
        ':id_alumni'          => $id_alumni
    ]);

    /* --------- UPLOAD FOTO BARU ---------- */
    if ($fotoBaru = uploadFoto('file', $dirFoto)) {

        // Ambil data lama
        $stmtOld = $pdo->prepare("SELECT foto FROM alumni WHERE id_alumni = :id");
        $stmtOld->execute([':id' => $id]);
        $old = $stmtOld->fetch(PDO::FETCH_ASSOC);

        // Hapus foto lama
        if (!empty($old['foto']) && is_file($dirFoto . $old['foto'])) {
            unlink($dirFoto . $old['foto']);
        }

        // Update foto baru
        $stmtFoto = $pdo->prepare("UPDATE alumni SET foto = :foto WHERE id_alumni = :id");
        $stmtFoto->execute([
            ':foto' => $fotoBaru,
            ':id'   => $id
        ]);
    }

    echo "ok";
    exit;
}

?>
