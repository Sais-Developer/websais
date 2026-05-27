<div class="app-menu">
  <ul class="accordion-menu">
  <li class="sidebar-title">PRESENSI DIGITAL</li>
	<li class="active-page"><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin'): ?>
	<li>
	<a href="#"><i class="material-icons-two-tone">settings</i>Setting Presensi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('mesin') ?>">Mesin Presensi</a></li>
    <li><a href="?pg=<?= enkripsi('waktu') ?>">Waktu Presensi</a></li>
	<li><a href="?pg=<?= enkripsi('jjm') ?>">Jumlah Jam Mengajar</a></li> 
    </ul>
  </li>	
  <li>
<a href="#"><i class="material-icons-two-tone">message</i>Setting Notifikasi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('notifsis') ?>">Siswa</a></li>
    <li><a href="?pg=<?= enkripsi('notifpeg') ?>">Pegawai</a></li>
	<li><a href="?pg=<?= enkripsi('sisnotif') ?>">Eskul Siswa</a></li> 
	<li><a href="?pg=<?= enkripsi('pegnotif') ?>">Eskul Pembina</a></li> 
    </ul>
  </li>	
  <li>
    <a href="#"><i class="material-icons-two-tone">restart_alt</i>Registrasi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<?php if($setting['mesin']=='1' OR $setting['mesin']=='2'): ?>
	<li><a href="?pg=<?= enkripsi('regsis') ?>">RFID Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('regpeg') ?>">RFID Pegawai</a></li>
     <?php endif; ?>
	 <?php if($setting['mesin']=='3'): ?>
	<li><a href="?pg=<?= enkripsi('barsis') ?>">QR Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('barpeg') ?>">QR Pegawai</a></li>
     <?php endif; ?>
	 <?php if($setting['mesin']=='4'): ?>
	<li><a href="?pg=<?= enkripsi('fsis') ?>">Finger Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('fpeg') ?>">Finger Pegawai</a></li>
     <?php endif; ?>	
    <?php if($setting['mesin']=='5'): ?>
	<li><a href="?pg=<?= enkripsi('rfsis') ?>">Face Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('rfpeg') ?>">Face Pegawai</a></li>
     <?php endif; ?>		 
	</ul>
  </li>
  <?php if($setting['mesin'] == 2): ?>
   <li><a href="https://luvvoice.com/#google_vignette" target="_blank"><i class="material-icons-two-tone">volume_up</i>Nada Presensi</a></li>
  <?php endif; ?>
  <?php endif; ?>
  <li>
<a href="#"><i class="material-icons-two-tone">co_present</i>Manual Presensi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('absiswa') ?>">Siswa</a></li>
	<?php if($user['level']=='admin'): ?>
    <li><a href="?pg=<?= enkripsi('abpeg') ?>">Pegawai</a></li>
   <?php endif; ?>	
    </ul>
  </li>	
  <li>
<a href="#"><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
 
	<li><a href="?pg=<?= enkripsi('presis') ?>">Harian Siswa</a></li>
	<?php if($user['level']=='admin'): ?>
	<li><a href="?pg=<?= enkripsi('prespeg') ?>">Harian Pegawai</a></li>
	<li><a href="?pg=<?= enkripsi('cetakpresensi') ?>">Rekap Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('cetakpresensi') ?>&ac=<?= enkripsi('pegawai') ?>">Rekap Pegawai</a></li>
	<li><a href="?pg=<?= enkripsi('cetakpresensi') ?>&ac=<?= enkripsi('eskul') ?>">Rekap Eskul</a></li>
	<li><a href="?pg=<?= enkripsi('cetakpresensi') ?>&ac=<?= enkripsi('pembina') ?>">Rekap Pembina</a></li>	
	<?php endif; ?>
    </ul>
  </li>	
  <?php if($user['level']=='admin'): ?>
 <li class="sidebar-title">DATABASE</li>
    <li>
<a href="#"><i class="material-icons-two-tone">folder_delete</i>Hapus Bulan<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('hapres') ?>">Hapus Presensi</a></li>
    </ul>
  </li>	
    <li><a href="?pg=<?= enkripsi('resetdata') ?>"><i class="material-icons-two-tone">storage</i>Reset Presensi</a></li>
  <?php endif; ?>
  
  <li class="sidebar-title">APP DASHBOARD</li>
   <li><a href="<?= $baseurl; ?>/myaps"><i class="material-icons-two-tone">apps</i>Dashboard</a></li>
<!-- <li><a href="<?= $baseurl ?>/mypres"><i class="material-icons-two-tone">select_all</i>E - Presensi</a></li> -->
		<li><a href="<?= $baseurl ?>/mycbt"><i class="material-icons-two-tone">wifi</i>E - Asesmen</a></li>
		<li><a href="<?= $baseurl ?>/mykbm"><i class="material-icons-two-tone">auto_stories</i>E - K B M</a></li>
		<li><a href="<?= $baseurl ?>/myrapor"><i class="material-icons-two-tone">rate_review</i>E - Rapor</a></li>
		<li><a href="<?= $baseurl ?>/myskl"><i class="material-icons-two-tone">school</i>E - Graduation</a></li>
		<li><a href="<?= $baseurl ?>/mylearn"><i class="material-icons-two-tone">library_books</i>E - Learning</a></li>
		<li><a href="<?= $baseurl ?>/mykonsel"><i class="material-icons-two-tone">laptop</i>E - Konseling</a></li>
		<?php if($setting['jenjang']=='SMK'): ?>
		<li><a href="<?= $baseurl ?>/mypkl"><i class="material-icons-two-tone">extension</i>E - Prakerin</a></li>
		<?php endif; ?>
  </ul>
  <br>
</div>
