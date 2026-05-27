<?php
require("../konek/koneksi.php"); 
$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $idu = $_POST['id'] ?? 0;

    if ($idu) {
        // hapus data
        $stmt = $pdo->prepare("DELETE FROM bell WHERE id = :id");
        $exec = $stmt->execute(['id' => $idu]);

        if ($exec) {
            $stmt = $pdo->query("SELECT id FROM bell ORDER BY id");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $no = 1;
            foreach ($rows as $row) {
                $old_id = $row['id'];
                $upd = $pdo->prepare("UPDATE bell SET id = :new_id WHERE id = :old_id");
                $upd->execute([
                    'new_id' => $no,
                    'old_id' => $old_id
                ]);
                $no++;
            }
            $pdo->query("ALTER TABLE bell AUTO_INCREMENT = $no");
        }
    }
}

if ($pg == 'tambah') {

    $stmt = $pdo->prepare("
        INSERT INTO bell (hari, jam, nada)
        VALUES (:hari, :jam, :nada)
    ");

    $exec = $stmt->execute([
        'hari' => $_POST['hari'] ?? '',
        'jam'  => $_POST['jam'] ?? '',
        'nada' => $_POST['nada'] ?? '',
    ]);
}

if ($pg == 'edit') {
    $id = $_POST['id'] ?? 0;

    if ($id) {
        $stmt = $pdo->prepare("
            UPDATE bell 
            SET hari = :hari, jam = :jam, nada = :nada 
            WHERE id = :id
        ");

        $exec = $stmt->execute([
            'hari' => $_POST['hari'] ?? '',
            'jam'  => $_POST['jam'] ?? '',
            'nada' => $_POST['nada'] ?? '',
            'id'   => $id
        ]);
    }
}
?>
