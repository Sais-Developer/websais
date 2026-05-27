<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'simpan_soal') {
    $nomor    = $_POST['nomor'] ?? '';
    $jenis    = $_POST['jenis'] ?? '';
    $id_bank  = $_POST['mapel'] ?? '';
    $skor     = $_POST['skor'] ?? 0;
    $isi_soal = addslashes($_POST['isi_soal'] ?? '');

    $ektensi = ['jpg', 'png', 'mp3', 'jpeg'];

    $pilA = addslashes($_POST['pilA'] ?? '');
    $pilB = addslashes($_POST['pilB'] ?? '');
    $pilC = addslashes($_POST['pilC'] ?? '');
    $pilD = addslashes($_POST['pilD'] ?? '');
    $pilE = addslashes($_POST['pilE'] ?? '');

    // Ambil data bank soal
    $stmt = $pdo->prepare("SELECT * FROM banksoal WHERE id_bank = :id_bank");
    $stmt->execute([':id_bank' => $id_bank]);
    $bank = $stmt->fetch(PDO::FETCH_ASSOC);

    function handle_upload($field, $prefix, $id_bank, $nomor, $ektensi): ?string {
        if (!empty($_FILES[$field]['name'])) {
            $file = $_FILES[$field]['name'];
            $temp = $_FILES[$field]['tmp_name'];
            $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $ektensi)) {
                $newName = "{$id_bank}_{$nomor}_{$prefix}.{$ext}";
                $destDir = __DIR__ . "/../../files/";
                if (!is_dir($destDir)) mkdir($destDir, 0777, true);
                $dest = $destDir . $newName;
                if (move_uploaded_file($temp, $dest)) {
                    return $newName;
                }
            }
        }
        return null;
    }

    $urlx   = handle_upload('file',  '1', $id_bank, $nomor, $ektensi);
    $filexA = handle_upload('fileA', 'A', $id_bank, $nomor, $ektensi);
    $filexB = handle_upload('fileB', 'B', $id_bank, $nomor, $ektensi);
    $filexC = handle_upload('fileC', 'C', $id_bank, $nomor, $ektensi);
    $filexD = handle_upload('fileD', 'D', $id_bank, $nomor, $ektensi);
    $filexE = handle_upload('fileE', 'E', $id_bank, $nomor, $ektensi);

    if ($jenis == '1') {
        $jawaban = $_POST['jawaban'] ?? '';
        $stmt = $pdo->prepare("INSERT INTO soal 
            (id_bank, nomor, soal, max_skor, jenis, pilA, pilB, pilC, pilD, pilE, jawaban, fileSoal, fileA, fileB, fileC, fileD, fileE) 
            VALUES (:id_bank, :nomor, :soal, :skor, '1', :pilA, :pilB, :pilC, :pilD, :pilE, :jawaban, :fileSoal, :fileA, :fileB, :fileC, :fileD, :fileE)");
        $stmt->execute([
            ':id_bank' => $id_bank,
            ':nomor'   => $nomor,
            ':soal'    => $isi_soal,
            ':skor'    => $skor,
            ':pilA'    => $pilA,
            ':pilB'    => $pilB,
            ':pilC'    => $pilC,
            ':pilD'    => $pilD,
            ':pilE'    => $pilE,
            ':jawaban' => $jawaban,
            ':fileSoal'=> $urlx,
            ':fileA'   => $filexA,
            ':fileB'   => $filexB,
            ':fileC'   => $filexC,
            ':fileD'   => $filexD,
            ':fileE'   => $filexE
        ]);
    }

    if ($jenis == '2' || $jenis == '3') {
        $jawabQ   = $_POST['jawaban'] ?? [];
        $jml_data = count($jawabQ);
        $tskor    = $jml_data * $skor;
        $jawaban  = implode(',', $jawabQ);

        $stmt = $pdo->prepare("INSERT INTO soal 
            (id_bank, nomor, soal, jenis, pilA, pilB, pilC, pilD, pilE, jawaban, fileSoal, fileA, fileB, fileC, fileD, fileE) 
            VALUES (:id_bank, :nomor, :soal, :jenis, :pilA, :pilB, :pilC, :pilD, :pilE, :jawaban, :fileSoal, :fileA, :fileB, :fileC, :fileD, :fileE)");
        $stmt->execute([
            ':id_bank' => $id_bank,
            ':nomor'   => $nomor,
            ':soal'    => $isi_soal,
            ':jenis'   => $jenis,
            ':pilA'    => $pilA,
            ':pilB'    => $pilB,
            ':pilC'    => $pilC,
            ':pilD'    => $pilD,
            ':pilE'    => $pilE,
            ':jawaban' => $jawaban,
            ':fileSoal'=> $urlx,
            ':fileA'   => $filexA,
            ':fileB'   => $filexB,
            ':fileC'   => $filexC,
            ':fileD'   => $filexD,
            ':fileE'   => $filexE
        ]);

        $idsoal = $pdo->lastInsertId();
        $stmt2 = $pdo->prepare("UPDATE soal SET max_skor = :tskor WHERE id_soal = :idsoal");
        $stmt2->execute([':tskor' => $tskor, ':idsoal' => $idsoal]);
    }

    if ($jenis == '4') {
        $perA = addslashes($_POST['perA'] ?? '');
        $perB = addslashes($_POST['perB'] ?? '');
        $perC = addslashes($_POST['perC'] ?? '');
        $perD = addslashes($_POST['perD'] ?? '');
        $perE = addslashes($_POST['perE'] ?? '');

        $stmt = $pdo->prepare("SELECT jawab, warna FROM menjodohkan WHERE idbank = :id_bank AND nomor = :nomor");
        $stmt->execute([':id_bank' => $id_bank, ':nomor' => $nomor]);
        $data = $datax = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r['jawab'];
            $datax[] = $r['warna'];
        }

        $warna  = implode(",", $datax);
        $jawab  = implode(",", $data);
        $jml    = count($data);
        $tskor  = $jml * (int)$skor;

        $stmt2 = $pdo->prepare("INSERT INTO soal 
            (id_bank, nomor, soal, max_skor, jenis, pilA, pilB, pilC, pilD, pilE, jawaban, warna, perA, perB, perC, perD, perE, 
             fileSoal, fileA, fileB, fileC, fileD, fileE) 
            VALUES (:id_bank, :nomor, :soal, :tskor, '4', :pilA, :pilB, :pilC, :pilD, :pilE, :jawab, :warna, :perA, :perB, :perC, :perD, :perE, 
                    :fileSoal, :fileA, :fileB, :fileC, :fileD, :fileE)");
        $stmt2->execute([
            ':id_bank' => $id_bank,
            ':nomor'   => $nomor,
            ':soal'    => $isi_soal,
            ':tskor'   => $tskor,
            ':pilA'    => $pilA,
            ':pilB'    => $pilB,
            ':pilC'    => $pilC,
            ':pilD'    => $pilD,
            ':pilE'    => $pilE,
            ':jawab'   => $jawab,
            ':warna'   => $warna,
            ':perA'    => $perA,
            ':perB'    => $perB,
            ':perC'    => $perC,
            ':perD'    => $perD,
            ':perE'    => $perE,
            ':fileSoal'=> $urlx ?? '',
            ':fileA'   => $filexA ?? '',
            ':fileB'   => $filexB ?? '',
            ':fileC'   => $filexC ?? '',
            ':fileD'   => $filexD ?? '',
            ':fileE'   => $filexE ?? ''
        ]);

        $idsoal = $pdo->lastInsertId();

        $stmt4 = $pdo->prepare("DELETE FROM menjodohkan WHERE idbank = :id_bank AND nomor = :nomor");
        $stmt4->execute([':id_bank' => $id_bank, ':nomor' => $nomor]);
    }

    if ($jenis == '5') {
        $jawaban = strtolower($pilA);
        $stmt = $pdo->prepare("INSERT INTO soal 
            (id_bank, nomor, soal, jawaban, max_skor, jenis, fileSoal) 
            VALUES (:id_bank, :nomor, :soal, :jawaban, :skor, '5', :fileSoal)");
        $stmt->execute([
            ':id_bank' => $id_bank,
            ':nomor'   => $nomor,
            ':soal'    => $isi_soal,
            ':jawaban' => $jawaban,
            ':skor'    => $skor,
            ':fileSoal'=> $urlx
        ]);
    }
}


?>
