<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'simpan_soal') {

    $idsoal   = $_POST['idsoal'];
    $nomor    = $_POST['nomor'];
    $jenis    = $_POST['jenis'];
    $id_bank  = $_POST['mapel'];
    $skor     = $_POST['skor'];
    $isi_soal = addslashes($_POST['isi_soal']);
    $pilA     = addslashes($_POST['pilA']);
    $jawaban  = strtolower($pilA);
    $stmt = $pdo->prepare("SELECT fileSoal FROM soal WHERE id_bank = :id_bank AND id_soal = :id_soal AND jenis = :jenis");
    $stmt->execute([
        ':id_bank' => $id_bank,
        ':id_soal' => $idsoal,
        ':jenis'   => $jenis
    ]);
    $soal = $stmt->fetch(PDO::FETCH_ASSOC);

    $oldFile = $soal['fileSoal'] ?? '';

    $ektensi = ['jpg', 'png', 'jpeg', 'mp3'];
    function handle_upload(string $field, string $prefix, string $id_bank, string $nomor, array $ektensi, string $oldFile): string {
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
        return $oldFile;
    }

    $urlx = handle_upload('file', '1', $id_bank, $nomor, $ektensi, $oldFile);

    $stmtUp = $pdo->prepare("
        UPDATE soal 
        SET soal = :soal, jawaban = :jawaban, max_skor = :max_skor, fileSoal = :fileSoal 
        WHERE id_soal = :id_soal AND jenis = '5'
    ");

    $stmtUp->execute([
        ':soal'     => $isi_soal,
        ':jawaban'  => $jawaban,
        ':max_skor' => $skor,
        ':fileSoal' => $urlx,
        ':id_soal'  => $idsoal
    ]);

    echo "1";  
}
?>
