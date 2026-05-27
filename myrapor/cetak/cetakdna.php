<?php
ob_start();
error_reporting(E_ALL);

require("../../konek/koneksi.php"); 
require("../../konek/function.php");

$kelas = $_GET['k'];
$ket   = $_GET['kt'];

$stmtKelas = $pdo->prepare("SELECT * FROM m_kelas WHERE kelas = ?");
$stmtKelas->execute([$kelas]);
$level = $stmtKelas->fetch(PDO::FETCH_ASSOC);
$tingkat = $level['level'];


$stmtWalas = $pdo->prepare("SELECT * FROM guru WHERE walas = ?");
$stmtWalas->execute([$kelas]);
$peg = $stmtWalas->fetch(PDO::FETCH_ASSOC);

if ($setting['semester'] == '1') {
    $smt = "Ganjil";
} elseif ($setting['semester'] == '2') {
    $smt = "Genap";
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rapor PAS <?= ucwords(strtolower($siswa['nama'])) ?></title>

<style>
@page { 
    margin: 0.5cm 0.5cm 0.5cm 0.5cm;
}
body { font-family: Arial, sans-serif; font-size: 15px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; font-size: 12px; }
th { background-color: #f0f0f0; }
.header-table td { border: none; text-align: left; padding: 2px; }
.text-center { text-align: center; }
.bold { font-weight: bold; }
</style>
</head>

<body>
<h4 class="text-center">DAFTAR NILAI AKHIR <?= $ket ?> KELAS <?= $kelas ?></h4>
<br>

<table class="header-table">
<tr>
    <td>Nama Sekolah</td><td>:</td>
    <td><?= $setting['sekolah'] ?></td>
    <td></td>
    <td>Semester</td><td>:</td>
    <td><?= $setting['semester'] ?> <?= $smt ?></td>
</tr>
<tr>
    <td>Alamat Sekolah</td><td>:</td>
    <td><?= $setting['alamat'] ?></td>
    <td></td>
    <td>Tahun Ajaran</td><td>:</td>
    <td><?= $setting['tp'] ?></td>
</tr>
</table>

<br>

<table>
<tr class="bold text-center" style="background-color:#DCDCDC">
    <td width="5%">NO</td>
    <td>NAMA SISWA</td>

    <?php
    
    $stmt = $pdo->prepare("
        SELECT m.kode 
        FROM mapel_rapor mr
        LEFT JOIN mapel m ON m.id = mr.idmapel
        WHERE mr.tingkat = ? AND mr.jurusan = ?
    ");
    $stmt->execute([$level['level'], $level['jurusan']]);

    $mapelList = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mapelList[] = $row['kode'];
        echo "<td>{$row['kode']}</td>";
    }
    ?>
    <td width="3%">TOTAL</td>
</tr>

<?php

$stmt2 = $pdo->prepare("SELECT id_siswa, nama FROM siswa WHERE kelas = ?");
$stmt2->execute([$kelas]);

$no = 0;

while ($data = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $no++;
    echo "<tr>";
    echo "<td class='text-center'>{$no}</td>";
    echo "<td>{$data['nama']}</td>";

    $stmt3 = $pdo->prepare("
        SELECT n.nilai, m.kode
        FROM nilai_capaian n
        LEFT JOIN mapel m ON m.id = n.idmapel
        WHERE n.idsiswa = ? AND n.semester = ? AND n.tapel = ? AND n.ket = ?
    ");
    $stmt3->execute([
        $data['id_siswa'],
        $semester,
        $tapel,
        $ket
    ]);

    $nilaiMapel = [];
    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $nilaiMapel[$row3['kode']] = $row3['nilai'];
    }

    $total = 0;
    foreach ($mapelList as $kodeMapel) {
        $nilai = $nilaiMapel[$kodeMapel] ?? '';
        echo "<td class='text-center'>{$nilai}</td>";
        $total += (is_numeric($nilai) ? $nilai : 0);
    }

    echo "<td class='text-center'>{$total}</td>";
    echo "</tr>";
}
?>
</table>

<?php

$stmt6 = $pdo->prepare("
    SELECT tanggal 
    FROM tanggal_rapor 
    WHERE semester = ? AND tapel = ? AND ket = ?
");
$stmt6->execute([$semester, $tapel, $ket]);
$rapor = $stmt6->fetch(PDO::FETCH_ASSOC);
?>

<br>

<table class="header-table">
<tr>
    <td width="5%"></td>
    <td width="50px"></td>
    <td>
        Mengetahui,<br>
        Kepala Sekolah<br><br><br><br>
        <u><?= $setting['kepsek'] ?></u><br/>
        NIP. <?= $setting['nip'] ?>
    </td>
    <td width="20%"></td>
    <td width="5%"></td>
    <td>
        <?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= $rapor['tanggal'] ?><br/>
        Wali Kelas <?= $kelas ?><br><br><br>
        <u><?= $peg['nama'] ?></u><br/>
        NIP. <?= $peg['nip'] ?>
    </td>
</tr>
</table>

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
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
$dompdf->stream("DNA_".$ket." ".$kelas.".pdf", ["Attachment" => false]);
exit(0);
?>
