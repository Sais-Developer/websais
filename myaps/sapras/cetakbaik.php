<?php ob_start();
error_reporting(0);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
	$bulanmu = date('m');
	$tahun = date('Y');
    $bulane = fetch ('bulan', ['bln' =>$bulanmu]);
	$day =  cal_days_in_month(CAL_GREGORIAN, $bulanmu, $tahun);
	
	$sql_baik = "SELECT s.*, r.nama_ruangan, k.kategori
	FROM sapras s 
	LEFT JOIN sapras_kate k ON k.id=s.idk 
	LEFT JOIN sapras_ruangan r ON r.id=s.lokasi_id
	WHERE kondisi = 'Baik' ORDER BY nama_barang";
	$stmt_baik = $pdo->prepare($sql_baik);
	$stmt_baik->execute();
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
   
  <h4 class="text-center">REKAPITULASI BARANG DALAM KONDISI BAIK<br> BULAN <?= strtoupper($bulane['ket']) ?> <?= $tahun ?></h4>
		<br>
		 <table width='100%'>       
			  <tr>
				 <th>No.</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Keterangan</th>								
			</tr>
			   <?php
            $no = 1;
            while ($data_baik = $stmt_baik->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='text-center'>" . $no++ . "</td>";
                echo "<td>" . $data_baik['nama_barang'] . "</td>";
                echo "<td>" . $data_baik['kategori'] . "</td>"; 
                echo "<td class='text-center'>" . $data_baik['jumlah'] . "</td>";
                echo "<td>" . $data_baik['nama_ruangan'] . "</td>"; 
                echo "<td>" . $data_baik['keterangan'] . "</td>";
                echo "</tr>";
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
		<td width="30%">
			
		</td>
	   <td width="5%"></td>						
		<td>
			<?= ucwords(strtolower($setting['kecamatan'])); ?>, <?= $day; ?>  <?= $bulane['ket'] ?> <?= date('Y') ?><br/>
			Bendahara Barang<br/>
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
$dompdf->stream("Rekap_Kondisi_Baik Bulan ". $bulane['ket'] . ".pdf", array("Attachment" => false));
exit(0);
?>