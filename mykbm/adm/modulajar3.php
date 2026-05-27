<?php 
ob_start();
error_reporting(0);
require("../../konek/koneksi.php"); // harus berisi $pdo
require("../../konek/function.php");

$smt   = $_GET['smt'];
$idel  = $_GET['elemen'];
$mapel = $_GET['mapel'];
$kelas = $_GET['kelas'];
$guru  = $_GET['guru'];

/* ---------------------------------
   GET m_kelas
-----------------------------------*/
$stmt = $pdo->prepare("SELECT * FROM m_kelas WHERE kelas = ?");
$stmt->execute([$kelas]);
$level = $stmt->fetch(PDO::FETCH_ASSOC);
$tingkat = $level['level'];

/* ---------------------------------
   GET mapel
-----------------------------------*/
$stmt = $pdo->prepare("SELECT * FROM mapel WHERE id = ?");
$stmt->execute([$mapel]);
$map = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$guru]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM adm_tp 
                       WHERE mapel = ? AND guru = ? AND tingkat = ? AND semester = ?");
$stmt->execute([$mapel, $guru, $tingkat, $smt]);
$cp = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM cp_elemen WHERE id_lingkup = ? AND id_elemen = ?");
$stmt->execute([$cp['id'], $idel]);
$el = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>MODUL-3</title>
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
        .header-table td { border: none; text-align: left; padding: 2px; font-size:14px; }
        .text-center { text-align: center; }
		strong {font-size: 18px;}
     </style>
