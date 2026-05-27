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
$semester = $setting['semester'];
$tapel = $setting['tp'];

// Ambil semua kelas dari tabel m_kelas untuk dropdown
$all_kelas = [];
$kelas_stmt = $pdo->prepare("SELECT kelas FROM m_kelas ORDER BY kelas");
$kelas_stmt->execute();
while ($row = $kelas_stmt->fetch(PDO::FETCH_ASSOC)) {
    $all_kelas[] = $row['kelas'];
}

// Ambil kelas yang dipilih dari form (single select)
$kelas_filter = $_POST['kelas'] ?? ''; // string tunggal

// Tentukan kelas yang akan ditampilkan di chart
$kelas_arr = [];
if (!empty($kelas_filter)) {
    // Pastikan kelas yang dipilih ada di nilai_rapor
    $kelas_stmt2 = $pdo->prepare(
        "SELECT DISTINCT kelas 
         FROM nilai_rapor 
         WHERE semester = ? AND tapel = ? AND kelas = ? 
         ORDER BY kelas"
    );
    $kelas_stmt2->execute([$semester, $tapel, $kelas_filter]);
    while ($row = $kelas_stmt2->fetch(PDO::FETCH_ASSOC)) {
        $kelas_arr[] = $row['kelas'];
    }
} else {
    // Jika tidak ada filter, tampilkan semua kelas yang ada di nilai_rapor
    $kelas_stmt2 = $pdo->prepare(
        "SELECT DISTINCT kelas 
         FROM nilai_rapor 
         WHERE semester = ? AND tapel = ? 
         ORDER BY kelas"
    );
    $kelas_stmt2->execute([$semester, $tapel]);
    while ($row = $kelas_stmt2->fetch(PDO::FETCH_ASSOC)) {
        $kelas_arr[] = $row['kelas'];
    }
}

// Ambil daftar mapel
$mapel_arr = [];
$mapel_stmt = $pdo->prepare("SELECT id, kode FROM mapel ORDER BY id");
$mapel_stmt->execute();
while ($row = $mapel_stmt->fetch(PDO::FETCH_ASSOC)) {
    $mapel_arr[$row['id']] = $row['kode'];
}

// Siapkan datasets chart
$datasets = [];
$colors = [
    'PTS' => 'rgba(54, 162, 235, 0.6)',
    'PAS' => 'rgba(255, 206, 86, 0.6)',
    'PAT' => 'rgba(75, 192, 192, 0.6)'
];

foreach ($kelas_arr as $kelas) {
    foreach (['PTS','PAS','PAT'] as $ket) {
        $query = "
            SELECT m.kode, AVG(n.nilai) AS avg_nilai
            FROM nilai_rapor n
            JOIN mapel m ON m.id = n.idmapel
            WHERE n.semester = :semester AND n.tapel = :tapel AND n.kelas = :kelas AND n.ket = :ket
            GROUP BY m.kode
            ORDER BY m.kode
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':semester' => $semester,
            ':tapel' => $tapel,
            ':kelas' => $kelas,
            ':ket' => $ket
        ]);

        $data_per_mapel = [];
        foreach ($mapel_arr as $mapel_name) {
            $data_per_mapel[$mapel_name] = null;
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_per_mapel[$row['kode']] = round((float)$row['avg_nilai'],2);
        }

        $datasets[] = [
            'label' => $kelas." - ".$ket,
            'data' => array_values($data_per_mapel),
            'backgroundColor' => $colors[$ket]
        ];
    }
}

$judul_kelas = !empty($kelas_arr) ? implode(', ', $kelas_arr) : 'Semua Kelas';
$chart_title = "Rata-rata Nilai Rapor Kelas: $judul_kelas (PTS/PAS/PAT)";
?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">GRAFIK NILAI RATA-RATA KELAS</h5>
            </div>
            <div class="card-body">
			<form method="post" class="mb-3">
				<label for="kelas">Pilih Kelas:</label>
				<div class="input-group mb-3">
				<select name="kelas" id="kelas" class="form-select">
					<option value="">-- Semua Kelas --</option>
					<?php foreach($all_kelas as $k): ?>
						<option value="<?= htmlspecialchars($k) ?>" <?= ($k == $kelas_filter) ? 'selected' : '' ?>>
							<?= htmlspecialchars($k) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<span class="input-group-text">
				<button type="submit" class="btn btn-sm btn-success">Filter</button>
				</span>
		    </div>	
			</form>
                <canvas id="raporChart" ></canvas>
            </div>
        </div>
    </div>
<script>
const ctx = document.getElementById('raporChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_values($mapel_arr)); ?>,
        datasets: <?= json_encode($datasets); ?>
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: <?= json_encode($chart_title); ?>
            },
            tooltip: {
                mode: 'index',
                intersect: false
            },
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
<?php
$semester = $setting['semester'];
$tapel    = $setting['tp'];
$koku    = rows("absen_rapor", $semester, $tapel);
$ekstra  = rows("peskul", $semester, $tapel);
$catatan = rows("catatan_rapor", $semester, $tapel);
?>
<div class="col-md-4">
   <div class="row">
		<div class="col-xl-12">
			<div class="card widget widget-stats">
				<div class="card-body">
					<div class="widget-stats-container d-flex">
						<div class="widget-stats-icon widget-stats-icon-primary">
							<i class="material-icons-outlined">school</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title">CATATAN WALI KELAS</span>
							<span class="widget-stats-amount"><?= $catatan; ?> </span>
						  
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card widget widget-stats">
				<div class="card-body">
					<div class="widget-stats-container d-flex">
						<div class="widget-stats-icon widget-stats-icon-warning">
							<i class="material-icons-outlined">dataset</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title">ABSENSI RAPOR</span>
							<span class="widget-stats-amount"><?= $koku; ?></span>
						   
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card widget widget-stats">
				<div class="card-body">
					<div class="widget-stats-container d-flex">
						<div class="widget-stats-icon widget-stats-icon-danger">
							<i class="material-icons-outlined">apps</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title">EKSTRAKOKURIKULER</span>
							<span class="widget-stats-amount"><?= $ekstra ?> </span>
						  
						</div>
					   
					</div>
				</div>
			</div>
		</div>
	 </div> 
				
  </div>
</div>

