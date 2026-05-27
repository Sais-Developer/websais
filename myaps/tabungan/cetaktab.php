<?php ob_start();
error_reporting(0);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
	$bulanmu = date('m');
	$tahun = date('Y');
    $bulane = fetch ('bulan', ['bln' =>$bulanmu]);
	$day =  cal_days_in_month(CAL_GREGORIAN, $bulanmu, $tahun);
	
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
    <title>Rekap Bulan <?= $bulane['ket'] ?>-<?= $tahun ?></title>
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
   
  <h4 class="text-center">DAFTAR PEMASUKAN TABUNGAN<br> BULAN <?= strtoupper($bulane['ket']) ?> <?= $tahun ?></h4>
		<br>
		 <table width='100%'>       
			  <tr>
				<th>NO</th>                                               
				<th>TANGGAL</th>
				<th>NAMA SISWA</th>
				<th>DEBET</th>									
			</tr>
			   <?php
				$no = 0;
				$zero = 0;
				$totalDebet = 0;

				$sql = "SELECT t.tanggal, MONTH(t.tanggal) AS bulan, t.debet, s.nama
						FROM saldo t
						LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
						WHERE t.debet > :zero AND MONTH(t.tanggal) = :bulanmu";

				try {
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
					$stmt->bindParam(':bulanmu', $bulanmu, PDO::PARAM_INT);
					
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$no++;
						$totalDebet += $data['debet'];
				?>
						<tr>
							<td class="text-center"><?= $no; ?></td>
							<td class="text-center"><?= htmlspecialchars($data['tanggal']); ?></td>
							<td><?= htmlspecialchars($data['nama']); ?></td>                                         
							<td style="text-align:right"><?= number_format($data['debet'], 0, ',', '.'); ?></td>
						</tr>
				<?php
					}
				?>
					<tr>
						<td colspan="3" style="text-align:right"><strong>Total Tabungan:</strong></td>
						<td style="text-align:right"><strong><?= number_format($totalDebet, 0, ',', '.'); ?></strong></td>
					</tr>
				<?php
				} catch (PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				?>

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
			Total Tabungan<br/>
			<?= $day; ?> <?= $bulane['ket'] ?> <?= date('Y') ?>
			<br/><br/>
			Rp. <?= number_format($totalDebet, 0, ',', '.'); ?>
			<br/>
			<i><?= ucfirst(terbilang($totalDebet)) . " rupiah"; ?></i>
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
$dompdf->stream("Rekap Tabungan ". $bulane['ket'] . ".pdf", array("Attachment" => false));
exit(0);
?>