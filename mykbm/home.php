<?php 
defined('APK') or exit('No Access');
$cp = countRows($db, "cp_elemen");
$tujuan = countRows($db, "adm_tp");
$agenda = countRows($db, "agenda");
$nilai = countRows($db, "nilai_harian");
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
	<div class="col-lg-8">
	  <div class="row">
		<div class="col-xl-6">
			<div class="card widget widget-stats">
				<div class="card-body">
					<div class="widget-stats-container d-flex">
						<div class="widget-stats-icon widget-stats-icon-danger">
							<i class="material-icons-outlined">select_all</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title"></span>
							<span class="widget-stats-amount"><?= $cp ?></span>
							<span class="widget-stats-info">Capaian Pembelajaran</span>
						</div>
						<div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
							<i class="material-icons">keyboard_arrow_down</i>
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
						<i class="material-icons-outlined">school</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title"></span>
						<span class="widget-stats-amount"><?= $tujuan ?></span>
						<span class="widget-stats-info">Tujuan Pembelajaran</span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
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
							<i class="material-icons-outlined">apps</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title"></span>
							<span class="widget-stats-amount"><?= $agenda ?></span>
							<span class="widget-stats-info">Jurnal dan Agenda</span>
						</div>
						<div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
							<i class="material-icons">keyboard_arrow_down</i>
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
							<i class="material-icons-outlined">alarm</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title"></span>
							<span class="widget-stats-amount"><?= $nilai ?></span>
							<span class="widget-stats-info">Nilai Harian</span>
						</div>
						<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
							<i class="material-icons">keyboard_arrow_down</i>
						</div>
					</div>
				</div>
			</div>
		</div>
		 
		<div class="col-xl-12 mb-2">
		    <div class="card">
			      <?php
					$sql = "
						SELECT (SUM(a.jjm) * :honor) AS total, g.nama, j.kelas, m.kode
						FROM absen_jjm a 
						LEFT JOIN guru g ON g.id_guru = a.idpeg
						LEFT JOIN jadwal_mengajar j ON j.id_jadwal = a.jadwal
						LEFT JOIN mapel m ON m.id = j.mapel
						WHERE a.tanggal = :tanggal
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						':honor'   => $setting['honor'],
						':tanggal' => $tanggal
					]);

					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
					?>
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-center">GRAFIK KBM & JJM HARI INI</h5>
				</div>
				   <div class="card-body">
					  <canvas id="myChart" height="110"></canvas>
				    </div>
			     </div>
		      </div>
		   </div>
	    </div> 
     </div>
  </div>
 <script>
		var data = <?php echo json_encode($data); ?>;
		console.log(data); 

		if (data.length === 0) {
			console.log('Data tidak tersedia!');
		} else {
			var labels = [];
			var totals = [];

			
			data.forEach(function(log) {
				labels.push(log['nama'] + ' - ' + log['kode']);
				totals.push(log['total']);
			});

			var ctx = document.getElementById('myChart').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar', 
				data: {
					labels: labels, 
					datasets: [{
						label: 'Total Honor',
						data: totals, 
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderColor: 'rgba(75, 192, 192, 1)',
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
		}
	</script>
	 
 <div class="col-xl-4">
    <div class="card widget widget-list">
        <div class="card-header">
            <h5 class="card-title">Jadwal Aktif Saat ini</h5>
        </div>
        <div class="card-body">
            <ul class="widget-list-content list-unstyled">
                <?php
					$ada = false;
					$hari = date('D');
					$jam = date('H:i');

					$stmt = $pdo->prepare("SELECT j.kelas, j.dari, j.sampai, g.nama, g.foto, m.nama_mapel
						  FROM jadwal_mengajar j
						  LEFT JOIN guru g ON g.id_guru = j.guru
						  LEFT JOIN mapel m ON m.id = j.mapel
						  WHERE j.hari = :hari AND j.dari < :jam_sampai AND j.sampai > :jam_dari AND g.level = 'guru'");

					$stmt->execute([
						':hari' => $hari,
						':jam_dari' => $jam,
						':jam_sampai' => $jam
					]);

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
						$ada = true;
					?>
						<li class="widget-list-item widget-list-item-green">
							<span class="widget-list-item-avatar">
								<div class="avatar avatar-rounded">
									<img src="../images/user.png" alt="">
								</div>
							</span>
							<span class="widget-list-item-description">
								<a href="#" class="widget-list-item-description-title">
									<?= htmlspecialchars($data['nama_mapel']) ?>
								</a>
								<span class="widget-list-item-description-subtitle">
									<?= htmlspecialchars($data['nama']) ?> <?= $data['kelas'] ?>   
								</span>
								<span class="widget-list-item-description-subtitle">
									<?= $data['dari'] ?> s/d <?= $data['sampai'] ?> 
								</span>
							</span>
						</li>
					<?php endwhile; ?>
                 <?php if($ada==false): ?>
				 <li class="widget-list-item widget-list-item-purple">
						<span class="widget-list-item-avatar">
							<div class="avatar avatar-rounded">
								<img src="../images/user.png" alt="">
							</div>
						</span>
						<span class="widget-list-item-description">
							<a href="#" class="widget-list-item-description-title">
								Tidak ada jadwal aktif
							</a>
							<span class="widget-list-item-description-subtitle">
								Saat ini
							</span>
						</span>
					</li>
				 <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

</div>
	
				   
	