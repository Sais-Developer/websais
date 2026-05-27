<?php
defined('APK') or exit('No Access');
?>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">                 
				<h5 class="card-title">DATA PESERTA ASESMEN</h5>
			</div>	
			<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-analisis edis2" >
						<thead>
							<tr>
								<th>NO</th>
								<th>NAMA SISWA</th>
								<th>USERNAME</th>
								<th>PASSWORD</th>
								<th>STATUS</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 0;
								try {
									$stmt = $pdo->query("SELECT id_siswa, nama, nopes, username, password, blok FROM siswa");
									$siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

									foreach ($siswaList as $data) {
										$no++;
										$sts = ($data['blok'] == 0) 
											? "<span class='badge badge-success'>Aktif</span>" 
											: "<span class='badge badge-danger'>Blokir</span>";
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars(ucwords(strtolower($data['nama'])) ?? '', ENT_QUOTES) ?></td>
									<td><?= htmlspecialchars($data['username'] ?? '', ENT_QUOTES) ?></td>
									<td><?= htmlspecialchars($data['password'] ?? '', ENT_QUOTES) ?></td>
									<td><?= $sts; ?></td>
									<td>
										<a href="?pg=<?= enkripsi('upsiswa') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_siswa']) ?>">
											<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
												<i class="material-icons">edit</i>
											</button>
										</a>
									</td>
								</tr>
								<?php
							}
							} catch(PDOException $e) {
							echo "Query gagal: " . $e->getMessage();
							}
							?>
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
	<div class="d-flex align-items-center flex-column mb-4">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
     <div class="widget-payment-request-info m-t-md"> 	
      	<a href="<?= $baseurl ?>/mycbt/proses.php" class="btn btn-sm btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
				<i class="material-icons">download</i> Format
			</a>	 
		<form id="formupload">
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
    $('#formupload').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'import_siswa.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			},				
			success: function(data){   		
			setTimeout(function(){
			window.location.reload();}, 500);
					}
				});
			return false;
			});
		</script>
<?php elseif ($ac == enkripsi('edit')): ?>
<?php
$id = dekripsi($_GET['ids'] ?? '');
try {
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $sts = ($data['blok'] == 0) ? 'Aktif' : 'Blokir';
    } else {
        $sts = 'Data tidak ditemukan';
    }
} catch (PDOException $e) {
    echo "Query gagal: " . $e->getMessage();
    $data = null;
    $sts = 'Error';
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
			<form id="formedit"  class="row g-3" enctype='multipart/form-data'>
				<input type="hidden" name="id" value="<?= $id ?>">
				<div class="col-md-12">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama'], ENT_QUOTES) ?>" required>
				</div>
				<div class="col-md-12">
					<label>No Peserta</label>
					<input type="text" name="nopes" class="form-control" value="<?= htmlspecialchars($data['nopes'], ENT_QUOTES) ?>" required>
				</div>
				<div class="col-md-6">
					<label>Username</label>
					<input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username'], ENT_QUOTES) ?>" required>
				</div>
				<div class="col-md-6">
					<label>Password</label>
					<input type="text" name="password" class="form-control" value="<?= htmlspecialchars($data['password'], ENT_QUOTES) ?>" required>
				</div>
				<div class="col-md-6">
					<label>Sesi</label>
					<select name="sesi" class="form-select" required>
						<option value="1" <?= $data['sesi']=='1'?'selected':'' ?>>Sesi 1</option>
						<option value="2" <?= $data['sesi']=='2'?'selected':'' ?>>Sesi 2</option>
					</select>
				</div>
				
				<div class="col-md-6">
					<label>Ruang</label>
					<input type='text' name='ruang' value="<?= $data['ruang'] ?>" class='form-control' />
					</div>
				<div class="col-md-12">
					<label>Status</label>
					<select name="blok" class="form-select" required>
						<option value="<?= $data['blok']=='0'?'selected':'' ?>"><?= $sts; ?></option>
						<option value="1" <?= $data['blok']=='1'?'selected':'' ?>>Blokir</option>
						<option value="0" <?= $data['blok']=='0'?'selected':'' ?>>Aktif</option>
					</select>
				</div>	
				<div class="d-flex justify-content-end align-items-center mb-3">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form>
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
		 url: 'tsiswa.php?pg=edit',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},				
		success: function(data){   		
		setTimeout(function(){
		window.location.replace("?pg=<?= enkripsi('upsiswa') ?>");}, 500);
					}
				});
		return false;
		});
	</script>
<?php endif; ?>
</div>