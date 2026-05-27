<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">JENIS PEMBAYARAN</h5>
			</div>
			<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="9%">NO</th>  												
							<th>KODE</th>
							<th>TOTAL RP</th>
							<th>MODEL</th>													 
							<th>JML X</th>
							<th>JML BAYAR RP</th>
							<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$stmt = $pdo->prepare("SELECT * FROM m_bayar");
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['kode']) ?></td>
								<td><?= 'Rp ' . number_format($data['total'], 0, ',', '.'); ?></td>

								<td>
									<?php if ($data['model'] == 1): ?>
										Sekali Bayar
									<?php else: ?>
										Angsuran
									<?php endif; ?>
								</td>
								<td><?= htmlspecialchars($data['jumlah']) ?> X</td>
								<td><?= 'Rp ' . number_format($data['angsuran'], 0, ',', '.'); ?></td>
								<td>
									<button 
										data-id="<?= $data['id'] ?>"  
										class="hapus btn btn-sm btn-danger" 
										data-bs-toggle="tooltip" 
										data-bs-placement="top" 
										title="Hapus">
										<i class="material-icons">delete</i>
									</button>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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
					<form id='formkate' >	
					<label class="bold">Kode</label>
						<div class="input-group mb-1">
                            <input type='text' name='kode' class='form-control' required='true' />									   
                                </div>	
					<label class="bold">Nama Pembayaran</label>
						<div class="input-group mb-1">
                            <input type='text' name='nama' class='form-control' required='true' />
                                </div>
					<label class="bold">Total Pembayaran Rp</label>
						<div class="input-group mb-1">
                            <input type='text' name='total' id="duit" class='form-control' required='true' autocomplete="off">
                                 </div>
					<label class="bold">Model Pembayaran</label>
						<div class="input-group mb-1">
                            <select name="model" id="model" class="form-select" style="width:100%" required>
							    <option value="">Pilih Model</option>
								<option value="1">Sekali Bayar</option>
								<option value="2">Bulanan</option>
							</select>
                           </div>
					<div class='col-md-12 mb-1'>
						<label class="bold">JUMLAH ANGSURAN</label>
							<select class="form-select" name="jumlah" id="jumlah" required style="width: 100%">
								<?php
								$angka = range(1, 12); 
								foreach ($angka as $jml):
								?>
								<option value="<?= $jml; ?>"><?= $jml; ?> X</option>
							<?php endforeach; ?>
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
$('#formkate').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		url: 'master/tjenis.php?pg=tambah',
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
			}else{
				 Swal.fire({
					icon: 'error',
					width:'320px',
					title: 'Error!',
					text: 'Kode Pembayaran sudah Ada'
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
<?php endif; ?>
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
