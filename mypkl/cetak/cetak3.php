<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$ids = $_GET['ids'] ?? '';

$sql = "
    SELECT p.*, s.nama, s.kelas,
           d.nama_dudi, d.instruktur,
           k.pk, k.kk,
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
		margin-top: 1.5cm; 
		margin-right: 2cm; 
		margin-bottom: 1cm; 
		margin-left: 2cm; 
		}
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; font-size: 13px; }
        th { background-color: #f0f0f0; }
       .header-table td { border: none; text-align: left; padding: 2px; }
       .text-center { text-align: center; }
	   .bold {font-weight:bold;}
     </style>
</head>
<body>
  <h4 class="text-center">PENILAIAN HASIL BELAJAR<br>PRAKTIK KERJA INDUSTRI (PRAKERIN)</h4>
   <table class="header-table" >       
	<tr>
	<td width="25%">Nama Peserta Dididk</td>
	<td>: <?= ucwords(strtolower($siswa['nama'])) ?></td>	
	</tr>
	<tr>
	<td>Kelas</td>
	<td>: <?= $siswa['kelas'] ?></td>	
	</tr>
	<tr>
	<td>Program Keahlian</td>
	<td>: <?= $siswa['pk'] ?></td>	
	</tr>
	<tr>
	<td>Kompetensi Keahlian</td>
	<td>: <?= $siswa['kk'] ?></td>	
	</tr>
	<tr>
	<td>Nama Industri</td>
	<td>: <?= ucwords(strtolower($siswa['nama_dudi'])) ?></td>	
	</tr>
	<tr>
	<td>Nama Instruktur</td>
	<td>: <?= $siswa['instruktur'] ?></td>	
	</tr>
	<tr>
	<td>Guru Pembimbing</td>
	<td>: <?= $siswa['nama_guru'] ?></td>	
	</tr>
	</table>
       <br>
     <br>
	 <table width="100%">
<tr style="vertical-align:middle;font-weight:bold" class="text-center">
    <td>No.</td>
    <td>Komponen Penilaian</td>
    <td>Skor<br>(0-100)</td>
   
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
    GROUP BY n.aspek
    ORDER BY a.kategori, a.id_aspek
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$ids]); 
$current_kategori = null;
$total = 0;
$jumlah = 0;

$grand_total = 0;    
$grand_jumlah = 0;   

function get_predikat($rata) {
    if ($rata >= 90) return "A";
    if ($rata >= 80) return "B";
    if ($rata >= 70) return "C";
    if ($rata >= 60) return "D";
    return "E";
}

function tampilkan_rata_kategori($kategori, $total, $jumlah) {
    if ($jumlah == 0) return;

    $rata = round($total / $jumlah, 2);
    $predikat = get_predikat($rata);

    echo "<tr style='font-weight:bold; background:#f9f9f9'>";
    if ($kategori != 'Laporan') {
        echo "<td colspan='2' style='text-align:right'>Rerata</td>";
        echo "<td class='text-center'>{$rata}</td>";
    }
    echo "</tr>";
}

$no = 0;
$nox = 1;

while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
    $no++;

    if ($current_kategori !== null && $current_kategori !== $data['kategori']):
        tampilkan_rata_kategori($current_kategori, $total, $jumlah);
        $nox++;
        $total = 0;
        $jumlah = 0;
    endif;

    if ($current_kategori !== $data['kategori']):
        $current_kategori = $data['kategori'];
        echo "<tr style='background:#e0e0e0; font-weight:bold;'>
                <td colspan='3'>{$nox}. " . htmlspecialchars($data['kategori']) . "</td>
              </tr>";
    endif;

    echo "<tr>
            <td class='text-center' style='width:30px;'>$no</td>
            <td>" . htmlspecialchars($data['nama_aspek']) . "</td>
            <td class='text-center'>" . htmlspecialchars(round($data['nilai'])) . "</td>
          </tr>";

    $total += $data['nilai'];
    $jumlah++;

    $grand_total += $data['nilai'];
    $grand_jumlah++;
endwhile;

tampilkan_rata_kategori($current_kategori, $total, $jumlah);

if ($grand_jumlah > 0):
    $rata_akhir = round($grand_total / $grand_jumlah, 2);
    $predikat_akhir = get_predikat($rata_akhir);
    echo "<tr style='background:#d0f0d0; font-weight:bold;'>
            <td colspan='2' style='text-align:right'><span>Rata-rata Akhir</span></td>
            <td style='text-align:center'><span>{$rata_akhir}</span></td>
          </tr>";
    echo "<tr style='background:#d0f0d0; font-weight:bold;'>
            <td colspan='2' style='text-align:right'><span>Predikat</span></td>
            <td style='text-align:center'><span>{$predikat_akhir}</span></td>
          </tr>";
endif;
?>

</table>
<br>
	 <table class="header-table">
		<tr>
		<td width="5%"></td>
		<td width='50px'></td>
			<td>
			 <br>							
				Kepala Sekolah
				<br><br><br><br>
				<u><?= $setting['kepsek'] ?></u><br/>
				NIP. <?= $setting['nip'] ?>
			</td>
			<td width='10%'></td>
			<td width="5%"></td>
			<td>
				<?= ucwords(strtolower($setting['kabupaten'])); ?>, <?= date('d'); ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br/>
				Kepala Dudi / Pembimbing Industri<br>
				<br><br><br>
				<u><?= $siswa['instruktur'] ?></u><br/>
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
$dompdf->stream("Nilai_Prakerin_".$siswa['nama'].".pdf", ["Attachment" => false]);
exit(0);
?>
