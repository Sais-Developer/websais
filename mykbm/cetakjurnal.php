<?php
ob_start();
error_reporting(0);
require("../konek/koneksi.php");
require("../konek/function.php");

$bl    = $_GET['bulan'] ?? '';
$guru  = $_GET['guru'] ?? '';
$kelas  = $_GET['kelas'] ?? '';
$mapel  = $_GET['mapel'] ?? '';
$tahun = date('Y');

$stmt1 = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt1->execute([$bl]);
$bulane = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$guru]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("SELECT * FROM mapel WHERE id = ?");
$stmt2->execute([$mapel]);
$pel = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT 
            j.*, 
            g.nama AS nama_guru, 
            m.kode AS kode_mapel,

            (SELECT COUNT(*) 
             FROM absensi a 
             WHERE a.tanggal = j.tanggal 
               AND a.kelas = j.kelas 
               AND a.ket = 'H'
            ) AS hadir,

            
            (SELECT COUNT(*) 
             FROM absensi a 
             WHERE a.tanggal = j.tanggal 
               AND a.kelas = j.kelas
            ) AS total_siswa,

           
            (
                CASE 
                    WHEN 
                        (SELECT COUNT(*) FROM absensi a 
                         WHERE a.tanggal = j.tanggal 
                           AND a.kelas = j.kelas
                        ) = 0 
                    THEN 0
                    ELSE 
                        (
                            (SELECT COUNT(*) FROM absensi a 
                             WHERE a.tanggal = j.tanggal 
                               AND a.kelas = j.kelas 
                               AND a.ket = 'H')
                            /
                            (SELECT COUNT(*) FROM absensi a 
                             WHERE a.tanggal = j.tanggal 
                               AND a.kelas = j.kelas
                            )
                        ) * 100
                END
            ) AS prosentase_hadir

        FROM jurnal j
        LEFT JOIN guru g ON g.id_guru = j.guru
        LEFT JOIN mapel m ON m.id = j.mapel

        WHERE j.guru = :guru
        AND MONTH(j.tanggal) = :bulan
        AND YEAR(j.tanggal) = :tahun
        AND j.kelas = :kelas
        AND j.mapel = :mapel

        ORDER BY j.tanggal ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':guru'  => $guru,
    ':bulan' => $bl,
    ':tahun' => $tahun,
    ':kelas' => $kelas,
    ':mapel' => $mapel
]);

$jurnal = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>JURNAL DAN AGENDA</title>
     <style>
        @page { 
		margin-top: 1cm; 
		margin-right: 1cm; 
		margin-bottom: 1cm; 
		margin-left: 1cm; 
		}
       body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; }
th { background-color: #f0f0f0; }
.header-table {
    width: 100%;
    border-collapse: collapse;
}
.header-table td {
    border: none;
    vertical-align: middle;
}
.header-table h3 {
    margin: 0;
    line-height: 1.2;
    font-size: 18px; 
    text-transform: uppercase;
}
.header-table p {
    margin: 2px 0 0 0;
    font-size: 12px;
    line-height: 1.3;
}
.double-hr {
    border: none;
    border-top: 1px solid #000; 
    margin: 5px 0 0 0;
    position: relative;
}
.double-hr::after {
    content: "";
    display: block;
    border-top: 1px solid #000; 
    margin-top: 2px;
}
.text-center { text-align: center; }
strong { font-size: 18px; }
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
		<center>
		<h3>JURNAL GURU <br>BULAN <?= strtoupper($bulane['ket']) ?> <?= date('Y') ?></h3>
		</center>
		<br>
 
   <table class="header-table">
	<tr>
	
		 <td width="120px">Kelas</td>
		<td width="5px">:</td>
		<td><?= $kelas ?></td>
		<td width="40%"></td>
		<td width="120px">Semester</td>
		<td width="5px">:</td>
		<td><?= $semester ?></td>
	</tr>
	<tr>
		
		<td>Mata Pelajaran</td>
		<td>:</td>
		<td><?= $pel['nama_mapel'] ?></td>
		<td ></td>
		 <td>Tahun Pelajaran</td>
		<td>:</td>
		<td><?= $setting['tp'] ?></td>
	</tr>
  </table>
     <br>
 <table  width='100%' style="font-size:13px;">       
	  <tr>
		<th width="3%" height="40px">NO</th>
		<th width="8%" class="text-center">TANGGAL</th>			
		<th class="text-center">MATERI</th>
		<th class="text-center">AKTIVITAS</th>
		<th class="text-center">METODE</th>
		<th class="text-center">MEDIA</th>
		<th class="text-center">KENDALA</th>
		<th class="text-center">RENCANA LANJUTAN</th>
		<th class="text-center">KETERCAPAIAN</th>
		<th width="5%" class="text-center">HADIR</th>
		<th class="text-center">CATATAN</th>
		 </tr>
		<?php 
		$no = 1;
		foreach($jurnal as $row): 
			
		?>	
		<tr style="vertical-align:top">
			<td style="text-align:center"><?= $no; ?></td>
			<td style="text-align:center"><?= date('d-m-Y',strtotime($row['tanggal'])); ?></td>
			<td><?= $row['materi'] ?></td>
			<td class="text-center"><?= $row['aktivitas'] ?></td>
            <td class="text-center"><?= $row['metode'] ?></td>
			<td class="text-center"><?= $row['media'] ?></td>
			<td class="text-center"><?= $row['kendala'] ?></td>
			<td class="text-center"><?= $row['rencana_lanjutan'] ?></td>
			<td class="text-center"><?= $row['ketercapaian'] ?></td>
			<td class="text-center"><?= $row['prosentase_hadir'] ?>%</td>
			<td><?= $row['catatan'] ?></td>
			</tr>
		<?php endforeach; ?>
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
		<td width='5%'></td>
		<td width="20%"></td>
		<td>
		<?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d'); ?> <?= bulan_indo($tanggal); ?> <?= date('Y') ?><br/>
		Guru Mapel<br/>
		<br/><br/><br/>
		<u><?= $usr['nama'] ?></u><br/>
		NIP. <?= $usr['nip'] ?>
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
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
$dompdf->stream("Agenda Guru ".$usr['nama']. " Bulan ".$bl . ".pdf", array("Attachment" => false));
exit(0);
?>
