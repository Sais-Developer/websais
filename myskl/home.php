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

$id_skl = 1;
$sql = "SELECT * FROM skl WHERE id_skl = :id_skl";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_skl' => $id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null; 
$waktumu = date('Y-m-d H:i:s');
?>

<style>
#clockdiv{
  font-family: sans-serif;
  color: #fff;
  display: inline-block;
  font-weight: 20;
  text-align: center;
  font-size: 20px;
}

#clockdiv > div{
  padding: 10px;
  border-radius: 3px;
  background: #00BF96;
  display: inline-block;
}

#clockdiv div > span{
  padding: 15px;
  border-radius: 3px;
  background: #00816A;
  display: inline-block;
}

.smalltext{
  padding-top: 5px;
  font-size: 16px;
}
</style>
<div class="row">
	<div class="col-md-4">
		<div class="card">
			
				<div class="d-flex align-items-center flex-column mb-1">
			<div class="sw-13 position-relative mb-0">
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
			</div>
			<div class="text-muted">E KELULUSAN</div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
			</div>
				<div class="card-title text-center">
				<?php if($waktumu < $skl['dibuka']): ?>
				PENGUMUMAN DIBUKA
				<?php endif; ?>
				<?php if($waktumu >= $skl['dibuka'] AND $waktumu <= $skl['ditutup']): ?>
				PENGUMUMAN SUDAH DIBUKA
				<?php endif; ?>
				<?php if($waktumu >= $skl['ditutup']): ?>
				PENGUMUMAN DITUTUP
				<?php endif; ?>
				</div>
				<?php if($waktumu < $skl['dibuka']): ?>
				<div id="clockdiv">
					<div>
					<span class="days"></span>
					<div class="smalltext">Hari</div>
					</div>
					 <div>
					<span class="hours"></span>
					<div class="smalltext">Jam</div>
					</div>
					<div>
					<span class="minutes"></span>
					<div class="smalltext">Menit</div>
					</div>
					<div>
					<span class="seconds"></span>
					<div class="smalltext">Detik</div>
					</div>
					</div> 
                    <?php endif; ?>	
					<div class="card-body">
				<p class="text-small text-muted mb-2">ALAMAT</p>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					  <i class="material-icons text-info" style="font-size:18px">home</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
						<i class="material-icons text-info" style="font-size:18px">star</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['desa'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					   <i class="material-icons text-info" style="font-size:18px">sync</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
				</div>
			  </div>
           </div>			  
</div>
<script>
function getTimeRemaining(endtime) {
  const total = endtime - new Date().getTime();
  const seconds = Math.floor((total / 1000) % 60);
  const minutes = Math.floor((total / 1000 / 60) % 60);
  const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
  const days = Math.floor(total / (1000 * 60 * 60 * 24));
  return { total, days, hours, minutes, seconds };
}
function initializeClock(id, endtime) {
  const clock = document.getElementById(id);
  if (!clock) return;

  const daysSpan = clock.querySelector('.days');
  const hoursSpan = clock.querySelector('.hours');
  const minutesSpan = clock.querySelector('.minutes');
  const secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    const t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
      daysSpan.innerHTML = 0;
      hoursSpan.innerHTML = "00";
      minutesSpan.innerHTML = "00";
      secondsSpan.innerHTML = "00";
     
    }
  }
  updateClock();
  const timeinterval = setInterval(updateClock, 1000);
}
const deadlineString = "<?= date('Y-m-d\TH:i:s', strtotime($skl['dibuka'])) ?>";
console.log("Countdown target:", deadlineString); // debug di console
const deadline = new Date(deadlineString).getTime();
initializeClock('clockdiv', deadline);
</script>
<?php
$stmtSmt = $pdo->prepare("SELECT COUNT(*) AS jumlah FROM nilai_skl WHERE ket = :ket");
$stmtSmt->execute([':ket' => 'SMT']);
$smt = (int) $stmtSmt->fetch(PDO::FETCH_ASSOC)['jumlah'];

$stmtUji = $pdo->prepare("SELECT COUNT(*) AS jumlah FROM nilai_skl WHERE ket = :ket");
$stmtUji->execute([':ket' => 'US']);
$uji = (int) $stmtUji->fetch(PDO::FETCH_ASSOC)['jumlah'];
?>
<div class="col-md-8">  
	<div class="row">
		<div class="col-xl-6">
            <div class="card widget widget-stats">
               <div class="card-body">
					<div class="widget-stats-container d-flex">
					  <div class="widget-stats-icon widget-stats-icon-success">
				   <i class="material-icons-outlined">webhook</i>
					 </div>
				 <div class="widget-stats-content flex-fill">
				 <span class="widget-stats-title">NILAI SEMESTER</span>
					   <span class="widget-stats-amount"><?= $smt; ?></span>
					  <span class="widget-stats-info"></span>
					   </div>
					 </div>
					</div>
				   </div>
			   </div>
	<div class="col-xl-6">
			<div class="card widget widget-stats">
				<div class="card-body">
				<div class="widget-stats-container d-flex">
			<div class="widget-stats-icon widget-stats-icon-primary">
			   <i class="material-icons-outlined">webhook</i>
				 </div>
			 <div class="widget-stats-content flex-fill">
			 <span class="widget-stats-title">NILAI UJIAN</span>
				   <span class="widget-stats-amount"><?= $uji; ?></span>
				  <span class="widget-stats-info"></span>
				   </div>
				 </div>
				</div>
			   </div>
		   </div>
		   </div>
			<div class="card">
                   <canvas id="myChart"></canvas>					 
			</div>
		</div>
</div>
		
		<?php
		$mapel = [];
		$jumlah = [];
		$stmt = $pdo->prepare("SELECT DISTINCT idmapel FROM mapel_rapor WHERE tingkat = :tingkat");
		$stmt->execute([':tingkat' => $skl['tingkat']]);
		$idmapel_list = $stmt->fetchAll(PDO::FETCH_COLUMN);

		foreach ($idmapel_list as $idmapel) {
			$stmtMapel = $pdo->prepare("SELECT kode FROM mapel WHERE id = :id");
			$stmtMapel->execute([':id' => $idmapel]);
			$kode_mapel = $stmtMapel->fetch(PDO::FETCH_COLUMN);
			$mapel[] = $kode_mapel;

			$stmtNilai = $pdo->prepare("SELECT COUNT(*) FROM nilai_skl WHERE mapel = :idmapel");
			$stmtNilai->execute([':idmapel' => $idmapel]);
			$jumlah_nilai = (int) $stmtNilai->fetchColumn();
			$jumlah[] = $jumlah_nilai;
		}
		?>

<script>
	const ctx = document.getElementById('myChart');
	new Chart(ctx, {
		type: 'line',
		data: {
			labels: <?php echo json_encode($mapel); ?>,
			datasets: [{
				label: 'Jumlah Data',
				data: <?php echo json_encode($jumlah); ?>,
				backgroundColor: [
					'rgba(255, 99, 71, 1)',
					'rgba(9, 31, 242, 0.8)',
					'rgba(255, 128, 6, 0.8)'
					],
				borderColor: [
					'rgba(255, 99, 71, 1)',
					'rgba(9, 31, 242, 0.8)',
					'rgba(255, 128, 6, 0.8)'
					],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>