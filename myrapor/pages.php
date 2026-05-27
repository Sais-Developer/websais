<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
<!-- ---------------------------------------------------------
     RAPOR
--------------------------------------------------------- -->
   <?php include 'home.php'; ?>
<?php elseif ($page == 'update') : ?>
   <?php include 'update.php'; ?>	
<?php elseif ($page == 'mapel') : ?>
   <?php include 'mapel.php'; ?>	
<?php elseif ($page == 'tanggal') : ?>
   <?php include 'tanggal.php'; ?>
<?php elseif ($page == 'pts') : ?>
   <?php include 'nilai/pts.php'; ?> 
<?php elseif ($page == 'pas') : ?>
   <?php include 'nilai/pas.php'; ?>  
<?php elseif ($page == 'pat') : ?>
   <?php include 'nilai/pat.php'; ?>     
<?php elseif ($page == 'kokupts') : ?>
   <?php include 'nilai/kokupts.php'; ?>
<?php elseif ($page == 'ekstra') : ?>
   <?php include 'walas/ekstra.php'; ?>
<?php elseif ($page == 'absensi') : ?>
   <?php include 'walas/absensi.php'; ?>
<?php elseif ($page == 'catatan') : ?>
   <?php include 'walas/catatan.php'; ?>
<?php elseif ($page == 'cetakpts') : ?>
   <?php include 'cetak/pts.php'; ?>
<?php elseif ($page == 'cetakpas') : ?>
   <?php include 'cetak/pas.php'; ?>
<?php elseif ($page == 'cetakpat') : ?>
   <?php include 'cetak/pat.php'; ?>
 <?php elseif ($page == 'cetakdna') : ?>
   <?php include 'cetak/cdna.php'; ?>
 <?php elseif ($page == 'resetdata') : ?>
   <?php include 'resetdata.php'; ?> 
   
   
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
