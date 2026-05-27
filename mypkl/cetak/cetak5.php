<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$ids = $_GET['ids'];
$dudi = $_GET['d'];

$sql = "
    SELECT p.*, s.nama, s.kelas, s.nisn, s.nis, s.t_lahir, s.tgl_lahir,
           d.nama_dudi, d.instruktur, d.alamat AS alamat_dudi,
           k.pk, k.kk, k.bk,
           g.nama AS nama_guru
    FROM pkl_siswa p
    LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
    LEFT JOIN pkl_dudi d ON d.id = p.dudi
    LEFT JOIN m_kelas k ON k.kelas = s.kelas
    LEFT JOIN guru g ON g.id_guru = p.idguru
    WHERE p.idsiswa = ?
";

$stmtSiswa = $pdo->prepare($sql);
$stmtSiswa->execute([$ids]);
$siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Nilai Prakerin <?= ucwords(strtolower($siswa['nama'])) ?></title>
<style>
    @page { 
		margin: 0; 
        size: A4 landscape; /* Ensure A4 size and Landscape orientation */
    }
    
    html, body {
        height: 100%; 
        margin: 0;  
    }
    
    body { 
        font-family: Arial, sans-serif; 
        font-size: 13px; 
        
        padding: 0;
    }
 p {
            margin-top: 5px;    
            margin-bottom: 10px; 
            line-height: 1;    
        }
    table { 
        border-collapse: collapse; 
        width: 80%;  /* Limit table width to 80% of the page */
        margin: 0 auto;  /* Center the table horizontally */
    }

    th, td { 
        border: 1px solid #000; 
        padding: 4px; 
        font-size: 14px; 
    }

    th { 
        background-color: #f0f0f0; 
    }

    .header-table td { 
        border: none; 
        text-align: left; 
        padding: 2px; 
    }

    .text-center { 
        text-align: center; 
    }

    .bold { 
        font-weight: bold; 
    }
</style>
</head>
<body>
  <img src="<?= $baseurl ?>/images/frame/frame.png" style="z-index: 800;position:absolute;width:1120px;height:795px">
    
    <br><p class="text-center" style="margin-top:150px;font-size:18px">Diberikan Kepada:</p>
<br><p class="text-center" style="font-size:28px;font-weight:bold"><?= $siswa['nama'] ?></p>	
     <table  class="header-table" style="margin-left:350px;margin-top:90px;width:90%">
	 <tr>
    <td width="20%">Tempat, Tanggal Lahir</td>
	<td width="1%">:</td>
	<td><?= $siswa['t_lahir'] ?>, <?= $siswa['tgl_lahir'] ?></td>
     </tr>
     
	 <tr>
    <td width="20%">Nomor Induk Siswa Nasional</td>
	<td width="1%">:</td>
	<td><?= $siswa['nisn'] ?></td>
     </tr>
      <tr>
    <td width="20%">Bidang Keahlian</td>
	<td width="1%">:</td>
	<td><?= $siswa['bk'] ?></td>
     </tr>	 
	 <tr>
    <td width="20%">Program Keahlian</td>
	<td width="1%">:</td>
	<td><?= $siswa['pk'] ?></td>
     </tr>
	  <tr>
    <td width="20%">Kompetensi Keahlian</td>
	<td width="1%">:</td>
	<td><?= $siswa['kk'] ?></td>
     </tr>
	  <tr>
    <td width="20%">Satuan Pendidikan</td>
	<td width="1%">:</td>
	<td width="40%"><?= $setting['sekolah'] ?></td>
     </tr>
	</table>
	<br><p class="text-center">Telah melaksanakam Praktik Kerja Lapangan (PKL) selama 6 bulan di <br>dengan hasil <b>Baik</b></p>		
<br>
 <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="z-index: 800;position:absolute;margin-top:-190;margin-left:400px;width:300px;opacity:0.08;">
  <table class="header-table" style="margin-left:100px;width:100%">
	 <tr>
    <td width="40%">
	<br>Kepala Sekolah<br>
	<?= $setting['sekolah'] ?>
	<br><br><br><br><br>
	<b><?= $setting['kepsek'] ?></b>
	</td>
	<td width="20%"></td>
	<td><?= $setting['kabupaten'] ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= $tahun ?> <br>
	Kepala Dudi / Pembimbing Industri<br>
	<br><br><br><br><br>
	<b><?= $siswa['instruktur'] ?></b>
	</td>
     </tr>
	 </table>
	  <p style="page-break-before: always;"></p>
	  <img src="<?= $baseurl ?>/images/frame/frame2.png" style="z-index: 800;position:absolute;width:1120px;height:795px">
	  
	  <div style="margin-top:50px"></div>
