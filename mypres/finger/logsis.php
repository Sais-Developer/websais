<?php
require("../../konek/koneksi.php");
?>
		<?php
			$no = 0;
				$stmt = $pdo->prepare("SELECT * FROM temp_finger WHERE serial <> ''  ORDER BY id DESC");
				$stmt->execute();
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
					$no++;  
			?>
		<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 240px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					SERIAL NUMBER
					</span>
					<span class="widget-bank-card-balance">
					<?= $data['idjari'] ?> - <?= $data['serial'] ?>
					</span>
					<div class="d-grid gap-2">
		<button class="btn btn-dark" type="button" disabled>
			<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
			Silahkan <b>Tekan Tombol di Mesin</b> selama 1 detik untuk menghapus Sidik Jari <?= $data['nama'] ?>
		</button>
		 </div>		
					
				</div>
			</div>
		</div>
	</div>
			<?php endwhile; ?>
		