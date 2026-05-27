<?php
defined('APK') or exit('No Access');

?>           
<div class="row">
 <div class="col-md-8">
    <div class="card">
	 <div class="card-header">       
	<h5 class="card-title">CAPAIAN PEMBELAJARAN</h5>
	</div>
	<div class="card-body">
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover">
			   <thead>
			   <tr>
				<th>#</th>  	
				<th>LINGKUP</th>
				<th>ELEMEN</th>
				<th>CAPAIAN PEMBELAJARAN</th>										                                      													
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
				<?php
					$no = 0;
					$id_lingkup = $_GET['id']; 

					if ($user['level'] === 'admin') {

						$sql = "
							SELECT a.*, m.kode, g.nama, ce.id_elemen, ce.capaian, ce.elemen
							FROM adm_tp a
							LEFT JOIN mapel m ON m.id = a.mapel
							LEFT JOIN guru g ON g.id_guru = a.guru
							LEFT JOIN cp_elemen ce ON ce.id_lingkup = a.id
							WHERE a.semester = ? AND a.id = ?
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([$semester, $id_lingkup]);

					} elseif ($user['level'] === 'guru') {

						$sql = "
							SELECT a.*, m.kode, g.nama, ce.id_elemen, ce.capaian, ce.elemen
							FROM adm_tp a
							LEFT JOIN mapel m ON m.id = a.mapel
							LEFT JOIN guru g ON g.id_guru = a.guru
							LEFT JOIN cp_elemen ce ON ce.id_lingkup = a.id
							WHERE a.semester = ? AND a.guru = ? AND a.id = ?
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([$semester, $id_user, $id_lingkup]);
					}

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
					?>

					<tr style="vertical-align:middle">
						<td><?= $no; ?></td>
						<td><?= $data['lingkup'] ?></td>
						<td><?= $data['elemen'] ?></td>
						<td><?= $data['capaian'] ?></td>
						<td>
						<?php if($data['elemen'] !=''): ?>
							<a href="?pg=<?= enkripsi('cpel') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $data['id'] ?>"
							   class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit">
								<i class="material-icons">edit</i>
							</a>

							<button data-id="<?= $data['id_elemen'] ?>" 
									class="hapus btn btn-sm btn-danger"
									data-bs-toggle="tooltip" title="Hapus">
								<i class="material-icons">delete</i>
							</button>
							<?php endif; ?>
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
        url: 'adm/tcpel.php?pg=hapus',
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

<?php if ($ac == '') : ?>
<?php
$input = $_GET['input'] ?? '';
$idcp = $_GET['id'] ?? '';
$sql = "
    SELECT a.*, m.*
    FROM adm_tp a
    LEFT JOIN mapel m ON m.id = a.mapel
    WHERE a.id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$idcp]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
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
			   <?php if($input ==='Manual'): ?>
			<form id='formcpel' class="row g-1">
			<?php else: ?>
			<form id='form-impor' class="row g-1">
			<?php endif; ?>
				<div class="col-md-12 mb-1">
				  <label class="bold">Input</label>
                    <select name="input" id="input" class='form-select' style='width:100%' required="true" > 
						<option value="<?= $input ?>"> <?= $input ?></option>
						<option value="Manual"> Manual</option>
						<option value="Import"> Import</option>
						</select>
                    </div>
				<script>
                    document.getElementById('input').addEventListener('change', () => {
                        const input = document.querySelector('#input').value;
						 const id = "<?= $_GET['id'] ?>";
                        location.replace(`?pg=<?= enkripsi('cpel') ?>&input=${input}&id=${id}`);
                    });
                </script>
				<input type="hidden" name="idlingkup" value="<?= $idcp; ?>" >
				<div class="col-md-12 mb-1">
			   <label class="bold">Mata Pelajaran</label>
					<select  class='form-select' style='width:100%' required="true" >                                         
					<option value="<?= $idcp; ?>"><?= $data['nama_mapel'] ?></option>  
					<select>
					</div>
				<div class="col-md-12 mb-1">
			   <label class="bold">Lingkup Materi</label>
					<select name="idl" class='form-select' style='width:100%' required="true" >                                         
					<option value="<?= $idcp; ?>"><?= $data['lingkup'] ?></option>  
					<select>
					</div>
				 <?php if($input ==='Manual'): ?>
				<div class="col-md-12 mb-1">
					<label class="bold">Elemen / Sub Materi</label>
					<textarea name="elemen" class="form-control" rows="3" required="true" maxlength="200" ></textarea>							   
			   </div>
			   <div id="count" style="color:blue;">
					<span id="current_count">0</span>
					<span id="maximum_count">/ 200</span>
				</div>
				<script type="text/javascript">
				$('textarea').keyup(function() {    
				var characterCount = $(this).val().length,
				current_count = $('#current_count'),
				maximum_count = $('#maximum_count'),
				count = $('#count');    
				current_count.text(characterCount);        
				});
				</script>
				<div class="col-md-12 mb-1">
					<label class="bold">Capaian Pembelajaran</label>
					<textarea name="cp" class="form-control textarea" rows="5" required="true" maxlength="200" ></textarea>							   
			   </div>
			   <div id="count2" style="color:red;">
					<span id="current_count2">0</span>
					<span id="maximum_count2">/ 200</span>
				</div>
				<script type="text/javascript">
				$('.textarea').keyup(function() {    
				var characterCount2 = $(this).val().length,
				current_count2 = $('#current_count2'),
				maximum_count2 = $('#maximum_count2'),
				count2 = $('#count2');    
				current_count2.text(characterCount2);        
				});
				</script>
				<div class="widget-payment-request-actions m-t-lg d-flex">

				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
				 <?php else : ?>
					<div class="widget-payment-request-info m-t-md"> 
					<a href="adm/CAPAIAN_PEMBELAJARAN.xlsx" class="btn btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
							<i class="material-icons">download</i> Format
						</a>	 	
					<label class="bold">Pilih File</label>			            
					<div class="input-group mb-3">
					  <input type='file' name='file' id="fileInput" class='form-control' required accept=".xlsx">
						<span class="input-group-text">
							<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
						</span>
                      </div>
					</div>
					<?php endif; ?>
				</form>
				
			 </div>
		</div>
		</div>
	</div>

