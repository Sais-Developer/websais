<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
<div class="row">
  <div class="col-md-8">
   <div class="card">
	<div class="card-header">
		<h5 class="card-title">TANGGAL RAPOR</h5>										
	</div>
    <div class="card-body">
		<table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
			<thead>
				<tr>
				  <th width="10%">NO</th>												  												 
				  <th>SMT</th>
				  <th>TAPEL</th>
				  <th>TANGGAL</th>
				  <th>KET</th>	
				  <th></th>	
				</tr>
			</thead>											
			<tbody>	
			<?php
				$no = 0;
				$query = "
					SELECT *
					FROM tanggal_rapor
					WHERE semester = ? AND tapel = ?
				";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$semester, $tapel]);

				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$no++;
				?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= htmlspecialchars($data['semester']); ?></td>
					<td><?= htmlspecialchars($data['tapel']); ?></td>
					<td><?= htmlspecialchars($data['tanggal']); ?></td>
					<td><?= htmlspecialchars($data['ket']); ?></td>
					<td>
						<button data-id="<?= $data['id']; ?>" 
								class="hapus btn btn-sm btn-danger" 
								data-bs-toggle="tooltip" 
								data-bs-placement="top" 
								title="Hapus">
							<i class="material-icons">delete</i>
						</button>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
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
                <div class="text-muted"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
			</div>
			<form id="formtanggal">
			<div class="col-md-12 mb-1">
			  <label class="bold">Semester</label>
				<select name="smt"  class='form-select' style='width:100%' required="true" > 
				<option value="<?= $semester ?>"><?= $semester ?></option>
				</select>
			   </div>
			<div class="col-md-12 mb-1">
			  <label class="bold">Tahun Pelajran</label>
				<select name="tapel"  class='form-select' style='width:100%' required="true" > 
				<option value="<?= $tapel ?>"><?= $tapel ?></option>
				</select>
			   </div>
			   <div class="col-md-12 mb-1">
			   <label class="bold">Penilaian</label>
				 <select name="ket" id="ket" class='form-select' style='width:100%' required="true" >                                         
					<option value="">Pilih Penialain</option> 
					<option value="PTS">PTS</option> 
					<?php if($setting['semester']=='1'): ?>
					<option value="PAS">PAS</option> 
					<?php else: ?>
					<option value="PAT">PAT</option> 
					<?php endif; ?>
					</select>
				</div>
				<div class="col-md-12 mb-1">
				   <label class="bold">Tanggal Rapor</label>
					<input type="text" name="tanggal" class="form-control" required>	
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
					 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php endif ?>
	<script>
	$('#formtanggal').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: 'trapor.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				if(response === "OK") {
					$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');	
					setTimeout(function() {
						window.location.reload();
					}, 500); 
				} else {
				iziToast.error({
						title: 'Error!',
						message: 'Sudah diinput',
						titleColor: '#FFFF00',
						messageColor: '#fff',
						backgroundColor: 'rgba(0, 0, 0, 0.5)',
						progressBarColor: '#FFFF00',
						position: 'topRight',
						timeout: 5000
					});
				}
			},
			error: function(xhr, status, error) {
				
				alert("An error occurred: " + error);
			}
		})
		return false;
	});
	</script>

					            
	<script>
	$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
		console.log(id);
		Swal.fire({
		title: 'Hapus Data',
		text: "Hapus Tanggal Rapor",
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
		url: 'hapus.php',
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

					  	  
					  
					  
					