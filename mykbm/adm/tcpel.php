<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';
 
if ($pg == 'tambah') {

    $idcp  = intval($_POST['idlingkup']);
    $elemen = $_POST['elemen'];
    $cp     = $_POST['cp'];

    $sql = "INSERT INTO cp_elemen (id_lingkup, elemen, capaian, semester)
            VALUES (?, ?, ?, ?)";
    $stmtIns = $pdo->prepare($sql);
    $stmtIns->execute([$idcp, $elemen, $cp, $semester]);
}

if ($pg == 'edit') {

    $idel   = intval($_POST['idel']);
    $elemen = $_POST['elemen'];
    $cp     = $_POST['cp'];

    $sql = "UPDATE cp_elemen 
            SET elemen = ?, capaian = ?
            WHERE id_elemen = ?";
    $stmtUpd = $pdo->prepare($sql);
    $stmtUpd->execute([$elemen, $cp, $idel]);
}

if ($pg == 'hapus') {

    $idu = intval($_POST['id']);
    $stmtDel = $pdo->prepare("DELETE FROM cp_elemen WHERE id_elemen = ?");
    $exec = $stmtDel->execute([$idu]);

    if ($exec) {

        $hasil = $pdo->query("SELECT id_elemen FROM cp_elemen ORDER BY id_elemen")
                     ->fetchAll(PDO::FETCH_ASSOC);

        $no = 1;
        $stmtUpd = $pdo->prepare("UPDATE cp_elemen SET id_elemen = ? WHERE id_elemen = ?");

        foreach ($hasil as $data) {
            $oldId = $data['id_elemen'];
            $stmtUpd->execute([$no, $oldId]);
            $no++;
        }
        $stmtAlter = $pdo->prepare("ALTER TABLE cp_elemen AUTO_INCREMENT = ?");
        $stmtAlter->execute([$no]);
    }
}
?>
