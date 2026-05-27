<?php 
ob_start();
error_reporting(0);
require("../../konek/koneksi.php"); // harus berisi $pdo
require("../../konek/function.php");

$smt   = $_GET['smt'];
$mapel = $_GET['mapel'];
$kelas = $_GET['kelas'];
$guru  = $_GET['guru'];

$stmt = $pdo->prepare("SELECT * FROM m_kelas WHERE kelas = ?");
$stmt->execute([$kelas]);
$level = $stmt->fetch(PDO::FETCH_ASSOC);
$tingkat = $level['level'];

$stmt = $pdo->prepare("SELECT * FROM mapel WHERE id = ?");
$stmt->execute([$mapel]);
$map = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$guru]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT a.*, c.*
    FROM adm_tp a
    LEFT JOIN cp_elemen c ON c.id_lingkup = a.id
    WHERE a.mapel = ? AND a.guru = ? AND a.tingkat = ? AND a.semester = ?
");
$stmt->execute([$mapel, $guru, $tingkat, $smt]);
$cp = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>PROMES SMT <?= $smt ?></title>
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
        .header-table td { border: none; text-align: left; padding: 2px; font-size:14px;}
        .text-center { text-align: center; }
		strong {font-size: 18px;}
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
<center><h3>PROGRAM SEMESTER</h3></center>
<br>
   <table class="header-table">
	
            <tr style="vertical-align:top">
			 <td width='2%'></td>
			<td width="20%">SATUAN PENDIDIKAN</td>
            <td width='5px'>:</td>
            <td width="35%"><?= $setting['sekolah'] ?></td>
           
			 <td></td>
			<td>TAHUN PELAJARAN</td>
            <td width='5px'>:</td>
            <td><?= $setting['tp'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>MATA PELAJARAN</td>
            <td width='5px'>:</td>
            <td><?= $map['nama_mapel'] ?> </td>
           
            <td></td>
			<td>KELAS / SEMESTER</td>
            <td width='5px'>:</td>
            <td><?= $level['fase'] ?> - <?= $kelas ?> / <?= $smt ?></td>
            </tr>
			
			
    </table>
	<br>
 
	 <table width="100%" border="1" style="font-size:12px;">
	<tr style="text-align:center">
    <td rowspan="2">TUJUAN PEMBELAJARAN</td>
	<td rowspan="2">MATERI PELAJARAN</td>	
	<td rowspan="2" width='7%'>ALOKASI WAKTU</td>
	<?php if($smt==1): ?>
	<td colspan="2">JULI</td>
	<td colspan="5">AGUSTUS</td>
    <td colspan="4">SEPTEMBER</td>	
	<td colspan="4" >OKTOBER</td>
	<td colspan="5" >NOPEMBER</td>
	<td colspan="2" width="5%">DESEMBER</td>
	<?php else: ?>
	<td colspan="4">JANUARI</td>
	<td colspan="4">FEBRUARI</td>
    <td colspan="4">MARET</td>	
	<td colspan="4" >APRIL</td>
	<td colspan="5" >MEI</td>
	<td colspan="2" width="5%">JUNI</td>
	<?php endif; ?>
	</tr>
	<tr style="text-align:center">
<?php if($smt==1): ?>	
	<td style="background-color:red" width="2%"></td>
	<td width="2%">1</td>
	<td width="2%">2</td>
	<td width="2%">3</td>
	<td width="2%">4</td>
	<td width="2%">5</td>
	<td width="2%">6</td>
	<td width="2%">7</td>
	<td width="2%">8</td>
	<td width="2%">9</td>
	<td width="2%">10</td>
	<td width="2%">11</td>
	<td width="2%">12</td>
	<td width="2%">13</td>
	<td width="2%">14</td>
	<td width="2%">15</td>
	<td width="2%">16</td>
	<td width="2%">17</td>
	<td width="2%">18</td>
	<td width="2%">19</td>
	<td width="2%">20</td>
	<td style="background-color:red"></td>
	<?php else: ?>
	<td width="2%">1</td>
	<td width="2%">2</td>
	<td width="2%">3</td>
	<td width="2%">4</td>
	<td width="2%">5</td>
	<td width="2%">6</td>
	<td width="2%">7</td>
	<td width="2%">8</td>
	<td width="2%">9</td>
	<td width="2%">10</td>
	<td width="2%">11</td>
	<td width="2%">12</td>
	<td width="2%">13</td>
	<td width="2%">14</td>
	<td width="2%">15</td>
	<td width="2%">16</td>
	<td width="2%">17</td>
	<td width="2%">18</td>
	<td width="2%">19</td>
	<td width="2%">20</td>
	<td width="2%">21</td>
	<td width="2%">22</td>
	<td style="background-color:red"></td>
	<?php endif; ?>
	</tr>
	<?php
		$sql = "SELECT a.*, c.* 
				FROM adm_tp a
				LEFT JOIN cp_elemen c ON c.id_lingkup = a.id
				WHERE a.mapel = ? AND a.guru = ? AND a.tingkat = ? AND a.semester = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->execute([$mapel, $guru, $tingkat, $smt]);

		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
		?>
	<tr>
	<td><?= $data['tujuan'] ?></td>
	<td><?= $data['lingkup'] ?></td>
	<td style="text-align:center">X<br><?= $data['waktu'] ?> JP</td>
	<td style="background-color:red"></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td style="background-color:red"></td>
	</tr>
	<?php endwhile; ?>
    </table>
   <br>   
 
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
		<td width='20%'></td>
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
require_once __DIR__ . '/../../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
$dompdf->stream("PROMES ".$smt." ". $kelas ." - ".$map['kode'].".pdf", array("Attachment" => false));
exit(0);
?>
