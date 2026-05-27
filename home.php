<?php
defined('APK') or exit('No access');
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM kebiasaan_harian WHERE id_siswa = :id_siswa");
$stmt->execute([':id_siswa' => $id_siswa]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_baris = $row['total'] ?? 0;
$bulan = date('m');
$tahun = date('Y');
$stmt2 = $pdo->prepare("
    SELECT COUNT(*) 
    FROM absensi 
    WHERE idsiswa = :idsiswa 
      AND ket = :ket 
      AND bulan = :bulan 
      AND tahun = :tahun
");
$stmt2->execute([
    ':idsiswa' => $id_siswa,
    ':ket'      => 'H',
    ':bulan'    => $bulan,
    ':tahun'    => $tahun
]);
$total_hadir = $stmt2->fetchColumn();
$stmt3 = $pdo->prepare("SELECT COUNT(*) FROM nilai WHERE id_siswa = :id_siswa");
$stmt3->execute([':id_siswa' => $id_siswa]);
$total_nilai = $stmt3->fetchColumn();
?>
<style>
.tampil-mobile {
    display: block;
}

@media (min-width: 769px) {
    .tampil-mobile {
        display: none;
    }
}
.tampil-desktop {
    display: none;
}
@media (min-width: 769px) {
    .tampil-desktop {
        display: block;
    }
}
</style>
<div class="row tampil-mobile">
   <div class="col-xl-8">
		<div class="card widget widget-action-list">
			<div class="card-body">
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('ujian') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">wifi</i>
								</span>
								<span class="widget-action-list-item-title">
									Asesmen
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('materi') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">library_books</i>
								</span>
								<span class="widget-action-list-item-title">
									Elearn
								</span>
							</a>
						</li>	
						<li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('skl') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">school</i>
								</span>
								<span class="widget-action-list-item-title">
									Kelulusan
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<?php
							$ada = false;
							$sql = "SELECT COUNT(*) AS jumlah FROM pkl_siswa WHERE idsiswa = :id_siswa";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([':id_siswa' => $id_siswa]);
							$jumlah = (int) $stmt->fetch(PDO::FETCH_ASSOC)['jumlah'];

							if ($jumlah > 0) {
								$ada = true;
							}
							?>
							<?php if ($ada): ?>
						<li class="widget-action-list-item">
							<a href="?pg=<?= enkripsi('prakerin') ?>">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">extension</i>
								</span>
								<span class="widget-action-list-item-title">
									Prakerin
								</span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
        <div class="card widget widget-info">
			<div class="card-body">
				<div class="widget-info-container">
				<?php if(empty($siswa['foto'])): ?>
					<div class="widget-info-image" style="background: url('images/siswa.png')"></div>
					<?php else: ?>
					<div class="widget-info-image" style="background: url('images/fotosiswa/<?= $siswa["foto"] ?>')"></div>
					<?php endif; ?>
					<label>Selamat Datang</label>
					<h5 class="widget-info-title"><?= $siswa['nama'] ?></h5>
					<a href="?pg=<?= enkripsi('profil') ?>" class="btn btn-primary">My Profil</a>
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
						<i class="material-icons-outlined">auto_stories</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Jurnal 7 Kebiasaan</span>
						<span class="widget-stats-amount"><?= $total_baris ?></span>
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
						<span class="widget-stats-title">Kehadiran</span>
						<span class="widget-stats-amount"><?= $total_hadir ?></span>
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
						<i class="material-icons-outlined">wifi</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Selesai Ujian</span>
						<span class="widget-stats-amount"><?= $total_nilai ?></span>
						
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_up</i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$query = "SELECT * FROM kebiasaan_harian WHERE id_siswa = :id_siswa ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([':id_siswa' => $siswa['id_siswa']]);
$jurnal = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="row">
   <div class="col-md-8">
       <div class="card" >
	   <div class="card-header" >
         <h5 class="card-title">Kebiasaan Harian Hari ini</h5>
	</div>			
		<div class="card-body">
	<table width="100%" border="1">
		<tr style="font-weight:bold;align-vertical:center;">
		<td height="30px" width="40%">&nbsp;Kebiasaan</td>
		<td>Waktu / Aktivitas</td>
		</tr>
		<tr>
		<td>&nbsp;1. Bangun pagi</td>
		<td>Pukul: <?= $jurnal['bangun_pagi'] ?></td>
		</tr>
		<tr>
		<td height="30px" style="vertical-align:middle">&nbsp;2. Beribadah</td>
		<td>
		 <label class="check-label">
        <input type="checkbox" <?php if($jurnal['subuh']!='') echo 'checked'; ?> disabled>
        Subuh <small style="color:blue"><?= $jurnal['subuh_pilihan'] ?></small>
    </label><br>

    <label class="check-label">
        <input type="checkbox" <?php if($jurnal['dzuhur']!='') echo 'checked'; ?> disabled>
        Dzuhur <small style="color:blue"><?= $jurnal['dzuhur_pilihan'] ?></small>
    </label><br>

    <label class="check-label">
        <input type="checkbox" <?php if($jurnal['ashar']!='') echo 'checked'; ?> disabled>
        Ashar <small style="color:blue"><?= $jurnal['ashar_pilihan'] ?></small>
    </label><br>

    <label class="check-label">
        <input type="checkbox" <?php if($jurnal['maghrib']!='') echo 'checked'; ?> disabled>
        Maghrib <small style="color:blue"><?= $jurnal['maghrib_pilihan'] ?></small>
    </label><br>

    <label class="check-label">
        <input type="checkbox" <?php if($jurnal['isya']!='') echo 'checked'; ?> disabled>
        Isya <small style="color:blue"><?= $jurnal['isya_pilihan'] ?></small>
    </label><br>

    <label class="check-label">
        <input type="checkbox" <?php if($jurnal['dhuha']!='') echo 'checked'; ?> disabled>
        Duha <small style="color:blue"><?= $jurnal['duha_pilihan'] ?></small>
    </label><br>

   
    <label class="check-label">
        
        Ibadah Lainnya <small style="color:blue"><?= $jurnal['ibadah_lainnya'] ?></small>
    </label>
		</td>
		</tr>
		<tr>
		<td>&nbsp;3. Berolahraga</td>
		<td>Jenis: <?= $jurnal['olahraga_jenis'] ?> &nbsp;&nbsp;&nbsp; durasi: <?= $jurnal['olahraga_durasi'] ?></td>
		</tr>
		<tr>
		<td>&nbsp;4. Gemar Membaca</td>
		<td><?= $jurnal['mapel'] ?></td>
		</tr>
		<tr>
		<td>&nbsp;5. Makan Sehat dan Bergizi</td>
		<td>Menu: <?= $jurnal['menu_makan'] ?></td>
		</tr>
		<tr>
		<td>&nbsp;6. Membantu Orang Tua</td>
		<td><?= $jurnal['kegiatan_masyarakat'] ?></td>
		</tr>
		<tr>
		<td>&nbsp;7. Istirahat Cukup</td>
		<td>Pukul: <?= $jurnal['istirahat'] ?></td>
		</tr>
		</table>
		<br>
		<table width="100%" border="1" style="font-size:11px">
		<tr style="text-align:center;">
		<td width="20%" style="vertical-align:top;">
		Paraf Ortu<br>
		<?php if($jurnal['paraf_ortu']!=''): ?>
		<img src="images/ttd/<?= $jurnal['paraf_ortu'] ?>" width="130px" height="80px">
		<br><?= $jurnal['ortu'] ?>
		<?php endif; ?>
		</td>
		<td width="20%" style="vertical-align:top;">
		Paraf Guru<br>
		<?php if($jurnal['paraf_guru']==''): ?>
		<br><br>
		<?php else: ?>
		<img src="images/ttd/<?= $jurnal['paraf_guru'] ?>" width="130px" height="80px">
		<br>
		<?php endif; ?>
		</td>
		<td style="vertical-align:top;">
		Catatan Guru<br>
		<?php if($jurnal['catatan_guru']==''): ?>
		<br><br>
		<?php else: ?>
		<?= $jurnal['catatan_guru'] ?>
		<?php endif; ?>
		</td>
		</tr>
		</table>
		
	</div>	
  </div>	
 </div>	
<div class="col-xl-4">
        <div class="card widget widget-info">
			<div class="card-body">
				<div class="widget-info-container">
					<div class="widget-info-image" style="background: url('images/<?= $setting['logo'] ?>')"></div>
					<p class="widget-info-text"><?= $setting['sekolah'] ?></p>
					<p class="widget-info-text m-t-n-xs">
					<?= $setting['alamat'] ?> Desa <?= $setting['desa'] ?> Kec. <?= $setting['kecamatan'] ?>
					Kab. <?= $setting['kabupaten'] ?>
					</p>
					<p class="text-muted"><?= $siswa['nama'] ?></p>
				</div>
				<div class="mb-0">
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
	  <div class="mb-2">
		<p class="text-small text-muted mb-2">CONTACT</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">phone</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">inbox</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['email'] ?></div>
		</div>
		<div class="row g-0 mb-0">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
			</div>
		</div>
	</div>
</div>
  