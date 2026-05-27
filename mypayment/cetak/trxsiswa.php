<?php
defined('APK') or exit('No Access');

?>           
<?php if ($ac == '') : ?>
	<div class="row">
		  <div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">LAPORAN DATA PEMBAYARAN</h5>
					</div>
					<div class="card-body">						
					<div class="card-box table-responsive">
						<table id="datatable1" class="table table-bordered table-hover edis" style="width:100%;font-size:12px">
							<thead>
							<tr>
								<th width="5%">NO</th> 													
								<th>NAMA SISWA</th>
								<th>KELAS</th>													
								<th>KODE</th>												  
								  <th>BAYAR</th>
								  <th>KE</th>
								 <th></th>
							</tr>
							</thead>
							<tbody>
							<?php
							$no = 0;
							$sql = "
								SELECT t.*, m.model, m.total, m.kode, s.nama, s.kelas
								FROM trx_bayar t
								LEFT JOIN m_bayar m ON m.id = t.idbayar
								LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
								ORDER BY t.id_trx DESC
								LIMIT 10
							";

							$stmt = $pdo->prepare($sql);
							$stmt->execute();

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
							?>
							<tr>
								<td style="text-align:center"><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nama']); ?></td>
								<td><?= htmlspecialchars($data['kelas']); ?></td>
								<td><?= htmlspecialchars($data['kode']); ?></td>
								<td><?= 'Rp ' . number_format($data['bayar'], 0, ',', '.'); ?></td>
								<td><?= $data['ke']; ?></td>
								<td>
									<a href="cetak/cetakstruk.php?idt=<?= $data['id_trx']; ?>" target="_blank" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Pembayaran">
										<i class="material-icons">print</i>
									</a>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				 </div>
			</div>
		</div>
	</div>
<div class="col-md-4">
	<div class="card">                                
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
				<div class="d-flex align-items-center flex-column">
					 <div class="sw-13 position-relative mb-3">
						<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
						</div>
					<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
						  <div class="text-muted">HIGH SCHOOL</div>
						</div>
					  </div>
					  <form id="formsiswa" action='cetak/cetakrekap.php' target="_blank" method='GET' class="row g-1" enctype='multipart/form-data'>
					 <div class="col-md-12">
					<label class="form-label bold">JENIS PEMBAYARAN</label>
					   <select class="form-select" name="jenis" required style="width: 100%">
						  <option value='' selected>Pilih Jenis</option>
						  <?php
							$stmt = $pdo->prepare("SELECT * FROM m_bayar");
							$stmt->execute();
							while ($level = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo '<option value="' . htmlspecialchars($level['id']) . '">' . htmlspecialchars($level['nama']) . '</option>';
							}
							?>
						</select>
					</div>	   
			   <div class="col-md-12 mb-4">
						<label class="form-label bold">BULAN</label>
						  <select name="bulan"  class="form-select" style="width: 100%;" required >
							<option value=''>Pilih Bulan</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM bulan");
							$stmt->execute();
							while ($mt = $stmt->fetch(PDO::FETCH_ASSOC)) :
							?>
								<option value="<?= htmlspecialchars($mt['bln']) ?>"><?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?></option>
							<?php endwhile; ?>
						</select>   
					</div>
				<div class="text-end">
					<button type="submit" class="btn btn-primary">CETAK</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div> 
<?php endif; ?>		 