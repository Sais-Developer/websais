<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
<div class="col-md-8">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">JENIS PELANGGARAN</h5>
		</div>
		<div class="card-body">									
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
				<thead>
					<tr>
					<th width="10%">NO</th>  												
					<th>KATEGORI</th>
					<th>PELANGGARAN</th>
					<th>POIN</th>
					<th width="20%"></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no = 0;
					$sql = "
						SELECT p.*, k.nama_kategori 
						FROM pelanggaran p
						LEFT JOIN kategori_pelanggaran k 
							ON p.id_kategori = k.id_kategori
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					?>
					<?php foreach ($result as $data): $no++; ?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= htmlspecialchars($data['nama_kategori']); ?></td>
					<td><?= htmlspecialchars($data['nama_pelanggaran']); ?></td>
					<td><?= $data['poin']; ?></td>

					<td>
						<a href="?pg=<?= enkripsi('jenis') ?>&id=<?= $data['id'] ?>">
							<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
								<i class="material-icons">edit</i>
							</button>
						</a>

						<button 
							data-id="<?= $data['id'] ?>" 
							class="hapus btn btn-sm btn-danger" 
							data-bs-toggle="tooltip" 
							data-bs-placement="top" 
							title="Hapus"
						>
							<i class="material-icons">delete</i>
						</button>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>											
				</table>
			</div>
		</div>
	</div>
</div>
<?php
$id = $_GET['id'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM pelanggaran WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$jenis = $stmt->fetch(PDO::FETCH_ASSOC);  
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
				<input type="hidden" name="id" value="<?= $id ?>" >
					<?php if($id===''): ?>
					<input type="hidden" name="ket" value="tambah" >
					<?php else: ?>
				    <input type="hidden" name="ket" value="ubah" >
					<?php endif; ?>
				<label class="bold">Kategori Pelanggaran</label>
					<div class="input-group mb-1">
						<select name="idkate" id="idkate" class='form-select' style='width:100%' required="true" >                                          
								<?php
									if ($id == '') {
										$stmt = $pdo->prepare("SELECT * FROM kategori_pelanggaran");
										$stmt->execute();
									} else {
										$stmt = $pdo->prepare("
											SELECT * FROM kategori_pelanggaran 
											WHERE id_kategori = :idk
										");
										$stmt->execute(['idk' => $jenis['id_kategori']]);
									}
									$kategori = $stmt->fetchAll(PDO::FETCH_ASSOC);
									?>
									<?php foreach ($kategori as $data): ?>
										<option value="<?= $data['id_kategori'] ?>">
											<?= htmlspecialchars($data['nama_kategori']) ?>
										</option>
									<?php endforeach; ?>
                                   </select>
							   </div>
							<label class="bold">Jenis Pelanggaran</label>
								<div class="input-group mb-1">
                                       <input type='text' name='pelanggaran' value="<?= $jenis['nama_pelanggaran'] ?>" class='form-control' required>									   
                                        </div>	
							<label class="bold">Poin Pelanggaran</label>
								<div class="input-group mb-1">
                                       <input type='number' name='poin' value="<?= $jenis['poin'] ?>" class='form-control' required>									   
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
	 url: 'master/tjenis.php?pg=tambah',
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
		window.location.replace("?pg=<?= enkripsi('jenis') ?>");
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