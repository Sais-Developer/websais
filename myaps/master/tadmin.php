<?php
require("../../konek/koneksi.php"); // $db = PDO
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';
$dirFoto = "../../images/fotoguru/";
if (!is_dir($dirFoto)) mkdir($dirFoto, 0777, true);

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';
    if ($id) {
        $user = select("users", ["id_user" => $id], 1);
        if (!empty($user['foto']) && is_file($dirFoto . $user['foto'])) {
            unlink($dirFoto . $user['foto']);
        }
        delete("users", ["id_user" => $id]);
    }
}

if ($pg == 'tambah') {
    $username = $_POST['username'] ?? '';
    $nama     = $_POST['nama'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $cek = select("users", ["username" => $username], 1);
    if ($cek) {
        echo "gagal";
    } else {
        $foto = '';
        $ektensi = ['jpg','jpeg','png'];
        if (!empty($_FILES['file']['name'])) {
            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $ektensi)) {
                $foto = uniqid("user_") . "." . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'], $dirFoto . $foto);
            }
        }
        insert("users", [
            "username" => $username,
            "nama"     => $nama,
            "level"    => "admin",
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "foto"     => $foto
        ]);
        echo "OK";
    }
}

if ($pg == 'edit') {
    $id_user = $_POST['iduser'] ?? '';
    $nama    = $_POST['nama'] ?? '';
    $password = $_POST['password'] ?? '';

    $update = ["nama" => $nama];
    if (!empty($password)) $update['password'] = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($id_user)) update("users", $update, ["id_user" => $id_user]);

    $ektensi = ['jpg','jpeg','png'];
    if (!empty($_FILES['file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $ektensi)) {
            $foto = uniqid("user_") . "." . $ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $dirFoto . $foto)) {
                update("users", ["foto" => $foto], ["id_user" => $id_user]);
            }
        }
    }
}
?>
