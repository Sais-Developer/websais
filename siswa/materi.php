<?php defined('APK') or exit('No access'); ?>
<div class="row">
<?php
$adaUjian = false;

$materikuQ = $pdo->prepare("
    SELECT m.*, g.nama AS guru_nama, p.kode 
    FROM materi m
    LEFT JOIN guru g ON g.id_guru = m.guru
    LEFT JOIN mapel p ON p.id = m.mapel
");
$materikuQ->execute();
$materikuRows = $materikuQ->fetchAll(PDO::FETCH_ASSOC);

foreach ($materikuRows as $materiku) :
    $datakelas = unserialize($materiku['kelas']);

    if (in_array($siswa['kelas'], $datakelas) || in_array('semua', $datakelas)) {
        $adaUjian = true;

        $today = date('Y-m-d');
        $dari = date('Y-m-d', strtotime($materiku['dari']));
        $sampai = date('Y-m-d', strtotime($materiku['sampai']));

        if ($today >= $dari && $today <= $sampai) :
?>
<div class="col-xl-4">
    <a href="?pg=<?= enkripsi('bukamateri') ?>&id=<?= $materiku['idm'] ?>" style="text-decoration:none">
        <div class="card">
            <div class="card-body text-center edis">
                <div class="d-flex align-items-center flex-column mb-0">
                    <div class="d-flex align-items-center flex-column">
                        <div class="sw-13 position-relative mb-0">
                            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="max-width:70px" alt="thumb" />
                        </div>
                        <span style="font-size: 20px"><b><?= htmlspecialchars($materiku['kode']) ?></b></span>
                        <p>Guru: <?= htmlspecialchars($materiku['guru_nama']) ?></p>
                        Berlaku<br>
                        <?= date('d-m-Y', strtotime($materiku['dari'])) ?> - <?= date('d-m-Y', strtotime($materiku['sampai'])) ?>
                        <span><?= htmlspecialchars($materiku['judul']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<?php
        endif;
    }
endforeach;

if (!$adaUjian) : ?>
    <div class="alert alert-warning">
        <strong>Belum ada Materi Belajar</strong> untuk kelas <b><?= htmlspecialchars($siswa['kelas']) ?></b> saat ini.
    </div>
<?php endif; ?>
</div>
