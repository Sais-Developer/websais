<?php
require("../../konek/koneksi.php"); // $db = PDO
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';
$dirFoto = "../../images/fotoguru/";
if (!is_dir($dirFoto)) mkdir($dirFoto, 0777, true);

if ($pg == 'tambah') {
    $username = $_POST['username'] ?? '';
    $nama     = $_POST['nama'] ?? '';
    $password = $_POST['password'] ?? '';
    $nowa     = $_POST['nowa'] ?? '';

    $cek = select("guru", ["username" => $username], null, 1);
    if (!empty($cek)) {
        echo "gagal"; 
        exit;
    }

    $foto = '';
    $ektensi = ['jpg','jpeg','png'];
    if (!empty($_FILES['file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $ektensi)) {
            $foto = uniqid("staff_") . "." . $ext;
            move_uploaded_file($_FILES['file']['tmp_name'], $dirFoto . $foto);
        }
    }

    insert("guru", [
        "username" => $username,
        "nama"     => $nama,
        "level"    => "staff",
        "jabatan"  => "Staff",
        "nowa"     => $nowa,
        "password" => $password,
        "foto"     => $foto
    ]);

    echo "OK";
}

if ($pg == 'edit') {
    $id_guru  = $_POST['idguru'] ?? '';
    $nama     = $_POST['nama'] ?? '';
    $password = $_POST['password'] ?? '';
    $nowa     = $_POST['nowa'] ?? '';

    update("guru", [
        "nama"     => $nama,
        "password" => $password,
        "nowa"     => $nowa
    ], ["id_guru" => $id_guru]);

    $ektensi = ['jpg','jpeg','png'];
    if (!empty($_FILES['file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $ektensi)) {
            $foto = uniqid("staff_") . "." . $ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $dirFoto . $foto)) {
                update("guru", ["foto" => $foto], ["id_guru" => $id_guru]);
            }
        }
    }
}
?>
