<?php 
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
	
$kelas = $_GET['k'];
$bl = $_GET['b'];
$dudi = $_GET['d'];

$sql = "SELECT nama, nip FROM guru WHERE walas = :kelas";
$stmt = $pdo->prepare($sql);
$stmt->execute(['kelas' => $kelas]);
$peg = $stmt->fetch(PDO::FETCH_ASSOC);

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
<title>PRESENSI PRAKERIN</title>
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

<center><h4 style="font-size:14px;font-weight:bold">REKAPITULASI PRESENSI PRAKERIN</h4></center>
<br>
 <table class="header-table">
	<tr>
	<td width="10%"></td>
		 <td width='100px'>Lokasi</td>
		<td width='10px'>:</td>
		<td><?= $dudix['nama_dudi'] ?></td>
		<td width="20%"></td>
		<td width='100px'>Bulan</td>
		<td width='10px'>:</td>
		<td><?= $bulane['ket'] ?> <?= date('Y') ?></td>
	</tr>
	
		<tr>
		<td width="10%"></td>
		<td width='100px'>Kelas</td>
		<td width='10px'>:</td>
		<td><?= $kelas ?></td>
		<td ></td>
		 <td width='100px'>Smt - TP</td>
		<td width='10px'>:</td>
		<td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
		</tr>
   </table>
<br>
<table  width='100%'>       
    <tr>
        <th width="2%" height="40px">No</th>
        <th>Nama Siswa</th>
        <th width="7%">Jurusan</th>
        <?php
        $bulan = $bl;
        $tahun = date('Y');
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        for ($i = 1; $i <= $tanggal; $i++) { 
            $date1 = date("D", strtotime("$tahun-$bulan-$i"));
        ?>
            <th width="2%">
                <?php if($date1 == 'Sun') { ?>				
                    <b style="color:red"><?= $i ?></b>
                <?php } else { ?>
                    <?= $i ?>
                <?php } ?>
            </th>
        <?php } ?>
        <th width="1%">H</th>
        <th width="1%">S</th>
        <th width="1%">I</th>
        <th width="1%">A</th>
    </tr>
			   <?php
				$stmt_siswa = $pdo->prepare("
				SELECT p.kelas, s.id_siswa, s.nama, s.jurusan
				FROM pkl_siswa p
				LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
				WHERE p.kelas = ? AND p.dudi = ?
				GROUP BY p.idsiswa
			");
			$stmt_siswa->execute([$kelas, $dudi]);
			$no = 0;
			while ($siswa = $stmt_siswa->fetch(PDO::FETCH_ASSOC)) {
				$stmt_hadir = $pdo->prepare("
					SELECT COUNT(*) FROM pkl_presensi 
					WHERE idsiswa = ? AND ket = 'H' AND MONTH(tanggal) = ?
				");
				$stmt_hadir->execute([$siswa['id_siswa'], $bulan]);
				$hadir = $stmt_hadir->fetchColumn(); 
				$stmt_sakit = $pdo->prepare("
					SELECT COUNT(*) FROM pkl_presensi 
					WHERE idsiswa = ? AND ket = 'S' AND MONTH(tanggal) = ?
				");
				$stmt_sakit->execute([$siswa['id_siswa'], $bulan]);
				$sakit = $stmt_sakit->fetchColumn();
				$stmt_izin = $pdo->prepare("
					SELECT COUNT(*) FROM pkl_presensi 
					WHERE idsiswa = ? AND ket = 'I' AND MONTH(tanggal) = ?
				");
				$stmt_izin->execute([$siswa['id_siswa'], $bulan]);
				$izin = $stmt_izin->fetchColumn();
				$stmt_alpha = $pdo->prepare("
					SELECT COUNT(*) FROM pkl_presensi 
					WHERE idsiswa = ? AND ket = 'A' AND MONTH(tanggal) = ?
				");
				$stmt_alpha->execute([$siswa['id_siswa'], $bulan]);
				$alpha = $stmt_alpha->fetchColumn();
				$no++;
			?>
        <tr>
            <td class="text-center"><?= $no; ?></td>
            <td><?= ucwords(strtolower($siswa['nama'])) ?></td>
            <td style="text-align:center"><?= $siswa['jurusan'] ?></td>

            <?php 
				for ($i = 1; $i <= $tanggal; $i++) {  
					$tanggalbaru = date('Y-m-d', mktime(0, 0, 0, $bulan, $i, $tahun));
					$date2 = date("D", strtotime("$tahun-$bulan-$i"));
					$stmt_absen = $pdo->prepare("SELECT * FROM pkl_presensi WHERE tanggal = ? AND idsiswa = ?");
					$stmt_absen->execute([$tanggalbaru, $siswa['id_siswa']]);
					$cekabsen = $stmt_absen->fetch(PDO::FETCH_ASSOC);

					if ($cekabsen) { ?>
						<td style="text-align:center"><b><?= htmlspecialchars($cekabsen['ket']) ?></b></td> 
					<?php } else { 
						if ($date2 == 'Sun') : ?>
							<td style="color:white;background-color:red" class="text-center">X</td>
						<?php else : ?>
							<td></td> 
						<?php endif; 
					} 
				} ?>  
            <td style="text-align:center"><?= $hadir; ?></td>
            <td style="text-align:center"><?= $sakit; ?></td>
            <td style="text-align:center"><?= $izin; ?></td>
            <td style="text-align:center"><?= $alpha; ?></td>
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
						<td>
							Mengetahui, <br/>
							
					Kepala Sekolah
					<br/>
							<br/>
							<br/>
							<br/>
							
							<u><?= $setting['kepsek'] ?></u><br/>
							NIP. <?= $setting['nip'] ?>
						</td>
						<td width='20%'></td>
						<td width="5%"></td>
						<td>
							<?= ucwords(strtolower($setting['kecamatan'])); ?>, <?php echo date("t",time()); ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
							Wali Kelas <?= $kelas ?><br/>
							<br/>
							<br/>
							
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
$dompdf->stream("Absen Kelas " . $kelas . " Bulan " . $bl . ".pdf", array("Attachment" => false));
exit(0);
?>
