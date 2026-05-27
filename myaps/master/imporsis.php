<?php
defined('APK') or exit('No accsess');
?>           
<div class="row">
  <div class="col-md-8">
     <div class="card" >
	   <div class="card-header d-flex justify-content-between align-items-center">
			<h5 class="card-title mb-0">PESERTA DIDIK</h5>
			<a href="?pg=<?= enkripsi('imporsis') ?>&ac=<?= enkripsi('tambah') ?>" class="btn btn-light d-flex align-items-center">
				<i class="material-icons me-1">add</i> PD
			</a>
		</div>
	   <div class="card-body">
	       <div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover">
				  <thead>
					<tr>
						<th>NO</th>
						<th>NAMA SISWA</th>
						<th>JK</th>
						<th>KELAS</th>
						<th>AGAMA</th>						
						<th>ACTION</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$siswa = select("siswa", [], "id_siswa DESC");

						foreach ($siswa as $data) :
							$no++;
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $data['nama'] ?></td>
							<td><?= $data['jk'] ?></td>
							<td><?= $data['kelas'] ?></td>
							<td><?= $data['agama'] ?></td>
							<td>
								<a href="?pg=<?= enkripsi('imporsis') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_siswa']) ?>"
								   class="btn btn-sm btn-success" 
								   data-bs-toggle="tooltip" 
								   title="Edit">
									<i class="material-icons">edit</i>
								</a>

								<?php if (($user['level'] ?? '') == 'admin'): ?>
								<button data-id="<?= $data['id_siswa'] ?>"  
										class="hapus btn btn-sm btn-danger" 
										data-bs-toggle="tooltip" 
										title="Hapus">
										<i class="material-icons">delete</i> 
								</button>
								<?php endif; ?>
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
        url: 'master/tsiswa.php?pg=hapus',
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
          setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporsis') ?>"), 1200);
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
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
     <div class="widget-payment-request-info m-t-md"> 	
      	<a href="master/M_SISWA.xlsx" class="btn btn-sm btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
				<i class="material-icons">download</i> Format
			</a>	 
		<form id="formsiswa">
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
$('#formsiswa').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'master/import_siswa.php',
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
<?php elseif($ac == enkripsi('edit')): ?>
<?php
$id = dekripsi($_GET['ids'] ?? '');
if (!empty($id)) {
    $data = fetch("siswa", ["id_siswa" => $id]);
    if ($data) {
        $jk = ($data['jk'] == 'L') ? 'Laki-laki' : 'Perempuan';
    }
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
		<input type="hidden" name="id" value="<?= $data['id_siswa'] ?>" class="form-control" >	            
		<div class="col-md-12">
		<label class="bold">Nama Siswa</label>	
		  <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" required >
			</div>
		<div class="col-md-6">
		<label class="bold">Nis</label>
		  <input type="text" name="nis" value="<?= $data['nis'] ?>" class="form-control" required >
			</div>	    
		<div class="col-md-6">
		<label class="bold">Nisn</label>
		  <input type="text" name="nisn" value="<?= $data['nisn'] ?>" class="form-control" required >
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Kelas</label>
			<select class="form-select" name="kelas" required style="width: 100%">
				<option value="<?= $data['kelas'] ?>"><?= $data['kelas'] ?></option>
				<?php
				$list_kelas = select("m_kelas");
				foreach ($list_kelas as $kelas) {
					$k = htmlspecialchars($kelas['kelas']);
					echo "<option value='$k'>$k</option>";
				}
				?>
			</select>
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Jenis Kelamin</label>
			<select class="form-select" name="jk" required style="width: 100%">
				<option value="<?= $data['jk'] ?>"><?= $jk ?></option>
				<option value="">Pilih Kelamin</option>
				<option value="L">Laki-laki</option>
				<option value="P">Perempuan</option>
			</select>
			</div>					          
		<div class="col-md-6">	
		<label class="bold">Agama</label>
			<select class="form-select" name="agama" required="true" style="width: 100%">
				<option value="<?= $data['agama'] ?>"><?= $data['agama'] ?></option>
				<option value='Islam'>Islam</option>
				<option value='Kristen'>Kristen</option>
				<option value='Katholik'>Katholik</option>
				<option value='Hindu'>Hindu</option>
				<option value='Budha'>Budha</option>
				<option value='Konghucu'>Konghucu</option>
			</select>
			</div>
		<div class="col-md-6">	
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
		url: 'master/tsiswa.php?pg=edit',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporsis') ?>"), 500);  
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
		<label class="bold">Nama Siswa</label>	
		  <input type="text" name="nama" class="form-control" required >
			</div>
		<div class="col-md-6">
		<label class="bold">Nis</label>
		  <input type="text" name="nis" class="form-control" required >
			</div>	    
		<div class="col-md-6">
		<label class="bold">Nisn</label>
		  <input type="text" name="nisn" class="form-control" required >
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Kelas</label>
			<select class="form-select" name="kelas" required style="width: 100%">
				<option value="">Pilih Kelas</option>
				  <?php
				$list_kelas = select("m_kelas");
				foreach ($list_kelas as $kelas) {
					$k = htmlspecialchars($kelas['kelas']);
					echo "<option value='$k'>$k</option>";
				}
				?>
				</select>
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Jenis Kelamin</label>
			<select class="form-select" name="jk" required style="width: 100%">
				<option value="">Pilih Kelamin</option>
				<option value="L">Laki-laki</option>
				<option value="P">Perempuan</option>
			</select>
			</div>					          
		<div class="col-md-6">	
		<label class="bold">Agama</label>
			<select class="form-select" name="agama" required="true" style="width: 100%">
				<option value="">Pilih Agama</option>
				<option value='Islam'>Islam</option>
				<option value='Kristen'>Kristen</option>
				<option value='Katholik'>Katholik</option>
				<option value='Hindu'>Hindu</option>
				<option value='Budha'>Budha</option>
				<option value='Konghucu'>Konghucu</option>
			</select>
			</div>
		<div class="col-md-6">	
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
$('#formtambah').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'master/tsiswa.php?pg=tambah',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(() => window.location.replace("?pg=<?= enkripsi('imporsis') ?>"), 500);  
			}
		});
		return false;
	});
</script>	
<?php endif; ?>		
</div>