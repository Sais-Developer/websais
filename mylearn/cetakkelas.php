<?php
ob_start();
error_reporting(E_ALL);
require("../konek/koneksi.php");
require("../konek/function.php");

$kelas = $_GET['kelas'] ?? '';
$bl = $_GET['bulan'] ?? date('m');
$tahun = date('Y');

$stmt1 = $pdo->prepare("SELECT * FROM guru WHERE walas = ?");
$stmt1->execute([$kelas]);
$peg = $stmt1->fetch();

$stmt2 = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt2->execute([$bl]);
$bulane = $stmt2->fetch();

$dayCount = cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rekap Absen Kelas <?= htmlspecialchars($kelas) ?></title>
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

<center><h4>REKAPITULASI PRESENSI DARING</h4></center>

<table class="header-table">
<tr>
    <td>Sekolah</td><td>:</td><td><?= $setting['sekolah'] ?></td>
    <td>Bulan</td><td>:</td><td><?= $bulane['ket'] ?> <?= $tahun ?></td>
</tr>
<tr>
    <td>Kelas</td><td>:</td><td><?= htmlspecialchars($kelas) ?></td>
    <td>Smt - TP</td><td>:</td><td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
</tr>
</table>

<br>

<table>
<tr>
    <th width="2%" height="40px">No</th>
    <th>Nama Siswa</th>

    <?php for($i=1; $i<=$dayCount; $i++): 
        $dateStr = date("D", strtotime("$tahun-$bl-$i")); ?>
        <th width="2%"><?= ($dateStr=='Sun') ? "<b style='color:red'>$i</b>" : $i ?></th>
    <?php endfor; ?>

    <th width="1%">H</th>
    <th width="1%">S</th>
    <th width="1%">I</th>
    <th width="1%">A</th>
</tr>

<?php
$stmt = $pdo->prepare("
    SELECT 
        s.id_siswa,
        s.nama,
        SUM(CASE WHEN a.ket = 'H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN a.ket = 'S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN a.ket = 'I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN a.ket = 'A' THEN 1 ELSE 0 END) AS alpha
    FROM siswa s
    LEFT JOIN absen_daring a 
        ON s.id_siswa = a.idsiswa 
        AND a.bulan = ? 
        AND a.tahun = ?
    WHERE s.kelas = ?
    GROUP BY s.id_siswa, s.nama
    ORDER BY s.nama ASC
");
$stmt->execute([$bl, $tahun, $kelas]);

$no = 1;
?>

<?php while ($siswa = $stmt->fetch()): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= ucwords(strtolower($siswa['nama'])) ?></td>

    <?php for ($i = 1; $i <= $dayCount; $i++):
        $tanggalbaru = date('Y-m-d', mktime(0,0,0,$bl,$i,$tahun));
        $stmt2 = $pdo->prepare("SELECT ket FROM absen_daring WHERE tanggal = ? AND idsiswa = ?");
        $stmt2->execute([$tanggalbaru, $siswa['id_siswa']]);
        $cekabsen = $stmt2->fetch();

        if ($cekabsen): ?>
            <td class="text-center"><b><?= $cekabsen['ket'] ?></b></td>
        <?php else:
            $dateStr = date("D", strtotime("$tahun-$bl-$i"));
            if ($dateStr == 'Sun'): ?>
                <td style="background:red;color:white" class="text-center">X</td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
        <?php endif; ?>
    <?php endfor; ?>

    <td><?= $siswa['hadir'] ?></td>
    <td><?= $siswa['sakit'] ?></td>
    <td><?= $siswa['izin'] ?></td>
    <td><?= $siswa['alpha'] ?></td>
</tr>
<?php endwhile; ?>

</table>

<p>H: HADIR | S: SAKIT | I: IZIN | A: TANPA KETERANGAN</p>

<br>

<table class="header-table">
<tr>
    <td width="5%"></td>
    <td width='50px'></td>

    <td>
        Mengetahui,<br>
        Kepala Sekolah<br><br><br><br>
        <u><?= $setting['kepsek'] ?></u><br/>
        NIP. <?= $setting['nip'] ?>
    </td>

    <td width='20%'></td>
    <td width="5%"></td>

    <td>
        <?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d') ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
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
require_once __DIR__ . '/../dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
$dompdf->stream("Absen_Kelas_".$kelas."_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit(0);
?>
