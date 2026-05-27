<div class="app-menu">
	<ul class="accordion-menu">
	<li class="sidebar-title">APP MASTER</li>
		<li class="active-page"><a href="." class="active"><i class="material-icons-two-tone">home</i>Home</a></li>
		<?php if($user['level']=='admin'): ?>
		<li>
			<a href=""><i class="material-icons-two-tone">widgets</i>Data Master<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
			<ul class="sub-menu">
				<li><a href="?pg=<?= enkripsi('imporsis') ?>">Peserta Didik</a></li>
				<li><a href="?pg=<?= enkripsi('imporpel') ?>">Mata Pelajaran</a></li>
                <li><a href="?pg=<?= enkripsi('imporpeg') ?>">Data Pendidik</a></li>
				<li><a href="?pg=<?= enkripsi('staff') ?>">Data Kependidikan</a></li>
				<li><a href="?pg=<?= enkripsi('admin') ?>">Data Administrator</a></li>
			    <?php if($setting['jenjang']=='SMK'): ?>
			    <li><a href="?pg=<?= enkripsi('jurusan') ?>">Data Jurusan</a></li>
				<?php endif; ?>
				<li><a href="?pg=<?= enkripsi('eskul') ?>">Ekstrakurikuler</a></li>
			</ul>
		</li>
		<li><a href="?pg=<?= enkripsi('bell') ?>"><i class="material-icons-two-tone">notifications</i>Setting Auto Bell</a></li>
		<?php endif; ?>
		<li><a href="?pg=<?= enkripsi('kebiasaan') ?>"><i class="material-icons-two-tone">face</i>Aprove Kebiasaan</a></li>	
		
		<?php if($user['level']=='admin'): ?>
		<li class="sidebar-title">MUTASI DAN PDB</li>
		<li>
			<a href=""><i class="material-icons-two-tone">sync</i>Mutasi Siswa<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
			<ul class="sub-menu">
				<li><a href="?pg=<?= enkripsi('naik') ?>">Naik Kelas</a></li>
				<li><a href="?pg=<?= enkripsi('tamat') ?>">Lulus Sekolah</a></li>
			</ul>
		</li>
		<li><a href="?pg=<?= enkripsi('pdb') ?>"><i class="material-icons-two-tone">menu</i>Peserta Didik Baru</a></li>
		<li class="sidebar-title">ALUMNI</li>
		<li>
			<a href=""><i class="material-icons-two-tone">block</i>Alumni<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
			<ul class="sub-menu">
				<li><a href="?pg=<?= enkripsi('alumni') ?>">Data Alumni</a></li>
				
			</ul>
		</li>
		<li class="sidebar-title">ADMINISTRATOR</li>
		<li><a href="?pg=<?= enkripsi('sekolah') ?>"><i class="material-icons-two-tone">settings</i>Setting Sekolah</a></li>
		<li><a href="?pg=<?= enkripsi('admin') ?>"><i class="material-icons-two-tone">person</i>Data Admin</a></li>
		
		<li class="sidebar-title">DATABASE</li>
		 <li>
		<a href="#" class="toggle-menu"><i class="material-icons-two-tone">storage</i>Database<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">
		 <li><a href="?pg=<?= enkripsi('resetdata') ?>">Reset Data Master</a></li>
		 <li><a href="?pg=<?= enkripsi('backup') ?>">Backup Database</a></li>
		 <li><a href="?pg=<?= enkripsi('restore') ?>">Restore Database</a></li>
      </ul>
    </li>
		<?php endif; ?>
		<li><a href="logout.php"><i class="material-icons-two-tone">logout</i>Logout</a></li>
	</ul>
</div>