<?php 
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");

$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$harix = date('D', strtotime($tanggal));
$bl = date('m');

$stmt1 = $db->prepare("SELECT * FROM bulan WHERE bln = :bln");
$stmt1->execute([':bln' => $bl]);
$bulane = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $db->prepare("SELECT * FROM m_hari WHERE inggris = :harix");
$stmt2->execute([':harix' => $harix]);
$hari = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>PRESENSI HARIAN PEGAWAI</title>
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
    <center><h3>REKAPITULASI PRESENSI HARIAN</h3></center>
    <br>

    <table class="header-table">
        <tr>
            <td width='10%'>Hari</td>
            <td width='2%'>:</td>
            <td width='15%'><?= $hari['hari'] ?></td>
            <td width='10%'></td>
            <td width='15%'>Semester</td>
            <td width='2%'>:</td>
            <td width='10%'><?= $setting['semester'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?></td>
            <td></td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td><?= $setting['tp'] ?></td>
        </tr>
    </table>

    <br>
    <table class='it-grid it-cetak' width='100%' style="font-size:13px;">       
        <tr height='40px'>
            <th width="5%">NO.</th>					
            <th width="20%">N I P</th>
            <th>NAMA PEGAWAI</th>
            <th width="20%">JABATAN</th>
            <th width="5%">KET</th>
            <th width="30%">KETERANGAN</th>
        </tr>
				<?php
				$no = 0;
				$stmt3 = $db->prepare("
					SELECT a.ket, a.keterangan, g.nama, g.nip, g.jabatan
					FROM absensi a
					LEFT JOIN guru g ON g.id_guru = a.idpeg
					WHERE a.level = 'pegawai' AND a.tanggal = :tanggal
				");
				$stmt3->execute([':tanggal' => $tanggal]);

				while ($data = $stmt3->fetch(PDO::FETCH_ASSOC)) {
					$no++;
				?>
			<tr>
				<td style="text-align:center"><?= $no; ?></td>
				<td style="text-align:center"><?= htmlspecialchars($data['nip']); ?></td>
				<td>&nbsp;&nbsp;<?= ucwords(strtolower($data['nama'])); ?></td>
				<td style="text-align:center"><?= htmlspecialchars($data['jabatan']); ?></td>
				<td style="text-align:center"><?= htmlspecialchars($data['ket']); ?></td>
				<td style="text-align:center">
					<?php if ($data['ket'] == 'H') { echo htmlspecialchars($data['keterangan']); } ?>
				</td>
			</tr>
			<?php } ?>
    </table>
    <br>
    <p>H : HADIR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S : SAKIT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I : IZIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A : TANPA KETERANGAN</p>

    <br>
    <table class="header-table">
        <tr>
            <td width="5%"></td>
            <td width='50px'></td>
            <td><br><br><br><br><br><br></td>
            <td width='20%'></td>
            <td width="5%"></td>
            <td>
                <?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d'); ?> <?= $bulane['ket']; ?> <?= date('Y'); ?><br/>							
                Kepala Sekolah
                <br><br><br><br>
                <u><?= $setting['kepsek']; ?></u><br/>
                NIP. <?= $setting['nip']; ?>
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
$dompdf->setPaper('A4', 'Potrait');
$dompdf->render();
$dompdf->stream("Absensi_Harian_Pegawai_Tanggal_" . date('d-m-Y') . ".pdf", ["Attachment" => false]);
exit;
?>
