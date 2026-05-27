<div class="app-menu">
  <ul class="accordion-menu">
    <li>
      <a href="."><i class="material-icons-two-tone">home</i>Beranda</a>
    </li>
	 <li>
      <a href="<?= $baseurl; ?>/myaps"><i class="material-icons-two-tone">apps</i>Dashboard</a>
    </li>
<?php if($user['level']=='admin'): ?>
  <li>
    <a href="#"><i class="material-icons-two-tone">settings</i>Master Konseling<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('kategori') ?>">Kategori Pelanggaran</a></li>
	<li><a href="?pg=<?= enkripsi('jenis') ?>">Jenis Pelanggaran</a></li>
	<li><a href="?pg=<?= enkripsi('teguran') ?>">Poin Teguran</a></li>
    </ul>
  </li>
   <?php endif; ?> 
  <li>					
<a href="#"><i class="material-icons-two-tone">select_all</i>Input Pelanggaran<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('pelanggaran') ?>">Pelanggaran</a></li>
   </ul>
 </li>	 
 <?php if($user['level']=='admin' OR $user['walas'] !='Bukan Walas'): ?>
 <li>					
<a href="#"><i class="material-icons-two-tone">person</i>Input Pembinaan<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('konseling') ?>">Pembinaan</a></li>
   </ul>
 </li>	
 <?php endif; ?> 
 <?php if($user['level']=='admin'): ?>
 <li class="sidebar-title">DATABASE</li>
    <li>
      <a href="#" class="toggle-menu"><i class="material-icons-two-tone">storage</i>Database<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
      <ul class="sub-menu">
     <li><a href="?pg=<?= enkripsi('resetdata') ?>">Reset Konseling</a></li>
      </ul>
    </li>
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
		
  </ul>
  
</div>
