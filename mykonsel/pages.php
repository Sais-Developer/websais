<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
    <?php include 'home.php'; ?>
<?php elseif ($pg == enkripsi('kategori')): ?>
    <?php include 'master/kategori.php'; ?>	
<?php elseif ($pg == enkripsi('jenis')) : ?>
    <?php include 'master/jenis.php'; ?>	
<?php elseif ($pg == enkripsi('teguran')) : ?>
    <?php include 'master/teguran.php'; ?>
<?php elseif ($pg == enkripsi('pelanggaran')) : ?>
    <?php include 'langgar/pelanggaran.php'; ?>
<?php elseif ($pg == enkripsi('konseling')) : ?>
    <?php include 'langgar/konsel.php'; ?>
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
