<?php
require("../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg == 'tambah') {
    $tgl    = $_POST['tgl'];
    $guru   = $_POST['guru'];
    $keterangan  = $_POST['keterangan'];
    $kegiatan  = $_POST['kegiatan'];
   
    $hari   = date('D', strtotime($tgl));
    $bulan  = date('m', strtotime($tgl));
    $tahun  = date('Y', strtotime($tgl));


    $data = [
        'hari'    => $hari,
        'tanggal' => $tgl,
        'kegiatan'   => $kegiatan,
        'keterangan'   => $keterangan,
        'bulan'   => $bulan,
        'tahun'   => $tahun,
		'guru'   => $guru,
    ];

        $fields = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));
        $stmt = $pdo->prepare("INSERT INTO agenda ($fields) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
    
}

if ($pg == 'edit') {
    $id     = $_POST['id'];
    $tgl    = $_POST['tgl'];
    $guru   = $_POST['guru'];
    $keterangan  = $_POST['keterangan'];
    $kegiatan  = $_POST['kegiatan'];

    $hari   = date('D', strtotime($tgl));
    $bulan  = date('m', strtotime($tgl));
    $tahun  = date('Y', strtotime($tgl));


    $data = [
        'hari'    => $hari,
        'tanggal' => $tgl,
        'kegiatan'   => $kegiatan,
        'keterangan'   => $keterangan,
        'bulan'   => $bulan,
        'tahun'   => $tahun,
		'guru'   => $guru,
    ];

    $set = implode(", ", array_map(fn($k) => "$k = ?", array_keys($data)));
    $stmt = $pdo->prepare("UPDATE agenda SET $set WHERE id = ?");
    $stmt->execute([...array_values($data), $id]);
}

if ($pg == 'hapus') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM agenda WHERE id = ?");
    $stmt->execute([$id]);
}

if ($pg == 'jurnal') {
    $id     = $_POST['id'];
    $hambat = $_POST['hambat'];
    $pecah  = $_POST['pecah'];

    $stmt = $pdo->prepare("UPDATE agenda SET hambatan = ?, pemecahan = ? WHERE id = ?");
    $stmt->execute([$hambat, $pecah, $id]);
}
