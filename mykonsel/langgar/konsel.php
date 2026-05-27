<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card card-header">
					<h5 class="card-title">PEMBINAAN SISWA</h5>
					
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="10%">NO</th> 												
							<th>NAMA SISWA</th>
							<th>KELAS</th>
							<th>POIN</th>
							<th>TEGURAN</th>
							<th width="18%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$sql = "
								SELECT 
									s.id_siswa,
									s.nama,
									s.kelas,
									s.total_poin,
									t.id_teguran,
									t.jenis_teguran,
									t.min_poin,
									t.max_poin
								FROM siswa AS s
								JOIN teguran AS t
									ON s.total_poin BETWEEN t.min_poin AND t.max_poin
								ORDER BY s.total_poin DESC
							";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

							foreach ($result as $data):
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= ucwords(strtolower(htmlspecialchars($data['nama']))); ?></td>
								<td><?= htmlspecialchars($data['kelas']); ?></td>
								<td><?= htmlspecialchars($data['total_poin']); ?></td>
								<td><?= htmlspecialchars($data['jenis_teguran']); ?></td>
								<td>
									<?php if($data['id_teguran'] > 1): ?>
										<a href="cetak/surat.php?s=<?= $data['id_siswa'] ?>&t=<?= $data['id_teguran'] ?>" target="_blank">
											<button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Cetak Surat">
												<i class="material-icons">print</i>
											</button>
										</a>
									<?php else: ?>
										<button class="btn btn-sm btn-secondary" disabled>
											<i class="material-icons">lock</i>
										</button>
									<?php endif; ?>

									<?php if($user['walas'] == $data['kelas'] || $user['level'] == 'admin'): ?>
										<a href="?pg=<?= enkripsi('konseling') ?>&ids=<?= $data['id_siswa'] ?>">
											<button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Pembinaan">
												<i class="material-icons">add</i>
											</button>
										</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; $stmt = null; ?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php
$idsiswa = $_GET['ids'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :idsiswa LIMIT 1");
$stmt->execute(['idsiswa' => $idsiswa]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null; 
?>
<div class="col-md-4">
	<div class="card">                                
	<div class="card-body">
		<div class="d-flex align-items-center flex-column mb-4">
		 <div class="sw-13 position-relative mb-3">
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
			</div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			  <div class="text-muted">HIGH SCHOOL</div>
			</div>
			<form id='formkate' >
			  <input type="hidden" name="ids" value="<?= $siswa['id_siswa'] ?>" >
			  <input type="hidden" name="poin" value="<?= $siswa['total_poin'] ?>" >
			  <input type="hidden" name="teguran" value="<?= $siswa['id_teguran'] ?>" >
			  <label class="bold">Nama Siswa</label>
				<div class="input-group mb-1">
					<input type="text" value="<?= ucwords(strtolower($siswa['nama'])) ?>" class="form-control" >
			  </div>
			  <label class="bold">Catatan dalam Pembinaan</label>
				<div class="input-group mb-1">
					<textarea name="catat" class="form-control" rows="4" required></textarea>
			  </div>
			  <label class="bold">Tindak Lanjut</label>
				<div class="input-group mb-1">
					<textarea name="tindak" class="form-control" rows="4" required></textarea>
			  </div>
				<div class="widget-payment-request-actions m-t-lg d-flex">
					<?php if($idsiswa !=''): ?>
						<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				   <?php endif; ?>
					</div>
				</form>
			 </div>
		</div>
	</div>
</div>
<script>
$('#formkate').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'langgar/tkonseling.php',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(function()
			{
			window.location.reload();
			}, 200);
								  
			}
		});
		return false;
	});
</script>	
<script>
		$('#datatable1').on('click', '.hapus', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
				  title: 'Yakin hapus data?',
				  text: "You won't be able to revert this!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya, Hapus!',
				  cancelButtonText: "Batal"				  
		}).then((result) => {
			if (result.value) {
				$.ajax({
				url: 'master/tjenis.php?pg=hapus',
				method: "POST",
				data: 'id=' + id,							
				success: function(data) {
				$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>'); 
				setTimeout(function() {
				window.location.reload();
						}, 200);
					}
				});
			}
			return false;
		})
	});
</script> 