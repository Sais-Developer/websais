<?php
require("../konek/koneksi.php"); 
require("../konek/function.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'edit') {
    $ids = $_POST['id'] ?? '';
    if ($ids !== '') {
        $data = [
            'nopes'    => $_POST['nopes'] ?? '',
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'ruang'    => $_POST['ruang'] ?? '',
            'sesi'     => $_POST['sesi'] ?? '',
            'blok'     => $_POST['blok'] ?? '',
            'nama'     => $_POST['nama'] ?? ''
        ];
        $fields = array_keys($data);
        $setStr = implode(", ", array_map(fn($f) => "$f = :$f", $fields));
        $sql = "UPDATE siswa SET $setStr WHERE id_siswa = :id_siswa";

        $stmt = $pdo->prepare($sql);
        $data['id_siswa'] = $ids;
        $stmt->execute($data);
    }
}
?>
