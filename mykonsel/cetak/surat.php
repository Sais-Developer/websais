<?php
ob_start();
error_reporting(0);

require("../../konek/koneksi.php");
require("../../konek/function.php");

$idsiswa = $_GET['s'] ?? null;
$idtegur = $_GET['t'] ?? null;
$bln = date('m');  
$tahun = date('Y');

$stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :id LIMIT 1");
$stmt->execute(['id' => $idsiswa]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null; 
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>

    <title>Rincian KBM <?= $bulane['ket'] ?>-<?= $tahun ?></title>
<style>
        @page { 
		margin-top: 0.8cm; 
		margin-right: 1.5cm; 
		margin-bottom: 0.8cm; 
		margin-left: 1.5cm; 
		}
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; font-size: 14px; }
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
		<?php 
		if($idtegur==2): 
		$surat = 'SURAT PERINGATAN I (SP 1)';
		$nomor = '420/SP1/'.$tahun;
		elseif($idtegur==3):
		$surat = 'SURAT PERINGATAN II (SP 2)';
		$nomor = '420/SP2/'.$tahun;
		elseif($idtegur==4):
		$surat = 'SURAT PERINGATAN II (SP 3)';
		$nomor = '420/SP3/'.$tahun;
		elseif($idtegur==5):
		$surat = 'SURAT SKORSING';
		$nomor = '420/SKR/'.$tahun;
		elseif($idtegur==6):
		$surat = 'PEMBERHENTIAN SISWA (DO)';
		$nomor = '420/DO/'.$tahun;
		endif;
		?>
		
		<h4 class="text-center"><?= $surat; ?></h4>
           <p class="text-center" style="margin-top:-15px;"> Nomor: <?= $nomor ?></p>	
			
		<table class="header-table">
		<tr><td colspan="2">Kepada Yth.</td></tr>
    	<tr><td colspan="2" class="bold">Orang Tua / Wali dari :</td></tr>
		<tr>
		<td width="15%">Nama</td>
		<td>: <?= $siswa['nama'] ?></td>
		</tr>
		<tr>
		<td>Kelas</td>
		<td>: <?= $siswa['kelas'] ?></td>
		</tr>
		<tr>
		<td>N I S</td>
		<td>: <?= $siswa['nis'] ?></td>
		</tr>
		<tr><td colspan="2"><br>di Tempat</td></tr>
		</table>
		<br><br>
		<b>Dengan hormat,</b>
       <?php if($idtegur==2): ?>		
		<p style="text-align:justify">Berdasarkan hasil pemantauan dan pencatatan pelanggaran tata tertib di <?= $setting['sekolah'] ?>, 
		siswa atas nama tersebut di atas telah melakukan pelanggaran pertama dengan rincian sebagai berikut:</p>
		<?php elseif($idtegur==3): ?>	
		<p style="text-align:justify">Berdasarkan hasil pemantauan dan pencatatan pelanggaran tata tertib siswa di <?= $setting['sekolah'] ?>, 
		kami sampaikan bahwa siswa atas nama tersebut di atas telah melanggar tata tertib sekolah secara berulang, sehingga yang bersangkutan 
		telah mencapai batas poin pelanggaran untuk tingkat Surat Peringatan II (SP 2), dengan rincian sebagai berikut:</p>
		<?php elseif($idtegur==4): ?>	
		<p style="text-align:justify">Berdasarkan hasil evaluasi dan catatan pelanggaran tata tertib di <?= $setting['sekolah'] ?>,
		kami sampaikan bahwa siswa atas nama tersebut di atas telah melakukan pelanggaran berulang terhadap tata tertib sekolah,
		dengan rincian sebagai berikut:</p>
		<?php elseif($idtegur==5): ?>	
		<p style="text-align:justify">Berdasarkan hasil evaluasi dan catatan pelanggaran tata tertib siswa di <?= $setting['sekolah'] ?>,
		dengan sangat menyesal kami sampaikan bahwa siswa atas nama tersebut di atas telah melakukan pelanggaran berat terhadap peraturan sekolah,
		dengan rincian sebagai berikut:</p>
		<?php elseif($idtegur==6): ?>
		<p style="text-align:justify">Sehubungan dengan catatan pelanggaran dan/atau alasan administratif yang telah dipertimbangkan oleh pihak sekolah,
		dengan ini kami menyampaikan bahwa siswa atas nama tersebut di atas diberhentikan/dikeluarkan dari <?= $setting['sekolah'] ?>,
		dengan ketentuan sebagai berikut:</p>
		<b>Telah melakukan pelanggaran berat.</b> dengan rincian sebagai berikut :
		<br><br>
		<?php endif; ?>
		
		
		<table style="width:70%;margin-left:90px">
		<tr>
		<th>No.</th>
		<th>Tanggal</th>
		<th>Jenis Pelanggaran</th>
		<th>Poin</th>
		</tr>
		<?php
			$no = 0;
			$sql = "
				SELECT c.tanggal, c.poin, p.nama_pelanggaran
				FROM catatan_pelanggaran c 
				LEFT JOIN pelanggaran p ON p.id = c.idpel
				WHERE c.id_siswa = :idsiswa AND c.status = 0
				ORDER BY c.tanggal ASC
			";

			$stmt = $pdo->prepare($sql);
			$stmt->execute(['idsiswa' => $idsiswa]);
			$catatan = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($catatan as $data):
				$no++;
			?>
			<tr>
				<td class="text-center"><?= $no ?></td>
				<td class="text-center"><?= htmlspecialchars($data['tanggal']) ?></td>
				<td><?= htmlspecialchars($data['nama_pelanggaran']) ?></td>
				<td class="text-center"><?= $data['poin'] ?></td>
			</tr>
			<?php
			endforeach;
			$stmt = null; 
			?>
	</table>
	<br>
	<?php if($idtegur==2): ?>
	<p style="text-align:justify">Sehubungan dengan hal tersebut, kami memberikan Surat Peringatan I (SP 1) sebagai peringatan awal agar siswa dapat memperbaiki perilaku dan tidak mengulangi pelanggaran serupa.</p>
	<p style="text-align:justify">Apabila pelanggaran terjadi kembali, pihak sekolah akan memberikan SP 2 atau tindakan disiplin sesuai ketentuan tata tertib sekolah.</p>
    <p style="text-align:justify">Demikian surat peringatan ini disampaikan untuk diketahui dan diperhatikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>
	<?php endif; ?>
		<?php if($idtegur==3): ?>	
			Teguran sebelumnya  : telah diberikan berupa Surat Peringatan 1 (SP 1).<br>
		<p style="text-align:justify">Sehubungan dengan hal tersebut, maka pihak sekolah memberikan Surat Peringatan II (SP 2) sebagai peringatan keras agar yang bersangkutan tidak mengulangi pelanggaran serupa.</p>
        <p style="text-align:justify">Apabila masih terjadi pelanggaran setelah diterbitkannya surat ini, maka sekolah akan memberikan Surat Peringatan III (SP 3) yang dapat berujung pada pemanggilan orang tua atau sanksi administratif lebih lanjut.</p>
        <p style="text-align:justify">Demikian surat peringatan ini dibuat untuk diketahui dan dilaksanakan dengan penuh kesadaran. Atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
		<?php endif; ?>
	<?php if($idtegur==4): ?>
    Teguran Sebelumnya  :<br>
    1.Surat Peringatan I (SP 1)<br> 
    2.Surat Peringatan II (SP 2)<br> 
   <p style="text-align:justify">Sehubungan dengan hal tersebut, sekolah memutuskan untuk memberikan Surat Peringatan III (SP 3) sebagai peringatan terakhir agar siswa tidak mengulangi pelanggaran tata tertib.</p>
    <p style="text-align:justify">Apabila setelah surat ini diterbitkan siswa masih melakukan pelanggaran, maka sekolah akan mengambil tindakan tegas, berupa <b>skorsing sementara</b> atau pemberhentian (Drop Out) sesuai peraturan sekolah yang berlaku.</p>
    <p style="text-align:justify">Kami berharap dengan adanya surat ini, siswa dapat memperbaiki perilaku dan menunjukkan komitmen untuk berubah menjadi lebih baik.</p>
