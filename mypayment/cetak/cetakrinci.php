<?php ob_start();
error_reporting(0);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
    $bulanmu = $_GET['b'];
	$idpeg = $_GET['idpeg'];
	$bl = $_GET['b'];
	$tgl = $_GET['t'];	
	$tahun = date('Y');
	$peg = fetch('guru',array('id_guru'=>$idpeg));	
    $bulane = fetch ('bulan', ['bln' =>$bl]);
	$day =  cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
	
   function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut($nilai % 1000000000);
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut($nilai % 1000000000000);
    }
    return $temp;
}
function terbilang($nilai) {
    if ($nilai < 0) {
        return "minus " . trim(penyebut($nilai));
    } else {
        return trim(penyebut($nilai));
    }
}
	?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <title>Rincian <?= $bulane['ket'] ?>-<?= $tahun ?></title>
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
	   .bold {font-weight:bold;}
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
		  <h4 class="text-center">RINCIAN HONOR<br> BULAN <?= strtoupper($bulane['ket']) ?> <?= $tahun ?></h4>
			<br>
          <table class="header-table" width='100%'>      						
			<tr>
				<td width="2%"></td>
				<td width='100px'>Nama Lengkap</td>
				<td width='10px'>:</td>
				<td><?= $peg['nama'] ?></td>
				<td width="10%"></td>
				<td>Bulan</td>
				<td width='10px'>:</td>
				<td><?= $bulane['ket'] ?> <?= $tahun ?></td>
			</tr>
			<tr>
				<td></td>
				<td width='100px'>Jabatan</td>
				<td width='10px'>:</td>
				<td><?= $peg['jabatan'] ?></td>
				<td ></td>
				<td>Smt - TP</td>
				<td width='10px'>:</td>
				<td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
			</tr>
			</table>
				<br>
	        <table  width='100%'>       
				<tr>
				<th width="5%" height="40px" class="text-center">NO</th>
				<th  class="text-center">NAMA TUGAS</th>
				<th  width="12%"  class="text-center">JJM</th>
				<th  width="15%"  class="text-center">JUMLAH</th>
				<th width="15%" class="text-center">PPH</th>
				<th width="15%" class="text-center">DITERIMA</th>
				</tr>
            <?php
				$no = 0;
				$total_honor = 0;
				$sql = "
					SELECT g.id_guru, g.level,
					CASE 
						WHEN g.level = 'guru' THEN 'Mengajar' 
						WHEN g.level = 'staff' THEN 'Tugas TU' 
					END AS tugas,
					SUM(a.jjm) AS total_jjm,
					(SUM(a.jjm) * :honor) AS honor
					FROM guru g
					JOIN absen_jjm a ON g.id_guru = a.idpeg
					WHERE a.idpeg = :idpeg
					  AND a.bulan = :bulan
					  AND a.tahun = :tahun
					GROUP BY g.id_guru
				";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':honor', $setting['honor'], PDO::PARAM_INT);
				$stmt->bindParam(':idpeg', $idpeg, PDO::PARAM_INT);
				$stmt->bindParam(':bulan', $bulanmu, PDO::PARAM_STR);
				$stmt->bindParam(':tahun', $tahun, PDO::PARAM_STR);

				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($rows as $data) {
					$total_honor += $data['honor'];
					$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['tugas']); ?></td>
						<td style="text-align:center;"><?= (int)$data['total_jjm']; ?></td>
						<td style="text-align:right;"><?= number_format($data['honor'], 0, ',', '.'); ?></td>
						<td style="text-align:center;">0</td>
						<td style="text-align:right;font-weight:bold"><?= number_format($data['honor'], 0, ',', '.'); ?></td>
					</tr>
				<?php
				}
				?>
				<?php
				$sql2 = "
					SELECT p.idpeg, p.tugas, p.besar AS honor
					FROM pay_lain p
					WHERE p.idpeg = :idpeg
				";

				$stmt2 = $pdo->prepare($sql2);
				$stmt2->bindParam(':idpeg', $idpeg, PDO::PARAM_INT);
				$stmt2->execute();
				$rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

				foreach ($rows2 as $data2):
					$total_honor += $data2['honor'];
					$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data2['tugas']); ?></td>
						<td style="text-align:center;">-</td>
						<td style="text-align:right;"><?= number_format($data2['honor'], 0, ',', '.'); ?></td>
						<td style="text-align:center;">0</td>
						<td style="text-align:right;font-weight:bold"><?= number_format($data2['honor'], 0, ',', '.'); ?></td>
					</tr>
				<?php
				endforeach;
				?>
				<tr>
					<td colspan="4" style="text-align:right;font-weight:bold">TOTAL&nbsp;</td>
					<td style="text-align:center;font-weight:bold">0</td>
					<td style="text-align:right;font-weight:bold"><?= number_format($total_honor, 0, ',', '.') ?></td>
				</tr>
			</table>
			<br>
			 <table class="header-table" width='100%'>
					<tr>
					<td width="1%"></td>	
					<td width="30%">
					Mengetahui, <br/>							
					Kepala Sekolah
					<br/><br/><br/><br/>
					<u><?= $setting['kepsek'] ?></u><br/>
					NIP. <?= $setting['nip'] ?>
						</td>						
						<td width="30%" style="border: 1px solid #000; padding: 10px; text-align: center; vertical-align: top;">
							Lunas Bayar<br/>
							<?= date('d',strtotime($tgl)) ?> <?= $bulane['ket'] ?> <?= date('Y') ?>
							<br/><br/>
							Rp. <?= number_format($total_honor, 0, ',', '.') ?>
							<br/>
							<i><?= ucfirst(terbilang($total_honor)) . " rupiah"; ?></i>
							<br/><br/><br/>							
						</td>	
                         <td width="5%"></td>						
						<td>
							<?= ucwords(strtolower($setting['kecamatan'])); ?>, <?= $day; ?>  <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
							Bendahara Sekolah<br/>
							<br/>
							<br/>
							<br/>
							
							<u>.................................................</u><br/>
							NIP. 
						</td>
					</tr>
				</table>
</div>
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
$dompdf->stream("Rekap Pembayaran Bulan ". $bulane['ket'] . ".pdf", array("Attachment" => false));
exit(0);
?>