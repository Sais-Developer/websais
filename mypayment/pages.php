<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
    <?php include 'home.php'; ?>
<?php elseif ($pg == enkripsi('jenis')): ?>
    <?php include 'master/jenis.php'; ?>	
<?php elseif ($pg == enkripsi('transaksi')) : ?>
    <?php include 'manual/transaksi.php'; ?>	
<?php elseif ($pg == enkripsi('trxpeg')) : ?>
    <?php include 'cetak/trxpeg.php'; ?>
<?php elseif ($pg == enkripsi('jenislain')) : ?>
    <?php include 'lainnya/gaji.php'; ?>
<?php elseif ($pg == enkripsi('trxsiswa')) : ?>
    <?php include 'cetak/trxsiswa.php'; ?>
<?php elseif ($pg == enkripsi('resetdata')) : ?>
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
