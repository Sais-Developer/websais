<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");


$tahun = date('Y');
$ids   = $_GET['ids'] ?? '';

$stmtSiswa = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :ids LIMIT 1");
$stmtSiswa->execute([':ids' => $ids]);
$siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC);

$stmtWalas = $pdo->prepare("SELECT * FROM guru WHERE walas = :kelas LIMIT 1");
$stmtWalas->execute([':kelas' => $siswa['kelas']]);
$peg = $stmtWalas->fetch(PDO::FETCH_ASSOC);

if ($setting['semester'] == '1') {
    $smt = "Ganjil";
} elseif ($setting['semester'] == '2') {
    $smt = "Genap";
} else {
    $smt = "";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rapor PAS <?= ucwords(strtolower($siswa['nama'])) ?></title>
     <style>
        @page { 
		margin-top: 1cm; 
		margin-right: 1cm; 
		margin-bottom: 1cm; 
		margin-left: 1.5cm; 
		}
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; font-size: 12px; }
        th { background-color: #f0f0f0; }
       .header-table td { border: none; text-align: left; padding: 2px; }
       .text-center { text-align: center; }
	   .bold {font-weight:bold;}
     </style>
</head>
<body>
   
    <h4 class="text-center">LAPORAN HASIL BELAJAR<br>( RAPOR )</h4>
    <br>
   <table class="header-table" >       
			<tr>
                <td width="20%">Nama Peserta Didik</td>
                <td width="2%">:</td>
				<td width="35%"><?= ucwords(strtolower($siswa['nama'])) ?></td>
				<td width="10%"></td>
				<td width="15%">Kelas</td>
                <td width="2%">:</td>
				<td><?= $siswa['kelas'] ?></td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
				<td><?= $siswa['nis'] ?> /  <?= $siswa['nisn'] ?></td>
				<td></td>
				<td>Fase</td>
                <td>:</td>
				<td><?= $siswa['fase'] ?></td>
            </tr>
			<tr>
                <td>Nama Sekolah</td>
                <td>:</td>
				<td><?= $setting['sekolah'] ?></td>
				<td></td>
				<td>Semester</td>
                <td>:</td>
				<td><?= $setting['semester'] ?> <?= $smt; ?></td>
            </tr>
			<tr>
                <td>Alamat Sekolah</td>
                <td>:</td>
				<td><?= $setting['alamat'] ?></td>
				<td></td>
				<td>Tahun Ajaran</td>
                <td>:</td>
				<td><?= $setting['tp'] ?></td>
            </tr>
        </table>
       <br>
      <table>
         <tr class="bold text-center" style="background-color:#DCDCDC">
		 <td width="5%" >No.</td>
		 <td>Mata Pelajaran</td>
		 <td width="8%">Nilai<br>Akhir</td>
		 <td>Capaian Kompetensi</td>
		 </tr>
		 <?php
		 $stmt = $pdo->prepare("
				SELECT * 
				FROM mapel_rapor mr
				LEFT JOIN kode k ON k.id = mr.kelompok
				WHERE mr.tingkat = :tingkat AND mr.jurusan = :jurusan
				GROUP BY mr.kelompok
				ORDER BY mr.kelompok
			");

			$stmt->execute([
				':tingkat' => $siswa['level'],
				':jurusan' => $siswa['jurusan']
			]);
			$no = 0;
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
		?>
			<?php if($data['sub']<>''): ?>
             <tr>
                <td colspan="4"><?= $data['sub'] ?></td>
			</tr>
			<?php endif; ?>	 
			<tr>	 
				<td colspan="4" class="bold">&nbsp;<?= $data['ket'] ?></td>	
            </tr>
            <?php
			$stmtNil = $pdo->prepare("
				SELECT * 
				FROM mapel_rapor mp
				LEFT JOIN mapel m ON m.id = mp.idmapel
				LEFT JOIN nilai_capaian nc ON nc.idmapel = mp.idmapel
				WHERE mp.tingkat = :tingkat
				  AND mp.jurusan = :jurusan
				  AND mp.kelompok = :kelompok
				  AND nc.idsiswa = :idsiswa
				  AND nc.ket = 'PAS'
				  AND nc.semester = :semester
				  AND nc.tapel = :tapel
				ORDER BY mp.id ASC
			");
			$stmtNil->execute([
				':tingkat'  => $siswa['level'],
				':jurusan'  => $siswa['jurusan'],
				':kelompok' => $data['kelompok'],
				':idsiswa'  => $siswa['id_siswa'],
				':semester' => $setting['semester'],
				':tapel'    => $setting['tp']
			]);

			while ($nilai = $stmtNil->fetch(PDO::FETCH_ASSOC)) {
				$no++;
			   
			?>
            <tr>
			<td class="text-center" style="vertical-align:top"> <?= $no ?></td>
			<td style="vertical-align:top"> <?= $nilai['nama_mapel'] ?></td>
			<td class="text-center"> <?= $nilai['nilai'] ?></td>
			<td style="text-align:justify"> <?= ucwords(strtolower($siswa['nama'])) ?> menunjukan pemahaman dalam <?= strtolower($nilai['tinggi']) ?>
			dan membutuhkan bimbingan dalam <?= strtolower($nilai['rendah']) ?>
			</td>
			</tr>
			<?php }}  ?>
			
		 </table>
		 <br>
		 <?php 
		    $stmtKoku = $pdo->prepare("
				SELECT * 
				FROM kokurikuler 
				WHERE idsiswa = :idsiswa 
				  AND keter = 'PAS' 
				  AND smt = :semester 
				  AND tapel = :tapel
			");
			$stmtKoku->execute([
				':idsiswa' => $ids,
				':semester' => $semester,
				':tapel' => $tapel
			]);

			$koku = $stmtKoku->fetch(PDO::FETCH_ASSOC);
		 ?>
		<table style="width:100%">
         <tr class="bold" style="background-color:#DCDCDC;">
		 <td>&nbsp;&nbsp;Kokurikuler</td>
		 </tr>
		 <tr>
		 <td style="text-align:justify">
		 <?php if($koku['mampu'] !== null) : ?>
		 <?= ucwords(strtolower($siswa['nama'])) ?> mampu <?= $koku['mampu'] ?>, namun perlu bimbimgan dalam <?= $koku['kurang'] ?>
		 <?php endif; ?>
		 </td>
		</tr>
		 </table>
            <br>
		<table style="width:100%">
         <tr class="bold text-center" style="background-color:#DCDCDC;">
		 <td width="5%" >No.</td>
		 <td width="41%">Ekstrakurikuler</td>
		 <td>Keterangan</td>
		 </tr>
		  <?php
		$stmt3 = $pdo->prepare("
			SELECT me.*, p.nilai, p.deskripsi
			FROM m_eskul me
			LEFT JOIN peskul p 
				ON p.eskul = me.eskul
				AND p.idsiswa = :idsiswa
				AND p.ket = 'PAS'
				AND p.semester = :semester
				AND p.tapel = :tapel
			ORDER BY me.eskul ASC
		");

		$stmt3->execute([
			':idsiswa' => $ids,
			':semester' => $semester,
			':tapel' => $tapel
		]);

		$eskul = $stmt3->fetchAll(PDO::FETCH_ASSOC);
		$no = 0;
		foreach ($eskul as $data) {
			$no++;
			
		?>
		<tr style="vertical-align:top">
		<td class="text-center"><?= $no; ?></td>
		<td><?= $data['eskul'] ?></td>
		<td style="text-align:justify">
		<?php if($data['deskripsi'] !== null) : ?>
		<?=  ucwords(strtolower($siswa['nama'])) ?> <?= $data['deskripsi'] ?>
		<?php endif; ?>
		</td>
		<?php } ?>
		
		 </table>
		 <br>
		<style>
		table {
		  border-collapse: collapse;
		}
		.inner-table {
		  width: 100%;
		  border: 1px solid #000; /* tabel dalam punya border */
		}
		.inner-table th, .inner-table td {
		  border: 1px solid #000;
		  padding: 4px;
		}
		</style>
		<?php
	$stmtAbsen = $pdo->prepare("
			SELECT sakit, izin, alpha 
			FROM absen_rapor 
			WHERE idsiswa = :idsiswa AND semester = :semester AND tapel = :tapel AND ket = 'PAS'
		");
		$stmtAbsen->execute([
			':idsiswa' => $ids,
			':semester' => $semester,
			':tapel' => $tapel
		]);

		$Absen = $stmtAbsen->fetch(PDO::FETCH_ASSOC);

		if (!$Absen) {
			$Absen = [
				'sakit' => 0,
				'izin'  => 0,
				'alpha' => 0
			];
		}
	?>

<table style="width:100%; border:none;">
  <tr>
    <td style="width:45%; vertical-align:top; border:none;">
      <table class="inner-table" style="margin-left:-5px">
        <tr style="background-color:#DCDCDC;">
		<td colspan="2" class="bold text-center">Kehadiran</td>
		</tr>
        <tr>
		<td>Sakit</td>
		<td><?= $Absen['sakit'] ?> hari</td>
		</tr>
		<tr>
		<td>Izin</td>
		<td><?= $Absen['izin'] ?> hari</td>
		</tr>
		<tr>
		<td>Tanpa Keterangan</td>
		<td><?= $Absen['alpha'] ?> hari</td>
		</tr>
      </table>
    </td>
		<?php
		$stmtCatat = $pdo->prepare("
			SELECT catatan
			FROM catatan_rapor 
			WHERE idsiswa = :idsiswa AND semester = :semester AND tapel = :tapel AND ket = 'PAS'
		");
		$stmtCatat->execute([
			':idsiswa' => $ids,
			':semester' => $semester,
			':tapel' => $tapel
		]);

		$Catat = $stmtCatat->fetch(PDO::FETCH_ASSOC);

		if (!$Catat) {
			$Catat = [
				'catatan' => ''
			];
		}
		?>
	<td style="width:5%; vertical-align:top; border:none;"></td>
    <td style="width:45%; vertical-align:top; border:none;">
      <table class="inner-table" style="margin-left:5px">
        <tr style="background-color:#DCDCDC;">
		<td>Catatan Wali Kelas</td>		
		</tr>
        <tr>
		<td height="60px" style="vertical-align:top"><?= $Catat['catatan'] ?></td>
		</tr>
      </table>
    </td>
  </tr>
</table>
<?php
		$stmt6 = $pdo->prepare("
			SELECT tanggal 
			FROM tanggal_rapor
			WHERE semester = :semester AND tapel = :tapel AND ket = 'PAS'
		");
		$stmt6->execute([
			':semester' => $semester,
			':tapel' => $tapel
		]);

		$rapor = $stmt6->fetch(PDO::FETCH_ASSOC);
		if (!$rapor) {
			$rapor = ['tanggal' => ''];
		}
		?>
    <br><table width="100%"class="header-table" style="text-align:center; margin-left:40px;">
    <tr>
        <td width="33%">
            Mengetahui,<br>
            Orang Tua/Wali
            <br><br><br><br>
            <u>_________________________</u><br>
        </td>
        <td width="33%">
            Mengetahui,<br>
            Kepala Sekolah
            <br><br><br><br>
            <u><strong>(<?= $setting['kepsek'] ?>)</strong></u><br>
            NIP. <?= $setting['nip'] ?>
        </td>
        <td width="33%">
           <?= ucwords(strtolower($setting['kabuPASen'])); ?>, <?= $rapor['tanggal'] ?><br/>
			Wali Kelas <?= $siswa['kelas'] ?><br>
            <br><br><br><br>
            <u><strong>(<?= $peg['nama'] ?>)</strong></u><br>
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
$dompdf->setPaper('A4', 'Potrait');
$dompdf->render();
$dompdf->stream("Rapor_PAS_".$siswa['nama'].".pdf", ["Attachment" => false]);
exit(0);
?>
