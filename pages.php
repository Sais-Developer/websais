<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
 <?php include 'home.php'; ?>
<!-- ---------------------------------------------------------
     ASESMEN
--------------------------------------------------------- -->
<?php elseif ($pg == enkripsi('ujian')): ?>
    <?php include 'siswa/beranda.php'; ?>	
<?php elseif ($pg == enkripsi('jadwal')): ?>
    <?php include 'jadwal.php'; ?>
<?php elseif ($page == 'konfirmasi') : ?>
    <?php include 'konfirmasi.php'; ?>
<?php elseif ($page == 'asesmen') : ?>
    <?php include 'asesmen.php'; ?>		
<?php elseif ($page == 'nilai') : ?>
    <?php include 'siswa/nilai.php'; ?>	
<?php elseif ($page == 'nilaiujian') : ?>
    <?php include 'siswa/nilaiujian.php'; ?>
<?php elseif ($page == 'kebiasaan') : ?>
    <?php include 'siswa/kebiasaan.php'; ?>	
<?php elseif ($page == 'materi') : ?>
    <?php include 'siswa/materi.php'; ?>
<?php elseif ($page == 'bukamateri') : ?>
    <?php include 'siswa/lihatmateri.php'; ?>	
<?php elseif ($page == 'tugas') : ?>
    <?php include 'siswa/tugas.php'; ?>		
<?php elseif ($page == 'bukatugas') : ?>
    <?php include 'siswa/lihattugas.php'; ?>
<?php elseif ($page == 'nilaitugas') : ?>
    <?php include 'siswa/nilaitugas.php'; ?>
<?php elseif ($page == 'prakerin') : ?>
    <?php include 'siswa/prakerin.php'; ?>
<?php elseif ($page == 'ttd') : ?>
    <?php include 'siswa/ttd.php'; ?>
<?php elseif ($page == 'pulang') : ?>
    <?php include 'siswa/pulang.php'; ?>
<?php elseif ($page == 'skl') : ?>
    <?php include 'siswa/skl.php'; ?>
<?php elseif ($page == 'profil') : ?>
    <?php include 'siswa/profil.php'; ?>	
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
