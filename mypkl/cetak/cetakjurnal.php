<?php 
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
	
	$ids = $_GET['s'];
	$bl = $_GET['b'];
    $dudi = $_GET['d'];
	$siswa = fetch('siswa',['id_siswa'=>$ids]);
	
	$sql = "SELECT * FROM bulan WHERE bln = :bl";
	$stmt_bulan = $pdo->prepare($sql);
	$stmt_bulan->execute(['bl' => $bl]);
	$bulane = $stmt_bulan->fetch(PDO::FETCH_ASSOC);

	$stmt_dudi = $pdo->prepare("SELECT * FROM pkl_dudi WHERE id = ?");
	$stmt_dudi->execute([$dudi]); 
	$dudix = $stmt_dudi->fetch(PDO::FETCH_ASSOC);
	?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>JURNAL PRAKERIN</title>
<style>
    @page { 
        margin-top: 1cm; 
        margin-right: 1cm; 
        margin-bottom: 1cm; 
        margin-left: 1cm; 
    }
    body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 4px; font-size: 13px; }
    th { background-color: #f0f0f0; }
    .header-table td { border: none; text-align: left; padding: 2px; }
    .text-center { text-align: center; }
    .bold { font-weight: bold; }
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
		<center><h4 style="font-size:14px;font-weight:bold">REKAPITULASI JURNAL  PRAKERIN <?= $siswa['jurusan'] ?></h4></center>
		<br>
        <table class="header-table">
            <tr>
			    <td width="10%"></td>
                <td width='100px'>Nama Siswa</td>
                <td width='10px'>:</td>
                <td><?= $siswa['nama'] ?></td>
				<td width="5%"></td>
				<td width='80px'>Bulan</td>
                <td width='10px'>:</td>
                <td><?= $bulane['ket'] ?> <?= date('Y') ?></td>
            </tr>
            <tr>
				<td></td>
                <td>Kelas</td>
                <td>:</td>
                <td><?= $siswa['kelas'] ?></td>
				<td ></td>
				 <td>Smt - TP</td>
                <td>:</td>
                <td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
		    </tr>
    </table>
     <br>
	 <table width="100%">
	 <tr>
	    <th width="3%">NO</th>
		<th width="10%">TANGGAL</th>
		<th>KOMPETENSI</th>
		<th>JURNAL KEGIATAN</th>
		<th width="10%">FOTO</th>
		<th>CATATAN</th>
		<th width="10%">TTD INSTRUKTUR</th>
	 </tr>
	 <?php
$sql = "
    SELECT j.*, k.kompeten
    FROM pkl_jurnal j
    LEFT JOIN pkl_kompetensi k ON k.id_kompetensi = j.idk
    WHERE j.idsiswa = ? AND MONTH(j.tanggal) = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$ids, $bl]); // Kirim parameter sebagai array

$no = 0;
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $no++;
?>

<tr style="vertical-align:top">
    <td class="text-center"><?= $no; ?></td>
    <td class="text-center"><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
    <td><?= htmlspecialchars($data['kompeten']) ?></td>
    <td><?= htmlspecialchars($data['jurnal']) ?></td>
    <td class="text-center">
        <?php if($data['foto_jurnal'] != ''): ?>
            <img src="<?= htmlspecialchars($baseurl) ?>/images/fotopkl/<?= htmlspecialchars($data['foto_jurnal']) ?>" style="width:80px;height:40px">
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($data['catatan']) ?></td>
    <td class="text-center">
        <?php if($data['ttd'] != ''): ?>
            <img src="<?= htmlspecialchars($baseurl) ?>/images/ttd/<?= htmlspecialchars($data['ttd']) ?>" style="width:120px;height:30px">
            <p><?= htmlspecialchars($data['pembina']) ?></p>
        <?php endif; ?>
    </td>
</tr>

<?php endwhile; ?>

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
$dompdf->stream("Jurnal ".$siswa['nama']." Bulan ". $bl . ".pdf", array("Attachment" => false));
exit(0);
?>