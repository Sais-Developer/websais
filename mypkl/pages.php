<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
    <?php include 'home.php'; ?>
<?php elseif ($pg == enkripsi('dudi')): ?>
    <?php include 'dudi/dudi.php'; ?>	
<?php elseif ($pg == enkripsi('pembina')): ?>
    <?php include 'pkl/input.php'; ?>
<?php elseif ($pg == enkripsi('peserta')): ?>
    <?php include 'pkl/siswa.php'; ?>
<?php elseif ($pg == enkripsi('kompetensi')): ?>
    <?php include 'pkl/kompetensi.php'; ?>	
<?php elseif ($pg == enkripsi('sikap')) : ?>
    <?php include 'siswa/nilai.php'; ?>
<?php elseif ($pg == enkripsi('inputnilai')) : ?>
    <?php include 'siswa/nilaipkl.php'; ?>
<?php elseif ($pg == enkripsi('presensi')) : ?>
    <?php include 'siswa/absensi.php'; ?>	
<?php elseif ($pg == enkripsi('jurnal')) : ?>
    <?php include 'siswa/jurnal.php'; ?>	
<?php elseif ($pg == enkripsi('aspek')) : ?>
    <?php include 'siswa/aspek.php'; ?>	
<?php elseif ($pg == enkripsi('lokasi')) : ?>
    <?php include 'lokasi.php'; ?>	
<?php elseif ($pg == enkripsi('cetakhasil')) : ?>
    <?php include 'siswa/hasil.php'; ?>		
<?php elseif ($pg == enkripsi('resetpres')) : ?>
    <?php include 'pengaturan/resetdata.php'; ?>
<?php elseif ($pg == enkripsi('sertifikat')) : ?>
    <?php include 'siswa/sertifikat.php'; ?>		
<?php elseif ($pg == enkripsi('resetdata')): ?>
    <?php include 'reset/resetdata.php'; ?>	
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
