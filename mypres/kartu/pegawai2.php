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
    $stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru BETWEEN :id AND :ids ORDER BY id_guru ASC");
    $stmt->execute(['id' => $id, 'ids' => $ids]);
    $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fungsi fetch data registrasi siswa
function fetchReg($pdo, $idpeg) {
    $stmt = $pdo->prepare("SELECT * FROM datareg WHERE idpeg = :idpeg LIMIT 1");
    $stmt->execute(['idpeg' => $idpeg]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KARPEG</title>
    
</head>
<body>
<table width='100%' align='center' cellpadding='0' cellspacing='0' style="margin-top:-20px;">
<tr>
<?php $no = 0; ?>
<?php foreach ($siswaList as $r): ?>
    <?php 
        $jkel = ($r['jk']=='L') ? 'Laki-laki' : 'Perempuan';
        $reg = fetchReg($pdo, $r['id_guru']);
        $no++;
    ?>
<td width='33%' style="padding:5px;">
    <table style="text-align:center; width:100%;">
        <tr>
            <td style="text-align:left; vertical-align:top">
                <img src="<?= $baseurl ?>/mypres/kartu/1.png" width="208px" height="328px">					
                <div class="text-center" style="margin-top:-130px;margin-left:10px;font-size:10px">
				 <?php if(!empty($r['foto'])): ?>
                    <img src="<?= $baseurl ?>/images/fotoguru/<?= $r['foto'] ?>" style="width:70px;margin-top:-100px;margin-left:60px">
                <?php else: ?>
                    <img src="<?= $baseurl ?>/images/user.png" style="width:70px;margin-top:-100px;margin-left:60px">
                <?php endif; ?>
                    <table>
                        <tr>
                            <td>NAMA</td>
                            <td>:</td>
                            <td><?= ucwords(strtolower($r['nama'])) ?></td>
                        </tr>
                        <tr>
                            <td>JABATAN</td>
                            <td>:</td>
                            <td><?= $r['jabatan'] ?></td>
                        </tr>
                         <tr>
                            <td>NUPTK</td>
                            <td>:</td>
                            <td><?= $r['nip'] ?? '-' ?></td>
                        </tr>
                       
                        <tr>
                            <td>ID KARTU</td>
                            <td>:</td>
                            <td><?= $reg['nokartu'] ?? '-' ?></td>
                        </tr>
                    </table>
                </div>
               
            </td>
        </tr>
    </table>
</td>

<?php if (($no % 3) == 0): ?>
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
$dompdf->stream("KARPEG DPN.pdf", ["Attachment" => false]);
exit(0);
?>
