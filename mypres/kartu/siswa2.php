<?php
ob_start();
error_reporting(E_ALL);

require("../../konek/koneksi.php");
require("../../konek/function.php");
include "../../vendor/phpqrcode/qrlib.php";

// Ambil input
$id = $_POST['id'];
$ids = $_POST['ids'];

try {
    // Ambil data siswa dengan PDO
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa BETWEEN :id AND :ids ORDER BY id_siswa ASC");
    $stmt->execute(['id' => $id, 'ids' => $ids]);
    $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fungsi fetch data registrasi siswa
function fetchReg($pdo, $id_siswa) {
    $stmt = $pdo->prepare("SELECT * FROM datareg WHERE idsiswa = :idsiswa LIMIT 1");
    $stmt->execute(['idsiswa' => $id_siswa]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KARPEL</title>
    
</head>
<body>
<table width='100%' align='center' cellpadding='0' cellspacing='0' style="margin-top:-20px;">
<tr>
<?php $no = 0; ?>
<?php foreach ($siswaList as $r): ?>
    <?php 
        $jkel = ($r['jk']=='L') ? 'Laki-laki' : 'Perempuan';
        $reg = fetchReg($pdo, $r['id_siswa']);
        $no++;
    ?>
<td width='33%' style="padding:5px;">
    <table style="text-align:center; width:100%;">
        <tr>
            <td style="text-align:left; vertical-align:top">
                <img src="<?= $baseurl ?>/mypres/kartu/KARSIS.png" width="328px" height="208px">					
                <div class="text-center" style="margin-top:-130px;margin-left:60px;font-size:10px">
                    <table>
                        <tr>
                            <td>NAMA</td>
                            <td>:</td>
                            <td><?= ucwords(strtolower($r['nama'])) ?></td>
                        </tr>
                        <tr>
                            <td>TEMPAT,TGL LAHIR</td>
                            <td>:</td>
                            <td><?= $r['t_lahir'] ?> <?= $r['tgl_lahir'] ?></td>
                        </tr>
                        <tr>
                            <td>JENIS KELAMIN</td>
                            <td>:</td>
                            <td><?= $jkel ?></td>
                        </tr>
                        <tr>
                            <td>ALAMAT</td>
                            <td>:</td>
                            <td><?= $r['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td>NIS</td>
                            <td>:</td>
                            <td><?= $r['nis'] ?></td>
                        </tr>
                        <tr>
                            <td>NISN</td>
                            <td>:</td>
                            <td><?= $r['nisn'] ?></td>
                        </tr>
                        <tr>
                            <td>ID KARTU</td>
                            <td>:</td>
                            <td><?= $reg['nokartu'] ?? '-' ?></td>
                        </tr>
                    </table>
                </div>
                <?php if(!empty($r['foto'])): ?>
                    <img src="<?= $baseurl ?>/images/fotosiswa/<?= $r['foto'] ?>" style="width:50px;margin-top:-105px;margin-left:2px">
                <?php else: ?>
                    <img src="<?= $baseurl ?>/images/user.png" style="width:50px;margin-top:-105px;margin-left:3px">
                <?php endif; ?>
            </td>
        </tr>
    </table>
</td>

<?php if (($no % 2) == 0): ?>
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
$dompdf->stream("KARPEL DPN.pdf", ["Attachment" => false]);
exit(0);
?>
