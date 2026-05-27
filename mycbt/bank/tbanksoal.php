<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg === 'ubah') {
    $id      = $_POST['idm']    ?? '';
    $pk      = $_POST['pk']     ?? '';
    $idmapel = $_POST['mapel']  ?? '';
    $level   = $_POST['level']  ?? '';
    $status  = $_POST['status'] ?? '';
    $kode    = str_replace(' ', '', $_POST['kode'] ?? '');
    $agama   = $_POST['agama']  ?? '';
    $guru    = $_POST['guru']   ?? '';

    if (empty($id) || empty($kode)) {
        echo "GAGAL: Data tidak lengkap";
        exit;
    }

    $stmtCek = $pdo->prepare("SELECT 1 FROM banksoal WHERE kode = :kode AND id_bank <> :id");
    $stmtCek->execute([
        ':kode' => $kode,
        ':id'   => $id
    ]);

    if ($stmtCek->rowCount() > 0) {
        echo "GAGAL";
    } else {

        $stmt = $pdo->prepare("
            UPDATE banksoal 
            SET kode = :kode, idmapel = :idmapel, tingkat = :tingkat,
                status = :status, idguru = :idguru, soal_agama = :agama
            WHERE id_bank = :id
        ");

        if ($stmt->execute([
            ':kode'    => $kode,
            ':idmapel' => $idmapel,
            ':tingkat' => $level,
            ':status'  => $status,
            ':idguru'  => $guru,
            ':agama'   => $agama,
            ':id'      => $id
        ])) {
            echo "OK";
        } else {
            echo "GAGAL";
        }
    }
}

if ($pg === 'tambah') {

    $pk       = $_POST['pk']       ?? '';
    $idmapel  = $_POST['mapel']    ?? '';
    $level    = $_POST['level']    ?? '';
    $status   = $_POST['status']   ?? '';
    $kode     = str_replace(' ', '', $_POST['kode'] ?? '');
    $agama    = $_POST['agama']    ?? '';
    $guru     = $_POST['guru']     ?? '';
    $model    = $_POST['model']    ?? '';

    $stmtCek = $pdo->prepare("SELECT 1 FROM banksoal WHERE kode = :kode LIMIT 1");
    $stmtCek->execute([':kode' => $kode]);

    if ($stmtCek->rowCount() > 0) {
        echo "GAGAL";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO banksoal 
            (kode, idmapel, idguru, tingkat, jurusan, model, status, soal_agama) 
            VALUES (:kode, :idmapel, :idguru, :tingkat, :pk, :model, :status, :agama)
        ");

        if ($stmt->execute([
            ':kode'    => $kode,
            ':idmapel' => $idmapel,
            ':idguru'  => $guru,
            ':tingkat' => $level,
            ':pk'      => $pk,
            ':model'   => $model,
            ':status'  => $status,
            ':agama'   => $agama
        ])) {
            echo "OK";
        } else {
            echo "ERROR";
        }
    }
}

if ($pg === 'hapus') {
    $idbank = intval($_POST['id'] ?? 0);

    // Ambil file terkait
    $stmtFile = $pdo->prepare("
        SELECT fileSoal, fileA, fileB, fileC, fileD, fileE 
        FROM soal WHERE id_bank = :id
    ");
    $stmtFile->execute([':id' => $idbank]);
    $files = $stmtFile->fetchAll(PDO::FETCH_ASSOC);

    foreach ($files as $data) {
        foreach (['fileSoal','fileA','fileB','fileC','fileD','fileE'] as $f) {
            $path = "../../files/" . $data[$f];
            if (!empty($data[$f]) && file_exists($path)) {
                unlink($path);
            }
        }
    }

    $stmt = $pdo->prepare("DELETE FROM banksoal WHERE id_bank = :id");
    $exec = $stmt->execute([':id' => $idbank]);

    $pdo->prepare("DELETE FROM soal WHERE id_bank = :id")->execute([':id' => $idbank]);
    $pdo->prepare("DELETE FROM kunci_soal WHERE id_bank = :id")->execute([':id' => $idbank]);

    echo $exec ? 1 : 0;
}

if ($pg === 'kosongsoal') {
    $id = intval($_POST['id'] ?? 0);
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $pdo->prepare("
        SELECT fileSoal, fileA, fileB, fileC, fileD, fileE 
        FROM soal WHERE id_bank = :id
    ");
    $stmt->execute([':id' => $id]);

    $deletedFiles = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach (['fileSoal','fileA','fileB','fileC','fileD','fileE'] as $f) {
            $path = "../../files/" . $data[$f];
            if (!empty($data[$f]) && file_exists($path)) {
                if (unlink($path)) {
                    $deletedFiles[] = $path;
                } else {
                    echo "Gagal hapus: $path<br>";
                }
            }
        }
    }
    $stmtDelSoal = $pdo->prepare("DELETE FROM soal WHERE id_bank = :id");
    $okSoal = $stmtDelSoal->execute([':id' => $id]);
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

    if ($okSoal) {
        echo "1 - File terhapus: <br>" . implode("<br>", $deletedFiles);
    } else {
        $errorInfo = $stmtDelSoal->errorInfo();
        echo "0 - Error: " . $errorInfo[2];
    }
}



if ($pg === 'hapussoal') {
    $id = intval($_POST['id'] ?? 0);

    $stmt = $pdo->prepare("
        SELECT fileSoal, fileA, fileB, fileC, fileD, fileE 
        FROM soal WHERE id_soal = :id
    ");
    $stmt->execute([':id' => $id]);

    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach (['fileSoal','fileA','fileB','fileC','fileD','fileE'] as $f) {
            $path = "../../files/" . $data[$f];
            if (!empty($data[$f]) && file_exists($path)) {
                unlink($path);
            }
        }
    }

    $pdo->prepare("DELETE FROM soal WHERE id_soal = :id")->execute([':id' => $id]);
    
    echo "1";
}
?>
