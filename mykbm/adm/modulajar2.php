<?php 
ob_start();
error_reporting(0);
require("../../konek/koneksi.php");
require("../../konek/function.php");

$smt   = $_GET['smt'];
$idel  = $_GET['elemen'];
$mapel = $_GET['mapel'];
$kelas = $_GET['kelas'];
$guru  = $_GET['guru'];

$stmt = $pdo->prepare("SELECT * FROM m_kelas WHERE kelas = ?");
$stmt->execute([$kelas]);
$level = $stmt->fetch(PDO::FETCH_ASSOC);
$tingkat = $level['level'];

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
<title>MODUL-2</title>
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
			<td>Alokasi Waktu</td>
            <td width='5px'>:</td>
            <td><?= $el['waktu'] ?> JP X <?= $setting['jjm'] ?> Menit</td>
            </tr>
			
			<tr>
            <td></td>
			<td>Tahun Pelajaran</td>
            <td width='5px'>:</td>
            <td><?= $setting['tp'] ?></td>
            </tr>
			
			
			<tr>
            <td></td>
			<td>Pertemuan Ke</td>
            <td width='5px'>:</td>
            <td><?= $el['ke'] ?></td>
            </tr>
			
			<tr style="vertical-align:top">
            <td></td>
			<td>Capaian Pembelajaran Elemen</td>
            <td width='5px'>:</td>
            <td><?= $el['capaian'] ?></td>
            </tr>
			
			<tr>
            <td></td>
			<td>Tujuan Pembelajaran</td>
            <td width='5px'>:</td>
            <td><?= $cp['tujuan'] ?></td>
            </tr>
    </table>
	<br>
	<br>
 <b>B. MODEL PEMBELAJARAN</b>
    <table class="header-table">
	<tr>
    <td width='2%'></td>
	<td>Discovery Learning</td>										
	</tr>
    </table>
   <br>   
    <b>C. TARGET PESERTA DIDIK</b>
    <table class="header-table">
	<tr>
    <td width='2%'></td>
	<td>Peserta Didik Reguler</td>										
	</tr>
    </table>
   <br>   
 <b>D. SARANA DAN PRASARANA (MEDIA DAN SUMBER BELAJAR)</b>
	 <table class="header-table">
	<tr>
    <td width='2%'></td>
	<td width='1%'>1.</td>	
	<td width='15%'>Media</td>
	<td>: <?= $el['media'] ?></td>	
	</tr>
	<tr>
    <td width='2%'></td>
	<td width='1%'>2.</td>	
	<td width='10%'>Alat/Bahan</td>
	<td>: Spidol, papan tulis, Laptop dan Infocus</td>	
	</tr>
	<tr>
    <td width='2%'></td>
	<td width='1%'>3.</td>	
	<td width='10%'>Sumber Belajar</td>
	<td>: Buku Panduan Guru, buku siswa, <?= $el['sumber'] ?></td>	
	</tr>
    </table>
   <br>   
 
 <b>F. KEGIATAN PEMBELAJARAN</b>											
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
    * Guru memberikan pertanyaan pemantik seputar tentang :<br>
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
	<td>* Guru membagi siswa dalam 3 kelompok berdasarkan profil belajar siswa dengan gaya belajar kelompok visual, &nbsp;&nbsp;&nbsp;auditori dan kinestetik. (Diferensiasi Proses)<br>
	* Masing-masing kelompok mengerjakan LKPD dengan aktivitas yang berbeda.									
	</td>	
	</tr>
	</table>
	<br>
	<table class="header-table" style="width:90%;margin-left:30px;">
	<tr>
	<td width='1%' colspan="2"></td>
	<td class="bold" >Sintak Discovery Learning	</td>	
	</tr>
	
	<tr style="vertical-align:top">
	<td width='5px'></td>
    <td width='5px' class="bold">1.</td>
	<td><b>Pemberian Rangsangan (Stimulation)</b><br>
	Guru menampilkan tayangan berupa gambar/slide/video terkait materi :<br>
	<?= $cp['lingkup'] ?><br>
	Peserta didik dimotivasi untuk memberikan pernyataan terkait tayangan tersebut. Guru memberi stimulus berupa pertanyaan terkait tayangan tersebut. (Literasi, Critical Thinking, Communication, Creativity)<br>
    <b>(Diferensiasi Konten)</b>
	</td>
	</tr>
	
	<tr style="vertical-align:top">
    <td></td>
    <td class="bold">2.</td>
	<td><b>Identifikasi Masalah (Problem Statement)</b><br>
	Peserta didik mengidentifikasi masalah terkait materi:<br>
		<?= $cp['lingkup'] ?><br>
		Peserta didik diberikan kesempatan untuk bertanya tentang gambar/slide/video yang ditampilkan guru.  (Literasi, Critical Thinking, Communication, Creativity)					
	</td>	
	</tr>
	<tr style="vertical-align:top">
    <td></td>
    <td class="bold">3.</td>
	<td><b>Pengumpulan Data (Data Collection)</b><br>
		Peserta didik membentuk kelompok dalam beberapa kelompok. Peserta didik berdiskusi dalam kelompoknya untuk menjelaskan masalah terkait :<br>
		<?= $el['elemen'] ?><br>
		Peserta didik mencari dan mengumpulkan data dari hasil diskusi kelompoknya maupun dari berbagi sumber yang relevan. (Collaboration, Critical Thinking, Communication, Creativity)														
	</td>	
	</tr>
	<tr style="vertical-align:top">
    <td></td>
    <td class="bold">4.</td>
	<td><b>Pengolahan Data (Data Processing)</b><br>
	Peserta didik dalam kelompoknya berdiskusi mengolah data dan menuliskan hasil diskusi pada lembar kerja peserta didik. Guru memantau jalannya diskusi dan membimbing peserta didik untuk mempresentasikan hasil diskusinya. Beberapa kelompok mempresentasikan hasil-hasil diskusi dan kerja kelompoknya. (Critical Thinking, Collaboration, Communication, Creativity). (Diferensiasi Produk)													
	</td>	
	</tr>
	
	<tr style="vertical-align:top">
    <td></td>
    <td class="bold">5.</td>
	<td><b>Pembuktian (Verification)</b><br>
	Peserta didik dibantu guru melakukan pembuktian/verifikasi terhadap data yang sudah diolah masing-masing kelompok terkait materi yang dipelajari. (Critical Thinking, Creativity, Collaboration).													
	</td>	
	</tr>
	<tr style="vertical-align:top">
    <td></td>
    <td class="bold">6.</td>
	<td><b>Menarik Simpulan/Generalisasi (Generalization)</b><br>
	Peserta didik menyusun kesimpulan terkait masalah yang dipelajari. Guru memberikan tanggapan atau koreksi terhadap kesimpulan yang disusun peserta didik tersebut. (Creativity, Communication)													
	</td>	
	</tr>
	</table>
	<table class="header-table">
	<tr>
    <td width='2%'></td>
	<td width='1%' class="bold">c.</td>
	<td class="bold">Kegiatan Penutup</td>	
	</tr>	
	<tr>
    <td width='2%'></td>
	<td width='1%'></td>
	<td>
	Membuat simpulan, refleksi, umpan balik, penugasan, pesan – pesan moral, dan menyampaikan informasi kegiatan pembelajaran yang akan datang, berdoa dan salam.
	</td>	
	</tr>
 </table>
 <br>
<b>G. PENILAIAN (ASSESMENT)</b>											
	 <table class="header-table">
	<tr>
	<td colspan="2" width="1%"></td>
	<td>1. Penilaian Pengetahuan : berupa Tes Tulis dan penugasan<br>
	2. Penilaian Keterampilan : berupa penilaian proyek, penilaian produk, penilaian unjuk kerja											
	</td>	
	</tr>
 </table>
  <br>

 <b>H. RINGKASAN MATERI</b>											
	 <table class="header-table">
	<tr>
	<td width="2%"></td>
	<td><?= $el['ringkasan'] ?></td>	
	</tr>
 </table>
 <br>
 <b>I. SUMBER</b>											
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
$dompdf->stream("Modul_Ajar_2.pdf", ["Attachment" => false]);
exit(0);
?>