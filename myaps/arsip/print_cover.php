<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
$ids = $_GET['ids'] ?? '';
$tp = date('Y');
$tpk = $tp - 1;

$stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :ids LIMIT 1");
$stmt->execute([':ids' => $ids]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if ($siswa) {
    $kelamin = ($siswa['jk'] === 'L') ? 'Laki-laki' : 'Perempuan';

    $stmtK = $pdo->prepare("SELECT * FROM m_kelas WHERE kelas = :kelas LIMIT 1");
    $stmtK->execute([':kelas' => $siswa['kelas']]);
    $k = $stmtK->fetch(PDO::FETCH_ASSOC);
} else {
    $kelamin = '';
    $k = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>

    <title>Cover_Rapor_<?= $siswa['nama'] ?></title>

 <style>
  @page { 
		margin-top: 2cm; 
		margin-right: 2cm; 
		margin-bottom: 2cm; 
		margin-left: 2cm; 
		}
    h1 {
      font-size: 24px;
      color: slateblue;
    }
	h6 {
      font-size: 18px;
    
    }
    .font-big {
       font-size: 14px;
    }

    .font-small {
      font-size: small;
    }
	 
  </style>

</head>

<body>

   <center>
        <h6>LAPORAN</h6>
		<h6>HASIL CAPAIAN KOMPETENSI PESERTA DIDIK</h6>
		<?php if($setting['jenjang']=='SMA'): ?>
		<h6>SEKOLAH MENENGAH ATAS (SMA)</h6>
		<?php elseif($setting['jenjang']=='SMK'): ?>
		<h6>SEKOLAH MENENGAH KEJURUAN (SMK)</h6>
		<?php elseif($setting['jenjang']=='SMP'): ?>
		<h6>SEKOLAH MENENGAH PERTAMA (SMP)</h6>
		<?php elseif($setting['jenjang']=='SD'): ?>
		<h6>SEKOLAH DASAR (SD)</h6>
		<?php endif; ?>
		
    </center>
    <br>
    <br>
       
    <div class="col-md-12">
	
     <center>
	 <img src="<?= $baseurl ?>/images/kemdikbud.png" width="30%">	 
	 </center>
         
        <br><br><br>
 <center class="font-big">Nama Peserta Didik</center>
    <br>
            <table style="margin-left: 70px;margin-right:50px;" style=" border: 1px solid #000;" width="100%">
                    <tr style="text-align: center;font-size: 18px;">
                        <td><b><?php echo ucfirst($siswa['nama']); ?></b></td>
                    </tr>
					</table>
					<br><br><br>
 <center>No. Induk / NISN</center>
    <br>
	<table style="margin-left: 70px;margin-right:50px;" style=" border: 1px solid #000;" width="100%">
                    <tr style="text-align: center;font-size: 14px;">
                        <td><?php echo $siswa['nis']; ?> / <?php echo $siswa['nisn']; ?></td>
                    </tr>
					</table>
					<br><br><br><br>
   <center>
        <h6>KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</h6>
		<h6>REPUBLIK INDONESIA</h6>
		
    </center>
	<div style='page-break-before:always;'></div>
 <center><h6>R A P O R</h6></center>
 <center>
 <?php if($setting['jenjang']=='SMA'): ?>
		<h6>SEKOLAH MENENGAH ATAS</h6>
		<h6>(SMA)</h6>
		<?php elseif($setting['jenjang']=='SMK'): ?>
		<h6>SEKOLAH MENENGAH KEJURUAN </h6>
		<h6>(SMK)</h6>
		<?php elseif($setting['jenjang']=='SMP'): ?>
		<h6>SEKOLAH MENENGAH PERTAMA</h6>
		<h6>(SMP)</h6>
		<?php elseif($setting['jenjang']=='SD'): ?>
		<h6>SEKOLAH DASAR</h6>
		<h6>(SD)</h6>
		<?php endif; ?>
 </center>

    <br><br>
            <table style="margin-left: 70px;margin-right:50px;"  width="100%">
                    <tr style="font-size: 14px;">
                        <td>Nama Sekolah</td>
						<td>:</td>
						<td><?= $setting['sekolah'] ?></td>
                    </tr>
					<tr style="font-size: 14px;">
                        <td>N P S N</td>
						<td>:</td>
						<td><?= $setting['npsn'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Kelurahan/Desa</td>
						<td>:</td>
						<td><?= $setting['desa'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Kecamatan</td>
						<td>:</td>
						<td><?= $setting['kecamatan'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Kabupaten/Kota</td>
						<td>:</td>
						<td><?= $setting['kabupaten'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Provinsi</td>
						<td>:</td>
						<td><?= $setting['propinsi'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Website</td>
						<td>:</td>
						<td><?= $setting['web'] ?></td>
					</tr>
					<tr style="font-size: 14px;">
                        <td>Email</td>
						<td>:</td>
						<td><?= $setting['email'] ?></td>
					</tr>
					</table>
					
 <div style='page-break-before:always;'></div>
    
   <center>
        <h6>IDENTITAS PESERTA DIDIK</h6>
		
    </center>
    <br>
    <br>
    <br>
    <div class="col-md-12">
	
        <table style="margin-left:30px;margin-right:10px"  width="100%">
            <tr>
			  <td width="1%">1.</td>
                <td width="20%">Nama Peserta Didik</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['nama'] ?></td>
            </tr>
            <tr>
			  <td width="1%">2.</td>
                <td >Nomor Induk</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['nis'] ?></td>
            </tr>
			 <tr>
			  <td width="1%">3.</td>
                <td >Tempat, Tanggal Lahir</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['t_lahir'] ?>, <?= $siswa['tgl_lahir'] ?> </td>
            </tr>
			 <tr>
			  <td width="1%">4.</td>
                <td >Jenis Kelamin</td>
                <td width="1%">:</td>
			<td width="40%"><?= $kelamin ?></td>
            </tr>
			 <tr>
			  <td width="1%">5.</td>
                <td >Agama</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['agama'] ?></td>
            </tr>
			 <tr>
			  <td width="1%">6.</td>
                <td >Pendidikan Sebelumnya</td>
                <td width="1%">:</td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="1%">7.</td>
                <td >Alamat Peserta Didik</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['alamat'] ?> Desa <?= $siswa['desa'] ?> Kec. <?= $siswa['kec'] ?> Kab. <?= $siswa['kab'] ?></td>
            </tr>
			<tr>
			  <td width="1%">8.</td>
                <td >Nama Orang Tua</td>
                <td width="1%"></td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">a. Ayah</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['ayah'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">b. Ibu</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['ibu'] ?></td>
            </tr>
			<tr>
			  <td width="1%">9.</td>
                <td >Pekerjaan Orang Tua</td>
                <td width="1%"></td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">a. Ayah</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['pek_ayah'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">b. Ibu</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['pek_ibu'] ?></td>
            </tr>
			<tr>
			  <td width="1%">10.</td>
                <td >Alamat Orang Tua</td>
                <td width="1%"></td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td width="12%">Jalan</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['alamat'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td width="12%">Kelurahan/Desa</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['desa'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td width="12%">Kecamatan</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['kec'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td width="12%">Kabupaten</td>
                <td width="1%">:</td>
			<td width="40%"><?= $siswa['kab'] ?></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td width="12%">Propinsi</td>
                <td width="1%">:</td>
			<td width="40%"><?= $setting['propinsi'] ?></td>
            </tr>
			<tr>
			  <td width="1%">11.</td>
                <td >Wali Peserta Didik</td>
                <td width="1%"></td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">a. Nama</td>
                <td width="1%">:</td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">b. Pekerjaan</td>
                <td width="1%">:</td>
			<td width="40%"></td>
            </tr>
			<tr>
			  <td width="4%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="12%">c. Alamat</td>
                <td width="1%">:</td>
			<td width="40%"></td>
            </tr>
		
        </table>
		<?php
			$ket = $_GET['k'] ?? '';
			$stmt6 = $pdo->prepare("SELECT tanggal FROM tanggal_rapor WHERE semester = :semester AND tapel = :tapel AND ket = :ket");
			$stmt6->execute([
				':semester' => $semester,
				':tapel'    => $tapel,
				':ket'      => $ket
			]);
			$rapor = $stmt6->fetch(PDO::FETCH_ASSOC);
			?>

        <table width="100%">
            <tr>
               <td style="text-align: center;width:50px"></td>
                <td style="text-align: center;width:180px">
				<br>
                    <?php if ($siswa['foto'] <>'') { ?>
                        <img width="90" class="img" src="<?= $baseurl ?>/images/fotosiswa/<?= $siswa['foto'] ?>" width="80" >
                    <?php } ?>
                   <?php if ($siswa['foto'] =='') { ?>
                        <img width="90" class="img" src="<?= $baseurl ?>/images/polos.png">
                    <?php } ?>
                </td>

                <td style="text-align: center;width:180px">
                    
                </td>
                <td style="text-align: justify">
                    <?= $setting['kecamatan'] ?>, <?= $rapor['tanggal'] ?><br>
                    Kepala Sekolah,

                   
                    
                        <br><br><br><br>
                    

                    <u><b><?= $setting['kepsek'] ?></b></u>
                    <br>
                    NIP. <?= $setting['nip'] ?>
                    
                        <br>
                        
                   
                </td>

            </tr>
        </table>
		
 	 <div style='page-break-before:always;'></div>
	 
   <center>
        <h6>PETUNJUK PENGISIAN</h6>	
    </center>
    <br>
    <br>
    <br>

<p style="text-align:justify">1. Laporan Hasil Belajar Peserta Didik merupakan ringkasan hasil penilaian terhadap seluruh aktivitas &nbsp;&nbsp;&nbsp;&nbsp;pembelajaran yangdilakukan peserta didik dalam kurun waktu tertentu. Laporan perkembangan dan &nbsp;&nbsp;&nbsp;&nbsp;hasil belajar peserta didik secara rinci disajikan dalam Laporan HasilBelajar Peserta Didik (Rapor).</p>
<p>2. Laporan hasil Belajar Peserta Didik dipergunakan selama peserta didik yang bersangkutan mengikuti<br>&nbsp;&nbsp;&nbsp;&nbsp;seluruh program pembelajaran di Sekolah Luar Biasa tersebut.</p>
<p style="text-align:justify">3. Apabila pindah sekolah, Laporan Hasil Belajar Peserta Didik ini dibawa oleh yang bersangkutan &nbsp;&nbsp;&nbsp;&nbsp;untuk dipergunakan di sekolah baru dengan meninggalkan arsip copi di sekolah lama.</p>
<p style="text-align:justify">4.	Apabila Laporan hasil Belajar Peserta Didik inihilang, dapat diganti yang disahkan oleh Kepala &nbsp;&nbsp;&nbsp;&nbsp;Sekolah asal.</p>
<p style="text-align:justify">5.	Laporan hasil Belajar Peserta Didik ini harus dilengkapi dengan pas foto (3 cm x 4 cm).</p>
<p style="text-align:justify">6.	Capaian peserta didik dalam pengetahuan dan keterampilan ditulis dalam bentuk nilai dan deskriptif.</p>
<p style="text-align:justify">7.	Prestasi diisi dengan jenis prestasi peserta didik yang diraih dalam bidang akademik dan non- &nbsp;&nbsp;&nbsp;&nbsp;akademik.</p>
<p style="text-align:justify">8.	Ketidakhadiran disi dengan data akumulasi ketidakhadiran Peserta Didik, baik karena sakit, izin, &nbsp;&nbsp;&nbsp;&nbsp;maupun tanpa keterangandalam satu semester.</p>
<p style="text-align:justify">9.	Nilai diisi dengan nilai pencapaian kompetensi belajar peserta didik.</p>
<p style="text-align:justify">10.	Deskripsi diisi uraian tentang pencapaian kompetensi peserta didik.</p>
	

	 <div style='page-break-before:always;'></div>
 <center>
        <h6>KETERANGAN PINDAH SEKOLAH</h6>
		
		<h6 class="font-small">Nama Peserta Didik: ........................................</h6>
    </center>
    
        <table style="border: 1px solid #000;"  width="100%">
		<tr>
		<td colspan="4" style="text-align:center;font-weight:bold;" >KELUAR</td>
		</tr>
            <tr>
			  <td style="text-align:center;">Tanggal</td>
                <td style="text-align:center;">Kelas yang Ditinggalkan</td>
                <td style="text-align:center;">Sebab-sebab Keluar atau atas Permintaan (Tertulis)</td>
			<td style="text-align:center;">Tanda Tangan Kepala Sekolah, Stempel Sekolah, dan Tanda Tangan Orang Tua/Wali</td>
            </tr>
            <tr>
			<td></td>
			<td></td>
			<td></td>
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			<br><br>Orang Tua/Wali,<br><br><br>........................................
			</td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			<br><br>Orang Tua/Wali,<br><br><br>........................................
			</td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			<br><br>Orang Tua/Wali,<br><br><br>........................................
			</td>
			</tr>
        </table>
       <br>
 	 <div style='page-break-before:always;'></div>
   
   <center>
        <h6>KETERANGAN PINDAH SEKOLAH</h6>
		
		<h6 class="font-small">Nama Peserta Didik: ........................................</h6>
    </center>
    
  
        <table style="border: 1px solid #000;"  width="100%" >
		
            <tr>
			  <td style="text-align:center;font-weight:bold">No</td>
                <td style="text-align:center;font-weight:bold" colspan="3">MASUK</td>
               
            </tr>
            <tr>
			<td style="text-align:center;">
			1<br>
			2<br>
			3<br>
			4<br>
			<br>
			<br>
			5<br>
			</td>
			<td width="25%">
			&nbsp;Nama Peserta didik<br>
			&nbsp;Nomor Induk<br>
            &nbsp;Nama Sekolah<br>
			&nbsp;Masuk di Sekolah ini:<br>
				&nbsp;a. Tanggal<br>
				&nbsp;b. Di Kelas<br>
				&nbsp;Tahun Pelajaran<br>
             </td>
			<td width="35%">
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			</td>
			
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			</td>
			</tr>
			
			 <tr>
			<td style="text-align:center;">
			1<br>
			2<br>
			3<br>
			4<br>
			<br>
			<br>
			5<br>
			</td>
			<td width="25%">
			&nbsp;Nama Peserta didik<br>
			&nbsp;Nomor Induk<br>
            &nbsp;Nama Sekolah<br>
			&nbsp;Masuk di Sekolah ini:<br>
				&nbsp;a. Tanggal<br>
				&nbsp;b. Di Kelas<br>
				&nbsp;Tahun Pelajaran<br>
             </td>
			<td width="35%">
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			</td>
			
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			</td>
			</tr>
			
			 <tr>
			<td style="text-align:center;">
			1<br>
			2<br>
			3<br>
			4<br>
			<br>
			<br>
			5<br>
			</td>
			<td width="25%">
			&nbsp;Nama Peserta didik<br>
			&nbsp;Nomor Induk<br>
            &nbsp;Nama Sekolah<br>
			&nbsp;Masuk di Sekolah ini:<br>
				&nbsp;a. Tanggal<br>
				&nbsp;b. Di Kelas<br>
				&nbsp;Tahun Pelajaran<br>
             </td>
			<td width="35%">
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			</td>
			
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			</td>
			</tr>
			
			 <tr>
			<td style="text-align:center;">
			1<br>
			2<br>
			3<br>
			4<br>
			<br>
			<br>
			5<br>
			</td>
			<td width="25%">
			&nbsp;Nama Peserta didik<br>
			&nbsp;Nomor Induk<br>
            &nbsp;Nama Sekolah<br>
			&nbsp;Masuk di Sekolah ini:<br>
				&nbsp;a. Tanggal<br>
				&nbsp;b. Di Kelas<br>
				&nbsp;Tahun Pelajaran<br>
             </td>
			<td width="35%">
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			</td>
			
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
			</td>
			</tr>
			
			 <tr>
			<td style="text-align:center;" width="5%">
			1<br>
			2<br>
			3<br>
			4<br>
			<br>
			<br>
			5<br>
			</td>
			<td width="25%">
			&nbsp;Nama Peserta didik<br>
			&nbsp;Nomor Induk<br>
            &nbsp;Nama Sekolah<br>
			&nbsp;Masuk di Sekolah ini:<br>
				&nbsp;a. Tanggal<br>
				&nbsp;b. Di Kelas<br>
				&nbsp;Tahun Pelajaran<br>
             </td>
			<td width="35%">
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			.........................................<br>
			</td>
			
			<td>......., ...............................<br>Kepala Sekolah,<br><br><br><br><?= $setting['kepsek'] ?><br>NIP.<?= $setting['nip'] ?>
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
$dompdf->stream("Cover_" . $siswa['nama'] . ".pdf", array("Attachment" => false));
exit(0);
?>
