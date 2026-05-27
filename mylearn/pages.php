<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 

if ($page === '') : ?>
<!-- ---------------------------------------------------------
     ELEARNING
--------------------------------------------------------- -->
   <?php include 'home.php'; ?>
<?php elseif ($pg == enkripsi('materi')): ?>
    <?php include 'materi.php'; ?>	
<?php elseif ($pg == enkripsi('inputmateri')): ?>
   <?php include 'inputmateri.php'; ?>	
<?php elseif ($pg == enkripsi('tugas')): ?>
    <?php include 'tugas.php'; ?>	
<?php elseif ($pg == enkripsi('inputtugas')): ?>
   <?php include 'inputtugas.php'; ?>	
<?php elseif ($pg == enkripsi('absen')): ?>
   <?php include 'abdaring.php'; ?>
<?php elseif ($pg == enkripsi('resetdata')): ?>
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
