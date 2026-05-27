<?php
defined('APK') or exit('No Access');
?>              
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">                                
                <h5 class="card-title">WAKTU PRESENSI</h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>                                               
                                <th>HARI</th>
                                <th>JAM SEKOLAH</th>
                                <th>JAM ESKUL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$no = 0;
							$sql = "
								SELECT 
									w.id,
									w.hari,
									w.masuk,
									w.alpha,
									w.pulang,
									w.masuk_eskul,
									w.pulang_eskul,
									m.hari AS nama_hari
								FROM waktu w
								LEFT JOIN m_hari m ON w.hari = m.inggris
								ORDER BY w.id ASC
							";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							foreach ($rows as $data) :
								$no++;
							?>
							<tr>
							   <td><?= $no; ?></td>
							   <td><?= htmlspecialchars($data['nama_hari'] ?? '-') ?></td>
							   <td>
									Masuk : <?= htmlspecialchars($data['masuk'] ?? '') ?>
									&nbsp;&nbsp;Alpha : <?= date('H:i', strtotime($data['alpha'] ?? '')) ?>
									&nbsp;&nbsp;Pulang : <?= htmlspecialchars($data['pulang'] ?? '') ?>
							   </td>
							   <td>
									Masuk&nbsp;&nbsp;: <?= htmlspecialchars($data['masuk_eskul'] ?? '') ?>
									<br>Pulang : <?= htmlspecialchars($data['pulang_eskul'] ?? '') ?>
							   </td>
							   <td>
									<a href="?pg=<?= enkripsi('waktu') ?>&ac=<?= enkripsi('edit') ?>&id=<?= intval($data['id']) ?>"
									   class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
									   <i class="material-icons">edit</i>
									</a>
									<button data-id="<?= intval($data['id']) ?>" class="hapus btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
        url: 'twaktu.php?pg=hapus',
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
          setTimeout(() => window.location.replace("?pg=<?= enkripsi('waktu') ?>"), 1200);
        }
      });
    }
  });
});
</script>
<?php if ($ac == '') : ?>
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
			<form id='formwaktu' method="post">										 
				<div class="col-md-12 mb-1">
				<label class="bold">Hari</label>
				  <select class="form-select" name="hari" required>
					<option value=''>-- Pilih Hari --</option>
						<?php						
						$stmt = $db->prepare("SELECT * FROM m_hari ORDER BY idh ASC");
						$stmt->execute();
						while ($level = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='" . htmlspecialchars($level['inggris']) . "'>" 
							   . htmlspecialchars($level['hari']) . "</option>";
						}						
						?>
					</select>
				</div>	
				<label class="bold">Jam Masuk</label>
				<div class="input-group mb-2">
				<input type="text" name="jam[]" class="timer form-control"  autocomplete="off" required>
				</div>
				
				<label class="bold">Deteksi Alpha</label>
				<div class="input-group mb-2">
					<input type="text" name="jam[]" class="timer form-control"  autocomplete="off" required>
				</div>
				
				<label class="bold">Jam Pulang</label>
				<div class="input-group mb-2">
					 <input type="text" name="jam[]" class="timer form-control"  autocomplete="off" required>
				</div>
				
				<label class="bold">Masuk Eskul (Jika ada)</label>
				<div class="input-group mb-2">
					  <input type="text" name="jam[]" class="timer form-control"  autocomplete="off">
				</div>
				
				<label class="bold">Pulang Eskul (Jika ada)</label>
				<div class="input-group mb-4">
					  <input type="text" name="jam[]" class="timer form-control"  autocomplete="off">
				</div>
				<div class="d-flex justify-content-end align-items-center mb-3">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form>
		</div>
	</div>
</div>
<script>
$('#formwaktu').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'twaktu.php?pg=tambah',
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
    return false;
});
</script>
<?php elseif($ac == enkripsi('edit')): ?>	
<?php
$id = intval($_GET['id'] ?? 0);
$data = fetch('waktu', ['id' => $id]);
$harix = hariIndo($data['hari']);
?>

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
            <form id='formedit' method="post">
                <input type="hidden" name="id" value="<?= $id; ?>" >									

                <div class="col-md-12 mb-1">
                    <label class="bold">Hari</label>
                    <select class="form-select" name="hari" required>
                        <option value="<?= htmlspecialchars($data['hari'] ?? '') ?>"><?= htmlspecialchars($harix) ?></option>
                       <option value=''>-- Pilih Hari --</option>
						<?php						
						$stmt = $db->prepare("SELECT * FROM m_hari ORDER BY idh ASC");
						$stmt->execute();
						while ($level = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='" . htmlspecialchars($level['inggris']) . "'>" 
							   . htmlspecialchars($level['hari']) . "</option>";
						}						
						?>
                    </select>
                </div>	
                 <label class="bold">Jam Masuk</label>
					<div class="input-group mb-2">
					<input type="text" name="jam[]" class="timer form-control" value="<?= $data['masuk'] ?>" autocomplete="off" required>
					</div>
					
					<label class="bold">Deteksi Alpha</label>
					<div class="input-group mb-2">
						<input type="text" name="jam[]" class="timer form-control" value="<?= $data['alpha'] ?>" autocomplete="off" required>
					</div>
					
					<label class="bold">Jam Pulang</label>
					<div class="input-group mb-2">
						 <input type="text" name="jam[]" class="timer form-control" value="<?= $data['pulang'] ?>" autocomplete="off" required>
					</div>
					
					<label class="bold">Masuk Eskul (Jika ada)</label>
					<div class="input-group mb-2">
						  <input type="text" name="jam[]" class="timer form-control" value="<?= $data['masuk_eskul'] ?>" autocomplete="off">
					</div>
					
					<label class="bold">Pulang Eskul (Jika ada)</label>
					<div class="input-group mb-4">
						  <input type="text" name="jam[]" class="timer form-control" value="<?= $data['pulang_eskul'] ?>" autocomplete="off">
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
    $.ajax({
        type: 'POST',
        url: 'twaktu.php?pg=edit',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },
        success: function(data){   		
            setTimeout(function() {
                window.location.replace('?pg=<?= enkripsi('waktu') ?>');
            }, 200);
        }
    });
    return false;
});
</script>
    <?php endif; ?>
</div>



