<?php
defined('APK') or exit('No access');
$siswa   = countRows($db, "siswa");
$guru = countRows($db, "guru");
$mapel   = countRows($db, "mapel");
?>
<div class="row">
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">school</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Peserta Didik</span>
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
						<span class="widget-stats-title">Pegawai</span>
						<span class="widget-stats-amount"><?= $guru ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_up</i>
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
						<i class="material-icons-outlined">auto_stories</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Mata Pelajaran</span>
						<span class="widget-stats-amount"><?= $mapel ?></span>
						
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_up</i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
   <div class="col-xl-8">
		<div class="card widget widget-action-list">
			<div class="card-body">
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<!--  <li class="widget-action-list-item">
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
					</ul>
				</div>
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykonsel">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-primary">laptop</i>
								</span>
								<span class="widget-action-list-item-title">
									Konseling
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypkl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">extension</i>
								</span>
								<span class="widget-action-list-item-title">
									Prakerin
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypayment">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-danger">money</i>
								</span>
								<span class="widget-action-list-item-title">
									Payment
								</span>
							</a>
						</li>
						<!-- <li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('gateway') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">send</i>
								</span>
								<span class="widget-action-list-item-title">
									WA Gateway
								</span>
							</a>
						</li> -->
						<li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('arsip') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">menu</i>
								</span>
								<span class="widget-action-list-item-title">
									App Lainnya
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myaps">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-dark">apps</i>
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
$tables = ['siswa', 'agenda', 'soal', 'nilai', 'materi', 'tugas'];

$labels = [
    'siswa'   => 'Data Siswa',
    // 'absensi' => 'Data Absensi',
    'agenda'  => 'Agenda Guru',
    'soal'    => 'Soal Ujian',
    'nilai'   => 'Nilai Ujian',
    'materi'  => 'Materi Belajar',
    'tugas'   => 'Tugas Siswa'
];

$data = [];
foreach ($tables as $tbl) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM $tbl");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data[$labels[$tbl]] = $row['total'] ?? 0;
}
?>
 <div class="row">
	<div class="col-xl-8">
		<div class="card">
			<div class="card-body">
			<canvas id="myChart"></canvas>
			
			</div>
		</div>
	</div>
<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_keys($data)) ?>,  
    datasets: [{
      label: 'Jumlah Data',
      data: <?= json_encode(array_values($data)) ?>,  
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',   // Warna pertama
        'rgba(54, 162, 235, 0.5)',   // Warna kedua
        'rgba(255, 206, 86, 0.5)',   // Warna ketiga
        'rgba(75, 192, 192, 0.5)',   // Warna keempat
        'rgba(153, 102, 255, 0.5)',  // Warna kelima
        'rgba(255, 159, 64, 0.5)',   // Warna keenam
        'rgba(100, 181, 246, 0.5)'   // Warna ketujuh
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',   // Border pertama
        'rgba(54, 162, 235, 1)',   // Border kedua
        'rgba(255, 206, 86, 1)',   // Border ketiga
        'rgba(75, 192, 192, 1)',   // Border keempat
        'rgba(153, 102, 255, 1)',  // Border kelima
        'rgba(255, 159, 64, 1)',   // Border keenam
        'rgba(100, 181, 246, 1)'   // Border ketujuh
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        labels: {
          font: {
            size: 10  
          }
        }
      },
      title: {
        display: true,
        text: 'Grafik Jumlah Data',
        font: {
          size: 12
        }
      }
    },
    scales: {
      x: {
        ticks: {
          font: {
            size: 9  
          }
        }
      },
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0,  
          font: {
            size: 9  
          }
        }
      }
    }
  }
});
</script>
	
<div class="col-xl-4">
	<div class="card widget widget-list">
		<div class="card-header">
			<h5 class="card-title">LIST JURNAL 7 KAIH</h5>
		</div>
		<div class="card-body" style="height:445px">
	<ul class="widget-list-content list-unstyled">                                        
	<?php
	$ada = false;
	$no = 0;
	$sql = "
		SELECT 
			k.*, 
			s.nama, 
			s.kelas 
		FROM kebiasaan_harian k 
		LEFT JOIN siswa s ON s.id_siswa = k.id_siswa 
		ORDER BY k.id DESC 
		LIMIT 5
	";
	$stmt3 = $pdo->prepare($sql); 
	$stmt3->execute();
	$result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC); 

	foreach ($result3 as $rows):
		$no++;
		$ada = true;
	?>
	 <li class="widget-list-item widget-list-item-green">
		  <span class="widget-list-item-avatar">
					<div class="avatar avatar-rounded">
						<img src="../images/siswa.png" alt="">
					</div>
				</span>
				<span class="widget-list-item-description">
					<a href="#" class="widget-list-item-description-title">
						<?= $rows['nama'] ?>
					</a>
					<span class="widget-list-item-description-subtitle">
						Bangun Pagi : <?= $rows['bangun_pagi'] ?>
					</span>
				</span>
			</li>
			<?php endforeach; $stmt3 = null; ?>
			<?php if($ada==false): ?>
			<li class="widget-list-item widget-list-item-green">
			<div class="spinner-border text-danger" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>  &nbsp;&nbsp;Tidak ada aktifitas
			</li>
			<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
	
</div>
