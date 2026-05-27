<?php
ob_start();
error_reporting(E_ALL);

require("../../konek/koneksi.php");
require("../../konek/function.php");
include "../../vendor/phpqrcode/qrlib.php";

// Ambil input
$id = $_POST['id'];
$ids = $_POST['ids'];

// Variabel tambahan
$tanggal = date('Y-m-d');  
            
$bl = date('m');           

try {
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa BETWEEN :id AND :ids");
    $stmt->execute(['id' => $id, 'ids' => $ids]);
    $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tempdir = "../../temp/";
    if (!file_exists($tempdir)) mkdir($tempdir, 0777, true);

    // Generate QR code
    foreach ($siswaList as $sis) {
        $codeContents = $sis['nis'];
        QRcode::png($codeContents, $tempdir . $sis['nis'] . '.png', QR_ECLEVEL_M, 4);
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KARPEL</title>
    <style>
        @page { 
            margin: 1cm 1cm 1cm 2cm; 
        }
        body { margin:0; padding:0; font-family: Arial, sans-serif; }
        table { border-collapse: collapse; border-spacing: 0; margin:0; padding:0; }
        td { padding:0; margin:0; vertical-align: top; }
        .kartu { position: relative; width: 328px; height: 208px; margin-bottom:5px; }
        .qr-code { position: absolute; top: 10px; right: 10px; width:50px; height:50px; }
        .text-kartu { position: absolute; top: 80px; left:10px; right:10px; font-size: 9px; line-height: 1.1; }
        .ttd { position: absolute; bottom: 10px; left:235px; width:70px; }
        .stempel { position: absolute; bottom: 10px; left:215px; width:60px; }
        .footer { position: absolute; bottom: 20px; left:220px; font-size: 8px; line-height:1.1; }
    </style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<?php $no=0; ?>
<?php foreach($siswaList as $r): $no++; ?>
<td style="width:50%; padding:0; margin:0;">
    <div class="kartu">
        <img src="<?= $baseurl ?>/mypres/kartu/KARSIS.png" style="width:100%; height:100%;">
       
        <div class="text-kartu">
            <b>KARTU PELAJAR DAN PRESENSI</b><br>
            * Kartu ini berlaku selama menjadi siswa<br>
            * Kartu ini tidak boleh berpindah milik<br>
            * Apabila ada kehilangan atau menemukan<br>
            &nbsp;&nbsp; kartu ini, segera hubungi alamat atau nomor<br>
            &nbsp;&nbsp; telephone sekolah yang bersangkutan<br>
            * Kartu ini berisi kode yang digunakan absensi<br>
            &nbsp;&nbsp; dalam mengikuti Kegiatan Belajar Mengajar
        </div>
        <img class="ttd" src="<?= $baseurl ?>/mypres/kartu/ttd.png">
        <img class="stempel" src="<?= $baseurl ?>/mypres/kartu/stempel.png">
        <div class="footer">
            Bogor, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br>
            Kepala Madrasah,<br><br>
            <b>Khoirudin Apandi, S.Pd.I</b>
        </div>
    </div>
</td>
<?php if($no % 2 == 0): ?>
</tr><tr>
<?php endif; ?>
<?php endforeach; ?>
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("KARPEL BLK.pdf", ["Attachment" => false]);
exit(0);
?>
