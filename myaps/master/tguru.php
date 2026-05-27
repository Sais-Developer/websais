<?php
require("../../konek/koneksi.php"); // $db = PDO
require("../../konek/crud.php");  

$pg = $_GET['pg'] ?? '';
$dirFoto = "../../images/fotoguru/";
if (!is_dir($dirFoto)) mkdir($dirFoto, 0777, true);

function uploadFoto($field, $dir) {
    if (empty($_FILES[$field]['name'])) return false;
    $allowed = ['jpg','jpeg','png'];
    $file    = $_FILES[$field];
    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    $new     = uniqid("guru_") . "." . $ext;
    $dest    = $dir . $new;
    return move_uploaded_file($file['tmp_name'], $dest) ? $new : false;
}

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';
    if ($id) {
        $old = fetch("guru", ["id_guru" => $id]);
        if (!empty($old['foto']) && is_file($dirFoto . $old['foto'])) unlink($dirFoto . $old['foto']);
        delete("guru", ["id_guru" => $id]);
        echo "ok";
    }
}

if ($pg == 'tambah') {
    $data = [
        "nip"      => $_POST['nip'] ?? '',
        "nama"     => $_POST['nama'] ?? '',
        "jabatan"  => $_POST['jabatan'] ?? '',
        "username" => $_POST['username'] ?? '',
        "password" => $_POST['password'] ?? '',
        "nowa"     => $_POST['nowa'] ?? '',
        "walas"    => $_POST['walas'] ?? '',
        "level"    => "guru"
    ];
    $cek = select("guru", ["username" => $data['username']], null, 1);
    if (!empty($cek)) {
        echo "gagal";
        exit;
    }
    if ($foto = uploadFoto('file', $dirFoto)) $data['foto'] = $foto;

    echo insert("guru", $data) ? "OK" : "gagal";
}

if ($pg == 'edit') {
    $id = $_POST['idguru'] ?? '';
    $data = [
        "nip"     => $_POST['nip'] ?? '',
        "nama"    => $_POST['nama'] ?? '',
        "jabatan" => $_POST['jabatan'] ?? '',
        "walas"   => $_POST['walas'] ?? '',
        "password"=> $_POST['password'] ?? '',
        "nowa"    => $_POST['nowa'] ?? ''
    ];

    update("guru", $data, ["id_guru" => $id]);

    if ($foto = uploadFoto('file', $dirFoto)) {
        $old = fetch("guru", ["id_guru" => $id]);
        if (!empty($old['foto']) && is_file($dirFoto . $old['foto'])) unlink($dirFoto . $old['foto']);
        update("guru", ["foto" => $foto], ["id_guru" => $id]);
    }
}
