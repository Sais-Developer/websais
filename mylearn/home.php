<div class="row">
   <div class="col-xl-8">
		<div class="card widget widget-action-list">
			<div class="card-body">
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<!-- <li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypres">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">select_all</i>
								</span>
								<span class="widget-action-list-item-title">
									Presensi
								</span>
							</a>
						</li> -->
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mycbt">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">wifi</i>
								</span>
								<span class="widget-action-list-item-title">
									Asesmen
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykbm">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">auto_stories</i>
								</span>
								<span class="widget-action-list-item-title">
									K B M
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myrapor">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">rate_review</i>
								</span>
								<span class="widget-action-list-item-title">
									Rapor SP
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myskl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">school</i>
								</span>
								<span class="widget-action-list-item-title">
									Graduation
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mylearn">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">library_books</i>
								</span>
								<span class="widget-action-list-item-title">
									Elearn
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykonsel">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">laptop</i>
								</span>
								<span class="widget-action-list-item-title">
									Konseling
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypkl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">extension</i>
								</span>
								<span class="widget-action-list-item-title">
									Prakerin
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypayment">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">money</i>
								</span>
								<span class="widget-action-list-item-title">
									Payment
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myaps">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">apps</i>
								</span>
								<span class="widget-action-list-item-title">
									Dashboard
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	  <div class="col-xl-4">
        <div class="card widget widget-info">
			<div class="card-body">
				<div class="widget-info-container">
					<div class="widget-info-image" style="background: url('../images/<?= $setting['logo'] ?>')"></div>
					<h5 class="widget-info-title"><?= $setting['sekolah'] ?></h5>
					<p class="widget-info-text m-t-n-xs">
					<?= $setting['alamat'] ?> Desa <?= $setting['desa'] ?> Kec. <?= $setting['kecamatan'] ?>
					Kab. <?= $setting['kabupaten'] ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
defined('APK') or exit('No Access');
$materi = countRows($db,"materi");
$tugas = countRows($db,"tugas");
$jawaban = countRows($db,"jawaban_tugas");
$absen = countRows($db,"absen_daring");
?>
<div class="row">
 <div class="col-lg-8">
	  <div class="row">
			<div class="col-xl-6">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-primary">
								<i class="material-icons-outlined">school</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">MATERI BELAJAR</span>
								<span class="widget-stats-amount"><?= $materi; ?> </span>
							  
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-warning">
								<i class="material-icons-outlined">dataset</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">TUGAS BELAJAR</span>
								<span class="widget-stats-amount"><?= $tugas; ?></span>
							   
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-danger">
								<i class="material-icons-outlined">apps</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">NILAI TUGAS</span>
								<span class="widget-stats-amount"><?= $jawaban ?> </span>
							  
							</div>
						   
						</div>
					</div>
				</div>
			</div>
			 <div class="col-xl-6">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-success">
								<i class="material-icons-outlined">alarm</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">PRESENSI DARING</span>
								<span class="widget-stats-amount"><?= $absen ?> </span>
							  
							</div>
						   
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="col-xl-4">
   <div class="card widget widget-list">
        <div class="card-header">
           <h5 class="card-title">Users Online</h5>
		</div>
	<div class="card-body" style="height:420px">
	 <ul class="widget-list-content list-unstyled">
		<?php
		$stmt = $pdo->prepare("
			SELECT * FROM absen_daring a
			JOIN siswa s ON s.id_siswa = a.idsiswa
			ORDER BY a.id DESC
			LIMIT 5
		");
		$stmt->execute();
		$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($logs)):
			foreach ($logs as $log):
		?>
         <li class="widget-list-item widget-list-item-purple">
			<span class="widget-list-item-avatar">
				<div class="avatar avatar-rounded">
					<img src="../images/user.png" alt="">
				</div>
			</span>
			<span class="widget-list-item-description">
				<a href="#" class="widget-list-item-description-title">
					<?= ucwords(strtolower($log['nama'])) ?>
				</a>
				<span class="widget-list-item-description-subtitle">
					<?= date('d M Y', strtotime($log['tanggal'])) ?> <?= htmlspecialchars($log['jam']) ?>
				</span>
			</span>
		</li>
		<?php
			endforeach;
		else:
		?>
		<strong>Belum ada Aktifitas</strong> saat ini.
		
<?php endif; ?>
	 </div>
 </div>