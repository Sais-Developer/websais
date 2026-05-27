<?php
ob_start();
error_reporting(0);
require("../konek/koneksi.php");
require("../konek/function.php");

$bl    = $_GET['bulan'] ?? '';
$guru  = $_GET['guru'] ?? '';
$tahun = date('Y');

$stmt = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt->execute([$bl]);
$bulane = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$guru]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>JURNAL DAN AGENDA</title>
     <style>
        @page { 
		margin-top: 1cm; 
		margin-right: 1cm; 
		margin-bottom: 1cm; 
		margin-left: 1cm; 
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
            <td width='70'><img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width='70'></td>
            <td style="text-align:center">
                <strong><?= strtoupper($setting['header'] ?? '') ?><br>
                <?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
                <small>Alamat: <?= ($setting['alamat'] ?? '') ?> Desa <?= ($setting['desa'] ?? '') ?> Kecamatan <?= ($setting['kecamatan'] ?? '') ?> Kabupaten <?= ($setting['kabupaten'] ?? '') ?></small>
            </td>
        </tr>
    </table>
	<hr style="margin:1px">
<hr style="margin:2px">
		<center>
		<h3>AGENDA GURU</h3>
		</center>
		<br>
 
   <table class="header-table">
	<tr>
	
		 <td>Sekolah</td>
		<td>:</td>
		<td><?= $setting['sekolah'] ?></td>
		<td></td>
		<td>Semester</td>
		<td>:</td>
		<td><?= $semester ?></td>
	</tr>
	<tr>
		
		<td>Bulan</td>
		<td>:</td>
		<td><?= $bulane['ket'] ?> <?= date('Y') ?></td>
		<td ></td>
		 <td>Tahun Pelajaran</td>
		<td>:</td>
		<td><?= $setting['tp'] ?></td>
	</tr>
  </table>
     <br>
 <table  width='100%' style="font-size:13px;">       
	  <tr>
		<th width="3%" height="40px">NO</th>
		<th width="12%" class="text-center">TANGGAL</th>			
		<th class="text-center">KEGIATAN</th>
		<th class="text-center">KETERANGAN</th>
		 </tr>
		<?php
			$no = 0;
			$sql = "SELECT * FROM agenda WHERE  bulan = :bl AND tahun = :tahun AND guru = :guru";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':bl'    => $bl,
				':tahun'    => $tahun,
				':guru'  => $guru
			]);
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$no++;
			?>		
		<tr style="vertical-align:top">
			<td style="text-align:center"><?= $no; ?></td>
			<td style="text-align:center"><?= date('d-m-Y',strtotime($data['tanggal'])); ?></td>
			<td><?= $data['kegiatan'] ?></td>
			<td><?= $data['keterangan'] ?></td>

			</tr>
		<?php } ?>
	</table>
    <br>
	 <table class="header-table">
		<tr>
		<td width="5%"></td>
		<td width='50px'></td>
		<td>
		Mengetahui, <br/>Kepala Sekolah
		<br/><br/><br/><br/>
		<u><?= $setting['kepsek'] ?></u><br/>
		NIP. <?= $setting['nip'] ?>
		</td>
		<td width='5%'></td>
		<td width="5%"></td>
		<td>
		<?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d'); ?> <?= bulan_indo($tanggal); ?> <?= date('Y') ?><br/>
		Guru Mapel<br/>
		<br/><br/><br/>
		<u><?= $usr['nama'] ?></u><br/>
		NIP. <?= $usr['nip'] ?>
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
$dompdf->setPaper('A4', 'Potrait');
$dompdf->render();
$dompdf->stream("Agenda Guru ".$usr['nama']. " Bulan ".$bl . ".pdf", array("Attachment" => false));
exit(0);
?>