<?php endif; ?>	
<?php if($idtegur==5): ?>
<p style="text-align:justify">Tingkat Teguran Terakhir : SP III / Peringatan Terakhir</p>
<p style="text-align:justify">Setelah melalui pembinaan dan teguran sebelumnya (SP 1, SP 2, SP 3)
 namun tidak menunjukkan perubahan perilaku yang signifikan, maka pihak sekolah memutuskan untuk memberikan 
 sanksi skorsing (penangguhan kehadiran sementara) kepada siswa yang bersangkutan.</p>
<?php endif; ?>	

	<?php if($idtegur==6): ?>	
		Tanggal Efektif DO: <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br>
       <p>Hak dan Kewajiban yang Masih Berlaku:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Siswa wajib menyelesaikan administrasi sekolah<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Surat keterangan kelulusan atau transkrip nilai akan diberikan sesuai ketentuan sekolah<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Segala kegiatan dan hak sebagai siswa tidak berlaku lagi sejak tanggal efektif DO

       <p style="text-align:justify">Kami berharap keputusan ini dapat menjadi pelajaran bagi siswa dan orang tua/wali, serta dapat dipertanggungjawabkan secara hukum dan administrasi.</p>
        Demikian surat pemberhentian ini dibuat agar dapat dipergunakan sebagaimana mestinya.<br>	
	<?php endif; ?>		
			<br>
			<table class="header-table" width='100%'>
					<tr>
					<td width="5%"></td>	
					<td width="40%">
					<br/>							
					
					<br/><br/><br/><br/>
					<br/>
					
						</td>						
						<td width="15%">
							
							
							<br/><br/>
							
							<br/><br/><br/><br/>							
						</td>						
						<td>
							<?= ucwords(strtolower($setting['kecamatan'])); ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br/>
							Kepala Sekolah<br/>
							<br/>
							<br/>
							<br/>
							
							<u><?= $setting['kepsek'] ?></u><br/>
							NIP. <?= $setting['nip'] ?> 
						</td>
					</tr>
				</table>
				<br>
				Tembusan:<br>
				1. Orang Tua/Wali Siswa<br>
				2. Waka Kesiswaan<br>
				3. Arsip Sekolah
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