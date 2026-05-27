<style type="text/css">
    .ttd {
        position: absolute;
        z-index: -1;
    }
</style>

<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
include "../../vendor/phpqrcode/qrlib.php";

$kelas = $_GET['kelas'] ?? '';

if (date('m') >= 7 && date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 && date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}

$stmt = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas");
$stmt->bindParam(':kelas', $kelas, PDO::PARAM_STR);
$stmt->execute();
$siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tempdir = "../../temp/";
if (!file_exists($tempdir)) mkdir($tempdir);

foreach ($siswaList as $sis) {
    $codeContents = $sis['nis'] . '-' . $sis['nama'];
    QRcode::png($codeContents, $tempdir . $sis['nis'] . '.png', QR_ECLEVEL_M, 4);
}
?>

<style>
    * { font-size: x-small; }
    .box { border: 1px solid #000; width: 100%; height: 150px; }
    .ukuran { font-size: 15px; }
    .ukuran2 { font-size: 12px; }
    .user { font-size: 15px; }
</style>

<table width='100%' align='center' cellpadding='10'>
    <tr>
        <?php
        $no = 0;
        foreach ($siswaList as $siswa):
            $no++;
        ?>
        <td width='50%'>
            <div style='width:10.5cm;border:1px solid #666;'>
                <table style="text-align:center; width:100%">
                    <tr>
                        <td style="text-align:left; vertical-align:top">
                            <img src="<?= htmlspecialchars($baseurl); ?>/images/<?= htmlspecialchars($setting['logo']); ?>" height='60px'>
                        </td>
                        <td style="text-align:center">
                            <b class="ukuran">
                                <?= strtoupper(htmlspecialchars($setting['header_kartu'])); ?><br>
                                <?= strtoupper(htmlspecialchars($setting['sekolah'])); ?><br>
                                TAHUN PELAJARAN <?= $ajaran ?>
                            </b>
                        </td>
                        <td style="text-align:right; vertical-align:top">
                            <img src="<?= htmlspecialchars($baseurl); ?>/images/kemdikbud.png" height='60px' />							
                        </td>
                    </tr>
                </table>
                <hr>
                <table style="text-align:left; width:100%">
                    <tr>
                        <td style="text-align:center; vertical-align:top; width:100px" rowspan="8">
                            <?php
                            $fotoPath = "../../images/fotosiswa/" . $siswa['foto'];
                            if (!empty($siswa['foto']) && file_exists($fotoPath)) {
                                echo "<img src='$baseurl/images/fotosiswa/" . htmlspecialchars($siswa['foto']) . "' style='max-width:60px' alt='Foto'>";
                            } else {
                                echo "<img src='$baseurl/images/user.png' style='max-width:60px' alt='User'>";
                            }
                            ?>
                            <br>
                            <img src="<?= $baseurl ?>/temp/<?= htmlspecialchars($siswa['nis']); ?>.png" width="90px">
                        </td>
                    </tr>
                    <tr>
                        <td class="ukuran" valign='top' width="30%">No Peserta</td>
                        <td class="ukuran" valign='top'>: <?= htmlspecialchars($siswa['nopes']); ?></td>
                    </tr>
                    <tr>
                        <td class="ukuran" valign='top'>Nama</td>
                        <td class="ukuran2" valign='top'>: <?= htmlspecialchars(substr($siswa['nama'], 0, 21)); ?></td>
                    </tr>
                    <tr>
                        <td class="ukuran" valign='top'>Kelas / Sesi Ujian</td>
                        <td class="ukuran" valign='top'>: <?= htmlspecialchars($kelas); ?> / Sesi <?= htmlspecialchars($siswa['sesi']); ?></td>
                    </tr>
                    <tr>
                        <td class="ukuran" valign='top'>Username</td>
                        <td class="ukuran" valign='top'>:<b class="user"> <?= htmlspecialchars($siswa['username']); ?></b></td>
                    </tr>
                    <tr>
                        <td class="ukuran" valign='top'>Password</td>
                        <td class="ukuran" valign='top'>: <b class="user"><?= htmlspecialchars($siswa['password']); ?></b></td>
                    </tr>
                    <tr>
                        <td valign='top'></td>
                        <td class="ukuran2" valign='top' align='center'>
                            Kepala Sekolah<br><br>
                            <b><?= htmlspecialchars($setting['kepsek']); ?></b><br>
                            <b>NIP. <?= htmlspecialchars($setting['nip']); ?></b>
                        </td>
                    </tr>
                </table>
            </div>
        </td>

        <?php if (($no % 2) == 0): ?>
    </tr>
    <tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tr>
</table>
