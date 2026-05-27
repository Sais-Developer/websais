<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
<!-- ---------------------------------------------------------
     PRESENSI
--------------------------------------------------------- -->
   <?php include 'home.php'; ?>
<?php elseif ($pg == enkripsi('mesin')): ?>
    <?php include 'mesin.php'; ?>	
<?php elseif ($pg == enkripsi('waktu')): ?>
    <?php include 'waktu.php'; ?>
<?php elseif ($pg == enkripsi('jjm')): ?>
    <?php include 'jjm.php'; ?>	
<?php elseif ($pg == enkripsi('notifsis')): ?>
    <?php include 'notifsis.php'; ?>		
<?php elseif ($pg == enkripsi('notifpeg')): ?>
    <?php include 'notifpeg.php'; ?>	
<?php elseif ($pg == enkripsi('sisnotif')): ?>
    <?php include 'sisnotif.php'; ?>	
<?php elseif ($pg == enkripsi('pegnotif')): ?>
    <?php include 'pegnotif.php'; ?>	
<?php elseif ($pg == enkripsi('regsis')): ?>
    <?php include 'rfid/siswa.php'; ?>
<?php elseif ($pg == enkripsi('regpeg')): ?>
    <?php include 'rfid/pegawai.php'; ?>	
<?php elseif ($pg == enkripsi('absiswa')): ?>
    <?php include 'absen/absiswa.php'; ?>
<?php elseif ($pg == enkripsi('presis')): ?>
    <?php include 'absen/presis.php'; ?>
<?php elseif ($pg == enkripsi('abpeg')): ?>
    <?php include 'absen/abpeg.php'; ?>
<?php elseif ($pg == enkripsi('prespeg')): ?>
    <?php include 'absen/prespeg.php'; ?>
<?php elseif ($pg == enkripsi('cetakpresensi')): ?>
    <?php include 'cetakpresensi.php'; ?>
<?php elseif ($pg == enkripsi('resetdata')): ?>
    <?php include 'resetdata.php'; ?>
<?php elseif ($pg == enkripsi('hapres')): ?>
    <?php include 'hapres.php'; ?>
<?php elseif ($pg == enkripsi('sinkron')): ?>
    <?php include 'sinkron/sinkron.php'; ?>
<?php elseif ($pg == enkripsi('rfsis')): ?>
    <?php include 'face/rfsis.php'; ?>
<?php elseif ($pg == enkripsi('rfpeg')): ?>
    <?php include 'face/rfpeg.php'; ?>
<?php elseif ($pg == enkripsi('fsis')): ?>
    <?php include 'finger/fsiswa.php'; ?>
<?php elseif ($pg == enkripsi('fpeg')): ?>
    <?php include 'finger/fpegawai.php'; ?>
<?php elseif ($pg == enkripsi('temp')): ?>
    <?php include 'finger/temp.php'; ?>	
<?php elseif ($pg == enkripsi('barsis')): ?>
    <?php include 'barkode/barsis.php'; ?>
<?php elseif ($pg == enkripsi('barpeg')): ?>
    <?php include 'barkode/barpeg.php'; ?>
	
<?php elseif ($pg == enkripsi('ckarpel')): ?>
    <?php include 'kartu/karpel.php'; ?>
<?php elseif ($pg == enkripsi('ckarpeg')): ?>
    <?php include 'kartu/karpeg.php'; ?>
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
