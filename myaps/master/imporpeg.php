<?php
defined('APK') or exit('No accsess');
?>       
<div class="row">
  <div class="col-xl-8" >
       <div class="card" >
	   <div class="card-header d-flex justify-content-between align-items-center">
			<h5 class="card-title mb-0">DATA PENDIDIK</h5>
			<a href="?pg=<?= enkripsi('imporpeg') ?>&ac=<?= enkripsi('tambah') ?>" class="btn btn-light d-flex align-items-center">
				<i class="material-icons me-1">add</i> Guru
			</a>
		</div>			
		<div class="card-body">
			<div class="card-box table-responsive">
			   <table id="datatable1" class="table table-bordered table-hover">
				   <thead>
					<tr>
					<th width="8%">NO</th>
					<th>NAMA GURU</th>
					<th>WALAS</th>
					<th>FOTO</th>
					<th width="20%"></th>
					</tr>
				   </thead>
				   <tbody>
					<?php
					$no = 0;
					$level = 'guru';
					$stmt = $db->prepare("SELECT * FROM guru WHERE level = :level");
					$stmt->execute(['level' => $level]);
					$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($gurus as $data):
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['nama']) ?></td>
						<td><?= htmlspecialchars($data['walas']) ?></td>
						<td>
							<?php if (empty($data['foto'])): ?>
								<img src="../images/user.png" class="table-img">
							<?php else: ?>
								<img src="../images/fotoguru/<?= htmlspecialchars($data['foto']) ?>" class="table-img">
							<?php endif; ?>
						</td>
						<td>
						<a href="master/cetak.php?idguru=<?= $data['id_guru'] ?>" target="_blank"
							   class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Cetak Akun">
								<i class="material-icons">print</i>
							</a>
							<a href="?pg=<?= enkripsi('imporpeg') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_guru']) ?>"
							   class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
								<i class="material-icons">edit</i>
							</a>
							<button data-id="<?= $data['id_guru'] ?>"  
									class="hapus btn btn-sm btn-danger" 
									data-bs-toggle="tooltip" 
									title="Hapus">
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
<script>
$('#datatable1').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'master/tguru.php?pg=hapus',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporpeg') ?>"), 1200);
        }
      });
    }
  });
});
</script>
<?php if (($ac ?? '') == ''): ?>
<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-4">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
     <div class="widget-payment-request-info m-t-md"> 	
      	<a href="master/M_GURU.xlsx" class="btn btn-sm btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
				<i class="material-icons">download</i> Format
			</a>	 
		<form id="formguru">
		<label class="bold">Pilih File</label>			            
		<div class="input-group mb-3">
		  <input type='file' name='file' id="fileInput" class='form-control' required accept=".xlsx">
			<span class="input-group-text">
				<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
				</span>
			</div>	
		</form>
	</div>                  
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
$('#formguru').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'master/import_pegawai.php',
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
</script>	
<?php elseif($ac == enkripsi('edit')): ?>
<?php
$idguru = dekripsi($_GET['ids'] ?? '');
if (!empty($idguru)) {
    $stmt = $db->prepare("SELECT * FROM guru WHERE id_guru = :id");
    $stmt->execute(['id' => $idguru]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $data = null;
}
?>

<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div> 
	<div class="widget-payment-request-info m-t-md"> 
		<form id="formedit" class="row g-2">
		<input type="hidden" name="idguru" value="<?= $data['id_guru'] ?>" class="form-control" >	            
		<div class="col-md-12">
		<label class="bold">NIP</label>
		  <input type="text" name="nip" value="<?= $data['nip'] ?>" class="form-control"  >
			</div>	
		<div class="col-md-12">
		<label class="bold">Nama Guru</label>	
		  <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" required >
			</div>    
		<div class="col-md-12">
		<label class="bold">Jabatan</label>
		  <input type="text" name="jabatan" value="<?= $data['jabatan'] ?>" class="form-control" required >
			</div>					            
		<div class="col-md-12">	
		<label class="bold">Wali Kelas</label>
			<select class="form-select" name="walas" required style="width: 100%">
				<option value="<?= htmlspecialchars($data['walas']) ?>"><?= htmlspecialchars($data['walas']) ?></option>
				<?php
					$stmt = $db->query("SELECT kelas FROM m_kelas");
					while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$val = htmlspecialchars($kelas['kelas']);
						echo "<option value='$val'>$val</option>";
					}
				?>
			</select>
			</div>
        <div class="col-md-6">		
		<label class="bold">Username</label>
		  <input type="text" name="username" value="<?= $data['username'] ?>" class="form-control" readonly >
			</div>				
		<div class="col-md-6">		
		<label class="bold">Password</label>
		  <input type="text" name="password" value="<?= $data['password'] ?>" class="form-control"  required >
			</div>				
		<div class="col-md-12">	
		<label class="bold">Nomor WA</label>
			<input type="text" name="nowa" value="<?= $data['nowa'] ?>" class="form-control" required >
			</div>
        <div class="col-md-12 mb-3">	
		<label class="bold">Foto</label>
			<input type="file" name="file"  class="form-control" >
			</div>
        <div class="d-flex justify-content-end align-items-center mb-3">
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>		
		</form>
       </div>
	</div>
	</div>
  </div>             
<script>
$('#formedit').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'master/tguru.php?pg=edit',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporpeg') ?>"), 500);  
			}
		});
		return false;
	});
</script>	
<?php elseif($ac == enkripsi('tambah')): ?>
<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div> 
	<div class="widget-payment-request-info m-t-md"> 
		<form id="formtambah" class="row g-2">
        <div class="col-md-12">		
		<label class="bold">NIP</label>
		  <input type="text" name="nip" class="form-control"  >
			</div>	
		<div class="col-md-12">
		<label class="bold">Nama Guru</label>	
		  <input type="text" name="nama" class="form-control" required >
			</div>    
		<div class="col-md-12">
		<label class="bold">Jabatan</label>
		  <input type="text" name="jabatan" class="form-control" required >
			</div>					            
		<div class="col-md-12">	
		<label class="bold">Wali Kelas</label>
			<select class="form-select" name="walas" required style="width: 100%">
				<option value="Bukan Walas">Bukan Walas</option>
				 <?php
						$stmt2 = $pdo->prepare("SELECT kelas FROM m_kelas");
						$stmt2->execute();

						while ($kelas = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='" . htmlspecialchars($kelas['kelas']) . "'>" . htmlspecialchars($kelas['kelas']) . "</option>";
						}
						?>
				</select>
			</div>
         <div class="col-md-6">		
		<label class="bold">Username</label>
		  <input type="text" name="username" class="form-control" required >
			</div>				
		<div class="col-md-6">		
		<label class="bold">Password</label>
		  <input type="text" name="password" class="form-control"  required >
			</div>	
		<div class="col-md-12">	
		<label class="bold">Nomor WA</label>
			<input type="text" name="nowa" class="form-control" required >
			</div>
        <div class="col-md-12 mb-3">	
		<label class="bold">Foto</label>
			<input type="file" name="file"  class="form-control" >
			</div>
        <div class="d-flex justify-content-end align-items-center mb-3">
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>		
		</form>
       </div>
	</div>
	</div>
  </div>             

<script>
$('#formtambah').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'master/tguru.php?pg=tambah',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporpeg') ?>"), 500);  
			}
		});
		return false;
	});
</script>	
<?php endif; ?>		
</div>