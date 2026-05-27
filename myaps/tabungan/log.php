<?php 
require("../../konek/koneksi.php");
?>
<div class="row">
    <div class="col-xl-6">
<?php
	$ada = false;
	$zero = 0;
	$sql = "SELECT t.id_saldo, t.tanggal, t.debet, s.nama, d.nokartu
			FROM saldo t
			LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
			LEFT JOIN datareg d ON d.idsiswa = t.idsiswa
			WHERE t.tanggal = :tanggal AND t.debet > :zero
			ORDER BY id_saldo DESC LIMIT 1
			";

	$stmt = $pdo->prepare($sql);
	if (!$stmt) {
		die("Query prepare failed: " . $pdo->errorInfo());
	}
	$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
	$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
	$stmt->execute();
	while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
	$ada = true;
	?>	
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					<?= $data['nama']; ?>
					<span class="widget-bank-card-number mt-auto">
						<?= $data['nokartu']; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
	<?php
	$stmt->closeCursor();
	?>
	<?php if($ada==false): ?>
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					Tidak ada aktifitas Simpanan
					<span class="widget-bank-card-number mt-auto">
						<?= $tanggal; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	</div>
<div class="col-xl-6">
<?php
	$ada = false;
	$zero = 0;
	$sql = "SELECT t.id_saldo, t.tanggal, t.kredit, s.nama, d.nokartu 
			FROM saldo t
			LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
			LEFT JOIN datareg d ON d.idsiswa = t.idsiswa
			WHERE t.tanggal = :tanggal AND t.kredit > :zero
			ORDER BY id_saldo DESC LIMIT 1
			";

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
		$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
		$stmt->execute();
		
		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ada = true;
	?>
    <div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?>
					</span>
					<?= $data['nama']; ?>
					<span class="widget-bank-card-number mt-auto">
						<?= $data['tanggal']; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	?>
	<?php if($ada==false): ?>
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					Tidak ada aktifitas Penarikan
					<span class="widget-bank-card-number mt-auto">
						<?= $tanggal; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
  </div>
</div>
