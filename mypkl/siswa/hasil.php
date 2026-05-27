<?php
defined('APK') or exit('No accsess');
$kelas = $_GET['k'] ?? '';
$dudi = $_GET['d'] ?? '';
?> 		

<div class="row">
  <div class="col-md-8">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">CETAK NILAI</h5>
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
									SELECT p.*, s.nama, s.kelas
									FROM pkl_nilai p 
									LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
									WHERE p.kelas = ? AND p.iddudi = ?
									GROUP BY p.idsiswa
								";

								$stmt = $pdo->prepare($sql);
								$stmt->execute([$kelas, $dudi]); // Kirim parameter sebagai array

								$no = 0;
								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
									$no++;
								?>
								<tr style="vertical-align:middle;">
									<td class="text-center"><?= $no; ?></td>
									<td><?= htmlspecialchars($data['nama']) ?></td>
									<td><?= htmlspecialchars($data['kelas']) ?></td>
									<td>
										<a href="cetak/cetak3.php?ids=<?= htmlspecialchars($data['idsiswa']) ?>" target="_blank" class="btn btn-sm btn-success">
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
				 <div class="col-md-12 mb-1">
					<label class="bold">Tempat Prakerin (DUDI)</label>
					<select  id="dudi" class="form-select" style="width:100%" required>
						<option value="">Pilih Dudi</option>
							<?php
							$stmt = $pdo->prepare("SELECT id, nama_dudi FROM pkl_dudi");
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$selected = ($dudi == $data['id']) ? 'selected' : '';
								?>
								<option value="<?= htmlspecialchars($data['id']) ?>" <?= $selected; ?>>
									<?= htmlspecialchars($data['nama_dudi']) ?>
								</option>
							<?php
							}

							?>
					  </select>
					</div>
						  <script type="text/javascript">
							$('#dudi').change(function() {
							var d = $('#dudi').val();	
							location.replace("?pg=<?= enkripsi('cetakhasil') ?>&d=" + d);
							}); 
						</script>
						 <div class="col-md-12 mb-1">
							<label class="bold">Kelas</label>
							<select  id="kelas" class="form-select" style="width:100%" required>
							<option value="">Pilih Kelas</option>
							<?php
								$stmt = $pdo->prepare("SELECT kelas FROM pkl_siswa WHERE dudi = ? GROUP BY kelas");
								$stmt->execute([$dudi]); 
								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$selected = ($kelas == $data['kelas']) ? 'selected' : '';
									?>
									<option value="<?= htmlspecialchars($data['kelas']) ?>" <?= $selected; ?>>
										<?= htmlspecialchars($data['kelas']) ?>
									</option>
								<?php
								}
								?>
						    </select>
						</div>
				<script type="text/javascript">
				$('#kelas').change(function() {
				var d = $('#dudi').val();
				var k = $('#kelas').val();										
				location.replace("?pg=<?= enkripsi('cetakhasil') ?>&k=" + k + "&d=" + d);
				}); 
			</script>
		   </div>
		</div>
	</div>
</div>
					