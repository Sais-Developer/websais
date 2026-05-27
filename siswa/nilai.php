<?php
defined('APK') or exit('No accsess');
?>

<div class='row'>
	<?php
		$stmt = $pdo->prepare("SELECT * FROM nilai WHERE id_siswa = :id_siswa ");
		$stmt->execute([':id_siswa' => $id_siswa]);
		$nilais = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$no = 0;
		foreach ($nilais as $nilai):
			$no++;

			$stmtMapel = $pdo->prepare("SELECT * FROM banksoal WHERE id_bank = :id_bank");
			$stmtMapel->execute([':id_bank' => $nilai['id_bank']]);
			$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);

			$stmtNamaMapel = $pdo->prepare("SELECT * FROM mapel WHERE id = :id");
			$stmtNamaMapel->execute([':id' => $mapel['idmapel']]);
			$namamapel = $stmtNamaMapel->fetch(PDO::FETCH_ASSOC);
		?>
			<div class="col-xl-4">
	<div class="card widget widget-payment-request">
		<div class="card-header">
					<h5 class="card-title"><?= $namamapel['kode'] ?></h5>
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
						<div class="widget-payment-request-actions m-t-lg d-flex justify-content-center">
						<h5>
							<span class="badge badge-primary">Nilai Ujian</span>
							<span class="badge badge-primary"><?= round($nilai['nilai']) ?></span>
						</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>