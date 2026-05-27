<?php
ob_start();
error_reporting(E_ALL);
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");

$kelas = $_GET['k'] ?? '';

$bl    = date('m');
$tahun = (int)date('Y');
$day   = date('d');

$peg = fetch('guru', ['walas' => $kelas]);
$bulane = fetch('bulan', ['bln' => $bl]);
$dayCount = cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Rekap 7KAIH Kelas <?= htmlspecialchars($kelas) ?></title>
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
    .header-table td { border: none; text-align: left; padding: 2px; }
    .text-center { text-align: center; }
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
    <hr>
    <center><h4>REKAPITULASI KEBIASAAN HARIAN SISWA</h4></center>

    <table class="header-table">
        <tr>
            <td>Sekolah</td><td>:</td><td><?= $setting['sekolah'] ?? '' ?></td>
            <td>Bulan</td><td>:</td><td><?= $bulane['ket'] ?? '' ?> <?= $tahun ?></td>
        </tr>
        <tr>
            <td>Kelas</td><td>:</td><td><?= htmlspecialchars($kelas) ?></td>
            <td>Smt - TP</td><td>:</td><td><?= ($setting['semester'] ?? '') ?> - <?= ($setting['tp'] ?? '') ?></td>
        </tr>
    </table>

    <br>
    <table>
        <tr>
            <th width="2%" rowspan="2">No</th>
            <th rowspan="2">Nama Siswa</th>
            <th colspan="7">Ibadah</th>
            <th rowspan="2" width="3%">OR</th>
            <th rowspan="2" width="3%">GM</th>
            <th rowspan="2" width="3%">BM</th>
        </tr>
        <tr>
            <th width="3%">Subuh</th>
            <th width="3%">Dzuhur</th>
            <th width="3%">Ashar</th>
            <th width="3%">Maghrib</th>
            <th width="3%">Isya</th>
            <th width="3%">Duha</th>
            <th width="3%">Lainnya</th>
        </tr>
		<?php
		$bulan = date('m');
		$tahun = date('Y');

		$sql = "
		SELECT s.kelas, s.id_siswa, s.nama, 
			COALESCE(SUM(ks.subuh),0) AS subuh,
			COALESCE(SUM(ks.dzuhur),0) AS dzuhur,
			COALESCE(SUM(ks.ashar),0) AS ashar,
			COALESCE(SUM(ks.maghrib),0) AS maghrib,
			COALESCE(SUM(ks.isya),0) AS isya,
			COALESCE(SUM(ks.dhuha),0) AS duha,
			COALESCE(SUM(CASE WHEN COALESCE(ks.ibadah_lainnya,'') <> '' THEN 1 ELSE 0 END),0) AS lainnya,
			COALESCE(SUM(CASE WHEN COALESCE(ks.olahraga_jenis,'') <> '' THEN 1 ELSE 0 END),0) AS olah,
			COALESCE(SUM(CASE WHEN COALESCE(ks.mapel,'') <> '' THEN 1 ELSE 0 END),0) AS pel,
			COALESCE(SUM(CASE WHEN ks.kegiatan_masyarakat = 'Ya' THEN 1 ELSE 0 END),0) AS keg
		FROM siswa s
		LEFT JOIN kebiasaan_harian ks ON s.id_siswa = ks.id_siswa
			AND MONTH(ks.tanggal) = :bulan 
			AND YEAR(ks.tanggal) = :tahun 
			AND ks.kelas = :kelas
		WHERE s.kelas = :kelas2
		GROUP BY s.id_siswa
		ORDER BY s.kelas, s.nama
		";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':bulan'  => $bulan,
			':tahun'  => $tahun,
			':kelas'  => $kelas,
			':kelas2' => $kelas
		]);

		$no = 0;
		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$no++;
		?>
		<tr>
			<td class="text-center"><?= $no; ?></td>
			<td><?= htmlspecialchars($data['nama']) ?></td>
			<td class="text-center"><?= $data['subuh'] ?> </td>
			<td class="text-center"><?= $data['dzuhur'] ?> </td>
			<td class="text-center"><?= $data['ashar'] ?></td>
			<td class="text-center"><?= $data['maghrib'] ?></td>
			<td class="text-center"><?= $data['isya'] ?></td>
			<td class="text-center"><?= $data['duha'] ?></td>
			<td class="text-center"><?= $data['lainnya'] ?></td>
			<td class="text-center"><?= $data['olah'] ?></td>
			<td class="text-center"><?= $data['pel'] ?></td>
			<td class="text-center"><?= $data['keg'] ?></td>
		</tr>
		<?php endwhile; ?>
    </table>

    <p>OR: OLAHRAGA | GM: GEMAR BELAJAR | BM: BERMASYARAKAT</p>

    <br>
    <table class="header-table">
        <tr>
            <td width="5%"></td>
            <td width='50px'></td>
            <td>
                Mengetahui, <br>							
                Kepala Sekolah
                <br><br><br><br>
                <u><?= $setting['kepsek'] ?></u><br/>
                NIP. <?= $setting['nip'] ?>
            </td>
            <td width='10%'></td>
            <td width="5%"></td>
            <td>
                <?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= $day; ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
                Wali Kelas <?= $kelas ?><br>
                <br><br><br>
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("7KAIH_Kelas_".$kelas."_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit(0);
?>
