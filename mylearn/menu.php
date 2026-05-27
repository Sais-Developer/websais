<div class="app-menu">
	<ul class="accordion-menu">
	<li class="sidebar-title">E - LEARNING</li>
	<li class="active-page"><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin' || $user['level']=='guru'): ?>
	<li><a href="?pg=<?= enkripsi('materi') ?>"><i class="material-icons-two-tone">menu_book</i>Materi Belajar</a></li>
	<li><a href="?pg=<?= enkripsi('tugas') ?>"><i class="material-icons-two-tone">edit_calendar</i>Tugas Belajar</a></li>
	<li><a href="?pg=<?= enkripsi('absen') ?>"><i class="material-icons-two-tone">print</i>Presensi Daring</a></li>
	<?php endif; ?>
	 <?php if($user['level']=='admin'): ?> 
		<li class="sidebar-title">DATABASE</li>
    <li><a href="?pg=<?= enkripsi('resetdata') ?>"><i class="material-icons-two-tone">storage</i>Reset Elearning</a></li>
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