<style>
li.divider {
    margin: 5px 0;      
    padding: 0;          
    border-top: 1px solid #ccc; 
    list-style: none;    
}
</style>
<div class="app-content">
		<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> content</a>
		<div class="content-menu content-menu-right">
			<ul class="list-unstyled">
			    <li><a href="?pg=<?= enkripsi('arsip') ?>">Beranda</a></li>
				<li><a href="?pg=<?= enkripsi('sapras') ?>" class="active">Data Sapras</a></li>
				<li><a href="?pg=<?= enkripsi('sapras') ?>&ac=<?= enkripsi('kategori') ?>">Kategori</a></li>
				<li><a href="?pg=<?= enkripsi('sapras') ?>&ac=<?= enkripsi('lokasi') ?>">Lokasi</a></li>
				<li class="divider"></li>
				<?php if($user['level']=='admin' || $user['level']=='staff'): ?>
				<li><a href="sapras/cetakrusak.php" target="_blank">Rekap Kondisi Rusak</a></li>
				<li><a href="sapras/cetakbaik.php" target="_blank">Rekap Kondisi Baik</a></li>
				
				<?php endif; ?>
			</ul>
		</div>
		<div class="content-wrapper">
			<div class="container-fluid">
				<?php if (($ac ?? '') == ''): ?>
			<div class="row">
			  <div class="col-md-12">
				 <div class="card">
					 <div class="card-header">
					<h5 class="card-title">DATA SAPRAS</h5>
				   </div>
						<div class="card-body">									
						<div class="card-box table-responsive">
							<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
								<thead>
									<tr>
									<th>NO</th>                                               
									<th>NAMA BARANG</th>
									<th>JML</th>
									<th>KONDISI</th>
									<th>LOKASI</th>
									<th></th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 0;
									$sql = "SELECT s.*, r.nama_ruangan
									FROM sapras s
									LEFT JOIN sapras_ruangan r ON r.id = s.lokasi_id ORDER BY s.id DESC";
									$stmt = $pdo->prepare($sql);
									if (!$stmt) {
										die("Query prepare failed: " . $pdo->errorInfo());
									}
									$stmt->execute();
									while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
										$no++;
									?>
										<tr>
											<td><?= $no; ?></td>
											<td><?= $data['nama_barang'] ?></td>
											<td><?= number_format($data['jumlah'], 0, ',', '.')  ?></td>
											<td><?= $data['kondisi'] ?></td>
											<td><?= $data['nama_ruangan'] ?></td>
											<td>
											  <a href="?pg=<?= enkripsi('sapras') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $data['id'] ?>"
												   class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
													<i class="material-icons">edit</i>
												</a>
												<button data-id="<?= $data['id'] ?>"  
														class="hapus btn btn-sm btn-danger" 
														data-bs-toggle="tooltip" 
														title="Hapus">
													<i class="material-icons">delete</i> 
												</button>
											</td>
										</tr>
									<?php endwhile; ?>
									<?php
									$stmt->closeCursor();
									?>
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
        url: 'sapras/hapus.php',
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
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>		
<?php elseif($ac == enkripsi('edit')): ?>
<div class="row">
  <div class="col-xl-6">
<?php
    $id = $_GET['id'];
	$sql = "SELECT s.*, r.nama_ruangan
			FROM sapras s
			LEFT JOIN sapras_ruangan r ON r.id = s.lokasi_id
			WHERE s.id = :id
			";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$datax = $stmt->fetch(PDO::FETCH_ASSOC);
	
	?>	
	<div class="col-xl-12">
       <div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">EDIT SAPRAS</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted mb-4">HIGH SCHOOL</div>
				</div>
				<?php if(!empty($datax['foto'])): ?>
				<img src="<?= $baseurl ?>/images/sapras/<?= $datax['foto'] ?>" style="width:300px">
				<?php else: ?>
				<div class="h5 mb-4 text-center">Tidak ada foto</div>
				<?php endif; ?>
				<div class="text-center mb-4">
				<p><?= $datax['nama_barang'] ?></p>
				<p>Kondisi <?= $datax['kondisi'] ?></p>
				 </div>
			</div>
		</div>
	</div>
