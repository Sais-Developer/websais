<?php
require("../konek/koneksi.php");

?>  
<style>
#grid {display: grid;grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));gap: 5px;padding: 10px;}
.peserta {border: 1px solid #333;padding: 10px;text-align: center;border-radius: 5px;}
.peserta img {width: 160px;height: 120px;border: 1px solid #f9f9f9;margin-bottom: 10px;}
    </style>
<div id="grid">
 <?php
$level = $_GET['level'] ?? '';
$iduser = $_GET['idus'] ?? '';
$ada = false;
$no = 0;

if ($level === 'admin') {
    $sql = "
        SELECT p.foto, p.jam_masuk, s.nama
        FROM pkl_presensi p 
        LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
        WHERE p.tanggal = :tanggal
        ORDER BY p.id DESC
        LIMIT 10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
} else {
    $sql = "
        SELECT p.foto, p.jam_masuk, s.nama
        FROM pkl_presensi p
        LEFT JOIN pkl_siswa g ON g.idsiswa = p.idsiswa
        LEFT JOIN siswa s ON s.id_siswa = g.idsiswa
        WHERE p.tanggal = :tanggal AND g.idguru = :iduser
        ORDER BY p.id DESC
        LIMIT 10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $data):
    $ada = true;
    $no++;
?>
<div class="peserta" id="peserta">
    <img src="<?= $baseurl ?>/images/prakerin/<?= htmlspecialchars($data['foto']) ?>" >
    <p style="font-size:12px;">
        <?= htmlspecialchars($data['nama']) ?><br><?= htmlspecialchars($data['jam_masuk']) ?>
    </p>		
</div>
<?php endforeach; ?>

<?php if (!$ada): ?>
<div class="card-body">
    <img src="<?= $baseurl ?>/images/animasi.gif" width="50px">
    <strong>Belum ada aktifitas</strong> <b>Presensi Prakerin</b> saat ini.
</div>
<?php endif; ?>

