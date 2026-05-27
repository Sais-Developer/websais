
<div class="app-menu">
  <ul class="accordion-menu">
  <li class="sidebar-title">E GRADUATION</li>
    <li><a href="."><i class="material-icons-two-tone">home</i>Beranda</a></li>
	<?php if($user['level']=='admin'): ?>
	<li>
	<a href="#"><i class="material-icons-two-tone">webhook</i>Master SKL<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">
		<li><a href="?pg=<?= enkripsi('skl') ?>">Setting SKL</a></li>
		<li><a href="?pg=<?= enkripsi('skb') ?>">Setting SKKB</a></li>
		</ul>
	  </li>
    <?php endif; ?>
	<?php 
	$sql = "SELECT k.kelas
			FROM skl s
			LEFT JOIN m_kelas k ON k.level = s.tingkat
			WHERE k.kelas = ?";

	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user['walas']]);
	$wali = $stmt->fetch(PDO::FETCH_ASSOC);
	?>
	<?php if ($user['level']=='admin' OR $user['walas'] == $wali['kelas']): ?>
	 <li>
	<a href="#"><i class="material-icons-two-tone">select_all</i>Nilai<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">					
		<li><a href="?pg=<?= enkripsi('nilai') ?>">Nilai Semester</a></li>
		<li><a href="?pg=<?= enkripsi('ujian') ?>">Nilai Ujian</a></li>									
		</ul>
	   </li>
	<li>
	<a href="#"><i class="material-icons-two-tone">print</i>Cetak Data<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
		<ul class="sub-menu">					
		<li><a href="?pg=<?= enkripsi('update') ?>">Update Siswa</a></li>
		<li><a href="?pg=<?= enkripsi('cskl') ?>">SKL & SKKB</a></li>	
		<li><a href="?pg=<?= enkripsi('ctrp') ?>">Transkip</a></li>	
		
		</ul>
	 </li>
	 <?php endif; ?> 
 <?php if($level=='users'): ?>
 <li class="sidebar-title">DATABASE</li>
    <li>
      <a href="#" class="toggle-menu"><i class="material-icons-two-tone">storage</i>Database<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
      <ul class="sub-menu">
     <li><a href="?pg=<?= enkripsi('resetdata') ?>">Reset E Graduation</a></li>
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
  <br><br>
</div>
