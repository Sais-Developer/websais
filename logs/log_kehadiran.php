<?php
require("../konek/koneksi.php");
require("../konek/crud.php");

$siswa = countRows($db, "siswa"); 

$sql = "
SELECT 
    SUM(ket = 'H') AS hadir,
    SUM(ket = 'I') AS izin,
    SUM(ket = 'A') AS alfa,
    SUM(ket = 'S') AS sakit
FROM absensi
WHERE level = 'siswa' 
  AND tanggal = CURDATE()
";

$data = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

$hadir = $data['hadir'];
$izin  = $data['izin'];
$alfa  = $data['alfa'];
$sakit = $data['sakit'];

$denom = ($siswa > 0) ? $siswa : 1;

$persen_hadir = ($hadir / $denom) * 100;
$persen_izin  = ($izin  / $denom) * 100;
$persen_alfa  = ($alfa  / $denom) * 100;
$persen_sakit = ($sakit / $denom) * 100;

$persen_hadir = round($persen_hadir, 1);
$persen_izin  = round($persen_izin, 1);
$persen_alpha  = round($persen_alfa, 1);
$persen_sakit = round($persen_sakit, 1);
?>

<div class="card widget widget-info">
	<div class="card-body" style="height:485px">
		<div class="widget-info-container">
			
			<h5 class="widget-info-title"><?= $setting['sekolah'] ?></h5>
			<p class="widget-info-text m-t-n-xs">
			<?= $setting['alamat'] ?> Desa <?= $setting['desa'] ?> Kec. <?= $setting['kecamatan'] ?>
			Kab. <?= $setting['kabupaten'] ?>
			</p>
			
		</div>
			<div class="widget widget-list">
				<ul class="widget-list-content list-unstyled">
				  <li class="widget-list-item widget-list-item-green">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">co_present</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title d-flex justify-content-between">
							Hadir <span class="text-end"><?= $persen_hadir ?>%</span>
						</a>
						<span class="widget-list-item-description-progress">
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: <?= $persen_hadir ?>%;" aria-valuenow="<?= $persen_hadir ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</span>
					</span>
				</li>
				 <li class="widget-list-item widget-list-item-blue">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">co_present</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title d-flex justify-content-between">
							Sakit <span class="text-end"><?= $persen_sakit ?>%</span>
						</a>
						<span class="widget-list-item-description-progress">
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: <?= $persen_sakit ?>%;" aria-valuenow="<?= $persen_sakit ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</span>
					</span>
				</li>
				 <li class="widget-list-item widget-list-item-purple">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">co_present</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title d-flex justify-content-between">
							Izin <span class="text-end"><?= $persen_izin ?>%</span>
						</a>
						<span class="widget-list-item-description-progress">
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: <?= $persen_izin ?>%;" aria-valuenow="<?= $persen_izin ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</span>
					</span>
				</li>
				 <li class="widget-list-item widget-list-item-red">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">co_present</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title d-flex justify-content-between">
							Alpha <span class="text-end"><?= $persen_alpha ?>%</span>
						</a>
						<span class="widget-list-item-description-progress">
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: <?= $persen_alpha ?>%;" aria-valuenow="<?= $persen_alpha ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</span>
					</span>
				</li>
			</ul>
		</div>				
	</div>
</div>