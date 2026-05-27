<?php
require("../konek/koneksi.php"); // $db = PDO

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $idw = intval($_POST['id'] ?? 0);
    
    $stmt = $db->prepare("DELETE FROM waktu WHERE id = ?");
    $stmt->execute([$idw]);

    if ($stmt->rowCount() > 0) {
        // Reset urutan ID
        $hasil = $db->query("SELECT id FROM waktu ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
        $no = 1;
        foreach ($hasil as $data) {
            $id = intval($data['id']);
            $stmt2 = $db->prepare("UPDATE waktu SET id=? WHERE id=?");
            $stmt2->execute([$no, $id]);
            $no++;
        }
        $db->exec("ALTER TABLE waktu AUTO_INCREMENT = $no");
    }
}

if ($pg == 'tambah' || $pg == 'edit') {
    $hari = trim($_POST['hari'] ?? '');
    $jam_bunyi_raw = $_POST['jam'] ?? [];
    $jam_bunyi = [];

    foreach ($jam_bunyi_raw as $j) {
        $j = trim($j);
        $jam_bunyi[] = $j ? date('H:i', strtotime($j)) : null;
    }

    $jam1 = $jam_bunyi[0] ?? null;
    $jam2 = $jam_bunyi[1] ?? null;
    $jam3 = $jam_bunyi[2] ?? null;
    $jam4 = $jam_bunyi[3] ?? null;
    $jam5 = $jam_bunyi[4] ?? null;

    if ($pg == 'tambah') {
        $stmt = $db->prepare("
            INSERT INTO waktu 
            (hari, masuk, pulang, masuk_eskul, pulang_eskul, alpha)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $success = $stmt->execute([$hari, $jam1, $jam3, $jam4, $jam5, $jam2]);
    } elseif ($pg == 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $stmt = $db->prepare("
            UPDATE waktu 
            SET hari=?, masuk=?, pulang=?, masuk_eskul=?, pulang_eskul=?, alpha=? 
            WHERE id=?
        ");
        $success = $stmt->execute([$hari, $jam1, $jam3, $jam4, $jam5, $jam2, $id]);
    }

    echo $success ? "Data berhasil disimpan." : "Gagal menyimpan data.";
}

if ($pg == 'mesin') {
    $id = 1;
    $jam = $_POST['jam'].':00' ?? '';
    $mesin = $_POST['mesin'] ?? '';

    $stmt = $db->prepare("UPDATE pengaturan SET mesin=?, notif=? WHERE id_aplikasi=?");
    $stmt->execute([$mesin, $jam, $id]);
}
?>
