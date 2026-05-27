<?php defined('APK') or die('No Access'); ?> 		
<div class="row">
  <div class="col-md-8">
     <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">       
    <h5 class="card-title mb-0">BELL SEKOLAH OTOMATIS</h5>
    <span class="badge badge-dark">Mesin Multi Presensi</span>
     </div>
		<div class="card-body">
			<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>
							<th>NO</th>
							<th>HARI</th>
							<th>JAM</th>
							<th>NADA BEL</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$sql = "
								SELECT 
									b.*, 
									n.*,         
									h.*  
								FROM bell b
								LEFT JOIN bell_nada n ON n.idb = b.nada
								LEFT JOIN m_hari h ON h.inggris = b.hari
							";

							$stmt = $pdo->query($sql);

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
							?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $data['hari'] ?? '-' ?></td>
							<td><?= $data['jam'] ?></td>
							<td><?= ucwords(strtolower($data['nama'])) ?? '-' ?></td>
							<td>
								<a href="?pg=<?= enkripsi('bell') ?>&ac=<?= enkripsi('edit') ?>&id=<?= enkripsi($data['id']) ?>"
									class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
									<i class="material-icons">edit</i>
								</a>
								<button data-id="<?= $data['id'] ?>" class="hapus btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
		  title: 'Hapus Data',
		  text: "Hapus Data Bell",
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
			   url: 'tbell.php?pg=hapus',
				method: "POST",
				data: 'id=' + id,
				beforeSend: function() {
				$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
				
				},
				success: function(data) {
				setTimeout(function() {
				window.location.reload();
					}, 100);
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
		<div class="card-header">
		    </div>
		<div class="card-body">
		<div class="d-flex align-items-center flex-column mb-4">
				<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
			</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
			 <div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id="formbell">	
				<label class="bold">HARI</label>
				<div class="input-group mb-1">
					<select name="hari" class="form-select" required>
						<option value="">Pilih Hari</option>
						<?php 
							$stmt = $pdo->query("SELECT * FROM m_hari");
							while ($hari = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= $hari['inggris'] ?>"><?= $hari['hari'] ?></option>
							<?php endwhile ?>
					</select>
				</div>	

				<label class="bold">JAM</label>
				<div class="input-group mb-1">
					<input type="text" name="jam" class="timer form-control" required autocomplete="off" />
				</div>

				<label class="bold">NADA BELL</label>
				<div class="input-group mb-1">
					<select name="nada" class="form-select" required>
						<option value="">Pilih Nada</option>
						<?php 
							$stmt = $pdo->query("SELECT * FROM bell_nada");
							while ($nd = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= $nd['idb'] ?>">
									<?= ucwords(strtolower($nd['nama'])) ?>
								</option>
							<?php endwhile ?>
					</select>
				</div>			
				<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
					<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				</div>
			</form>
		<div class="mb-2">
		<p class="text-small text-muted mb-2">ALAMAT</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">home</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">star</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['desa'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">sync</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
		</div>
	  </div>
	  <div class="mb-2">
		<p class="text-small text-muted mb-2">CONTACT</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">phone</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">inbox</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['email'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
	  <div class="mb-0">
		<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			 <i class="material-icons text-info" style="font-size:18px">person</i>
			</div>
		  </div>
		  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">payment</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nip'] ?></div>
		</div>
	  </div>
	</div>
  </div>             
</div>					
</div>
	

<script>
$('#formbell').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		url: 'tbell.php?pg=tambah',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},			
		success: function(data){  			
			setTimeout(function(){ window.location.reload(); }, 200);
		}
	});
});
</script>	

<?php elseif ($ac == enkripsi('edit')): ?>	
<?php
$id = dekripsi($_GET['id'] ?? '');
$sql = "
    SELECT 
        b.*, 
        h.hari AS nama_hari,
        n.nama,
        n.idb 
    FROM bell b
    LEFT JOIN m_hari h ON h.inggris = b.hari
    LEFT JOIN bell_nada n ON n.idb = b.nada
    WHERE b.id = :id
    LIMIT 1
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);
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
			<form id="formedit">	
				<input type="hidden" name="id" value="<?= $id ?>" >
				
				<label class="bold">HARI</label>
				<div class="input-group mb-1">
					<select name="hari" class="form-select" required>
						<option value="<?= $data['hari'] ?>"><?= $data['nama_hari'] ?? '' ?></option>
						<option value="">Pilih Hari</option>
						<?php 
							$stmt = $pdo->query("SELECT * FROM m_hari");
							while ($hari = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= $hari['inggris'] ?>"><?= $hari['hari'] ?></option>
							<?php endwhile ?>
					</select>
				</div>	

				<label class="bold">JAM</label>
				<div class="input-group mb-1">
					<input type="text" name="jam" class="timer form-control" value="<?= $data['jam'] ?>" required />
				</div>

				<label class="bold">NADA BELL</label>
				<div class="input-group mb-1">
					<select name="nada" class="form-select" required>
						<option value="<?= $data['nada'] ?>"><?= ucwords(strtolower($data['nama'])) ?? '' ?></option>
						<option value="">Pilih Nada</option>
						<?php 
							$stmt = $pdo->query("SELECT * FROM bell_nada");
							while ($nd = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= $nd['idb'] ?>">
									<?= ucwords(strtolower($nd['nama'])) ?>
								</option>
							<?php endwhile ?>
					</select>
				</div>
			
				<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
					<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				</div>
			</form>
		<div class="mb-2">
		<p class="text-small text-muted mb-2">ALAMAT</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">home</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">star</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['desa'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">sync</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
		</div>
	  </div>
	  <div class="mb-2">
		<p class="text-small text-muted mb-2">CONTACT</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">phone</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">inbox</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['email'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
	  <div class="mb-0">
		<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			 <i class="material-icons text-info" style="font-size:18px">person</i>
			</div>
		  </div>
		  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
		</div>
		<div class="row g-0 mb-2">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">payment</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nip'] ?></div>
		</div>
	  </div>
	</div>
  </div>             
</div>					


<script>
$('#formedit').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		url: 'tbell.php?pg=edit',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},			
		success: function(data){  			
			setTimeout(function(){ window.location.replace('?pg=<?= enkripsi("bell") ?>'); }, 200);
		}
	});
});
</script>	
<?php endif ?>
