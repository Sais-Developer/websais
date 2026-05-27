<?php
require("../../konek/koneksi.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';
$dirFoto = "../../images/fotosiswa/";

if (!is_dir($dirFoto)) mkdir($dirFoto, 0777, true);
function uploadFoto($field, $dir)
{
    if (empty($_FILES[$field]['name'])) return false;
    $allowed = ['jpg','jpeg','png'];
    $file    = $_FILES[$field];
    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) return false;
    $new  = uniqid("siswa_") . "." . $ext;
    $dest = $dir . $new;
    return move_uploaded_file($file['tmp_name'], $dest) ? $new : false;
}

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';
    $cekFK = select("presensi", ["id_siswa" => $id]);
    if (!empty($cekFK)) {
        echo "gagal: data digunakan di presensi!";
        exit;
    }
    $cekFK2 = select("nilai", ["id_siswa" => $id]);
    if (!empty($cekFK2)) {
        echo "gagal: data digunakan di nilai!";
        exit;
    }
    $old = fetch("siswa", ['id_siswa' => $id]);

    if (!empty($old['foto'])) {

        $filePath = $dirFoto . $old['foto'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    delete("siswa", ['id_siswa' => $id]);

    echo "ok";
    exit;
}


if ($pg == 'edit') {
    $id = $_POST['id'] ?? '';
    $data = [
        'nis'   => $_POST['nis'] ?? '',
        'nisn'  => $_POST['nisn'] ?? '',
        'nama'  => $_POST['nama'] ?? '',
        'jk'    => $_POST['jk'] ?? '',
        'agama' => $_POST['agama'] ?? '',
        'kelas' => $_POST['kelas'] ?? '',
        'nowa'  => $_POST['nowa'] ?? ''
    ];

    update("siswa", $data, ['id_siswa' => $id]);
    if ($fotoBaru = uploadFoto('file', $dirFoto)) {
        $old = fetch("siswa", ['id_siswa' => $id]);
        if (!empty($old['foto']) && is_file($dirFoto . $old['foto'])) {
            unlink($dirFoto . $old['foto']);
        }
        update("siswa", ['foto' => $fotoBaru], ['id_siswa' => $id]);
    }
    echo "ok";
    exit;
}

if ($pg == 'tambah') {
    $data = [
        'nis'   => $_POST['nis'] ?? '',
        'nisn'  => $_POST['nisn'] ?? '',
        'nama'  => $_POST['nama'] ?? '',
        'jk'    => $_POST['jk'] ?? '',
        'agama' => $_POST['agama'] ?? '',
        'kelas' => $_POST['kelas'] ?? '',
        'nowa'  => $_POST['nowa'] ?? ''
    ];
    $ok = insert("siswa", $data);
    global $db;
    $last_id = $db->lastInsertId();
    if ($fotoBaru = uploadFoto('file', $dirFoto)) {
        update("siswa", ['foto' => $fotoBaru], ['id_siswa' => $last_id]);
    }
    echo "ok";
    exit;
}

if ($pg == 'jurusan') {
    update("m_kelas",
        [
            'pk' => $_POST['pk'] ?? '',
            'bk' => $_POST['bk'] ?? '',
            'kk' => $_POST['kk'] ?? ''
        ],
        ['jurusan' => $_POST['id'] ?? '']
    );

    echo "ok";
    exit;
}
