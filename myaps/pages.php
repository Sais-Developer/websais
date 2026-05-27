<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 
$presurl = __DIR__ . '/../mypres';
$kbmurl = __DIR__ . '/../mykbm';
$cbturl = __DIR__ . '/../mycbt';

if ($page === '') : ?>
<!-- ---------------------------------------------------------
     MASTER
--------------------------------------------------------- -->
    <?php include 'home.php'; ?>
<?php elseif ($page == 'imporsis') : ?>
    <?php include 'master/imporsis.php'; ?>
<?php elseif ($page == 'imporpel') : ?>
    <?php include 'master/imporpel.php'; ?>
<?php elseif ($page == 'imporpeg') : ?>
    <?php include 'master/imporpeg.php'; ?>
<?php elseif ($page == 'staff') : ?>
    <?php include 'master/staff.php'; ?>
<?php elseif ($page == 'admin') : ?>
    <?php include 'master/admin.php'; ?>
<?php elseif ($page == 'jurusan') : ?>
    <?php include 'master/jurusan.php'; ?>	
<?php elseif ($page == 'eskul') : ?>
    <?php include 'master/eskul.php'; ?>
<?php elseif ($page == 'profil') : ?>
    <?php include 'master/profil.php'; ?>
<?php elseif ($page == 'pengaturan') : ?>
    <?php include 'master/sekolah.php'; ?>
<?php elseif ($page == 'bell') : ?>
    <?php include 'bell.php'; ?>
<?php elseif ($page == 'gateway') : ?>
    <?php include 'gateway.php'; ?>
<?php elseif ($page == 'kebiasaan') : ?>
    <?php include 'kebiasaan.php'; ?>
<?php elseif ($page == 'cetakkeb') : ?>
    <?php include 'cetak.php'; ?>
<?php elseif ($page == 'naik') : ?>
    <?php include 'mutasi/naik.php'; ?>
<?php elseif ($page == 'tamat') : ?>
    <?php include 'mutasi/tamat.php'; ?>
<?php elseif ($page == 'pdb') : ?>
    <?php include 'mutasi/pdb.php'; ?>
<?php elseif ($page == 'sekolah') : ?>
    <?php include 'pengaturan/sekolah.php'; ?>
<?php elseif ($page == 'resetdata') : ?>
    <?php include 'pengaturan/resetdata.php'; ?>
<?php elseif ($page == 'backup') : ?>
    <?php include 'pengaturan/backupdata.php'; ?>
<?php elseif ($page == 'restore') : ?>
    <?php include 'pengaturan/restoredata.php'; ?>
<?php elseif ($page == 'sinkron') : ?>
    <?php include 'sinkron/sinkron.php'; ?>
<?php elseif ($page == 'alumni') : ?>
    <?php include 'alumni/alumni.php'; ?>
<?php elseif ($page == 'arsip') : ?>
    <?php include 'arsip.php'; ?>
<?php elseif ($page == 'tabungan') : ?>
    <?php include 'saving.php'; ?>
<?php elseif ($page == 'sapras') : ?>
    <?php include 'sapras.php'; ?>	
<?php else : ?>
    <div class="app app-error align-content-stretch d-flex flex-wrap">
        <div class="app-error-info">
            <h5>Oops!</h5>
            <span>It seems that the page you are looking for no longer exists.<br>
                We will try our best to fix this soon.</span>
            <a href="." class="btn btn-dark">Go to dashboard</a>
        </div>
        <div class="app-error-background"></div>
    </div>
<?php endif ?>
