<?php
defined('APK') or exit('No Access');

$semester = $setting['semester'];
$ftapel   = $setting['tp'];

try {
    $stmt = $pdo->prepare("
        SELECT SUM(bayar) AS total_bayar
        FROM trx_bayar
        WHERE MONTH(tanggal) = :bulan 
          AND YEAR(tanggal) = :tahun
    ");
    $stmt->bindParam(':bulan', $bulan, PDO::PARAM_INT);
    $stmt->bindParam(':tahun', $tahun, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_bayar = $row['total_bayar'] ?? 0;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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
 <div class="col-lg-12">
	  <div class="row">
			<div class="col-xl-4">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-primary">
								<i class="material-icons-outlined">school</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">PENDAPATAN BULAN INI</span>
								<span class="widget-stats-amount"><?= number_format($total_bayar, 0, ',', '.'); ?> </span>
							  
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
								<i class="material-icons-outlined">dataset</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">PENGELUARAN BULAN INI</span>
								<span class="widget-stats-amount">0</span>							   
							</div>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card widget widget-stats">
					<div class="card-body">
						<div class="widget-stats-container d-flex">
							<div class="widget-stats-icon widget-stats-icon-purple">
								<i class="material-icons-outlined">apps</i>
							</div>
							<div class="widget-stats-content flex-fill">
								<span class="widget-stats-title">MESIN PEMBAYARAN</span>
								<span class="widget-stats-amount" id="barsiswa"> </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		 </div> 
   </div>
<?php
$all_bulan = [
    '01' => 'Jan', 
    '02' => 'Feb', 
    '03' => 'Mar', 
    '04' => 'Apr', 
    '05' => 'Mei', 
    '06' => 'Jun', 
    '07' => 'Jul', 
    '08' => 'Agu', 
    '09' => 'Sept', 
    '10' => 'Okt', 
    '11' => 'Nov', 
    '12' => 'Des'
];
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$data = [];
try {

    $stmt = $pdo->prepare("
        SELECT MONTH(tanggal) AS bulan, SUM(bayar) AS total
        FROM trx_bayar
        WHERE YEAR(tanggal) = :tahun
        GROUP BY bulan
        ORDER BY bulan ASC
    ");
    
    $stmt->bindParam(':tahun', $tahun, PDO::PARAM_INT);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bulan = str_pad($row['bulan'], 2, '0', STR_PAD_LEFT);  
        $data[$bulan] = (int)$row['total'];
    }
    
} catch (PDOException $e) {
   
    $data = [];
}

$values = [];
foreach ($all_bulan as $key => $nama_bulan) {
    $values[] = $data[$key] ?? 0;
}

$labels = array_values($all_bulan);
$labels_json = json_encode($labels);
$values_json = json_encode($values);
?>

<div class="row">
  <div class="col-xl-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-center">GRAFIK PENDAPATAN</h5>
        </div>
        <div class="card-body">
            <form method="get">
                Pilih Tahun: 
                <select name="tahun" onchange="this.form.submit()">
                    <?php
                    $tahun_now = date('Y');
                    for ($t = $tahun_now - 5; $t <= $tahun_now + 1; $t++) {
                        $selected = $t == $tahun ? 'selected' : '';
                        echo "<option value='$t' $selected>$t</option>";
                    }
                    ?>
                </select>
            </form>
            <canvas id="grafikPembayaran"></canvas>
			</div>
        </div>
    </div>
 <div class="col-xl-4">
        <div id="trx"></div>
	 </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	setInterval(function(){
	$("#trx").load('trx/trx.php')
		$("#barsiswa").load('master/kartusiswa.php')
		}, 1000);  
	});
</script>
<script>
const ctx = document.getElementById('grafikPembayaran').getContext('2d');
new Chart(ctx, {
    type: 'line', // Bisa diganti 'line', 'pie', dll
    data: {
        labels: <?= $labels_json; ?>,
        datasets: [{
            label: 'Total Pembayaran (Rp)',
            data: <?= $values_json; ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.formattedValue.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>

    
	