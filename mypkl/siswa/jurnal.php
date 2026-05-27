<?php
defined('APK') or exit('No accsess');
	$kelas = $_GET['k'] ?? '';
	$bln = $_GET['b'] ?? '';
	$dudi = $_GET['d'] ?? '';

 ?>
<div class="row">
     <div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">CETAK JURNAL</h5>
			</div>
			<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
					 <tr>
					  <th>NO</th>
					 <th>NAMA SISWA</th>									  
					  <th>KELAS</th>                                         
					  <th></th>										 										 
					  </tr>
					  </thead>
					  <tbody>
						<?php
						$sql = "
							SELECT j.idsiswa, s.nama
							FROM pkl_jurnal j
							LEFT JOIN siswa s ON s.id_siswa = j.idsiswa
							WHERE j.dudi = ? AND j.kelas = ?
							GROUP BY j.idsiswa
						";
						$stmt = $pdo->prepare($sql);

						$stmt->execute([$dudi, $kelas]);

						$no = 0;
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']) ?></td>
							<td><?= htmlspecialchars($kelas) ?></td>
							<td>
								<a href="cetak/cetakjurnal.php?s=<?= $data['idsiswa'] ?>&b=<?= $bln ?>&d=<?= $dudi ?>" target="_blank" class="btn btn-sm btn-primary">
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
		 <div class="sw-13 position-relative mb-3">
			<img src="<?= $baseurl ?>/images/pkl.png" class="responsive-img" alt="thumb" />
			</div>
			<div class="h5 mb-0">PRAKERIN</div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			  <div class="text-muted">HIGH SCHOOL</div>
			</div>
				 <label class="bold">KELAS</label>
				 <div class="input-group mb-2">
				   <select  id="kelas" class="form-select" style="width:100%" required>
						<option value="">Pilih Kelas</option>
						<?php
							$stmt = $pdo->prepare("SELECT kelas FROM pkl_siswa GROUP BY kelas");
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { 
								$selected = ($kelas == $data['kelas']) ? 'selected' : '';
								?>
								<option value="<?= htmlspecialchars($data['kelas']) ?>" <?= $selected ?>>
									<?= htmlspecialchars($data['kelas']) ?>
								</option>
							<?php 
							} 
							?>
					</select>
				 </div>
				  <script type="text/javascript">
					$('#kelas').change(function() {
					var k = $('#kelas').val();										
					location.replace("?pg=<?= enkripsi('jurnal') ?>&k=" + k);
					}); 
				</script>									 
				  <label class="bold">LOKASI PRAKERIN</label>
				 <div class="input-group mb-2">
					<select  id="dudi" class="form-select" style="width:100%" required>
					<option value="">Pilih Dudi</option>
						<?php
							$stmt = $pdo->prepare("
								SELECT d.id, d.nama_dudi
								FROM pkl_siswa p
								LEFT JOIN pkl_dudi d ON d.id = p.dudi
								WHERE p.kelas = ?
								GROUP BY kelas
							");
							$stmt->execute([$kelas]);
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { 
								$selected = ($dudi == $data['id']) ? 'selected' : '';
								?>
								<option value="<?= htmlspecialchars($data['id']) ?>" <?= $selected ?>>
									<?= htmlspecialchars($data['nama_dudi']) ?>
								</option>
							<?php 
							} 
							?>
					</select>
				 </div>
				 <script type="text/javascript">
					$('#dudi').change(function() {
					var k = $('#kelas').val();
					var d = $('#dudi').val();										
					location.replace("?pg=<?= enkripsi('jurnal') ?>&k=" + k + "&d=" + d);
					}); 
				</script>
				 <label class="bold">BULAN</label>
				 <div class="input-group mb-2">
				   <select class="form-select" id="bulan" required style="width: 100%">
					<option value="">Pilih Bulan</option>
						<?php
						$stmt = $pdo->prepare("SELECT * FROM bulan");
						$stmt->execute();
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { 
							$selected = ($bln == $data['bln']) ? 'selected' : '';
							?>
							<option value="<?= htmlspecialchars($data['bln']) ?>" <?= $selected ?>>
								<?= htmlspecialchars($data['ket']) ?>
							</option>
						<?php 
						} 
						?>
					</select>
				 </div>
				<script type="text/javascript">
					$('#bulan').change(function() {
					var k = $('#kelas').val();
					var d = $('#dudi').val();
					var b = $('#bulan').val();
					location.replace("?pg=<?= enkripsi('jurnal') ?>&k=" + k + "&d=" + d + "&b=" + b);
					}); 
				</script>									 
				<div class="widget-payment-request-actions m-t-lg d-flex">
					
				   </div>
			   </div>
			</div>
		</div>
	</div>
						
					