<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card card-header">
					<h5 class="card-title">KATEGORI PELANGGARAN</h5>
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="10%">NO</th>  												
							<th>NAMA KATEGORI</th>
							<th width="20%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$sql = "SELECT * FROM kategori_pelanggaran";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
							foreach ($result as $data):
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nama_kategori']); ?></td>
								<td>
									<a href="?pg=<?= enkripsi('kategori') ?>&idk=<?= $data['id_kategori'] ?>">
										<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
											<i class="material-icons">edit</i>
										</button>
									</a>

									<button 
										data-id="<?= $data['id_kategori'] ?>"  
										class="hapus btn btn-sm btn-danger" 
										data-bs-toggle="tooltip" 
										data-bs-placement="top" 
										title="Hapus"
									>
										<i class="material-icons">delete</i>
									</button>
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
$idk = $_GET['idk'] ?? '';
$stmt = $pdo->prepare("SELECT nama_kategori FROM kategori_pelanggaran WHERE id_kategori = :idk LIMIT 1");
$stmt->execute(['idk' => $idk]);
$kate = $stmt->fetch(PDO::FETCH_ASSOC);
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
				<input type="hidden" name="idk" value="<?= $idk ?>" >
				<?php if($idk===''): ?>
				<input type="hidden" name="ket" value="tambah" >
				<?php else: ?>
				<input type="hidden" name="ket" value="ubah" >
				<?php endif; ?>
			 <label class="bold">Kategori Pelanggaran</label>
				<div class="input-group mb-1">
					<input type='text' name='kate' value="<?= $kate['nama_kategori'] ?>" class='form-control' required>									   
				</div>	
				<div class="widget-payment-request-actions m-t-lg d-flex">
				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
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
		 url: 'master/tkate.php?pg=tambah',
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
			window.location.replace("?pg=<?= enkripsi('kategori') ?>");
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
		Swal.fire({
				  title: 'Yakin hapus data?',
				  text: "You won't be able to revert this!",
				  icon: 'warning',
				  width:'320px',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya, Hapus!',
				  cancelButtonText: "Batal"				  
		}).then((result) => {
			if (result.value) {
				$.ajax({
				url: 'master/tkate.php?pg=hapus',
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