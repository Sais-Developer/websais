<?php
defined('APK') or exit('No Access');
?>           		   
<div class="row">
	<div class="col-md-8">
		<div class="card">
		  <div class="card-header">
			<h5 class="card-title">EKSTRAKURIKULER</h5>
		</div>
		<div class="card-body">									
			<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">NO</th>                                               
						<th>EKSTRAKURIKULER</th>
						<th>NAMA PEMBINA</th>
						 <th width="10%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					$sql = "SELECT * FROM m_eskul m 
							JOIN guru g ON g.id_guru = m.guru";
					$stmt = $db->prepare($sql);
					$stmt->execute();
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($results as $data) :
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['eskul'], ENT_QUOTES) ?></td>
						<td><?= htmlspecialchars($data['nama'], ENT_QUOTES) ?></td>
						<td>
							<button data-id="<?= htmlspecialchars($data['id'], ENT_QUOTES) ?>" 
									class="hapus btn btn-sm btn-danger" 
									data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
        url: 'master/teskul.php?pg=hapus',
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
          setTimeout(() => window.location.replace("?pg=<?= enkripsi('eskul') ?>"), 1200);
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
		<form id='formguru' >										
			 <label>Nama Eskul</label>
		  <div class="input-group mb-1">
		   <input type='text' name='eskul' class='form-control' required='true' />
			</div>
			<label>Nama Pembina</label>
		  <div class="input-group mb-4">
		  <select name="guru" class="form-select" required style="width: 100%">
			<option value=''>Pilih Guru Pembina</option>
				<?php
				$stmt = $db->prepare("SELECT id_guru, nama FROM guru");
				$stmt->execute();
				$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($gurus as $guru) {
					echo "<option value='" . htmlspecialchars($guru['id_guru'], ENT_QUOTES) . "'>" 
						 . htmlspecialchars($guru['nama'], ENT_QUOTES) . "</option>";
				}
				?>
				</select>
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
$.ajax(
{
	type: 'POST',
	 url: 'master/teskul.php?pg=tambah',
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
