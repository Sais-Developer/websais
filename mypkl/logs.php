<?php
require("../konek/koneksi.php");
require("../konek/function.php");
?>  
<style>
#grid {display: grid;grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));gap: 5px;padding: 10px;}
.jurnal {border: 1px solid #333;padding: 10px;text-align: center;border-radius: 5px;}
.jurnal img {width: 160px;height: 120px;border: 1px solid #f9f9f9;margin-bottom: 10px;}
    </style>
<div id="grid">
 <?php
$level = $_GET['lvl'] ?? '';
$iduser = $_GET['idu'] ?? '';
$zero = 0;
$ada = false;
$no = 0;

if ($level === 'admin') {
    $sql = "
        SELECT p.foto_jurnal, p.jurnal, p.id, s.nama
        FROM pkl_jurnal p
        LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
        WHERE p.tanggal = :tanggal AND p.status = :zero
        ORDER BY p.id DESC
        LIMIT 10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':tanggal', $tanggal);
    $stmt->bindValue(':zero', $zero, PDO::PARAM_INT);
} else {
    $sql = "
        SELECT p.foto_jurnal, p.jurnal, p.id, s.nama
        FROM pkl_jurnal p
        LEFT JOIN pkl_siswa g ON g.idsiswa = p.idsiswa
        LEFT JOIN siswa s ON s.id_siswa = g.idsiswa
        WHERE p.tanggal = :tanggal AND g.idguru = :iduser AND p.status = :zero
        ORDER BY p.id DESC
        LIMIT 10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':tanggal', $tanggal);
    $stmt->bindValue(':iduser', $iduser, PDO::PARAM_INT);
    $stmt->bindValue(':zero', $zero, PDO::PARAM_INT);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $data):
    $ada = true;
    $no++;
?>
<div class="jurnal" id="jurnal">
    <img src="<?= $baseurl ?>/images/fotopkl/<?= htmlspecialchars($data['foto_jurnal']) ?>" >
    <p style="font-size:12px;"><?= htmlspecialchars($data['nama']) ?></p>
    <a href="?pg=&ac=<?= enkripsi('jurnal') ?>&id=<?= $data['id'] ?>" class="btn btn-sm btn-primary">Approve</a>
</div>
<?php endforeach; ?>

<?php if (!$ada): ?>
<div class="card-body">
    <img src="<?= $baseurl ?>/images/animasi.gif" width="50px">
    <strong>Belum ada aktifitas</strong> <b>Jurnal Prakerin</b> saat ini.
</div>
<?php endif; ?>