</div>
	
	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">EDIT SAPRAS</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id='formEdit'>
			     <input type="hidden" name="id" value="<?= $id; ?>" >
                 <label class="bold">Nama Barang</label>
					<div class="input-group mb-1">
						<input type="text" name="barang" value="<?= $datax['nama_barang'] ?>" class='form-control' required >
					</div>
				  <label class="bold">Jumlah</label>
					<div class="input-group mb-1">
						<input type="number" name="jumlah" value="<?= $datax['jumlah'] ?>" class='form-control' required >
					</div>
                  <label class="bold">Sumber Dana</label>
					<div class="input-group mb-1">
						<select class="form-select" name="dana"  required style="width: 100%">
							<option value="<?= $datax['sumber_dana'] ?>"><?= $datax['sumber_dana'] ?></option>
							<option value=''>Pilih Sumber Dana</option>
							<option value='BOS'>BOS</option>
							<option value='BOSDA'>BOSDA</option>
							<option value='Komite Sekolah'>Komite Sekolah</option>
							<option value='Hibah'>Hibah</option>
							<option value='Lainnya'>Lainnya</option>
							</select>
						</div>					
				 <label class="bold">Kondisi</label>
					<div class="input-group mb-1">
						<select class="form-select" name="kondisi"  required style="width: 100%">
							<option value="<?= $datax['kondisi'] ?>"><?= $datax['kondisi'] ?></option>
							<option value=''>Pilih Kondisi</option>
							<option value='Baik'>Baik</option>
							<option value='Rusak Ringan'>Rusak Ringan</option>
							<option value='Rusak Berat'>Rusak Berat</option>
							</select>
						</div>
					<label class="bold">Lokasi</label>
						<div class="input-group mb-1">
							<select class="form-select" name="lokasi"  required style="width: 100%">
							<option value="<?= $datax['lokasi_id'] ?>"><?= $datax['nama_ruangan'] ?></option>
							<option value=''>Pilih Lokasi</option>
							<?php
							$list_lokasi = select("sapras_ruangan");
							foreach ($list_lokasi as $lok) { ?>
								<option value="<?= $lok['id'] ?>"><?= $lok['nama_ruangan'] ?></option>
							<?php } ?>
							</select>
						</div>
					<label class="bold">Keterangan</label>
						<div class="input-group mb-1">
							<textarea name='ket' rows="2" class='form-control' required ><?= $datax['keterangan'] ?></textarea>
						  </div>
					 <label class="bold">Foto Barang (Jika Ada)</label>
					<div class="input-group mb-1">
					 <input type="file" name="foto" class="form-control" >
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
$('#formEdit').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'sapras/edit.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>	
<?php elseif($ac == enkripsi('input')): ?>
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">INPUT SAPRAS</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id='formSapras'>
			    <label class="bold">Kategori</label>
					<div class="input-group mb-1">
						<select class="form-select" name="kate"  required style="width: 100%">
						<option value=''>Pilih Kategori</option>
						<?php
							$list_kate = select("sapras_kate");
							foreach ($list_kate as $kate) { ?>
								<option value="<?= $kate['id'] ?>"><?= $kate['kategori'] ?></option>
							<?php } ?>
						</select>
					</div>
                 <label class="bold">Nama Barang</label>
					<div class="input-group mb-1">
						<input type="text" name="barang" class='form-control' required >
					</div>
				  <label class="bold">Jumlah</label>
					<div class="input-group mb-1">
						<input type="number" name="jumlah" value="1" class='form-control' required >
					</div>
                  <label class="bold">Sumber Dana</label>
					<div class="input-group mb-1">
						<select class="form-select" name="dana"  required style="width: 100%">
							<option value=''>Pilih Sumber Dana</option>
							<option value='BOS'>BOS</option>
							<option value='BOSDA'>BOSDA</option>
							<option value='Komite Sekolah'>Komite Sekolah</option>
							<option value='Hibah'>Hibah</option>
							<option value='Lainnya'>Lainnya</option>
							</select>
						</div>					
				 <label class="bold">Kondisi</label>
					<div class="input-group mb-1">
						<select class="form-select" name="kondisi"  required style="width: 100%">
							<option value=''>Pilih Kondisi</option>
							<option value='Baik'>Baik</option>
							<option value='Rusak Ringan'>Rusak Ringan</option>
							<option value='Rusak Berat'>Rusak Berat</option>
							</select>
						</div>
					<label class="bold">Lokasi</label>
						<div class="input-group mb-1">
							<select class="form-select" name="lokasi"  required style="width: 100%">
							<option value=''>Pilih Lokasi</option>
							<?php
							$list_lokasi = select("sapras_ruangan");
							foreach ($list_lokasi as $lok) { ?>
								<option value="<?= $lok['id'] ?>"><?= $lok['nama_ruangan'] ?></option>
							<?php } ?>
							</select>
						</div>
					<label class="bold">Keterangan</label>
						<div class="input-group mb-1">
							<textarea name='ket' rows="2" class='form-control' required ><?= $datax['keterangan'] ?></textarea>
						  </div>
					 <label class="bold">Foto Barang (Jika Ada)</label>
					<div class="input-group mb-4">
					 <input type="file" name="foto" class="form-control" >
					    </div>
						<div class="text-end">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				 </div>
			</div>
		</div>
	</div>
