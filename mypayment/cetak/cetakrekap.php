<?php
ob_start();
error_reporting(0);
require("../../konek/koneksi.php"); 
require("../../konek/function.php");

$idb = $_GET['jenis'];
$bulan = $_GET['bulan'];
$tahun = date('Y');

$stmtKode = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :idb");
$stmtKode->execute([':idb' => $idb]);
$kode = $stmtKode->fetch(PDO::FETCH_ASSOC);

$stmtBulan = $pdo->prepare("SELECT * FROM bulan WHERE bln = :bln");
$stmtBulan->execute([':bln' => $bulan]);
$bulane = $stmtBulan->fetch(PDO::FETCH_ASSOC);

$day = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rekap Pembayaran Bulan <?= htmlspecialchars($bulan) ?>-<?= $tahun ?></title>
<style>
    @page { 
        margin-top: 1cm; 
        margin-right: 1.5cm; 
        margin-bottom: 1.5cm; 
        margin-left: 1.5cm; 
    }
    body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 4px; font-size: 12px; }
    th { background-color: #f0f0f0; }
    .header-table td { border: none; text-align: left; padding: 2px; }
    .text-center { text-align: center; }
    .bold { font-weight:bold; }
</style>
</head>
<body>
<table class="header-table">
    <tr>
        <td width='70'><img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width='70'></td>
        <td style="text-align:center">
            <p style="font-size:15px;font-weight:bold;"><?= strtoupper($setting['header'] ?? '') ?><br>
            <?= strtoupper($setting['sekolah'] ?? '') ?></p>
            <p style="margin-top:-10px">Alamat: <?= ($setting['alamat'] ?? '') ?> Desa <?= ($setting['desa'] ?? '') ?> Kecamatan <?= ($setting['kecamatan'] ?? '') ?> Kabupaten <?= ($setting['kabupaten'] ?? '') ?></p>
        </td>
    </tr>
</table>
<hr style="margin:1px">
<hr style="margin:2px">
<br>
<h4 class="text-center">DATA PEMBAYARAN</h4>
<br>

<table class="header-table" width="100%">
    <tr>
        <td width="2%"></td>
        <td width='100px'>Sekolah</td>
        <td width='10px'>:</td>
        <td><?= htmlspecialchars($setting['sekolah']) ?></td>
        <td width="10%"></td>
        <td width='100px'>Bulan</td>
        <td width='10px'>:</td>
        <td><?= htmlspecialchars($bulane['ket']) ?> <?= $tahun ?></td>
    </tr>
    <tr>
        <td width="2%"></td>
        <td width='100px'>Kode</td>
        <td width='10px'>:</td>
        <td><?= htmlspecialchars($kode['kode']) ?></td>
        <td ></td>
        <td width='100px'>Smt - TP</td>
        <td width='10px'>:</td>
        <td><?= htmlspecialchars($setting['semester']) ?> - <?= htmlspecialchars($setting['tp']) ?></td>
    </tr>    
</table>
<br>

<table width='100%'>
<tr>
    <th width="5%" height="40px" class="text-center">NO</th>
    <th width="15%" class="text-center">BULAN</th>
    <th width="20%" class="text-center">KODE</th>
    <th class="text-center">NAMA PEMBAYARAN</th>
    <th width="15%" class="text-center">TOTAL RP</th>
</tr>

<?php
$no = 0;
$stmtTotal = $pdo->prepare("
    SELECT SUM(t.bayar) AS total, m.kode
    FROM trx_bayar t
    LEFT JOIN m_bayar m ON m.id = t.idbayar
    WHERE t.bulan = :bulan AND t.tahun = :tahun
    GROUP BY m.kode
");
$stmtTotal->execute([':bulan' => $bulan, ':tahun' => $tahun]);

while ($data = $stmtTotal->fetch(PDO::FETCH_ASSOC)) :
    $no++;
?>
<tr>
    <td><?= $no; ?></td>
    <td><?= htmlspecialchars($bulane['ket']) ?> <?= $tahun ?></td>
    <td><?= htmlspecialchars($data['kode']) ?></td>
    <td><?= htmlspecialchars($kode['nama']) ?></td>
    <td style="text-align:center;font-weight:bold"><?= number_format($data['total'], 0, ',', '.') ?></td>
</tr>
<?php endwhile; ?>
</table>
<br>

<table class="header-table" width='100%'>
<tr>
    <td width="5%"></td>
    <td width='50px'></td>
    <td>
        Mengetahui, <br/>    
        Kepala Sekolah
        <br><br><br><br>
        <u><?= htmlspecialchars($setting['kepsek']) ?></u><br/>
        NIP. <?= htmlspecialchars($setting['nip']) ?>
    </td>
    <td width='10%'></td>
    <td width="5%"></td>
    <td>
        <?= ucwords(strtolower($setting['kecamatan'])); ?>, <?= $day; ?> <?= htmlspecialchars($bulane['ket']) ?> <?= date('Y') ?><br/>
        Bendahara Sekolah<br/>
        <br/><br/><br/>
        <u>.................................................</u><br/>
        NIP. 
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Rekap_Pembayaran_Bulan_". $bulane['ket'] . ".pdf", ["Attachment" => false]);
exit(0);
?>
