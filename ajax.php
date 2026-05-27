<?php
require("konek/koneksi.php");
require("konek/function.php");
require("konek/crud.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$pg = $_GET['pg'] ?? '';
$nokartu = $_POST['nokartu'] ?? '';

if (!empty($nokartu)) {
    $stmtCek = $pdo->prepare("SELECT COUNT(*) FROM datareg WHERE nokartu = ?");
    $stmtCek->execute([$nokartu]);
    $cek = $stmtCek->fetchColumn();
    if ($cek == 0) {
        function uploadImage($path, $imgBase64) {
            if (empty($path) || empty($imgBase64)) {
                return ['status' => false, 'msg' => 'PATH atau IMAGE kosong!'];
            }

            $dir = "data/$path/";

            if (!is_dir($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    return ['status' => false, 'msg' => 'Gagal membuat folder: ' . $dir];
                }
            }

            $clean = preg_replace('/^data:image\/\w+;base64,/', '', $imgBase64);
            $clean = str_replace(' ', '+', $clean);

            $data = base64_decode($clean, true);
            if ($data === false) {
                return ['status' => false, 'msg' => 'Gagal decode base64'];
            }

            $files = glob($dir . "*.png");
            $filename = $dir . "image" . count($files) . ".png";

            if (!file_put_contents($filename, $data)) {
                return ['status' => false, 'msg' => 'Gagal menyimpan file'];
            }

            return ['status' => true, 'file' => $filename];
        }

        if ($pg === 'pegawai') {

            $path   = $_POST['path'] ?? '';
            $img    = $_POST['image'] ?? '';
            $idpeg  = $_POST['idpeg'] ?? '';

            $stmtPeg = $pdo->prepare("SELECT nama, nowa FROM guru WHERE id_guru = ?");
            $stmtPeg->execute([$idpeg]);
            $peg = $stmtPeg->fetch(PDO::FETCH_ASSOC);

            $nama = $peg['nama'] ?? '';
            $nowa = $peg['nowa'] ?? '';

            $upload = uploadImage($path, $img);

            echo $upload['status']
                ? $upload['file']
                : 'ERROR: ' . $upload['msg'];

            $stmtInsert = $pdo->prepare("
                INSERT INTO datareg (folder, idpeg, nama, nowa, level, nokartu)
                VALUES (?, ?, ?, ?, 'pegawai', ?)
            ");
            $stmtInsert->execute([$path, $idpeg, $nama, $nowa, $nokartu]);
            $last_id = $pdo->lastInsertId();

            if ($last_id) {

                $stmtUp1 = $pdo->prepare("UPDATE datareg SET nada = ? WHERE id = ?");
                $stmtUp1->execute([$last_id, $last_id]);

                $stmtUp2 = $pdo->prepare("UPDATE guru SET sts = 1 WHERE id_guru = ?");
                $stmtUp2->execute([$idpeg]);

                $pdo->query("TRUNCATE tmpface");
            }
        }

        elseif ($pg === 'siswa') {

            $path    = $_POST['path'] ?? '';
            $img     = $_POST['image'] ?? '';
            $idsiswa = $_POST['idpeg'] ?? '';

            $stmtSis = $pdo->prepare("SELECT nama, kelas, nowa FROM siswa WHERE id_siswa = ?");
            $stmtSis->execute([$idsiswa]);
            $siswa = $stmtSis->fetch(PDO::FETCH_ASSOC);

            $nama  = $siswa['nama'] ?? '';
            $kelas = $siswa['kelas'] ?? '';
            $nowa  = $siswa['nowa'] ?? '';

            $upload = uploadImage($path, $img);

            echo $upload['status']
                ? $upload['file']
                : 'ERROR: ' . $upload['msg'];

            $stmtInsert = $pdo->prepare("
                INSERT INTO datareg (folder, idsiswa, nama, kelas, nowa, level, nokartu)
                VALUES (?, ?, ?, ?, ?, 'siswa', ?)
            ");
            $stmtInsert->execute([$path, $idsiswa, $nama, $kelas, $nowa, $nokartu]);
            $last_id = $pdo->lastInsertId();

            if ($last_id) {

                $stmtUp1 = $pdo->prepare("UPDATE datareg SET nada = ? WHERE id = ?");
                $stmtUp1->execute([$last_id, $last_id]);

                $stmtUp2 = $pdo->prepare("UPDATE siswa SET sts = 1 WHERE id_siswa = ?");
                $stmtUp2->execute([$idsiswa]);

                $pdo->query("TRUNCATE tmpface");
            }
        }

    }
}
?>
