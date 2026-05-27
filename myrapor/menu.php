<div class="app-menu">
	<ul class="accordion-menu">
	<li class="sidebar-title">RAPOR SP</li>
	
	<li class="active-page"><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin'): ?>
	<li><a href="?pg=<?= enkripsi('update') ?>"><i class="material-icons-two-tone">upload</i>Update Siswa</a></li>
	<li>
		<a href=""><i class="material-icons-two-tone">settings</i>Setting Rapor<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
		<ul class="sub-menu">
			<li><a href="?pg=<?= enkripsi('mapel') ?>">Mapel Rapor</a></li>
			<li><a href="?pg=<?= enkripsi('tanggal') ?>">Tanggal Rapor</a></li>
		</ul>
	</li>
	<?php endif; ?>
	<li class="sidebar-title">RAPOR P T S</li>
	<li><a href="?pg=<?= enkripsi('pts') ?>"><i class="material-icons-two-tone">assignment</i>Nilai PH (Sumatif) + PTS</a></li>
	<?php if($setting['semester']==1): ?>
	<li class="sidebar-title">RAPOR P A S</li>
	<?php else : ?>
	<li class="sidebar-title">RAPOR P A T</li>
	<?php endif; ?>
	<li>
		<a href=""><i class="material-icons-two-tone">edit_calendar</i>Input Nilai<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
		<ul class="sub-menu">
			<?php if($setting['semester']==1): ?>
			<li><a href="?pg=<?= enkripsi('pas') ?>">PH (Sumatif) + PAS</a></li>
			<?php else: ?>
			<li><a href="?pg=<?= enkripsi('pat') ?>">PH (Sumatif) + PAT</a></li>
			<?php endif; ?>
		</ul>
	</li>	
	<li class="sidebar-title">WALI KELAS</li>
	<li>
	<a href="#" class="toggle-menu"><i class="material-icons-two-tone">tab</i>Wali Kelas<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">
		<li><a href="?pg=<?= enkripsi('kokupts') ?>">Kokurikuler</a></li>
	   <li><a href="?pg=<?= enkripsi('ekstra') ?>">Ekstrakokurikuler</a></li>
		<li><a href="?pg=<?= enkripsi('absensi') ?>">Presensi Siswa</a></li>
	   <li><a href="?pg=<?= enkripsi('catatan') ?>">Catatan Wali Kelas</a></li>
		</ul>
   </li>
	<li>
	<a href="#" class="toggle-menu"><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">
		<li><a href="?pg=<?= enkripsi('cetakpts') ?>">Cetak Rapor PTS</a></li>
	   <?php if($setting['semester']==1): ?>
	   <li><a href="?pg=<?= enkripsi('cetakpas') ?>">Cetak Rapor PAS</a></li>
	   <?php else: ?>
		<li><a href="?pg=<?= enkripsi('cetakpat') ?>">Cetak Rapor PAT</a></li>
	   <?php endif; ?>
	   <li><a href="?pg=<?= enkripsi('cetakdna') ?>">Cetak DNA</a></li>
		</ul>
   </li>
	<?php if($user['level']=='admin'): ?>
		<li class="sidebar-title">DATABASE</li>
    <li><a href="?pg=<?= enkripsi('resetdata') ?>"><i class="material-icons-two-tone">storage</i>Reset Rapor</a></li>
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