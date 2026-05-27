<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php"); 
require("../../konek/function.php");

$idj   = $_GET['idjadwal'] ?? 0;
$kelas = $_GET['kelas'] ?? '';
$bl    = date('m');

$stmt2 = $db->prepare("SELECT * FROM bulan WHERE bln = :bln");
$stmt2->execute([':bln' => $bl]);
$bulane = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $db->prepare("
    SELECT j.*, g.nama, g.nip, m.kode
    FROM jadwal_mengajar j
    LEFT JOIN guru g ON g.id_guru = j.guru
    LEFT JOIN mapel m ON m.id = j.mapel
    WHERE j.id_jadwal = :id_jadwal
");
$stmt3->execute([':id_jadwal' => $idj]);
$datax = $stmt3->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
 <title>PRESENSI HARIAN</title>
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
		<td width='100px'>Mata Pelajaran</td>
		<td width='10px'>:</td>
		<td><?= $datax['kode'] ?></td>
		<td width='200px'></td>
		<td width='150px'>Semester</td>
		<td width='10px'>:</td>
		<td><?= $setting['semester'] ?></td>
		</tr>		
		<tr>
		<td width='100px'>Kelas</td>
		<td width='10px'>:</td>
		<td><?= $kelas ?></td>
		<td width='200px'></td>
		 <td width='150px'>Tahun Pelajaran</td>
		<td width='10px'>:</td>
		<td> <?= $setting['tp'] ?></td>
		</tr>
	 </table>
<br>
 <table width='100%'>       
	  <tr height='40px'>
			<th width="5%">NO.</th>					
			<th width="15%">N I S</th>
			 <th>NAMA SISWA</th>
			
			<th width="10%">JK</th>
			<th width="10%" >KET</th>
			<th width="20%">KETERANGAN</th>
		   </tr>
			<?php
			$tanggalHariIni = date('Y-m-d');

			$sql = "SELECT s.id_siswa, s.nis, s.jk, s.kelas, s.nama, a.ket AS absen_hari_ini
					FROM siswa s
					LEFT JOIN absensi a 
						ON a.idsiswa = s.id_siswa AND a.tanggal = :tanggal
					WHERE s.kelas = :kelas
					GROUP BY s.id_siswa
					ORDER BY s.nama ASC";

			$stmt = $db->prepare($sql);
			$stmt->execute([
				':tanggal' => $tanggalHariIni,
				':kelas'   => $kelas
			]);

			$no = 0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$no++;
				$absen = $row['absen_hari_ini'] ?? '';
				?>
				<tr>
					<td class="text-center"><?= $no ?></td>
					<td class="text-center"><?= htmlspecialchars($row['nis'], ENT_QUOTES) ?></td>
					<td><?= htmlspecialchars($row['nama'], ENT_QUOTES) ?></td>
					<td class="text-center"><?= htmlspecialchars($row['jk'], ENT_QUOTES) ?></td>
					<td class="text-center"><?= htmlspecialchars($absen, ENT_QUOTES) ?></td>
					<td></td>
				</tr>
			<?php
			}
			?>
	</table>
	<br>
	<p>H : HADIR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S : SAKIT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I : IZIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A : TANPA KETERANGAN</p>
	  <br>
	 <table class="header-table">
			<tr>
			<td width="5%"></td>
			<td width='50px'></td>
				<td><br><br><br><br></td>
				<td width='15%'></td>
				<td width="5%"></td>
				<td>
					<?= $setting['kabupaten'] ?>, <?php echo date('d'); ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
					Guru Mapel <?= $datax['kode'] ?>
					<br><br><br><br>
					<u><b><?= $datax['nama'] ?></b></u><br>
					NIP. <?= $datax['nip'] ?>
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
$dompdf->stream("Absensi_Harian_Kelas ". $kelas . " Tanggal ". date('d-m-Y'). ".pdf", array("Attachment" => false));
exit;
?>
