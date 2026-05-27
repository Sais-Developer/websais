<?php
defined('APK') or exit('No access');
function hitungLevel($pdo, $level) {
    $sql = "SELECT COUNT(*) AS total FROM datareg WHERE level = :level";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['level' => $level]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
$siswa = hitungLevel($pdo, 'siswa');
$pegawai = hitungLevel($pdo, 'pegawai');

$mode = $pdo->query("SELECT mode FROM status")->fetchColumn();

$status = [
    1 => "masuk",
    2 => "pulang",
    3 => "eskul",
    4 => "pulang eskul pdp"
][$mode] ?? "tidak diketahui";

?>
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
<div class="row">
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">school</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Registrasi Siswa</span>
						<span class="widget-stats-amount"><?= $siswa ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-warning">
						<i class="material-icons-outlined">person</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Registrasi Pegawai</span>
						<span class="widget-stats-amount"><?= $pegawai ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-success">
						<i class="material-icons-outlined">alarm</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title"><?= $status ?></span>
						<span class="widget-stats-amount" id="jam"></span>
						
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	  <div class="col-xl-4">
       <div id="logsis"></div>
	</div>
	<div class="col-xl-4">
       <div id="logdata" style="height:480px"></div>
	</div>
	<div class="col-xl-4">
        <div id="kehadiran" style="height:480px"></div>
	</div>
</div>




<script>
setInterval(function() {
    $('#jam').load('jam.php');
    $('#kehadiran').load('log_kehadiran.php');
	$('#logsis').load('log_siswa.php');
	$('#logdata').load('log_data.php');
}, 1000);
</script>
