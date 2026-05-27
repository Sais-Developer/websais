<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">CATATAN PELANGGARAN SISWA</h5>
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="10%">NO</th>
							<th>TANGGAL</th>  												
							<th>NAMA SISWA</th>
							<th>KELAS</th>
							<th>POIN</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$sql = "
								SELECT * 
								FROM catatan_pelanggaran c
								LEFT JOIN siswa s ON s.id_siswa = c.id_siswa 
								WHERE c.status = '0'
								ORDER BY c.id DESC
							";

							$stmt = $pdo->prepare($sql); // gunakan $pdo
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll untuk PDO

							foreach ($result as $data):
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['tanggal']); ?></td>
								<td><?= htmlspecialchars($data['nama']); ?></td>
								<td><?= htmlspecialchars($data['kelas']); ?></td>
								<td><?= htmlspecialchars($data['poin']); ?></td>
							</tr>
							<?php endforeach; ?>
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
					<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
					</div>
				<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
					  <div class="text-muted">HIGH SCHOOL</div>
					</div>
					<form id='formkate' >	
					 <label class="bold">Kategori Pelanggaran</label>
					  <div class="input-group mb-1">
					  <select name="idkate" id="idkate" class='form-select' style='width:100%' required="true" >                                          
						 <option value="">Pilih Kategori</option>
						 <?php
							$sql = "SELECT * FROM kategori_pelanggaran";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$kategoriList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($kategoriList as $data): 
							?>
								<option value="<?= htmlspecialchars($data['id_kategori']); ?>">
									<?= htmlspecialchars($data['nama_kategori']); ?>
								</option>
							<?php endforeach; $stmt = null; ?>
						</select>
					  </div>
					<label class="bold">Jenis Pelanggaran</label>
					  <div class="input-group mb-1">
						<select name="idpel" id="idpel" class='form-select' style='width:100%' required="true" >                                          			                                           
						</select>
					  </div>
					<label class="bold">Kelas</label>
					  <div class="input-group mb-1">
						<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true" >                                          
						 <option value="">Pilih Kelas</option>
						 <?php
							$sql = "SELECT kelas FROM m_kelas";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($kelasList as $data): 
							?>
								<option value="<?= htmlspecialchars($data['kelas']); ?>">
									<?= htmlspecialchars($data['kelas']); ?>
								</option>
							<?php endforeach; $stmt = null; ?>		                                           
						</select>
					  </div>
					   <label class="bold">Nama Siswa</label>
					  <div class="input-group mb-1">
					  <select name="idsiswa" id="idsiswa" class='form-select' style='width:100%' required="true" >                                          			                                           
						</select>
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
$("#idkate").change(function() {
var idkate = $(this).val();					
console.log(idkate);
$.ajax({
	type: "POST",
	url: "langgar/ambildata.php?pg=langgar", 
	data: "idkate=" + idkate, 
	success: function(response) { 
		$("#idpel").html(response);
		console.log(response);
	},
	error: function(xhr, status, error) {
		console.log(error);
	}
});
});
$("#kelas").change(function() {
var kelas = $(this).val();					
console.log(kelas);
$.ajax({
	type: "POST",
	url: "langgar/ambildata.php?pg=siswa", 
	data: "kelas=" + kelas, 
	success: function(response) { 
		$("#idsiswa").html(response);
		console.log(response);
	},
	error: function(xhr, status, error) {
		console.log(error);
	}
});
});
</script>
<script>
$('#formkate').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'langgar/simpan.php',
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