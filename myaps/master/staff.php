<?php
defined('APK') or exit('No access');
?>		   
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">DATA STAFF</h5>
      </div>
      <div class="card-body">
        <div class="card-box table-responsive">
          <table id="datatable1" class="table table-bordered table-hover">
            <thead>
              <tr>
				<th>NO</th>
                <th>NAMA STAFF</th>
                <th>USERNAME</th>
                <th>FOTO</th> 
                <th width="20%"></th>
              </tr>
            </thead>
            <tbody>
              <?php
				$no = 0;
				$level = 'staff';
				$stmt = $db->prepare("SELECT * FROM guru WHERE level = ?");
				$stmt->execute([$level]);
				$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($staffs as $data) {
				$no++;
				?>
				<tr>
					<td><?= htmlspecialchars($no) ?></td>
					<td><?= htmlspecialchars($data['nama']) ?></td>
					<td><?= htmlspecialchars($data['username']) ?></td>
					<td style="text-align:center">
						<?php if (empty($data['foto'])): ?>
							<img src="../images/user.png" class="table-img">
						<?php else: ?>
							<img src="../images/fotoguru/<?= htmlspecialchars($data['foto']) ?>" class="table-img">
						<?php endif; ?>
					</td>
					<td>
						<a href="?pg=<?= enkripsi('staff') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id_guru']) ?>"
							class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
								<i class="material-icons">edit</i>
						</a>
						<button data-id="<?= $data['id_guru'] ?>" class="hapus btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
          setTimeout(() => window.location.replace("?pg=<?= enkripsi('staff') ?>"), 1200);
        }
      });
    }
  });
});
</script>
  <?php if (empty($ac)) : ?>
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
         <form id='formguru'>		
             <label class="bold">Nama Lengkap</label>
              <div class="input-group mb-1">
                <input type='text' name='nama' class='form-control' required >
              </div>
              <label class="bold">Username</label>
              <div class="input-group mb-1">
                <input type='text' name='username' class='form-control' required >
              </div>
              <label class="bold">Password</label>
              <div class="input-group mb-1">
                <input type='text' name='password' class='form-control' required >
              </div>
			  <label class="bold">Nomor WA</label>
              <div class="input-group mb-1">
                <input type='number' name='nowa' class='form-control' required>
              </div>	
              <label class="bold">Foto Jika Ada</label>
              <div class="input-group mb-3">
                <input type='file' name='file' class='form-control'/>
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
$('#formguru').submit(function(e){
  e.preventDefault();
  var data = new FormData(this);
  $.ajax({
    type: 'POST',
    url: 'master/tstaff.php?pg=tambah',
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
    },
    success: function() {   		
      setTimeout(function() {
        window.location.reload();
      }, 500);
    }
  });
});
</script>	
  <?php elseif ($ac == enkripsi('edit')): ?>	
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
         <form id='formedit'>	
			<input type='hidden' name='idguru' class='form-control' value="<?= $idguru ?>" >
             		
              <label class="bold">Nama Lengkap</label>
              <div class="input-group mb-1">
                <input type='text' name='nama' class='form-control' value="<?= $data['nama'] ?>" required >
              </div>
			   
              <label class="bold">Username</label>
              <div class="input-group mb-1">
                <input type='text' name='username' class='form-control' value="<?= $data['username'] ?>" readonly >
              </div>
              <label class="bold">Password</label>
              <div class="input-group mb-1">
                <input type='text' name='password' class='form-control' value="<?= $data['password'] ?>" required >
              </div>
			  <label class="bold">Nomor WA</label>
              <div class="input-group mb-1">
                <input type='number' name='nowa' class='form-control' value="<?= $data['nowa'] ?>" required>
              </div>	
              <label class="bold">Foto Jika Ada</label>
              <div class="input-group mb-3">
                <input type='file' name='file' class='form-control'/>
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
  $.ajax({
    type: 'POST',
    url: 'master/tstaff.php?pg=edit',
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
    },
    success: function() {   		
      setTimeout(function() {
        window.location.replace('?pg=<?= enkripsi('staff') ?>');
      }, 500);
    }
  });
});
</script>	
  <?php endif ?>
</div>
