<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

function stmt_delete($pdo, string $table, string $field, $value) {
    $sql = "DELETE FROM {$table} WHERE {$field} = :value";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':value' => $value]);
}

function stmt_select_row($pdo, string $sql, array $bind) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($bind);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function stmt_select_all($pdo, string $sql, array $bind) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($bind);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($pg === 'simpan_soal') {

    $idsoal   = $_POST['idsoal'] ?? '';
    $nomor    = $_POST['nomor'] ?? '';
    $jenis    = $_POST['jenis'] ?? '';
    $id_bank  = $_POST['mapel'] ?? '';
    $skor     = (int)($_POST['skor'] ?? 0);
    $isi_soal = $_POST['isi_soal'] ?? '';

    // Select soal record
    $soal = stmt_select_row(
        $pdo,
        "SELECT * FROM soal WHERE id_bank = :id_bank AND id_soal = :id_soal AND jenis = :jenis",
        ['id_bank' => $id_bank, 'id_soal' => $idsoal, 'jenis' => $jenis]
    );

    $ektensi = ['jpg', 'png', 'jpeg', 'mp3'];

    function handle_upload(string $field, string $prefix, string $id_bank, string $nomor, array $ektensi, string $oldFile): string {
        if (!empty($_FILES[$field]['name'])) {
            $file = $_FILES[$field]['name'];
            $tmp  = $_FILES[$field]['tmp_name'];
            $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($ext, $ektensi)) {
                $new = "{$id_bank}_{$nomor}_{$prefix}.{$ext}";
                $dir = __DIR__ . "/../../files/";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $dst = $dir . $new;
                if (move_uploaded_file($tmp, $dst)) return $new;
            }
        }
        return $oldFile;
    }

    // Handle file uploads
    $urlx   = handle_upload('file',  '1', $id_bank, $nomor, $ektensi, $soal['fileSoal']);
    $filexA = handle_upload('fileA', 'A', $id_bank, $nomor, $ektensi, $soal['fileA']);
    $filexB = handle_upload('fileB', 'B', $id_bank, $nomor, $ektensi, $soal['fileB']);
    $filexC = handle_upload('fileC', 'C', $id_bank, $nomor, $ektensi, $soal['fileC']);
    $filexD = handle_upload('fileD', 'D', $id_bank, $nomor, $ektensi, $soal['fileD']);
    $filexE = handle_upload('fileE', 'E', $id_bank, $nomor, $ektensi, $soal['fileE']);

    $pilA = $_POST['pilA'] ?? '';
    $pilB = $_POST['pilB'] ?? '';
    $pilC = $_POST['pilC'] ?? '';
    $pilD = $_POST['pilD'] ?? '';
    $pilE = $_POST['pilE'] ?? '';

    $params = [
        'soal'   => $isi_soal,
        'pilA'   => $pilA,
        'pilB'   => $pilB,
        'pilC'   => $pilC,
        'pilD'   => $pilD,
        'pilE'   => $pilE,
        'skor'   => $skor,
        'fileSoal' => $urlx,
        'fileA'  => $filexA,
        'fileB'  => $filexB,
        'fileC'  => $filexC,
        'fileD'  => $filexD,
        'fileE'  => $filexE
    ];

    $update_sql = "
        UPDATE soal SET 
            soal = :soal, pilA = :pilA, pilB = :pilB, pilC = :pilC, pilD = :pilD, pilE = :pilE,
            max_skor = :skor, fileSoal = :fileSoal, fileA = :fileA, fileB = :fileB, fileC = :fileC, fileD = :fileD, fileE = :fileE
    ";

    if ($jenis == '1') {
        $jawaban = $_POST['jawaban'] ?? '';
        $update_sql .= ", jawaban = :jawaban";
        $params['jawaban'] = $jawaban;

        $update_sql .= " WHERE id_soal = :id_soal";
        $params['id_soal'] = $idsoal;

        $stmt = $pdo->prepare($update_sql);
        $stmt->execute($params);
    }

    if ($jenis == '2' || $jenis == '3') {
        $jawabQ = $_POST['jawaban'] ?? [];
        if (!is_array($jawabQ)) $jawabQ = [];
        $jawaban = implode(",", $jawabQ);
        $tskor = count($jawabQ) * $skor;

        $update_sql .= ", jawaban = :jawaban, max_skor = :max_skor";
        $params['jawaban'] = $jawaban;
        $params['max_skor'] = $tskor;

        $update_sql .= " WHERE id_soal = :id_soal";
        $params['id_soal'] = $idsoal;

        $stmt = $pdo->prepare($update_sql);
        $stmt->execute($params);
    }

    if ($jenis == '4') {
        $perA = $_POST['perA'] ?? '';
        $perB = $_POST['perB'] ?? '';
        $perC = $_POST['perC'] ?? '';
        $perD = $_POST['perD'] ?? '';
        $perE = $_POST['perE'] ?? '';

        $rows = stmt_select_all(
            $pdo,
            "SELECT jawab, warna FROM menjodohkan WHERE idbank = :idbank AND nomor = :nomor",
            ['idbank' => $id_bank, 'nomor' => $nomor]
        );

        $jawab = [];
        $warna = [];
        foreach ($rows as $r) {
            $jawab[] = $r['jawab'];
            $warna[] = $r['warna'];
        }

        $jawabx = implode(",", $jawab);
        $warnax = implode(",", $warna);
        $tskor = count($jawab) * $skor;

        stmt_delete($pdo, "menjodohkan", "idbank", $id_bank);

        $update_sql .= ",
            perA = :perA, perB = :perB, perC = :perC, perD = :perD, perE = :perE,
            jawaban = :jawaban, warna = :warna, max_skor = :max_skor
        ";

        $params['perA'] = $perA;
        $params['perB'] = $perB;
        $params['perC'] = $perC;
        $params['perD'] = $perD;
        $params['perE'] = $perE;

        $params['jawaban'] = $jawabx;
        $params['warna'] = $warnax;
        $params['max_skor'] = $tskor;

        $update_sql .= " WHERE id_soal = :id_soal";
        $params['id_soal'] = $idsoal;

        $stmt = $pdo->prepare($update_sql);
        $stmt->execute($params);
    }
}
?>
