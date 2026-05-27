<?php
defined('APK') or exit('No Access');
?>           
<?php if ($ac == '') : ?>
<div class="row">
<div class="col-md-8">
	<div class="card">
		<div class="card card-header">
	 <h5 class="card-title">DATA REGISTRASI SISWA</h5>
	</div>
	  <div class="card-body">		
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover">
				<thead>
					<tr>
					<th>NO</th>                                               
					<th>BARCODE</th>
					<th>NAMA LENGKAP</th>
					<th>STATUS</th>
					<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no = 0;
					$sql = "SELECT d.*, s.nama, s.kelas
							FROM datareg d 
							LEFT JOIN siswa s ON s.id_siswa = d.idsiswa 
							WHERE d.level = :level 
							ORDER BY d.id DESC";

					$stmt = $db->prepare($sql);
					$level = 'siswa';
					$stmt->execute(['level' => $level]);
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['nokartu'] ?? '', ENT_QUOTES) ?></td>
						<td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES) ?></td>
						<td>Siswa - <?= htmlspecialchars($data['kelas'] ?? '', ENT_QUOTES) ?></td>
						<td>
							<button data-id="<?= $data['id'] ?>" class="hapus btn btn-sm btn-danger"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus RFID">
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
        url: 'barkode/tbarkode.php?pg=hapus',
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
		   <div class="d-grid gap-2 mb-4">
			  <a href="?pg=<?= enkripsi('barsis') ?>&ac=<?= enkripsi('siswa') ?>" class="btn btn-primary"> Registrasi Siswa</a>
			 </div>												
			 <div class="mb-4">
					<p class="text-small text-muted mb-4">ALAMAT</p>
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
					<p class="text-small text-muted mb-4">CONTACT</p>
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
					<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
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
</div>
<?php elseif ($ac == enkripsi('siswa')) : ?>
<div class="row">
  <div class="col-md-8">
     <div class="card">
        <div class="card card-header">
	        <h5 class="card-title">REGISTRASI SISWA</h5>
	    </div>
			 <div class="card-body">									
				<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
				   <thead>
					<tr>
					<th>NO</th>                                               
					<th>N I S</th>
					<th>NAMA SISWA</th>
					<th>ROMBEL</th>
					<th>REG</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$sql = "SELECT id_siswa, nis, nama, kelas, sts FROM siswa WHERE sts = :sts";
						$stmt = $db->prepare($sql);
						$sts = '0';
						$stmt->execute(['sts' => $sts]);

						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nis'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['kelas'] ?? '', ENT_QUOTES) ?></td>
							<td>                                            
								<a href="?pg=<?= enkripsi('barsis') ?>&ac=<?= enkripsi('siswa') ?>&ids=<?= htmlspecialchars($data['id_siswa'] ?? '', ENT_QUOTES) ?>">
									<button class='btn btn-sm btn-success' data-bs-toggle="tooltip" 
									data-bs-placement="top" title="Registrasi">
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
<div class="col-md-4">                  
  <div class="card">
	 <div class="card-body">
		<?php
		$ids = $_GET['ids'] ?? '';
		$siswa = null;

		if (!empty($ids)) {
			$stmt = $db->prepare("SELECT * FROM siswa WHERE id_siswa = :id_siswa");
			$stmt->execute(['id_siswa' => $ids]);
			$siswa = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		?>
		<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
        <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
     </div>
	 
	    <div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
            </div>
		 <div class="widget-payment-request-info m-t-md"> 	
		<form id='formkartu' class="row g-2">
			<input type='hidden' name='id' class='form-control' value="<?= $ids; ?>"  />									   
			<div class="col-md-12 mb-1">
			   <label class="bold">Nama Lengkap</label>
			   <input type='text' name='nama' class='form-control' value="<?= $siswa['nama'] ?>" readonly />
				</div>										
			<div class="col-md-12 mb-1">
			  <label class="bold">Rombel</label>
			   <input type='text' name='kelas' class='form-control' value="<?= $siswa['kelas'] ?>" readonly />
				</div>
			<div class="col-md-12 mb-4">
			  <label class="bold">No WA</label>
			   <input type='text' name='nowa' class='form-control' value="<?= $siswa['nowa'] ?>" readonly />
				</div>
				<div class="d-grid gap-2">
				<button class="btn btn-dark" type="button" disabled>
					<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
					Scan Barcode...
				</button>
				 </div>
				<label class="bold">Barcode</label>
			<div class="col-md-12 mb-3" id="norfid">            
				</div>
			<div class="d-grid gap-2">
				<?php if($ids !=''): ?>
				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				   <?php endif; ?>
				   </div>
				</form>
			 </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	setInterval(function(){
	$("#norfid").load('barkode/nokartu.php')
	}, 1000);  
	});
</script>

<script>
$('#formkartu').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'barkode/tbarkode.php?pg=siswa',
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
			window.location.replace('?pg=<?= enkripsi("barsis") ?>&ac=<?= enkripsi("siswa") ?>');
		}, 200);
								  
				}
				});
			return false;
		});
	</script>

<?php endif ?>
