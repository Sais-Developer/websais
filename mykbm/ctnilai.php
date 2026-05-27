<?php
ob_start();
error_reporting(0);
require("../konek/koneksi.php");
require("../konek/function.php");

$mapel = $_GET['mapel'];
$kelas = $_GET['kelas'];
$guru  = $_GET['guru'];

$stmt = $pdo->prepare("SELECT * FROM mapel WHERE id = ?");
$stmt->execute([$mapel]);
$map = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$guru]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE kelas = ?");
$stmt->execute([$kelas]);
$jsiswa = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM nilai_harian WHERE kelas = ? AND mapel = ? AND guru = ? AND smt = ? AND tp = ?");
$stmt->execute([$kelas, $mapel, $guru, $setting['semester'], $setting['tp']]);
$jumnil = $stmt->fetchColumn();

$jml = ($jsiswa > 0) ? $jumnil / $jsiswa : 0;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>PENILAIAN HARIAN</title>
</head>
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
     </style>
</head>
<body>
<div>
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
  
		<center><h3>REKAPITULASI PENILAIAN HARIAN</h3></center>
		<br>
 <table class="header-table">
	<tr>
	<td width="10%"></td>
		 <td width='100px'>Kelas</td>
		<td width='10px'>:</td>
		<td><?= $kelas ?></td>
		<td width="10%"></td>
		<td>Semester</td>
		<td width='10px'>:</td>
		<td><?= $setting['semester'] ?></td>
	</tr>
	
		<tr>
		<td width="10%"></td>
		<td width='100px'>Mata Pelajaran</td>
		<td width='10px'>:</td>
		<td><?= $map['nama_mapel'] ?></td>
		<td ></td>
		 <td>Tahun Pelajaran</td>
		<td width='10px'>:</td>
		<td><?= $setting['tp'] ?></td>
		</tr>
    </table>
     <br>
 <table width='100%' style="font-size:13px;">        
	  <tr>
		<th width="5%" height="40px">NO</th>
		<th  width="15%" style="text-align:center">N I S</th>
		<th  style="text-align:center">NAMA SISWA</th>
		<th  width="5%" style="text-align:center">JK</th>
		<?php for( $i=0; $i < $jml; $i++ ): ?>
		 <th  style="text-align:center">PH <?= ($i+1); ?></th>
		 <?php endfor; ?>
	   <th style="text-align:center">NR</th>
		 </tr>
		<?php
		$no = 0;
		$stmt = $pdo->prepare("SELECT id_siswa, nama, nis, jk FROM siswa WHERE kelas = ?");
		$stmt->execute([$kelas]);

		while ($siswa = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$no++;
			echo "<tr>";
			echo "<td style='text-align:center'>{$no}</td>";
			echo "<td style='text-align:center'>{$siswa['nis']}</td>";
			echo "<td>" . ucwords(strtolower($siswa['nama'])) . "</td>";
			echo "<td style='text-align:center'>{$siswa['jk']}</td>";

			$stmt2 = $pdo->prepare("
				SELECT nilai 
				FROM nilai_harian 
				WHERE idsiswa = ? AND kelas = ? AND guru = ? AND mapel = ? 
				GROUP BY tanggal
			");
			$stmt2->execute([$siswa['id_siswa'], $kelas, $guru, $mapel]);
			while ($datax = $stmt2->fetch(PDO::FETCH_ASSOC)) {
				echo "<td style='text-align:center'>{$datax['nilai']}</td>";
			}

			$stmt3 = $pdo->prepare("
				SELECT AVG(nilai) AS rata 
				FROM nilai_harian 
				WHERE idsiswa = ? AND mapel = ?
			");
			$stmt3->execute([$siswa['id_siswa'], $mapel]);
			$rata = $stmt3->fetchColumn();

			echo "<td style='text-align:center'>" . round($rata) . "</td>";
			echo "</tr>";
		}
		?>
</table>
<br>
<table class="header-table">
	<tr>
		<td width="5%"></td>
		<td width='50px'></td>
		<td><br/><br/><br/><br/><br/><br/></td>
		<td width='20%'></td>
		<td width="5%"></td>
		<td>
		<?= ucwords(strtolower($setting['kecamatan'])); ?>, <?php echo  date("t",time()); ?> <?= bulan_indo($tanggal); ?> <?= date('Y') ?><br/>
		Guru Pengampu
		<br/><br/><br/><br/>
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
$dompdf->stream("PH ". $kelas . ".pdf", array("Attachment" => false));
exit(0);
?>