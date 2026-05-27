<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';

    $stmt = $koneksi->prepare("DELETE FROM pengumuman WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' untuk integer
    $stmt->execute();
    $stmt->close();
}

if ($pg == 'simpan') {
    $judul = $_POST['judul'] ?? '';
    $isi = $_POST['isi'] ?? '';

    $stmt = $koneksi->prepare("INSERT INTO pengumuman (judul, isi) VALUES (?, ?)");
    $stmt->bind_param("ss", $judul, $isi); // 'ss' untuk 2 string
    $stmt->execute();
    $stmt->close();
}
