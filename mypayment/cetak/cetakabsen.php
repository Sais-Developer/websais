<?php ob_start();
error_reporting(0);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

	$idpeg = $_GET['idpeg'];
	$bl = $_GET['b'];	
	$tahun = date('Y');
	$peg = fetch($koneksi, 'guru',array('id_guru'=>$idpeg));	
    $bulane = fetch ($koneksi, 'bulan', ['bln' =>$bl]);
	$day =  cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
	?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>

    <title>Rincian KBM <?= $bulane['ket'] ?>-<?= $tahun ?></title>
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
		 <h4 class="text-center">RINCIAN KEGIATAN BELAJAR MENGAJAR<br> BULAN <?= strtoupper($bulane['ket']) ?> <?= $tahun ?></h4>
		<br>
    
								  <table class="header-table" width="100%">								
										<tr>
										<td width="10%"></td>
											 <td width='100px'>Nama Lengkap</td>
											<td width='10px'>:</td>
											<td><?= $peg['nama'] ?></td>
											<td width="10%"></td>
											<td width='100px'>Bulan</td>
											<td width='10px'>:</td>
											<td><?= $bulane['ket'] ?> <?= $tahun ?></td>
										</tr>
										
											<tr>
											<td width="10%"></td>
											<td width='100px'>Jabatan</td>
											<td width='10px'>:</td>
											<td><?= $peg['jabatan'] ?></td>
											<td ></td>
											 <td width='100px'>Smt - TP</td>
											<td width='10px'>:</td>
											<td><?= $setting['semester'] ?> - <?= $setting['tp'] ?></td>
											</tr>										
										</table>
									 <br>
	 
								 <table width='100%'>       
									  <tr>
										<th width="5%" height="40px" class="text-center">NO</th>
										<th  class="text-center">TANGGAL</th>
										<th  class="text-center">KELAS</th>
										<th  class="text-center">MATA PELAJARAN</th>
										<th class="text-center">JAM MASUK</th>
										<th class="text-center">JJM</th>
									</tr>
                                       <?php
										$no = 0;
										$stmt = $koneksi->prepare("SELECT * FROM absen_jjm a
											LEFT JOIN jadwal_mengajar j ON j.id_jadwal = a.jadwal
											LEFT JOIN mapel m ON m.id = j.mapel
											WHERE a.idpeg = ? AND a.bulan = ?");
										$stmt->bind_param("ss", $idpeg, $bl);
										$stmt->execute();
										$result = $stmt->get_result();

										while ($data = $result->fetch_assoc()) :
											$no++;
										?>
										<tr>
											<td style="text-align:center"><?= $no; ?></td>
											<td style="text-align:center"><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
											<td style="text-align:center"><?= $data['kelas'] ?></td>
											<td><?= $data['nama_mapel'] ?></td>
											<td style="text-align:center"><?= $data['masuk'] ?></td>
											<td style="text-align:center"><?= $data['jjm'] ?></td>
										</tr>
										<?php endwhile; ?>

										<?php
										
										$sum_stmt = $koneksi->prepare("SELECT SUM(jjm) AS jml FROM absen_jjm WHERE idpeg = ? AND bulan = ?");
										$sum_stmt->bind_param("ss", $idpeg, $bl);
										$sum_stmt->execute();
										$sum_result = $sum_stmt->get_result();
										$jumlah = $sum_result->fetch_assoc();
										?>
                            <tr>
							<td colspan="5" style="text-align:right;font-weight:bold">TOTAL&nbsp;</td>
							
							<td style="text-align:center;font-weight:bold"><?= $jumlah['jml'] ?></td>
							</tr>
							<?php
							$stmt->close();
							$sum_stmt->close();
							?>						
						</table>
						<br>
			
			<table class="header-table" width='100%'>
					<tr>
					<td width="5%"></td>	
					<td width="40%">
					Mengetahui, <br/>							
					Kepala Sekolah
					<br/><br/><br/><br/>
					<u><?= $setting['kepsek'] ?></u><br/>
					NIP. <?= $setting['nip'] ?>
						</td>						
						<td width="15%">
							
							
							<br/><br/>
							
							<br/><br/><br/><br/>							
						</td>						
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