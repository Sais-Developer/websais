<?php
ob_start();
require "../../konek/koneksi.php";
require "../../konek/function.php";
require "../../konek/crud.php";

$id_skl = 1;
$stmt = $pdo->prepare("SELECT * FROM skl WHERE id_skl = :id_skl");
$stmt->execute([':id_skl' => $id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);
$kuri = $skl['kuri'];

$ids = $_GET['ids'] ?? 0;
$siswa = fetch('siswa', ['id_siswa' => $ids]);
$bidang = fetch('m_kelas', ['kelas' => $siswa['kelas']]);
$pk = $bidang['pk'];
$bk = $bidang['pk'];
$kk = $bidang['kk'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>SKL</title>
<style>
@page { margin: 1cm 2cm 1cm 2cm; }
body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; font-size: 12px; }
th { background-color: #f0f0f0; }
.header-table td { border: none; text-align: left; padding: 2px; }
.tengah { text-align: center; }
.bold { font-weight: bold; }
</style>
</head>
<body>

<?php if(!empty($skl['header'])): ?>
<img src="<?= $baseurl ?>/images/<?= $skl['header'] ?>" style="max-width:670px;"><br>
<?php else: ?>
<table class="header-table">
<tr>
<td width="70"><img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70"></td>
<td style="text-align:center">
<strong><?= strtoupper($setting['header'] ?? '') ?><br><?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
<small>Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?></small>
</td>
</tr>
</table>
<hr style="margin:1px;background-color:black;margin-top:-7px">
<hr style="margin:2px;background-color:black">
<?php endif; ?>

<center><h3>TRANSKIP NILAI</h3></center>

<div style="margin-left:10px">Yang bertanda tangan di bawah ini :</div><br>
<table style="margin-left:50px" class="header-table">
<tr><td width="150px">Nama</td><td>:</td><td><?= $setting['kepsek'] ?></td></tr>
<tr><td>NIP</td><td>:</td><td><?= $setting['nip'] ?></td></tr>
<tr><td>Jabatan</td><td>:</td><td>Kepala <?= $setting['sekolah'] ?></td></tr>
</table><br>

<div style="margin-left:10px">Menerangkan bahwa :</div><br>
<table style="margin-left:50px" class="header-table">
<tr><td width="150px">Nama</td><td>:</td><td><?= $siswa['nama'] ?></td></tr>
<tr><td>Tempat, Tgl Lahir</td><td>:</td><td><?= $siswa['t_lahir'] ?>, <?= $siswa['tgl_lahir'] ?></td></tr>
<tr><td>NIS / NISN</td><td>:</td><td><?= $siswa['nis'] ?> / <?= $siswa['nisn'] ?></td></tr>
<?php if($setting['jenjang']=='SMK'): ?>
<tr><td>&nbsp;Bidang Keahlian</td><td>&nbsp;: <?= $bk ?></td></tr>
<tr><td>&nbsp;Program Keahlian</td><td>&nbsp;: <?= $pk ?></td></tr>
<tr><td>&nbsp;Kompetensi Keahlian</td><td>&nbsp;: <?= $kk ?></td></tr>
<?php endif; ?>
</table><br>

<?php
$no = 0;
$stmt_mapel = $pdo->prepare("SELECT idmapel FROM mapel_rapor WHERE tingkat=:level AND jurusan=:jurusan ORDER BY id ASC");
$stmt_mapel->execute([':level'=>$siswa['level'], ':jurusan'=>$siswa['jurusan']]);
$mapels = $stmt_mapel->fetchAll(PDO::FETCH_ASSOC);

if($kuri=='1'): ?>
<table width="90%" style="font-size:10px;">
<tr>
<td rowspan="3" class="tengah bold">NO</td>
<td rowspan="3" class="tengah bold">MATA PELAJARAN</td>
<td colspan="12" class="tengah bold">SEMESTER</td>
<td rowspan="2" colspan="2" class="tengah bold">UJIAN SEKOLAH</td>
</tr>
<tr><?php for($s=1;$s<=6;$s++): ?><td colspan="2" class="tengah bold"><?= $s ?></td><?php endfor; ?></tr>
<tr><?php for($s=1;$s<=6;$s++): ?><td class="tengah bold">P</td><td class="tengah bold">K</td><?php endfor; ?><td class="tengah bold">Teori</td><td class="tengah bold">Praktek</td></tr>

<?php
foreach($mapels as $mapel_row):
    $no++;
    $idmapel = $mapel_row['idmapel'];
    $stmt_nama = $pdo->prepare("SELECT nama_mapel FROM mapel WHERE id=:idmapel");
    $stmt_nama->execute([':idmapel'=>$idmapel]);
    $nama_mapel = $stmt_nama->fetchColumn();

    echo "<tr><td class='tengah'>$no</td><td>$nama_mapel</td>";

    $stmt_nilai = $pdo->prepare("
        SELECT kode,
               MAX(CASE WHEN ki='KI3' THEN nilai END) AS KI3,
               MAX(CASE WHEN ki='KI4' THEN nilai END) AS KI4
        FROM nilai_skl
        WHERE idsiswa=:ids AND mapel=:idmapel AND ket='SMT'
        GROUP BY kode
        ORDER BY kode ASC
    ");
    $stmt_nilai->execute([':ids'=>$ids, ':idmapel'=>$idmapel]);
    $nilai_rows = $stmt_nilai->fetchAll(PDO::FETCH_ASSOC);

    foreach($nilai_rows as $r){
        echo "<td class='tengah'>{$r['KI3']}</td><td class='tengah'>{$r['KI4']}</td>";
    }

    $stmt_us = $pdo->prepare("
        SELECT 
            MAX(CASE WHEN kode='TEORI' THEN nilai END) AS teori,
            MAX(CASE WHEN kode='PRAKTEK' THEN nilai END) AS praktek
        FROM nilai_skl 
        WHERE idsiswa=:ids AND mapel=:idmapel AND ket='US'
    ");
    $stmt_us->execute([':ids'=>$ids, ':idmapel'=>$idmapel]);
    $us = $stmt_us->fetch(PDO::FETCH_ASSOC);

    echo "<td class='tengah'>{$us['teori']}</td><td class='tengah'>{$us['praktek']}</td></tr>";

endforeach;
?>
</table>
<?php endif; ?>
<?php if($kuri == '2'): ?>
<table width="90%" style="font-size:12px;">
<tr>
    <td rowspan="2" class="tengah bold">NO</td>
    <td rowspan="2" class="tengah bold">MATA PELAJARAN</td>
    <td colspan="6" class="tengah bold">SEMESTER</td>
    <td colspan="2" class="tengah bold">UJIAN SEKOLAH</td>
</tr>
<tr>
    <?php for($s=1;$s<=6;$s++): ?>
        <td class="tengah bold"><?= $s ?></td>
    <?php endfor; ?>
    <td class="tengah bold">Teori</td>
    <td class="tengah bold">Praktek</td>
</tr>

<?php
$no = 0;
$stmt_mapel = $pdo->prepare("SELECT idmapel FROM mapel_rapor WHERE tingkat=:tingkat AND jurusan=:jurusan ORDER BY id ASC");
$stmt_mapel->execute([':tingkat'=>$siswa['level'], ':jurusan'=>$siswa['jurusan']]);
$mapel_rows = $stmt_mapel->fetchAll(PDO::FETCH_ASSOC);

foreach ($mapel_rows as $mapel_row):
    $no++;
    $idmapel = $mapel_row['idmapel'];

    $stmt_nama = $pdo->prepare("SELECT nama_mapel FROM mapel WHERE id=:id");
    $stmt_nama->execute([':id'=>$idmapel]);
    $nama_mapel = $stmt_nama->fetch(PDO::FETCH_ASSOC)['nama_mapel'];

    echo "<tr><td class='tengah'>$no</td><td>$nama_mapel</td>";

    $stmt_nilai = $pdo->prepare("
        SELECT nilai FROM nilai_skl 
        WHERE idsiswa=:idsiswa AND mapel=:mapel AND ket='SMT' AND ki IS NULL
        ORDER BY kode ASC
    ");
    $stmt_nilai->execute([':idsiswa'=>$ids, ':mapel'=>$idmapel]);
    $nilai_rows = $stmt_nilai->fetchAll(PDO::FETCH_ASSOC);
    foreach ($nilai_rows as $r) {
        echo "<td class='tengah'>{$r['nilai']}</td>";
    }

    $stmt_us = $pdo->prepare("
        SELECT 
            MAX(CASE WHEN kode='TEORI' THEN nilai END) AS teori,
            MAX(CASE WHEN kode='PRAKTEK' THEN nilai END) AS praktek
        FROM nilai_skl 
        WHERE idsiswa=:idsiswa AND mapel=:mapel AND ket='US'
    ");
    $stmt_us->execute([':idsiswa'=>$ids, ':mapel'=>$idmapel]);
    $us = $stmt_us->fetch(PDO::FETCH_ASSOC);

    echo "<td class='tengah'>{$us['teori']}</td><td class='tengah'>{$us['praktek']}</td></tr>";

endforeach;
?>
</table>
<?php endif; ?>

<br><br>
<table class="header-table">
<tr>
<td width="30%"></td>
<td width="40%" class="tengah">
<?php if(!empty($siswa['foto'])): ?>
<img src='<?= $baseurl ?>/images/fotosiswa/<?= $siswa['foto'] ?>' width='90px'><br>
<?php else: ?>
<img src='<?= $baseurl ?>/images/polos.png' width='90px'><br>
<?php endif; ?>
</td>
<td width="30%" style="text-align:left">
<?= $setting['kecamatan'] ?>, <?= $skl['tgl_surat'] ?><br>
Kepala Sekolah,<br><br><br><br><br>
<b><u><?= $setting['kepsek'] ?></u></b><br>
NIP. <?= $setting['nip'] ?>
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
$dompdf->setPaper('Folio', 'portrait');
$dompdf->render();
$dompdf->stream("SKL_" . $siswa['nama'] . ".pdf", ["Attachment" => false]);
exit;
?>
