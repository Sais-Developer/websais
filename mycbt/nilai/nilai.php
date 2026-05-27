<?php 
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");

$tanggal = date('Y-m-d');
$idb     = $_GET['idb'] ?? '';  
$sesi    = $_GET['sesi'] ?? '';
$kelas   = $_GET['kls'] ?? '';

$sql = "
    SELECT * FROM banksoal b
    LEFT JOIN mapel m ON m.id = b.idmapel
    WHERE b.id_bank = :idb
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['idb' => $idb]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Nilai Kelas <?= htmlspecialchars($kelas) ?></title>
    <style>
        @page { 
            margin-top: 1cm; 
            margin-right: 1cm; 
            margin-bottom: 1cm; 
            margin-left: 2cm; 
        }
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px;  }
        th { background-color: #f0f0f0; width: auto;}
        .header-table td { border: none; text-align: left; padding: 2px; }
        .text-center { text-align: center; }
        strong { font-size: 18px; }
    </style>
</head>
<body>
<div>
    <table class="header-table">
        <tr>
            <td width="70px">
                <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70px" alt="Logo">
            </td>
            <td style="text-align:center;">
                <strong>
                    <?= strtoupper($setting['header'] ?? '') ?><br>
                    <?= strtoupper($setting['sekolah'] ?? '') ?>
                </strong><br>
                <small>
                    Alamat: <?= ($setting['alamat'] ?? '') ?> Desa <?= ($setting['desa'] ?? '') ?> 
                    Kecamatan <?= ($setting['kecamatan'] ?? '') ?> Kabupaten <?= ($setting['kabupaten'] ?? '') ?>
                </small>
            </td>
        </tr>
    </table>
    <hr>
    <center><h4>DAFTAR NILAI ASESMEN</h4></center>
    <br>

    <table class="header-table">
        <tr>
            <td width='100px'>Mata Pelajaran</td>
            <td width='10px'>:</td>
            <td><?= htmlspecialchars($data['nama_mapel']) ?></td>
            <td width='20px'></td>
            <td width='150px'>Semester</td>
            <td width='10px'>:</td>
            <td><?= $setting['semester'] ?></td>
        </tr>
        <tr>
            <td width='100px'>Asesmen</td>
            <td width='10px'>:</td>
            <td><?= $setting['jenis_ujian'] ?></td>
            <td width='20px'></td>
            <td width='150px'>Tahun Pelajaran</td>
            <td width='10px'>:</td>
            <td><?= $setting['tp'] ?></td>
        </tr>							
    </table>
    <br>

    <table>
        <tr>
            <th>NO</th>
            <th>N I S</th>
            <th>N I S N</th>
            <th>NAMA SISWA</th>
            <th>KELAS</th>
            <th width="5%">JK</th>
            <th width="10%">NILAI</th>
        </tr>
			<?php
			$sqlSiswa = "SELECT * FROM siswa WHERE kelas = :kelas AND sesi = :sesi";
			$stmtSiswa = $pdo->prepare($sqlSiswa);
			$stmtSiswa->execute(['kelas' => $kelas, 'sesi' => $sesi]);
			$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

			$no = 0;

			$sqlNilai = "SELECT id_siswa, id_bank, nilai FROM nilai WHERE id_siswa = :id_siswa AND id_bank = :idb";
			$stmtNilai = $pdo->prepare($sqlNilai);

			foreach ($siswaList as $dataq) :
				$no++;
				$stmtNilai->execute(['id_siswa' => $dataq['id_siswa'], 'idb' => $idb]);
				$nilai = $stmtNilai->fetch(PDO::FETCH_ASSOC);
			?>
        <tr>		
            <td class="text-center"><?= $no ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['nis']) ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['nisn']) ?></td>
            <td><?= htmlspecialchars($dataq['nama']) ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['kelas']) ?></td>
            <td class="text-center"><?= htmlspecialchars($dataq['jk']) ?></td>
            <td class="text-center"><?= number_format($nilai['nilai'] ?? 0, 2, '.', '') ?></td>
        </tr>
<?php endforeach; ?>
    </table>
    <br>

    <table class="header-table">
        <tr>
            <td width="5%"></td>
            <td width='50px'></td>
            <td><br/><br/><br/><br/></td>
            <td width='20%'></td>
            <td width="5%"></td>
            <td>
                <?= $setting['kabupaten'] ?>, <?= date('d'); ?> <?= bulan_indo($tanggal); ?> <?= date('Y') ?><br/>
                Kepala Sekolah
                <br/><br/><br/><br/>
                <u><?= $setting['kepsek'] ?></u><br/>
                NIP. <?= $setting['nip'] ?>
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Daftar_Nilai_Kelas_".$kelas.".pdf", ["Attachment" => false]);
exit;
?>
