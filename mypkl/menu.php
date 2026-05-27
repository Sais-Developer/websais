<div class="app-menu">

  <ul class="accordion-menu">
  <li class="sidebar-title">PRAKERIN</li>
    <li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	 <?php if($level=='users'): ?>
    <li><a href="?pg=<?= enkripsi('dudi') ?>"><i class="material-icons-two-tone">select_all</i> Data Dudi</a></li>
	<li>
	<a href="#"><i class="material-icons-two-tone">people</i>Peserta Prakerin<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">					
		<li><a href="?pg=<?= enkripsi('pembina') ?>">Input Peserta</a></li>
		<li><a href="?pg=<?= enkripsi('peserta') ?>">Data Peserta</a></li>
			
	</ul>
 </li>
  
 <li><a href="?pg=<?= enkripsi('kompetensi') ?>"><i class="material-icons-two-tone">school</i> Kompetensi Prakerin</a></li>
	<?php endif; ?>
   
  <li>
	<a href="#"><i class="material-icons-two-tone">print</i>Cetak Administrasi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">					
		 <li><a href="?pg=<?= enkripsi('presensi') ?>" >Presensi Prakerin</a></li>
		<li><a href="?pg=<?= enkripsi('jurnal') ?>" >Jurnal Prakerin</a></li>
		<li><a href="?pg=<?= enkripsi('sertifikat') ?>" >Sertifikat Prakerin</a></li>	
	</ul>
 </li>
 <li>
<a href="#"><i class="material-icons-two-tone">edit</i>Penilaian Prakerin<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	 <?php if($level=='users'): ?>
	<li><a href="?pg=<?= enkripsi('aspek') ?>" >Aspek Penilaian</a></li>
    <?php endif; ?>	
	 <li><a href="?pg=<?= enkripsi('inputnilai') ?>" >Input Nilai Prakerin</a></li>		
     <li><a href="?pg=<?= enkripsi('cetakhasil') ?>" >Cetak Nilai</a></li>	 
		</ul>
   </li>	
	

 <?php if($level=='users'): ?>
 <li class="sidebar-title">DATABASE</li>
    <li>
      <a href="#" class="toggle-menu"><i class="material-icons-two-tone">storage</i>Database<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
      <ul class="sub-menu">
     <li><a href="?pg=<?= enkripsi('resetdata') ?>">Reset E Prakerin</a></li>
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
		<?php if($setting['jenjang']=='SMK'): ?>
		<li><a href="<?= $baseurl ?>/mypkl"><i class="material-icons-two-tone">extension</i>E - Prakerin</a></li>
		<?php endif; ?>
  </ul>
  
</div>
