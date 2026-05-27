<?php 
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");

$tanggal = date('Y-m-d');
$idb = $_GET['idb'] ?? '';
$kelas = $_GET['kls'] ?? '';

try {
    // Fetch bank soal and mapel
    $sql = "
        SELECT * FROM banksoal b
        LEFT JOIN mapel m ON m.id = b.idmapel 
        WHERE b.id_bank = :idb
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idb', $idb, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch siswa for the class
    $stmtSiswa = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas");
    $stmtSiswa->bindParam(':kelas', $kelas, PDO::PARAM_STR);
    $stmtSiswa->execute();
    $siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

    // Prepare nilai statement
    $stmtNilai = $pdo->prepare("SELECT id_siswa, id_bank, katrol FROM nilai WHERE id_siswa = :id_siswa AND id_bank = :idb");
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Nilai Kelas <?= htmlspecialchars($kelas); ?></title>
    <style>
        @page { margin: 1cm 1cm 1cm 2cm; }
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background-color: #f0f0f0; }
        .header-table td { border: none; text-align: left; padding: 2px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
<div>
    <table class="header-table">
        <tr>
            <td width="70px">
                <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70px" alt="Logo">
            </td>
            <td style="text-align:center;">
                <strong>
                    <?= strtoupper($setting['header'] ?? '') ?><br>
                    <?= strtoupper($setting['sekolah'] ?? '') ?>
                </strong><br>
                <small>
                    Alamat: <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                    Kecamatan <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> Kabupaten <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
                </small>
            </td>
        </tr>
    </table>
    <hr>
    <center><h4>DAFTAR NILAI ASESMEN</h4></center>
    <br>
    <table class="header-table">
        <tr>
            <td width='100px'>Mata Pelajaran</td>
            <td width='10px'>:</td>
            <td><?= htmlspecialchars($data['nama_mapel']); ?></td>
            <td width='20px'></td>
            <td width='150px'>Semester</td>
            <td width='10px'>:</td>
            <td><?= htmlspecialchars($setting['semester']); ?></td>
        </tr>
        <tr>
            <td>Asesmen</td>
            <td>:</td>
            <td><?= htmlspecialchars($setting['jenis_ujian']); ?></td>
            <td></td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td><?= htmlspecialchars($setting['tp']); ?></td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <th>NO</th>
            <th>N I S</th>
            <th>N I S N</th>
            <th>NAMA SISWA</th>
            <th>KELAS</th>
            <th>JK</th>
            <th>NILAI</th>
        </tr>
        <?php
        $no = 0;
        foreach ($siswaList as $dataq):
            $id_siswa = $dataq['id_siswa'];
            $stmtNilai->bindParam(':id_siswa', $id_siswa, PDO::PARAM_INT);
            $stmtNilai->bindParam(':idb', $idb, PDO::PARAM_INT);
            $stmtNilai->execute();
            $nilai = $stmtNilai->fetch(PDO::FETCH_ASSOC);
            $no++;
        ?>
        <tr>
            <td class="text-center"><?= $no; ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['nis']); ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['nisn']); ?></td>
            <td><?= htmlspecialchars($dataq['nama']); ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['kelas']); ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['jk']); ?></td>
            <td class="text-center"><?= number_format($nilai['katrol'] ?? 0, 2, '.', ''); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <table class="header-table">
        <tr>
            <td width="5%"></td>
            <td width='50px'></td>
            <td></td>
            <td width='30%'></td>
            <td width="5%"></td>
            <td>
                <?= htmlspecialchars($setting['kabupaten']); ?>, <?= date('d'); ?> <?= bulan_indo($tanggal); ?> <?= date('Y'); ?><br/>
                Kepala Sekolah<br/><br/><br/><br/>
                <u><?= htmlspecialchars($setting['kepsek']); ?></u><br/>
                NIP. <?= htmlspecialchars($setting['nip']); ?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

<?php
$html = ob_get_clean();
require_once __DIR__ . '/../../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Nilai_Kelas_".$kelas.".pdf", ["Attachment" => false]);
exit;
?>
