<div class="app-menu">
	<ul class="accordion-menu">
	<li class="sidebar-title">BELAJAR MENGAJAR</li>
	<li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin'): ?>
	<li><a href="?pg=<?= enkripsi('jadwalkbm') ?>"><i class="material-icons-two-tone">alarm</i>Jadwal Mengajar</a></li>
		<?php endif; ?>
		<?php if($user['level']=='admin' || $user['level']=='guru'): ?>
	<li>
		<a href=""><i class="material-icons-two-tone">menu_book</i>Administrasi Guru<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
		<ul class="sub-menu">
			<li><a href="?pg=<?= enkripsi('lingkup') ?>">Lingkup Materi</a></li>
			<li><a href="?pg=<?= enkripsi('atp') ?>">Alokasi Waktu</a></li>
			<li><a href="?pg=<?= enkripsi('konten') ?>">Input Konten</a></li>
		</ul>
	</li>
	<li>
		<a href=""><i class="material-icons-two-tone">edit_calendar</i>Agenda dan Jurnal<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
		<ul class="sub-menu">
			<li><a href="?pg=<?= enkripsi('agenda') ?>">Agenda Harian</a></li>
			<li><a href="?pg=<?= enkripsi('jurnal') ?>">Jurnal Harian</a></li>
		</ul>
	</li>
	<li><a href="?pg=<?= enkripsi('nilph') ?>"><i class="material-icons-two-tone">edit</i>Penilaian Harian</a></li>
	<li>
			<a href=""><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
			<ul class="sub-menu">
				<li><a href="?pg=<?= enkripsi('modul1') ?>">Modul Ajar 1</a></li>
				<li><a href="?pg=<?= enkripsi('modul2') ?>">Modul Ajar 2</a></li>
                <li><a href="?pg=<?= enkripsi('modul3') ?>">Modul Ajar 3</a></li>
				<li><a href="?pg=<?= enkripsi('crpp') ?>">R P P</a></li>
				<li><a href="?pg=<?= enkripsi('cpromes') ?>">Program Semester</a></li>
				<li><a href="?pg=<?= enkripsi('cprota') ?>">Program Tahunan</a></li>
				<li><a href="?pg=<?= enkripsi('cnil') ?>">Penilaian Harian</a></li>
				<li><a href="?pg=<?= enkripsi('ctkagenda') ?>">Agenda Guru</a></li>
				<li><a href="?pg=<?= enkripsi('ctkjurnal') ?>">Jurnal Guru</a></li>
			</ul>
		</li>	
		<?php endif; ?>
		<?php if($user['level']=='admin'): ?>
		<li class="sidebar-title">DATABASE</li>
    <li><a href="?pg=<?= enkripsi('resetkbm') ?>"><i class="material-icons-two-tone">storage</i>Reset K B M</a></li>
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