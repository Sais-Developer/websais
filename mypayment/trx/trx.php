<?php
require("../../konek/koneksi.php");
?>
<style>
.kanan {
	float: right;
}
</style>
<div class="row">
    <div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">LIVE TRX TANGGAL <?= strtoupper(date('d M Y')); ?></h5>
					</div>
            <div class="card-body" style="height:420px">
				<?php
					$ada = false;
					$no = 0;

					$sql = "
						SELECT t.id_trx, t.bayar, t.ke, t.bukti,
							   s.nama, s.kelas, b.kode 
						FROM trx_bayar t 
						LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
						LEFT JOIN m_bayar b ON b.id = t.idbayar
						WHERE t.tanggal = :tanggal
						ORDER BY t.id_trx DESC
						LIMIT 3
					";
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':tanggal', $tanggal);
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$ada = true;
						$no++;
					?>
						<?= htmlspecialchars($data['nama']) ?> 
						<span class="badge badge-secondary kanan"><?= htmlspecialchars($data['kelas']) ?></span>
						<h5>
							<span class="badge badge-dark"><?= htmlspecialchars($data['kode']) ?></span>
							<span class="badge badge-success"><?= number_format($data['bayar']) ?></span>
							<span class="badge badge-primary"><?= htmlspecialchars($data['ke']) ?></span>
						</h5>
						<?= htmlspecialchars($data['bukti']) ?>
						<a href="cetak/cetakstruk.php?idt=<?= $data['id_trx']; ?>" target="_blank" class="btn btn-sm btn-success kanan">
										<i class="material-icons">print</i>
									</a>
						<hr>
					<?php endwhile; ?>
					<?php if ($ada == false): ?>
						<p class="text-muted">
							<img src="../images/animasi.gif" style="width:40px">
							Belum ada aktifitas
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	 </div>
									