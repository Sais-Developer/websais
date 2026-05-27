<?php
defined('APK') or exit('NO ACCESS');
?>           
    <div class="row">
		  <div class="col-md-8">
				<div class="card">
					<div class="card card-header">
						<h5 class="card-title">TUGAS LAINNYA</h5>										
					</div>
					<div class="card-body">									
					<div class="card-box table-responsive">
						<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
							<thead>
							<tr>
							<th width="9%">NO</th>  	
							<th>PENERIMA</th>
							<th>TUGAS</th>
							<th>JUMLAH</th>  
							<th></th>
							</tr>
							</thead>
							<tbody>
							<?php
								$no = 0;
								$sql = "SELECT p.id_lain, p.tugas, p.besar, g.nama
										FROM pay_lain p
										LEFT JOIN guru g ON g.id_guru = p.idpeg";

								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($results as $data):
									$no++;
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars($data['nama']); ?></td>
									<td><?= htmlspecialchars($data['tugas']); ?></td>
									<td><?= 'Rp ' . number_format($data['besar'], 0, ',', '.'); ?></td>
									<td>
										<button data-id="<?= $data['id_lain']; ?>" class="hapus btn btn-sm btn-danger" 
												data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
		<?php if ($ac == '') : ?>
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
					<form id='formlain' >
					<div class="col-md-12 mb-2">
						<label class="bold">Nama Tugas Lainnya</label>				  
					   <input type='text' name='tugas' class='form-control' required='true' />                            
						</div>
					<div class="col-md-12 mb-2">									
					<label class="bold">Nama Penerima</label>
					  <select name="guru" id="guru" class='form-select guru' style='width:100%' required="true" >                                          
						<option value="">Pilih Pegawai</option>  
							<?php
								$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru");
								$stmt->execute();
								$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($gurus as $data): ?>
									<option value="<?= htmlspecialchars($data['id_guru']); ?>"><?= htmlspecialchars($data['nama']); ?></option>
								<?php endforeach; ?>			                                           
						</select>
					  </div>	
					 <div class="col-md-12 mb-2">
						<label class="bold">Honor Flat per Bulan</label>				  
					   <input type='text' name='besar' id="duit" class='form-control' required='true' >                            
					</div>	 								
					<div class="widget-payment-request-actions m-t-lg d-flex">
						  <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					    </div>
					</form>
			    </div>
		   </div>
	  </div>
  </div>
 <?php endif ?>
	
<script>
var duit = document.getElementById('duit');
	duit.addEventListener('keyup', function(e)
	{
		duit.value = formatRupiah(this.value);
	});
	  function formatRupiah(angka, prefix)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split    = number_string.split(','),
			sisa     = split[0].length % 3,
			rupiah     = split[0].substr(0, sisa),
			ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
</script>
<script>
	$('#formlain').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: 'lainnya/thonor.php?pg=gaji',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				
					$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');	
					setTimeout(function() {
						window.location.reload();
					}, 500); 
				
			},
			
		})
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
	  width: '320px',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya, Hapus!',
	  cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
			$.ajax({
			url: 'lainnya/thonor.php?pg=hapus',
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