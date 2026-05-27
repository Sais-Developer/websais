<?php
$pg = $_GET['pg'] ?? '';
$page = $pg ? dekripsi($pg) : ''; 


if ($page === '') : ?>
<!-- ---------------------------------------------------------
     KBM
--------------------------------------------------------- -->
   <?php include 'home.php'; ?>
<?php elseif ($page == 'jadwalkbm') : ?>
   <?php include 'jadwal.php'; ?>	
<?php elseif ($page == 'lingkup') : ?>
    <?php include 'adm/lingkup.php'; ?>
<?php elseif ($pg == enkripsi('cpel')) : ?>
    <?php include 'adm/cpel.php'; ?>
<?php elseif ($pg == enkripsi('atp')) : ?>
    <?php include 'adm/atp.php'; ?>	
<?php elseif ($pg == enkripsi('konten')) : ?>
    <?php include 'adm/konten.php'; ?>	
<?php elseif ($pg == enkripsi('nilph')) : ?>
    <?php include 'nilph.php'; ?>		
<?php elseif ($pg == enkripsi('modul1')) : ?>
    <?php include 'adm/modul1.php'; ?>		
<?php elseif ($pg == enkripsi('modul2')) : ?>
    <?php include 'adm/modul2.php'; ?>			
<?php elseif ($pg == enkripsi('modul3')) : ?>
    <?php include 'adm/modul3.php'; ?>	
<?php elseif ($pg == enkripsi('crpp')) : ?>
   <?php include 'adm/crpp.php'; ?>
<?php elseif ($pg == enkripsi('cprota')) : ?>
    <?php include 'adm/cprota.php'; ?>	
<?php elseif ($pg == enkripsi('cpromes')) : ?>
    <?php include 'adm/cpromes.php'; ?>
<?php elseif ($pg == enkripsi('cnilai')) : ?>
    <?php include 'cnilai.php'; ?>		
<?php elseif ($pg == enkripsi('agenda')) : ?>
    <?php include 'agenda.php'; ?>	
<?php elseif ($pg == enkripsi('cagenda')) : ?>
     <?php include 'cetak.php'; ?>
<?php elseif ($pg == enkripsi('jurnal')) : ?>
    <?php include 'jurnal.php'; ?>	
<?php elseif ($pg == enkripsi('cnil')) : ?>
    <?php include 'cnilai.php'; ?>		
<?php elseif ($pg == enkripsi('ctkjurnal')) : ?>
    <?php include 'ctkjurnal.php'; ?>	
<?php elseif ($pg == enkripsi('ctkagenda')) : ?>
    <?php include 'ctkagenda.php'; ?>		
<?php elseif ($pg == enkripsi('resetkbm')) : ?>
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