<script>
$('#formcpel').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			 url: 'adm/tcpel.php?pg=tambah',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			
			},
			success: function(data) {
			   
				setTimeout(function() {
					window.location.reload();
				}, 200);
			}
		})
		return false;
	});
	</script>
<script>
	$('#form-impor').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
			$.ajax({
			type: 'POST',
			url: 'adm/impor_capaian.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
						},
			success: function(data) {
				setTimeout(function() {
				window.location.reload();
					}, 200);
				}
			})
			return false;
			});
	</script>
<?php elseif ($ac == enkripsi('edit')): ?>
<?php
$idcp = $_GET['id'] ?? '';
$sql = "SELECT *
        FROM adm_tp a
        LEFT JOIN cp_elemen c ON c.id_lingkup = a.id
        WHERE a.id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$idcp]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
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
			<form id='formedit'>
				<input type="hidden" name="idel" value="<?= $data['id_elemen'] ?>" >
				<div class="col-md-12 mb-1">
			   <label class="bold">Lingkup Materi</label>
					<select  class='form-select' style='width:100%' required="true" >                                         
					<option value="<?= $idcp; ?>"><?= $data['lingkup'] ?></option>  
					<select>
					</div>
				<div class="col-md-12 mb-1">
					<label class="bold">Elemen / Sub Materi</label>
					<textarea name="elemen" class="form-control" rows="3" required="true" maxlength="200" ><?= $data['elemen'] ?></textarea>							   
			   </div>
			   <div id="count" style="color:blue;">
					<span id="current_count">0</span>
					<span id="maximum_count">/ 200</span>
				</div>
				<script type="text/javascript">
				$('textarea').keyup(function() {    
				var characterCount = $(this).val().length,
				current_count = $('#current_count'),
				maximum_count = $('#maximum_count'),
				count = $('#count');    
				current_count.text(characterCount);        
				});
				</script>
				<div class="col-md-12 mb-1">
					<label class="bold">Capaian Pembelajaran</label>
					<textarea name="cp" class="form-control textarea" rows="5" required="true" maxlength="200" ><?= $data['capaian'] ?></textarea>							   
			   </div>
			   <div id="count2" style="color:red;">
					<span id="current_count2">0</span>
					<span id="maximum_count2">/ 200</span>
				</div>
				<script type="text/javascript">
				$('.textarea').keyup(function() {    
				var characterCount2 = $(this).val().length,
				current_count2 = $('#current_count2'),
				maximum_count2 = $('#maximum_count2'),
				count2 = $('#count2');    
				current_count2.text(characterCount2);        
				});
				</script>
				<div class="widget-payment-request-actions m-t-lg d-flex">

				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
				</form>
				
			 </div>
		</div>
		</div>
	</div>

<script>
$('#formedit').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			 url: 'adm/tcpel.php?pg=edit',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			
			},
			success: function(data) {
			   
				setTimeout(function() {
					window.location.replace("?pg=<?= enkripsi('cpel') ?>&id=<?= $idcp ?>");
				}, 200);
			}
		})
		return false;
	});
	</script>

<?php endif ?>


					  
					  	  
					  
					  
					