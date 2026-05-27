<?php defined('APK') or exit('No access'); ?>
<div class="row">
<?php
$adaUjian = false;

$tugasQ = $pdo->prepare("
    SELECT t.*, g.nama AS guru_nama, p.kode 
    FROM tugas t
    LEFT JOIN guru g ON g.id_guru = t.guru
    LEFT JOIN mapel p ON p.id = t.mapel
");
$tugasQ->execute();
$tugasRows = $tugasQ->fetchAll(PDO::FETCH_ASSOC);

foreach ($tugasRows as $tugas) :
    $datakelas = unserialize($tugas['kelas']);

    if (in_array($siswa['kelas'], $datakelas) || in_array('semua', $datakelas)) :
        $adaUjian = true;
        $now = date('Y-m-d H:i:s');
?>
    <div class="col-xl-4">
        <?php if ($tugas['tgl_mulai'] > $now && $tugas['tgl_selesai'] > $now) : ?>
            <div class="card">
                <div class="card-body text-center edis">
                    TUGAS BELUM MULAI<br>
                    <img src="<?= $baseurl ?>/images/animasi.gif" style="max-width:70px" alt="thumb" />
                </div>
            </div>
        <?php elseif ($tugas['tgl_mulai'] <= $now && $tugas['tgl_selesai'] >= $now) : ?>
            <a href="?pg=<?= enkripsi('bukatugas') ?>&id=<?= $tugas['id_tugas'] ?>" style="text-decoration:none">
                <div class="card">
                    <div class="card-body text-center edis">
                        <div class="d-flex align-items-center flex-column mb-0">
                            <div class="d-flex align-items-center flex-column">
                                <div class="sw-13 position-relative mb-0">
                                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="max-width:70px" alt="thumb" />
                                </div>
                                <span style="font-size: 20px"><b><?= htmlspecialchars($tugas['kode']) ?></b></span>
                                <p>Guru: <?= htmlspecialchars($tugas['guru_nama']) ?></p>
                                Berlaku<br>
                                <?= date('d-m-Y H:i', strtotime($tugas['tgl_mulai'])) ?> - <?= date('d-m-Y H:i', strtotime($tugas['tgl_selesai'])) ?>
                                <span><?= htmlspecialchars($tugas['judul']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>
<?php
    endif;
endforeach;

if (!$adaUjian) : ?>
    <div class="alert alert-warning">
        <strong>Belum ada Tugas Belajar</strong> untuk kelas <b><?= htmlspecialchars($siswa['kelas']) ?></b> saat ini.
    </div>
<?php endif; ?>
</div>
