<?php
require("../konek/koneksi.php");
require("../konek/crud.php");

$bulan = $_POST['bulan'] ?? '';

if ($bulan !== '') {
    $exec = delete('absensi', ['bulan' => $bulan]);
	$exec = delete('absensi_les', ['bulan' => $bulan]);
    echo $exec ? "1" : "0"; 
} else {
    echo "0"; 
}