</head>
<body>
<div>
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
  
		<center><h3>MODUL AJAR<br><?= strtoupper($setting['sekolah']) ?></h3></center>
		<br>
 <b>A. INFORMASI UMUM</b>
   <table class="header-table">
	
            <tr>
			 <td width='2%'></td>
			<td width="30%">Nama Sekolah</td>
            <td width='5px'>:</td>
            <td><?= $setting['sekolah'] ?></td>
            </tr>
			
			<tr>
			 <td></td>
			<td>Mata Pelajaran</td>
            <td width='5px'>:</td>
            <td><?= $map['nama_mapel'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>Kelas / Semester</td>
            <td width='5px'>:</td>
            <td><?= $kelas ?> / <?= $cp['semester'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>Materi Pokok</td>
            <td width='5px'>:</td>
            <td><?= $cp['lingkup'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>Tahun Pelajaran</td>
            <td width='5px'>:</td>
            <td><?= $setting['tp'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>Alokasi Waktu</td>
            <td width='5px'>:</td>
            <td><?= $el['waktu'] ?> JP X <?= $setting['jjm'] ?> Menit</td>
            </tr>
    </table>
 
   <table class="header-table">
	
            <tr>
			<td width="32%" class="bold">B. Tujuan Pembelajaran</td>
            <td width='5px'>:</td>
            <td><?= $cp['tujuan'] ?></td>
            </tr>
		</table>	
	<br>
 <b>C. MEDIA PEMBELAJARAN</b>
   <table class="header-table">
	<tr>
    <td width='2%'></td>
	<td><?= $el['media'] ?></td>										
	</tr>
    </table>
   <br>   
 <b>D. PERTANYAAN PEMANTIK / ASESMEN AWAL PEMBELAJARAN</b>
	<table class="header-table">
	<tr>
	<td width='1%'></td>
    <td width='1%'></td>	
	<td>Guru Memberikan pertanyaan ringan kepada siswa atau melakukan aktivitas tentang :<br>
	<?= $cp['lingkup'] ?><br>
	Untuk mengetahui kemampuan awal siswa tentang materi tersebut.
	</td>	
	</tr>
    </table>
<br>   
 <b>E. KEGIATAN PEMBELAJARAN</b>											
	<table class="header-table">
	<tr>
    <td width='2%'></td>
	<td width='1%' class="bold">a.</td>
	<td class="bold">Kegiatan Pendahuluan</td>	
	</tr>
	<tr>
    <td width='2%'></td>
	<td width='1%'></td>
	<td>* Guru dan peserta didik menyampaikan salam dan berdoa.<br>
	* Guru melakukan presensi kehadiran peserta didik. Guru mempersiapkan pembelajaran peserta didik.<br>									
	* Guru membuat kesepakatan Kelas.<br>
	* Apersepsi:<br>
    * Guru memberikan pertanyaan pemantik tentang :<br>
	&nbsp;&nbsp;&nbsp;  <?= $cp['lingkup'] ?><br>
   * Guru menginformasikan tujuan pembelajaran mengenai :<br>	
	&nbsp;&nbsp;&nbsp;  <?= $cp['tujuan'] ?><br>
	</td>	
	</tr>
	<tr>
    <td width='2%'></td>
	<td width='1%' class="bold">b.</td>
	<td class="bold">Kegiatan Inti</td>	
	</tr>	
	<tr>
    <td width='2%'></td>
	<td width='1%'></td>
	<td>* Siswa mengamati media yang ditampilkan guru (Video, Gambar, Media Kongrit) tentang :<br>
			&nbsp;&nbsp; <?= $el['elemen'] ?></br>	
		* Siswa menyebutkan semua yang didapatnya dari media tersebut<br>
		* Guru membagi siswa menjadi beberapa kelompok sesuai dengan hasil pemahaman awalnya<br>
		* Guru memberikan LKPD yang berbeda kepada masing-masing kelompok sesuai dengan kemampuannya<br>&nbsp;&nbsp; tentang : <?= $el['elemen'] ?><br>
		* Siswa berdiskusi dalam kelompoknya untuk mengerjakan LKPD yang diberikan<br>
		* Guru membimbing siswa dalam berdiskusi agar semua siswa terlibat aktif dalam berdiskusi<br>
		* Perwakilan masing-masing kelompok mempresentasikan hasil didskusinya di depan kelas<br>
		* Guru memberikan kesempatan yang sama kepada siswa untuk menanggapi<br>
		* Guru memberikan apresiasi kepada setiap kelompok yang tampil secara bergantian<br>
		* Siswa menyimpulkan pembelajaran yang telah dilakukan tentang :<br>
		&nbsp;&nbsp; <?= $cp['tujuan'] ?><br>
		* Siswa mengerjakan latihan yang diberika guru<br>
		* Guru menyampaikan analisis hasil latihan dan memintak umpan balik siswa<br>
		* Guru menyampaikan analisis hasil latihan dan memintak umpan balik siswa<br>
		* Memberikan kesempatan kepada siswa jika ada yang maish ingin ditanyakan tentang :<br> 
		&nbsp;&nbsp; <?= $cp['tujuan'] ?><br>
		* Guru menyampaikan langkah pembelajaran berikutnya sesuai engan umpan balik siswa
	</td>	
	</tr>
	</table>
	 <p style="page-break-before: always;"></p>
	<table class="header-table">
	<tr>
    <td width='2%'></td>
	<td width='1%' class="bold">c.</td>
	<td class="bold">Kegiatan Penutup</td>	
	</tr>	
	<tr>
    <td width='2%'></td>
	<td width='1%'></td>
	<td>* Guru membimbing siswa melakukan refleksi pembelajaran yang telah dilalui<br>
	* Guru memberikan kesempatan kepada salah satu siswa untuk memimpin doa<br>									
	* Guru menutup pembeljaran dan salam<br>
	</td>	
	</tr>
 </table>
 <br>
<b>F. PENILAIAN (ASSESMENT)</b>											
	<table class="header-table">
	<tr>
	<td colspan="2" width="1%"></td>
	<td>Penilaian dilakukan dengan cara berikut:<br>
	    &nbsp;&nbsp;&nbsp;&nbsp; 1. Observasi																					
	</td>	
	</tr>
 </table>
   <table style="width:90%;margin-left:30px;font-size:12px" border="1">
	<tr style="text-align:center;">
	<td rowspan="2" width="8%">NO</td>
	<td rowspan="2" width="32%">NAMA</td>
	<td colspan="4">SIKAP YANG DIAMATI</td>
	<td rowspan="2" width="10%">SKOR</td>
   </tr>
   <tr style="text-align:center;">
	<td colspan="4">7 Kebiasaan Harian</td>
	</tr>
	<tr>
	<td height="10px"></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td height="10px"></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td height="10px"></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>
 </table>
<table class="header-table">
	<tr>
	<td colspan="2" width="1%"></td>
	<td><br>&nbsp;&nbsp;&nbsp;&nbsp; 2. Tes Tertulis<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Tes tertulis ini dilakukan untuk penilaian pengetahuan siswa tentang :<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= $el['elemen'] ?>	
	
	</td>	
	</tr>
	</table>
	<table class="header-table">
	<tr>
	<td colspan="2" width="1%"></td>
	<td><br>&nbsp;&nbsp;&nbsp;&nbsp; 3. Rubrik<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Rubrik penilaian dijadikan untuk menilai keterampilan atau produk hasil kerja siswa tentang :<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= $cp['tujuan'] ?>	
	
	</td>	
	</tr>
	</table>
	<table style="width:90%;margin-left:30px;font-size:12px" border="1">
	<tr style="text-align:center;">
	<td rowspan="2" width="30%" class="bold">Tujuan Pembelajaran</td>
	<td colspan="4"  class="bold">Penilaian</td>	
	</tr>
	<tr style="text-align:center;">
	<td class="bold">Perlu Bimbingan</td>
	<td class="bold">Cukup</td>
	<td class="bold">Baik</td>
	<td class="bold">Sangat Baik</td>
	</tr>
	<tr style="text-align:center;vertical-align:top">
	<td><?= $el['capaian'] ?></td>
	<td>Belum mempu menyebutkan	<br><?= $cp['tujuan'] ?></td>
	<td>Mampu menyebutkan<br><?= $cp['tujuan'] ?></td>
	<td>Mampu Menjelaskan masing-masing fungsi<br><?= $cp['tujuan'] ?></td>
	<td>Mampu membandingkan fungsi dari<br><?= $cp['tujuan'] ?></td>
	</tr>
	</table>
	<table class="header-table">
	<tr>
	<td colspan="2" width="1%"></td>
	<td><br>&nbsp;&nbsp;&nbsp;&nbsp; 4. Angket<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Angket digunakan untuk merefleksikan pembelajaran yang telah dilalui<br>
	</td>	
	</tr>
	</table>
	 <table style="width:90%;margin-left:30px;font-size:12px" border="1">
	<tr style="text-align:center;">
	<td rowspan="2" width="60%">PERNYATAAN</td>
	<td colspan="4">PENILAIAN</td>
   </tr>
  <tr style="text-align:center;">
	<td>TS</td>
	<td>KS</td>
	<td>S</td>
	<td>SS</td>	
	</tr>
	<tr>
	<td>Perasaan saya selama proses pembelajaran</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
	<tr>
	<td>Perasaan saya setelah pembelajaran hari ini</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
	<tr>
	<td>Saya memahami materi yang disampaikan guru</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
	<tr>
	<td>Perasaan saya terhadap cara yang dilakukan guru</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
	<tr>
	<td>Soal yang diberikan guru</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
	<tr>
	<td>Materi yang disampaikan guru</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>	
	</tr>
   </table>
  <br>

 <b>G. SUMBER</b>											
	<table class="header-table">
	<tr>
	<td width="2%"></td>
	<td><?= $el['sumber'] ?></td>	
	</tr>
 </table>
		<br>
	<table class="header-table">
		<tr>
		<td width="5%"></td>
		<td width='50px'></td>
		<td>
		Mengetahui, <br/>Kepala Sekolah
		<br/><br/><br/><br/>
		<u><?= $setting['kepsek'] ?></u><br/>
		NIP. <?= $setting['nip'] ?>
		</td>
		<td width='10%'></td>
		<td width="5%"></td>
		<td>
		<?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d'); ?> <?= bulan_indo($tanggal); ?> <?= date('Y') ?><br/>
			Guru Mapel<br/><br/><br/><br/>
			<u><?= $usr['nama'] ?></u><br/>
			NIP. <?= $usr['nip'] ?>
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
$dompdf->stream("Modul_Ajar_3.pdf", ["Attachment" => false]);
exit(0);
?>