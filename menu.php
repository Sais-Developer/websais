<div class="app-menu">
  <ul class="accordion-menu">
  <li class="sidebar-title">MY DASHBOARD</li>
	<li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<li><a href="?pg=<?= enkripsi('kebiasaan') ?>"><i class="material-icons-two-tone">auto_stories</i>7 Kebiasaan</a></li>
	<li><a href="?pg=<?= enkripsi('ujian') ?>"><i class="material-icons-two-tone">alarm</i>Asesmen</a></li>
  <li>
	<a href=""><i class="material-icons-two-tone">select_all</i>Data Nilai<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
	<ul class="sub-menu">
		<li><a href="?pg=<?= enkripsi('nilai') ?>">Nilai Asesmen</a></li>
	</ul>
</li>
<li>
	<a href=""><i class="material-icons-two-tone">wifi</i>E Learning<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
	<ul class="sub-menu">
		<li><a href="?pg=<?= enkripsi('materi') ?>">Materi Belajar</a></li>
		<li><a href="?pg=<?= enkripsi('tugas') ?>">Tugas Belajar</a></li>
		<li><a href="?pg=<?= enkripsi('nilaitugas') ?>">Nilai Tugas</a></li>
	</ul>
</li>
<li><a href="?pg=<?= enkripsi('skl') ?>"><i class="material-icons-two-tone">school</i>Info Kelulusan</a></li>
<?php
$ada = false;
$sql = "SELECT COUNT(*) AS jumlah FROM pkl_siswa WHERE idsiswa = :id_siswa";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_siswa' => $id_siswa]);
$jumlah = (int) $stmt->fetch(PDO::FETCH_ASSOC)['jumlah'];

if ($jumlah > 0) {
    $ada = true;
}
?>
<?php if ($ada): ?>
<li><a href="?pg=<?= enkripsi('prakerin') ?>"><i class="material-icons-two-tone">extension</i>Prakerin</a></li>
<?php endif; ?>
		
		
		
		
	<li><a href="logout.php"><i class="material-icons-two-tone">logout</i>Logout</a></li>
  </ul>
</div>
