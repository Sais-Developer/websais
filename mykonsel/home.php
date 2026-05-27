<?php
defined('APK') or exit('No Access');
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
<?php
    $sql = "
        SELECT 
            k.nama_kategori AS kategori,
            MONTH(c.tanggal) AS bulan,
            YEAR(c.tanggal) AS tahun,
            COUNT(c.id) AS jumlah_pelanggaran
        FROM 
            catatan_pelanggaran AS c
        JOIN 
            pelanggaran AS p ON c.idpel = p.id
        JOIN 
            kategori_pelanggaran AS k ON p.id_kategori = k.id_kategori
        GROUP BY 
            k.nama_kategori, YEAR(c.tanggal), MONTH(c.tanggal)
        ORDER BY 
            YEAR(c.tanggal), MONTH(c.tanggal)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // <-- fetchAll di PDO

    $data = [];
    $bulanList = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $tahunAktif = date('Y'); 
    foreach ($result as $row) {
        $data[$row['kategori']][(int)$row['bulan']] = $row['jumlah_pelanggaran'];
    }

    foreach ($data as $kategori => $bulanData) {
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($data[$kategori][$i])) {
                $data[$kategori][$i] = 0;
            }
        }
        ksort($data[$kategori]); 
    }

?>
<div class="row">
   <div class="col-xl-4">
     <div class="card widget widget-list">
	 <div class="card-header">
			<h5 class="card-title">LIST PERINGATAN</h5>
		</div>
	<div class="card-body">
		<ul class="widget-list-content list-unstyled">
	<?php
	$sql = "
	SELECT 
		t.id_teguran,
		t.jenis_teguran,
		t.min_poin,
		t.max_poin,
		COUNT(s.id_siswa) AS jumlah_siswa
	FROM 
		teguran AS t
	LEFT JOIN 
		siswa AS s
		ON s.total_poin BETWEEN t.min_poin AND t.max_poin
	GROUP BY 
		t.id_teguran, t.jenis_teguran, t.min_poin, t.max_poin
	ORDER BY 
		t.min_poin ASC
	";
	$stmt2 = $pdo->prepare($sql); 
	$stmt2->execute();
	$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); 
	foreach ($result2 as $row):
	?>          
				<li class="widget-list-item widget-list-item-green">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">warning</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title">
							<?= htmlspecialchars($row['jenis_teguran']) ?>
						</a>
						<span class="widget-list-item-description-subtitle">
							<?= htmlspecialchars($row['jumlah_siswa']) ?>
						</span>
					</span>
				</li>
		   <?php endforeach; $stmt2 = null; ?>
		   </ul>
		</div>
	</div>
</div>
<div class="col-xl-8">
	<div class="card widget widget-list">
		<div class="card-header">
			<h5 class="card-title">LIST PEMBINAAN SISWA</h5>
		</div>
		<div class="card-body" style="height:445px">
	<ul class="widget-list-content list-unstyled">                                        
	<?php
	$ada = false;
	$no = 0;
	$sql = "
		SELECT 
			k.tanggal, 
			k.catatan, 
			k.tindakan_lanjutan, 
			s.nama, 
			s.kelas 
		FROM konseling k 
		LEFT JOIN siswa s ON s.id_siswa = k.idsiswa 
		ORDER BY k.id_konseling DESC 
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
						Catatan : <?= $rows['catatan'] ?>
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
<script>
const bulanLabels = <?= json_encode(array_values($bulanList)); ?>;
const dataFromPHP = <?= json_encode($data); ?>;

const datasets = Object.entries(dataFromPHP).map(([kategori, values]) => ({
    label: kategori,
    data: Object.values(values),
    borderWidth: 2,
    fill: false,
    tension: 0.3,
    borderColor: '#' + Math.floor(Math.random()*16777215).toString(16),
}));

new Chart(document.getElementById('grafikPelanggaran'), {
    type: 'bar', // bisa diganti 'line' kalau mau garis
    data: {
        labels: bulanLabels,
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Grafik Jumlah Pelanggaran per Bulan Berdasarkan Kategori'
            },
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Pelanggaran'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Bulan'
                }
            }
        }
    }
});
</script>