<p class="text-center" style="font-size:18px;font-weight:bold;">DAFTAR NILAI PRAKTIK KERJA INDUSTRI</p>
<p class="text-center" style="font-size:18px;font-weight:bold;"><?= $setting['sekolah'] ?></p>
<p class="text-center" style="font-size:18px;font-weight:bold;">TAHUN PELAJARAN <?= $setting['tp'] ?></p>

<br>
<table class="header-table" style="width:100%;margin-left:100px;margin-top:50px">
	 <tr>
    <td width="15%">Nama Siswa</td>
	<td width="25%">: <?= $siswa['nama'] ?></td>
	<td width="5%"></td>
	<td width="18%">Bidang Study Keahlian</td>
	<td>: <?= $siswa['bk'] ?></td>
     </tr>
	  <tr>
    <td>No. Induk Siswa</td>
	<td>: <?= $siswa['nis'] ?></td>
	<td></td>
	<td>Program Study Keahlian</td>
	<td>: <?= $siswa['pk'] ?></td>
     </tr>
	  <tr>
    <td>N I S N</td>
	<td>: <?= $siswa['nisn'] ?></td>
	<td></td>
	<td>Kompetensi Keahlian</td>
	<td>: <?= $siswa['kk'] ?></td>
     </tr>
	 </table>
	 <br>
	 <b style="margin-left:100px">TEMPAT PRAKERIN</b>	
	 <table class="header-table" style="width:100%;margin-left:100px">
	 <tr>
    <td width="15%">Nama DU/DI</td>
	<td>: <?= ucwords(strtolower($siswa['nama_dudi'])) ?></td>
	</tr>
	<tr>
	<td width="15%">Alamat DU/DI</td>
	<td>: <?= ucwords(strtolower($siswa['alamat_dudi'])) ?></td>
     </tr>
	  </table>
	  <br>
	  <table style="width:60%;margin-left:250px;margin-right:300px;">
  <tr>
    <th rowspan="2">NO</th>
    <th rowspan="2">ASPEK PENILAIAN</th>
    <th colspan="2">NILAI</th>
  </tr>
  <tr>
    <th>ANGKA</th>
    <th>HURUF</th>
  </tr>
  
 <?php
$sql = "
    SELECT 
        a.kategori,
        a.nama_aspek,
        AVG(n.nilai) AS nilai
    FROM pkl_nilai n
    LEFT JOIN pkl_aspek a ON a.kode_aspek = n.aspek
    WHERE n.idsiswa = ?
    GROUP BY a.kategori
    ORDER BY a.kategori, a.id_aspek
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$ids]); // Kirim parameter sebagai array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

function get_predikat($nilai) {
    if (!is_numeric($nilai)) {
        return "E";  
    }

    if ($nilai >= 90) return "A";
    if ($nilai >= 80) return "B";
    if ($nilai >= 70) return "C";
    if ($nilai >= 60) return "D";
    return "E";  
}

$no = 0;
foreach ($result as $data):
    $nilai = $data['nilai'];
    $predikat = get_predikat($nilai);
    $no++;
?>
  <tr>
    <td class="text-center"><?= $no ?></td>
    <td><?= $data['kategori'] ?></td>
    <td class="text-center"><?= number_format($nilai, 2) ?></td>
    <td class="text-center"><?= $predikat ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<br>
 <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="z-index: 800;position:absolute;margin-top:-190;margin-left:400px;width:300px;opacity:0.08;">
  <table class="header-table" style="margin-left:100px;width:100%">
	 <tr>
    <td width="40%">
	<br>Kepala Sekolah<br>
	<?= $setting['sekolah'] ?>
	<br><br><br><br><br>
	<b><?= $setting['kepsek'] ?></b>
	</td>
	<td width="20%"></td>
	<td><?= $setting['kabupaten'] ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= $tahun ?> <br>
	Kepala Dudi / Pembimbing Industri<br>
	<br><br><br><br><br>
	<b><?= $siswa['instruktur'] ?></b>
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
$dompdf->stream("Sertifikat PKL " . $siswa['nama'] . ".pdf", array("Attachment" => false));
exit(0);
?>
