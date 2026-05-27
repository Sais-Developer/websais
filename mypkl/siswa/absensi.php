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
				<h5 class="card-title">CETAK PRESENSI</h5>
					</div>
				<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
					 <tr>
					  <th>NO</th>
					 <th>TANGGAL - JAM</th>									  
					  <th>NAMA SISWA</th>                                         
					  <th>KET</th>										 										 
					  </tr>
					  </thead>
					  <tbody>
						<?php
							$sql = "
								SELECT MONTH(a.tanggal) AS bulan, a.tanggal, a.jam_masuk, a.ket, s.nama
								FROM pkl_presensi a
								LEFT JOIN pkl_jurnal j ON j.tanggal = a.tanggal AND j.idsiswa = a.idsiswa
								LEFT JOIN siswa s ON s.id_siswa = a.idsiswa
								WHERE MONTH(a.tanggal) = :bln AND j.dudi = :dudi AND j.kelas = :kelas
							";

							$stmt = $pdo->prepare($sql);
							$stmt->execute([
								'bln'   => $bln,
								'dudi'  => $dudi,
								'kelas' => $kelas
							]);

							$no = 0;
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$no++;
								?>
								<tr>
									<td><?= $no ?></td>
									<td><?= htmlspecialchars($data['jam_masuk']) ?></td>
									<td><?= htmlspecialchars($data['nama']) ?></td>
									<td><?= htmlspecialchars($data['ket']) ?></td>
								</tr>
								<?php
							}
							?>
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
							$stmt = $pdo->query("SELECT kelas FROM pkl_siswa GROUP BY kelas");
							$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($results as $data) {
								$selected = ($kelas == $data['kelas']) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($data['kelas']) . '" ' . $selected . '>' . htmlspecialchars($data['kelas']) . '</option>';
							}
							?>
					</select>
				 </div>
				  <script type="text/javascript">
					$('#kelas').change(function() {
					var k = $('#kelas').val();										
					location.replace("?pg=<?= enkripsi('presensi') ?>&k=" + k);
					}); 
				</script>									 
				  <label class="bold">LOKASI PRAKERIN</label>
				 <div class="input-group mb-2">
				 <select  id="dudi" class="form-select" style="width:100%" required>
					<option value="">Pilih Dudi</option>
						<?php
						$sql = "
							SELECT d.id, d.nama_dudi
							FROM pkl_siswa p
							LEFT JOIN pkl_dudi d ON d.id = p.dudi
							WHERE p.kelas = :kelas
							GROUP BY d.id, d.nama_dudi
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute(['kelas' => $kelas]);
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($results as $data) {
							$selected = ($dudi == $data['id']) ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($data['id']) . '" ' . $selected . '>' . htmlspecialchars($data['nama_dudi']) . '</option>';
						}
						?>
					</select>
				 </div>
				 <script type="text/javascript">
					$('#dudi').change(function() {
					var k = $('#kelas').val();
					var d = $('#dudi').val();										
					location.replace("?pg=<?= enkripsi('presensi') ?>&k=" + k + "&d=" + d);
					}); 
				</script>
				 <label class="bold">BULAN</label>
				 <div class="input-group mb-2">
				   <select class="form-select" id="bulan" required style="width: 100%">
					<option value="">Pilih Bulan</option>
						<?php
							$sql = "SELECT * FROM bulan";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($results as $data) {
								$selected = ($bln == $data['bln']) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($data['bln']) . '" ' . $selected . '>' . htmlspecialchars($data['ket']) . '</option>';
							}
							?>
					</select>
				 </div>
				<script type="text/javascript">
					$('#bulan').change(function() {
					var k = $('#kelas').val();
					var d = $('#dudi').val();
					var b = $('#bulan').val();
					location.replace("?pg=<?= enkripsi('presensi') ?>&k=" + k + "&d=" + d + "&b=" + b);
					}); 
				</script>									 
				<div class="widget-payment-request-actions m-t-lg d-flex">
					<?php if($bln !='' AND $dudi !=''): ?>
					<a href="cetak/cetakabsen.php?k=<?= $kelas ?>&b=<?= $bln ?>&d=<?= $dudi ?>" target="_blank"  class="btn btn-success flex-grow-1 m-l-xxs">CETAK</a>
					<?php endif; ?>
				   </div>
					
			   </div>
			</div>
		</div>
	</div>
	
					