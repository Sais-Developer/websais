<?php
defined('APK') or exit('No Access');
?>           
<?php if ($ac == '') : ?>
<div class="row">
<div class="col-md-8">
	<div class="card">
		<div class="card card-header">
	 <h5 class="card-title">DATA REGISTRASI PEGAWAI</h5>
	</div>
	  <div class="card-body">		
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover">
				<thead>
					<tr>
					<th>NO</th>                                               
					<th>NO KARTU</th>
					<th>NAMA LENGKAP</th>
					<th>STATUS</th>
					<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 0;
				$sql = "SELECT d.*, g.jabatan
						FROM datareg d
						LEFT JOIN guru g ON g.id_guru = d.idpeg
						WHERE d.level = :level
						ORDER BY d.id DESC";

				$stmt = $db->prepare($sql);
				$level = 'pegawai';
				$stmt->execute(['level' => $level]);

				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
					$no++;
				?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= htmlspecialchars($data['nokartu'] ?? '', ENT_QUOTES) ?></td>
					<td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES) ?></td>
					<td>Pegawai - <?= htmlspecialchars($data['jabatan'] ?? '', ENT_QUOTES) ?></td>
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
        url: 'rfid/trfid.php?pg=hapus',
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
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
        <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
     </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
	   <div class="widget-payment-request-info m-t-md">
		   <div class="d-grid gap-2 mb-4">
			  <a href="?pg=<?= enkripsi('regpeg') ?>&ac=<?= enkripsi('pegawai') ?>" 
			  class="btn btn-primary"> Pegawai</a>
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
		 </div>   
		 
	

<?php elseif ($ac == enkripsi('pegawai')) : ?>
<div class="row">
<div class="col-md-8">
	<div class="card">
		<div class="card card-header">
	 <h5 class="card-title">REGISTRASI PEGAWAI</h5>
	</div>
	  <div class="card-body">		
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover">
			   <thead>
				<tr>
				<th width="8%">NO</th>                                               
				<th>N I P</th>
				<th>NAMA PEGAWAI</th>
				<th>JABATAN</th>
				<th>REG</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						$sql = "SELECT * FROM guru WHERE sts = :sts";
						$stmt = $db->prepare($sql);
						$sts = '0';
						$stmt->execute(['sts' => $sts]);

						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nip'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['jabatan'] ?? '', ENT_QUOTES) ?></td>
							<td>
								<a href="?pg=<?= enkripsi('regpeg') ?>&ac=<?= enkripsi('pegawai') ?>&idp=<?= intval($data['id_guru']) ?>"
								   class='btn btn-sm btn-success' data-bs-toggle="tooltip" 
								   data-bs-placement="top" title="Registrasi RFID">
								   <i class="material-icons">add_circle</i>
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
		$idp = $_GET['idp'] ?? '';
		if (!empty($idp)):
		  $peg = fetch('guru',['id_guru'=>$idp]);
		  endif;
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
		<input type='hidden' name='id' class='form-control' value="<?= $idp; ?>"  />									   
		  <div class="col-md-12 mb-1">
		   <label class="bold">Nama Lengkap</label>
		   <input type='text' name='nama' class='form-control' value="<?= $peg['nama'] ?>" readonly />
			</div>										
		  <div class="col-md-12 mb-1">
		  <label class="bold">Jabatan</label>
		   <input type='text' name='kelas' class='form-control' value="<?= $peg['jabatan'] ?>" readonly />
			</div>
			<div class="col-md-12 mb-2">
		  <label class="bold">No WA</label>
		   <input type='text' name='nowa' class='form-control' value="<?= $peg['nowa'] ?>" readonly />
			</div>
			<div class="d-grid gap-2">
			<button class="btn btn-dark" type="button" disabled>
				<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
				Tempel Kartu...
			</button>
			 </div>
			<label class="bold">No Kartu</label>
		  <div class="col-md-12 mb-3" id="norfid">            
			</div>
			
			<div class="d-grid gap-2">
			<?php if($idp !=''): ?>
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
	$("#norfid").load('rfid/nokartu.php')
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
		url: 'rfid/trfid.php?pg=tambah',
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
			window.location.replace('?pg=<?= enkripsi("regpeg") ?>&ac=<?= enkripsi("pegawai") ?>');
		}, 200);
								  
				}
				});
			return false;
		});
	</script>

<?php endif ?>