<script>
$('#formSapras').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'sapras/simpan.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>	
<?php elseif($ac == enkripsi('kategori')): ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="card-title">DATA KATEGORI</h5>
				<button type="button" class="btn btn-link m-b-sm ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable">
					<i class="material-icons">add</i>Tambah
				</button>
			</div>
            <div class="card-body">
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">    
                        <thead>
                        <tr>
                            <th width="8%">NO</th>
                            <th>KATEGORI</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 0;
                            $sql = "SELECT * FROM sapras_kate";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $no++;    
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $data['kategori'] ?></td>
                            <td>
                                <button
                                    class="btn btn-sm btn-success edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter"
                                    data-id="<?= $data['id'] ?>"
                                    data-kategori="<?= $data['kategori'] ?>"
                                >
                                    <i class="material-icons">edit</i>
                                </button>
                                <button 
                                    data-id="<?= $data['id'] ?>"  
                                    class="hapus btn btn-sm btn-danger" 
                                    data-bs-toggle="tooltip" 
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
        url: 'sapras/hapus_kate.php',
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
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>	
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="kategoriId" name="id">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" id="kategori" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.edit-btn', function() {
    var kategoriId = $(this).data('id');
    var kategori = $(this).data('kategori');
    $('#kategoriId').val(kategoriId);
    $('#kategori').val(kategori);
});
$('#saveBtn').on('click', function() {
    var kategoriId = $('#kategoriId').val();
    var kategori = $('#kategori').val();

    if(kategori.trim() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Kategori tidak boleh kosong!'
        });
        return;
    }

    $.ajax({
        url: 'sapras/edit_kate.php', 
        method: 'POST',
        data: {
            id: kategoriId,
            kategori: kategori
        },
        success: function(response) {
            if (response == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Kategori berhasil diperbarui!',
                }).then(() => {
                    location.reload(); 
                });
            } else if (response == 'no_changes') {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ada perubahan',
                    text: 'Tidak ada perubahan data kategori.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memperbarui kategori.',
                });
            }
        },
        
    });
});
</script>	
<div class="modal fade" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Tambah Kategori</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formkate">
				<div class="modal-body">
					<div class="form-group">
                       <label for="kategori">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$('#formkate').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'sapras/simpan_kate.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>
<?php elseif($ac == enkripsi('lokasi')): ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="card-title">DATA LOKASI</h5>
				<button type="button" class="btn btn-link m-b-sm ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable">
					<i class="material-icons">add</i>Tambah
				</button>
			</div>
            <div class="card-body">
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">    
                        <thead>
                        <tr>
                            <th width="8%">NO</th>
                            <th>NAMA RUANGAN</th>
							<th>LOKASI</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 0;
                            $sql = "SELECT * FROM sapras_ruangan ORDER BY id DESC";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $no++;    
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $data['nama_ruangan'] ?></td>
							<td><?= $data['lokasi'] ?></td>
                            <td>
                                <button
                                    class="btn btn-sm btn-success edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter"
                                    data-id="<?= $data['id'] ?>"
                                    data-ruang="<?= $data['nama_ruangan'] ?>"
									data-lokasi="<?= $data['lokasi'] ?>"
                                >
                                    <i class="material-icons">edit</i>
                                </button>
                                <button 
                                    data-id="<?= $data['id'] ?>"  
                                    class="hapus btn btn-sm btn-danger" 
                                    data-bs-toggle="tooltip" 
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
        url: 'sapras/hapus_lokasi.php',
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
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>	
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="lokasiId" name="id">
                    <div class="form-group">
                        <label for="ruang">Nama Ruangan</label>
                        <input type="text" id="ruang" class="form-control" required>
                    </div>
					<div class="form-group">
                        <label for="ruang">Lokasi</label>
                        <input type="text" id="lokasi" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.edit-btn', function() {
    var lokasiId = $(this).data('id');
    var ruang = $(this).data('ruang');
	var lokasi = $(this).data('lokasi');
    $('#lokasiId').val(lokasiId);
    $('#ruang').val(ruang);
	$('#lokasi').val(lokasi);
});
$('#saveBtn').on('click', function() {
    var lokasiId = $('#lokasiId').val();
    var ruang = $('#ruang').val();
    var lokasi = $('#lokasi').val();
    if(lokasi.trim() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Kategori tidak boleh kosong!'
        });
        return;
    }

    $.ajax({
        url: 'sapras/edit_lokasi.php', 
        method: 'POST',
        data: {
            id: lokasiId,
            ruang: ruang,
			lokasi: lokasi
        },
        success: function(response) {
            if (response == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Kategori berhasil diperbarui!',
                }).then(() => {
                    location.reload(); 
                });
            } else if (response == 'no_changes') {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ada perubahan',
                    text: 'Tidak ada perubahan data kategori.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memperbarui kategori.',
                });
            }
        },
        
    });
});
</script>	
<div class="modal fade" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Tambah Lokasi</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formkate">
				<div class="modal-body">
					<div class="form-group">
                       <label for="ruang">Nama Ruangan</label>
                        <input type="text" name="ruang" class="form-control" required>
                    </div>
					<div class="form-group">
                       <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$('#formkate').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'sapras/simpan_lokasi.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>
<?php endif; ?>
	</div>
</div>
