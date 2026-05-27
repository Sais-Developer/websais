<?php
defined('APK') or exit('No Access');
?>

<?php if (($ac ?? '') == ''): ?>
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card card-header">                 
				<h5 class="card-title">DATA PESERTA ASESMEN</h5>
				<?php if (($user['level'] ?? '') == 'admin'): ?>
				<div class="pull-right">					
					<button type="button" class="btn btn-primary kanan" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i class="material-icons">sync</i> Update
                     </button>					
				</div>
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Update Peserta</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
								<form id='formupload'>	
									<label class="bold">Pilih File</label>
									<a href="siswa/proses.php" class="btn btn-link kanan" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format"> <i class="material-icons">download</i> Format</a>	   				            
									<br><br><br>
									<div class="input-group mb-2">
								   <input type='file' name='file' class='form-control' required='true' accept=".xlsx">
										<span class="input-group-text">
											<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
										</span>
									</div>	
								</form>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>	
			<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-analisis edis2" >
						<thead>
							<tr>
								<th>NO</th>
								<th>NAMA SISWA</th>
								<th>NO PESERTA</th>
								<th>USERNAME</th>
								<th>PASSWORD</th>
								<th>SESI</th>
								<th>RUANG</th>
								<th>STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							$query = mysqli_query($koneksi, "SELECT * FROM siswa"); 
							while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) :
							if($data['blok']==0){$sts="<h5><span class='badge badge-success'>Aktif</span></h5>";}
							if($data['blok']==1){$sts="<h5><span class='badge badge-danger'>Blokir</span></h5>";}
							$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES) ?></td>
								<td><?= htmlspecialchars($data['nopes'] ?? '', ENT_QUOTES) ?></td>
								<td><?= htmlspecialchars($data['username'] ?? '', ENT_QUOTES) ?></td>
								<td><?= htmlspecialchars($data['password'] ?? '', ENT_QUOTES) ?></td>
								<td><?= htmlspecialchars($data['sesi'] ?? '', ENT_QUOTES) ?></td>
								<td><?= htmlspecialchars($data['ruang'] ?? '', ENT_QUOTES) ?></td>
								<td><?= $sts; ?></td>
								<td>
									<a href="?pg=<?= enkripsi('siswa') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_siswa']) ?>">
										<button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit">
											<i class="material-icons">edit</i>
										</button>
									</a>
									
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>		

<script>
$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
	swal({
		title: 'Yakin hapus data?',
		text: "Data yang dihapus tidak bisa dikembalikan!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: 'siswa/tsiswa.php?pg=hapus',
				method: "POST",
				data: {id:id},
				success: function() {
					$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
					setTimeout(function() {
						window.location.reload();
					}, 500);
				}
			});
		}
	});
});
</script>    
<script>
    $('#formupload').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/import_siswa.php',
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
				window.location.replace("?pg=<?= enkripsi('siswa') ?>");
						}, 500);
									  
						}
					});
				return false;
			});
		</script>
<?php elseif ($ac == enkripsi('edit')): ?>
<?php
$id = dekripsi($_GET['ids'] ?? '');
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'"), MYSQLI_ASSOC);
if($data['blok']==0){$sts='Aktif';}if($data['blok']==1){$sts='Blokir';}
?>
<div class="row">
	<div class="col-xl-8">
		<div class="card">
			<div class="card card-header">
				<h5 class="card-title">EDIT SISWA</h5>
			</div>
			<div class="card-body">
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
					<div class="col-md-4">
						<label>Sesi</label>
						<select name="sesi" class="form-control" required>
							<option value="1" <?= $data['sesi']=='1'?'selected':'' ?>>Sesi 1</option>
							<option value="2" <?= $data['sesi']=='2'?'selected':'' ?>>Sesi 2</option>
						</select>
					</div>
					
					<div class="col-md-4">
						<label>Ruang</label>
                        <input type='text' name='ruang' value="<?= $data['ruang'] ?>" class='form-control' />
						</div>
					<div class="col-md-4">
						<label>Status</label>
						<select name="blok" class="form-select" required>
							<option value="<?= $data['blok']=='0'?'selected':'' ?>"><?= $sts; ?></option>
							<option value="1" <?= $data['blok']=='1'?'selected':'' ?>>Blokir</option>
							<option value="0" <?= $data['blok']=='0'?'selected':'' ?>>Aktif</option>
						</select>
					</div>	
					<div class="col-md-12">
							<button type="submit" class="btn btn-primary kanan">Simpan</button>
							</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-xl-4 mb-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                <div class="d-flex align-items-center flex-column">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" alt="thumb" />
                    </div>
                <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>
                  </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">NPSN</p>
                      <p><?= $setting['npsn'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">SMT</p>
                      <p><?= $setting['semester'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">TP</p>
                      <p><?= $setting['tp'] ?></p>
                    </div>                    
                  </div>
                  <div class="mb-4">
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
                  <div class="mb-4">
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
                  <div class="mb-4">
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
    $('#formedit').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/tsiswa.php?pg=edit',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			$('.progress-bar').animate({

			}, 500);
			},
								
			success: function(data){   		
			setTimeout(function()
				{
				window.location.replace("?pg=<?= enkripsi('siswa') ?>");
						}, 500);
									  
						}
					});
				return false;
			});
		</script>
</div>
<?php endif; ?>
