<?php
defined('APK') or exit('No accsess');
?>           
<div class="row">
  <div class="col-md-8">
     <div class="card" >
	   <div class="card-header d-flex justify-content-between align-items-center">
			<h5 class="card-title mb-0">DATA ALUMNI</h5>
		</div>
	   <div class="card-body">
	       <div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover">
				  <thead>
					<tr>
						<th>NO</th>
						<th>NAMA SISWA</th>
						<th>NIS</th>
						<th>JK</th>
						<th>TAHUN</th>						
						<th>ACT</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$siswa = select("alumni", [], "id_alumni DESC");

						foreach ($siswa as $data) :
							$no++;
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $data['nama'] ?></td>
							<td><?= $data['nis'] ?></td>
							<td><?= $data['jk'] ?></td>
							<td><?= $data['tahun_lulus'] ?></td>
							<td>
								<a href="?pg=<?= enkripsi('alumni') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_alumni']) ?>"
								   class="btn btn-sm btn-success" 
								   data-bs-toggle="tooltip" 
								   title="Edit">
									<i class="material-icons">edit</i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

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
<?php elseif($ac == enkripsi('edit')): ?>
<?php
$id = dekripsi($_GET['ids'] ?? '');
if (!empty($id)) {
    $data = fetch("alumni", ["id_alumni" => $id]);
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
		<input type="hidden" name="id" value="<?= $id; ?>" class="form-control" >	            
		<div class="col-md-12">
		<label class="bold">Nama Alumni</label>	
		  <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" readonly >
			</div>
		<div class="col-md-6">
		<label class="bold">Tahun Masuk</label>
		  <input type="text" name="masuk" value="<?= $data['tahun_masuk'] ?>" class="form-control" required >
			</div>	    
		<div class="col-md-6">
		<label class="bold">Tahun Lulus</label>
		  <input type="text"  value="<?= $data['tahun_lulus'] ?>" class="form-control" readonly >
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Kelas Terakhir</label>
			<select class="form-select"   style="width: 100%">
				<option value="<?= $data['kelas'] ?>"><?= $data['kelas'] ?></option>
			</select>
			</div>					            
		<div class="col-md-6">	
		<label class="bold">Jurusan</label>
			<select class="form-select"   style="width: 100%">
				<option value="<?= $data['jurusan'] ?>"><?= $data['jurusan'] ?></option>
			</select>
			</div>				
		<div class="col-md-12">	
		<label class="bold">Status</label>
			<select class="form-select" name="status" required="true" style="width: 100%">
			    <option value="<?= $data['status'] ?>"><?= $data['status'] ?></option>
				<option value="">-- Pilih Status --</option>
				<option value="Bekerja">Bekerja</option>
				<option value="Kuliah">Kuliah</option>
				<option value="Wirausaha">Wirausaha</option>
				<option value="Lainnya">Lainnya</option>
			</select>
			</div>
         <div class="col-md-12">	
		<label class="bold">Nama Instansi / Perguruan Tinggi</label>
			<input type="text" name="instansi" value="<?= $data['nama_instansi'] ?>" class="form-control" >
			</div>
		<div class="col-md-12">	
		<label class="bold">Nomor WA</label>
			<input type="text" name="nowa" value="<?= $data['nowa'] ?>" class="form-control" >
			</div>
        <div class="col-md-12 mb-3">	
		<label class="bold">Foto Alumni</label>  
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
		url: 'alumni/tsiswa.php?pg=edit',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(() => window.location.reload(), 500);  
			}
		});
		return false;
	});
</script>	

<?php endif; ?>		
</div>