<div class="app-menu">
  <ul class="accordion-menu">
  <li class="sidebar-title">ASESSMEN</li>
	<li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin'): ?>
	<li><a href="?pg=<?= enkripsi('info') ?>"><i class="material-icons-two-tone">campaign</i>Informasi</a></li>
	<li><a href="?pg=<?= enkripsi('upsiswa') ?>"><i class="material-icons-two-tone">upload</i>Update Siswa</a></li>
	<li><a href="?pg=<?= enkripsi('jenis') ?>"><i class="material-icons-two-tone">select_all</i>Jenis Asesmen</a></li>
	<?php endif; ?>
  	<li><a href="?pg=<?= enkripsi('banksoal') ?>"><i class="material-icons-two-tone">wallet</i>Bank Soal</a></li>
    <li><a href="?pg=<?= enkripsi('jadwaluji') ?>"><i class="material-icons-two-tone">computer</i>Jadwal Asesmen</a></li>
 
  <li>
<a href="#"><i class="material-icons-two-tone">edit</i>Nilai Asesmen<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
  <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('nilai') ?>">Nilai Mapel</a></li>
    <li><a href="?pg=<?= enkripsi('rekap') ?>">Nilai Rekap</a></li>
	<li><a href="?pg=<?= enkripsi('anbuso') ?>">Analisis Butir Soal</a></li> 
    </ul>
  </li>	
  <li>
    <a href="#"><i class="material-icons-two-tone">restart_alt</i>Katrol Nilai<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('katrol') ?>">Katrol Nilai</a></li>
	<li><a href="?pg=<?= enkripsi('ckatrol') ?>">Cetak Nilai Katrol</a></li>									
	</ul>
  </li>
  <?php if($user['level']=='admin'): ?>
<li>
<a href="#" class="toggle-menu"><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('kartu') ?>">Kartu Peserta</a></li>
    <li> <a href="?pg=<?= enkripsi('absen') ?>">Daftar Hadir</a></li>
    <li> <a href="?pg=<?= enkripsi('berita') ?>">Berita Acara</a></li> 					
    </ul>
 </li>
 <li class="sidebar-title">DATABASE</li>
    <li><a href="?pg=<?= enkripsi('resetdata') ?>"><i class="material-icons-two-tone">storage</i>Reset Asessmen</a></li>
	<?php endif; ?>
	
	<li class="sidebar-title">APP DASHBOARD</li>
	<li class="active-page"><a href="<?= $baseurl; ?>/myaps"><i class="material-icons-two-tone">apps</i>Dasboard</a></li>
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
</div>
