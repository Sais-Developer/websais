<div class="app-menu">
  <ul class="accordion-menu">
    <li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin' OR $user['level']=='staff'): ?>
    <li class="sidebar-title">PAYMENT SISWA</li>
	<li><a href="?pg=<?= enkripsi('jenis') ?>"><i class="material-icons-two-tone">settings</i>Jenis Pembayaran</a></li>
  <li>					
<a href="#"><i class="material-icons-two-tone">shopping_cart</i>Transaksi<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('transaksi') ?>">Input Pembayaran</a></li>
   </ul>
 </li>	 
 
<li>
<a href="#"><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('trxsiswa') ?>">Transaksi Pembayaran</a></li>
       </ul>
      </li>
<?php endif; ?>
<?php if($user['level']=='admin'): ?>
  <li class="sidebar-title">PAYMENT PEGAWAI</li>
  <li>
    <a href="#"><i class="material-icons-two-tone">settings</i>Payment Lainnya<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('jenislain') ?>">Pengaturan Lainnya</a></li>
    </ul>
  </li>
<li>
<a href="#"><i class="material-icons-two-tone">print</i>Cetak Payment Pegawai<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
    <ul class="sub-menu">
	<li><a href="?pg=<?= enkripsi('trxpeg') ?>">Transaksi Pembayaran</a></li>
       </ul>
      </li>
 <li class="sidebar-title">DATABASE</li>
    <li>
      <a href="#" class="toggle-menu"><i class="material-icons-two-tone">storage</i>Database<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
      <ul class="sub-menu">
     <li><a href="?pg=<?= enkripsi('resetdata') ?>">Reset Payment</a></li>
      </ul>
    </li>	  
<?php endif; ?>
   <li class="sidebar-title">APP DASHBOARD</li>
	    <li class="active-page"><a href="<?= $baseurl; ?>/myaps"><i class="material-icons-two-tone">apps</i>Dashboard</a></li>
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
