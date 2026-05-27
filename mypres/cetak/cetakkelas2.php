<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php"); // harus menghasilkan $pdo (PDO)
require("../../konek/function.php");

$kelas = $_GET['kelas'] ?? '';
$bl    = $_GET['bulan'] ?? '';
$eskul = $_GET['eskul'] ?? '';

/* --- AMBIL DATA GURU (WALAS) --- */
$stmt1 = $pdo->prepare("SELECT * FROM guru WHERE walas = ?");
$stmt1->execute([$kelas]);
$peg = $stmt1->fetch(PDO::FETCH_ASSOC);

/* --- AMBIL DATA BULAN --- */
$stmt2 = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt2->execute([$bl]);
$bulane = $stmt2->fetch(PDO::FETCH_ASSOC);

$day = cal_days_in_month(CAL_GREGORIAN, $bl, date('Y'));
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rekap Absen Eskul <?= $eskul ?> Kelas <?= $kelas ?></title>
<style>
@page { 
    margin-top: 1cm; 
    margin-right: 1cm; 
    margin-bottom: 1cm; 
    margin-left: 2cm; 
}
body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; }
th { background-color: #f0f0f0; }
.header-table {
    width: 100%;
    border-collapse: collapse;
}
.header-table td {
    border: none;
    vertical-align: middle;
}
.header-table h3 {
    margin: 0;
    line-height: 1.2;
    font-size: 18px; 
    text-transform: uppercase;
}
.header-table p {
    margin: 2px 0 0 0;
    font-size: 12px;
    line-height: 1.3;
}
.double-hr {
    border: none;
    border-top: 1px solid #000; 
    margin: 5px 0 0 0;
    position: relative;
}
.double-hr::after {
    content: "";
    display: block;
    border-top: 1px solid #000; 
    margin-top: 2px;
}
.text-center { text-align: center; }
strong { font-size: 18px; }
</style>
</head>
<body>
<table class="header-table">
    <tr>
        <td width="70">
            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70" alt="Logo">
        </td>
        <td class="text-center">
            <h3>
                <?= $setting['header'] ?? '' ?><br>
                <?= $setting['sekolah'] ?? '' ?>
            </h3>
            <p>
                Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> 
                Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?>
            </p>
        </td>
    </tr>
</table>

<hr class="double-hr">

<center><h4>REKAPITULASI ABSENSI<br>EKSTRAKURIKULER <?= strtoupper($eskul) ?></h4></center>
<br>

<table class="header-table">
<tr>
    <td>Sekolah</td><td>:</td><td><?= $setting['sekolah'] ?></td>
    <td>Bulan</td><td>:</td><td><?= $bulane['ket'] ?> <?= date('Y') ?></td>
</tr>
<tr>
    <td>Kelas</td><td>:</td><td><?= htmlspecialchars($kelas) ?></td>
    <td>Smt - TP</td><td>:</td><td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
</tr>
</table>

<br>

<table width='100%'>
<tr>
    <th width="2%" height="40px">No</th>
    <th>Nama Siswa</th>

    <?php
    $bulan = $bl;
    $tahun = date('Y');
    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    for ($i = 1; $i <= $tanggal; $i++) {
        $date1 = date("D", strtotime("$tahun-$bulan-$i"));
        echo "<th width='2%'>";
        echo ($date1 == 'Sun') ? "<b style='color:red'>$i</b>" : $i;
        echo "</th>";
    }
    ?>
    <th width="1%">H</th>
    <th width="1%">S</th>
    <th width="1%">I</th>
    <th width="1%">A</th>
</tr>

<?php
/* --- AMBIL LIST SISWA --- */
$stmtSiswa = $pdo->prepare("
    SELECT id_siswa, kelas, nama 
    FROM siswa 
    WHERE kelas = ?
    GROUP BY id_siswa
");
$stmtSiswa->execute([$kelas]);
$datasiswa = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

$no = 0;

/* --- PREPARE QUERY ABSEN PER HARI --- */
$stmtAbsen = $pdo->prepare("
    SELECT ket 
    FROM absensi_les 
    WHERE idsiswa = ? AND tanggal = ?
    LIMIT 1
");

/* --- PREPARE TOTAL REKAP --- */
$stmtCount = $pdo->prepare("
    SELECT 
        SUM(ket='H') AS hadir,
        SUM(ket='S') AS sakit,
        SUM(ket='I') AS izin,
        SUM(ket='A') AS alpha
    FROM absensi_les
    WHERE idsiswa = ? AND bulan = ? AND tahun = ?
");

foreach ($datasiswa as $siswa) {
    $no++;

    // Total HSIA
    $stmtCount->execute([$siswa['id_siswa'], $bulan, $tahun]);
    $count = $stmtCount->fetch(PDO::FETCH_ASSOC);

    echo "<tr>";
    echo "<td class='text-center'>{$no}</td>";
    echo "<td>&nbsp;&nbsp;" . ucwords(strtolower($siswa['nama'])) . "</td>";

    for ($i = 1; $i <= $tanggal; $i++) {
        $tanggalbaru = date('Y-m-d', mktime(0,0,0,$bulan,$i,$tahun));
        $dayName = date("D", strtotime($tanggalbaru));

        $stmtAbsen->execute([$siswa['id_siswa'], $tanggalbaru]);
        $hasil = $stmtAbsen->fetch(PDO::FETCH_ASSOC);

        if ($hasil) {
            echo "<td class='text-center'><b>{$hasil['ket']}</b></td>";
        } else {
            if ($dayName == 'Sun') {
                echo "<td style='color:white;background-color:red' class='text-center'>X</td>";
            } else {
                echo "<td></td>";
            }
        }
    }

    echo "<td class='text-center'>".($count['hadir'] ?? 0)."</td>";
    echo "<td class='text-center'>".($count['sakit'] ?? 0)."</td>";
    echo "<td class='text-center'>".($count['izin'] ?? 0)."</td>";
    echo "<td class='text-center'>".($count['alpha'] ?? 0)."</td>";

    echo "</tr>";
}
?>
</table>

<br>
<p>H : HADIR &nbsp;&nbsp; S : SAKIT &nbsp;&nbsp; I : IZIN &nbsp;&nbsp; A : TANPA KETERANGAN</p>

<br>

<table class="header-table">
<tr>
    <td width="5%"></td>
    <td width='50px'></td>
    <td>
        Mengetahui, <br> Kepala Sekolah<br><br><br><br>
        <u><?= $setting['kepsek'] ?></u><br/>
        NIP. <?= $setting['nip'] ?>
    </td>
    <td width='20%'></td>
    <td width="5%"></td>
    <td>
        <?= ucwords(strtolower($setting['kabupaten'])) ?>, <?= $day ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
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
$dompdf->stream("Absen_Eskul_Kelas_".$kelas."_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit;
?>
