<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
 <?php include 'home.php'; ?>
<!-- ---------------------------------------------------------
     ASESMEN
--------------------------------------------------------- -->
<?php elseif ($pg == enkripsi('upsiswa')): ?>
    <?php include 'siswa.php'; ?>
<?php elseif ($pg == enkripsi('info')): ?>
    <?php include 'info.php'; ?>		
<?php elseif ($pg == enkripsi('jenis')): ?>
    <?php include 'jenis.php'; ?>
<?php elseif ($pg == enkripsi('banksoal')): ?>
    <?php include 'bank/banksoal.php'; ?>	
<?php elseif ($pg == enkripsi('editsoal1')): ?>
    <?php include 'input/editsoal1.php'; ?>		
<?php elseif ($pg == enkripsi('editsoal2')): ?>
    <?php include 'input/editsoal2.php'; ?>	
<?php elseif ($pg == enkripsi('editsoal3')): ?>
    <?php include 'input/editsoal3.php'; ?>	
<?php elseif ($pg == enkripsi('editsoal4')): ?>
    <?php include 'input/editsoal4.php'; ?>	
<?php elseif ($pg == enkripsi('editsoal5')): ?>
    <?php include 'input/editsoal5.php'; ?>
<?php elseif ($pg == enkripsi('jadwaluji')): ?>
    <?php include 'jadwal.php'; ?>	
<?php elseif ($pg == enkripsi('status')): ?>
    <?php include 'status.php'; ?>
<?php elseif ($pg == enkripsi('nilai')): ?>
    <?php include 'nilai/mapel.php'; ?>
<?php elseif ($pg == enkripsi('rekap')): ?>
    <?php include 'nilai/rekap.php'; ?>	
<?php elseif ($pg == enkripsi('katrol')): ?>
    <?php include 'nilai/katrol.php'; ?>
<?php elseif ($pg == enkripsi('ckatrol')): ?>
    <?php include 'nilai/ckatrol.php'; ?>	
<?php elseif ($pg == enkripsi('anbuso')): ?>
    <?php include 'nilai/anbuso.php'; ?>	
<?php elseif ($pg == enkripsi('kartu')): ?>
    <?php include 'cetak/kartu.php'; ?>		
<?php elseif ($pg == enkripsi('absen')): ?>
    <?php include 'cetak/absen.php'; ?>			
<?php elseif ($pg == enkripsi('berita')): ?>
    <?php include 'cetak/berita.php'; ?>
<?php elseif ($pg == enkripsi('resetdata')): ?>
    <?php include 'reset/resetdata.php'; ?>
<?php elseif ($page == 'sinkron') : ?>
    <?php include 'sinkron/sinkron.php'; ?>
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
