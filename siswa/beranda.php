<?php
$stmt = $pdo->prepare("SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT 2");
$stmt->execute();
?>
<div class="row">
   <div class="col-xl-8">
		<div class="card widget widget-list">
			<div class="card-header">
				<h5 class="card-title">INFORMASI</h5>
			</div>
			<div class="card-body">
	
		<?php if ($stmt->rowCount() > 0): ?>
			<?php while ($p = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<div class="card widget widget-popular-blog">
			<div class="card-body">
							<div class="widget-popular-blog-container">
								<div class="widget-popular-blog-image">
									<img src="images/corong.png" alt=""> 
								</div>
								<div class="widget-popular-blog-content ps-4">
									<span class="widget-popular-blog-title">
										<?= $p['judul'] ?>
									</span>
									<span>
										<?= $p['isi'] ?> 
									</span>
								</div>
							</div>
						</div>
						<div class="card-footer d-flex justify-content-between align-items-center" id="datata">
							<span class="widget-popular-blog-date">
								Date: <?= htmlspecialchars($p['tanggal']) ?>
							</span>
						</div>
					</div>
					<?php endwhile; ?>
				<?php else: ?>
				<p style="text-align:center; color:#777;">Belum ada pengumuman untuk saat ini.</p>
			<?php endif; ?>
		 
		</div>
	</div>
</div>
<div class="col-xl-4">
	<div class="card widget widget-payment-request">
		<div class="card-header">
					<h5 class="card-title">KONFIRMASI PESERTA</h5>
				</div>
				<div class="card-body">
					<div class="widget-payment-request-container">
						<div class="widget-payment-request-author">
							<div class="avatar m-r-sm">
								<img src="images/siswa.png" alt="">
							</div>
							<div class="widget-payment-request-author-info">
								<span class="widget-payment-request-author-name"><?= ucwords(strtolower($siswa['nama'])) ?></span>
								<span class="widget-payment-request-author-about">Kelas <?= $siswa['kelas'] ?></span>
							</div>
						</div>
						
						<div class="widget-payment-request-info m-t-md edis2">
						   <div style="display: flex; flex-direction: column; gap: 10px;">
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">No Peserta</span>
								<span class="text-muted"><?= $siswa['nopes'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">N I S</span>
								<span class="text-muted"><?= $siswa['nis'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">N I S N</span>
								<span class="text-muted"><?= $siswa['nisn'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Ruang</span>
								<span class="text-muted"><?= $siswa['ruang'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Sesi</span>
								<span class="text-muted"><?= $siswa['sesi'] ?></span>
							</div>
						</div>
						<div class="widget-payment-request-actions m-t-lg d-flex">
							<a href="?pg=<?= enkripsi('jadwal') ?>" class="btn btn-primary flex-grow-1 m-l-xxs">Konfirmasi</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>