<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
   <div class="col-md-8">
      <div class="card">
    <div class="card-header">
		<h5 class="card-title">LINGKUP MATERI</h5>
		 </div>
	<div class="card-body">
	<div class="table-responsive">
       <table id="datatable1" class="table table-bordered">
        <thead>
           <tr>
            <th width="5%">#</th>  	
			<th>MAPEL</th>
			<th>LINGKUP MATERI</th>
            <th width="8%">ELEMEN</th>										
			<th></th>
           </tr>
        </thead>
        <tbody>
		<?php
			$no = 0;
			if ($user['level'] === 'admin') {
				$sql = "
					SELECT a.*, m.kode, g.nama,
					(SELECT COUNT(*) FROM cp_elemen c WHERE c.id_lingkup = a.id) AS jumel
					FROM adm_tp a
					LEFT JOIN mapel m ON m.id = a.mapel
					LEFT JOIN guru g ON g.id_guru = a.guru
					WHERE a.semester = ?
				";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$semester]);

			} elseif ($user['level'] === 'guru') {
				$sql = "
					SELECT a.*, m.kode, g.nama,
					(SELECT COUNT(*) FROM cp_elemen c WHERE c.id_lingkup = a.id) AS jumel
					FROM adm_tp a
					LEFT JOIN mapel m ON m.id = a.mapel
					LEFT JOIN guru g ON g.id_guru = a.guru
					WHERE a.semester = ? AND a.guru = ?
				";

				$stmt = $pdo->prepare($sql);
				$stmt->execute([$semester, $id_user]);
			}

			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
				$no++;
			?>
				<tr style="vertical-align:middle">
					<td><?= $no; ?></td>
					<td>
						<span class="badge bg-primary"><?= $data['tingkat'] ?></span>
						<span class="badge bg-dark"><?= $data['kode'] ?></span>
						<?= $data['nama'] ?>
					</td>
					<td><?= $data['lingkup'] ?></td>
					<td class="text-center">
						<span class="badge bg-success"><?= $data['jumel'] ?></span>
					</td>
					<td>
						<a href="?pg=<?= enkripsi('cpel') ?>&id=<?= $data['id'] ?>"
						   class="btn btn-sm btn-success"
						   data-bs-toggle="tooltip" data-bs-placement="top" title="Capaian Pembelajaran">
							<i class="material-icons">add</i>
						</a>

						<a href="?pg=<?= enkripsi('lingkup') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $data['id'] ?>"
						   class="btn btn-sm btn-primary"
						   data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
							<i class="material-icons">edit</i>
						</a>

						<button data-id="<?= $data['id'] ?>"
								class="hapus btn btn-sm btn-danger"
								data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
        url: 'adm/tlingkup.php?pg=hapus',
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
<?php $input = $_GET['input'] ?? ''; ?>
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
			<form id='formcp' class="row g-1">
			<?php else: ?>
			<form id='form-impor' class="row g-1">
			<?php endif; ?>
			<div class="col-md-6 mb-1">
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
                        location.replace(`?pg=<?= enkripsi('lingkup') ?>&input=${input}`);
                    });
                </script>
				<div class="col-md-6 mb-1">
				  <label class="bold">Semester</label>
                    <select name="smt"  class='form-select' style='width:100%' required="true" > 
						<option value="<?= $setting['semester'] ?>">Semester <?= $setting['semester'] ?></option>
						</select>
                    </div>
				<div class="col-md-12 mb-1">
				   <label class="bold">Guru</label>
					<select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="">Pilih Guru</option>  
						<?php
							if ($user['level'] == 'admin') {
								$stmt = $pdo->prepare("SELECT * FROM guru WHERE level = 'guru'");
								$stmt->execute();
							} elseif ($user['level'] == 'guru') {
								$stmt = $pdo->prepare("SELECT * FROM guru WHERE level = 'guru' AND id_guru = ?");
								$stmt->execute([$id_user]);
							}

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
							?>
								<option value="<?= $data['id_guru'] ?>"><?= htmlspecialchars($data['nama']) ?></option>
							<?php
							}
							?>		                                           
						</select>
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Tingkat</label>
						<select name="level" id="level" class='form-select' style='width:100%' required="true" >                                         													                                           
						</select>
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Mapel</label>
						<select name="mapel" id="mapel" class='form-select' style='width:100%' required="true" >                                         													                                           
							</select>
                    </div>
				<?php if($input ==='Manual'): ?>
				<div class="col-md-12 mb-1">
					<label class="bold">Lingkup Materi</label>
						<textarea name="lingkup" class="form-control" rows="3" required="true" maxlength="200" ></textarea>							   
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
					<label class="bold">Tujuan Pembelajaran</label>
						<textarea name="tujuan" class="form-control textarea" rows="5" required="true" maxlength="200" ></textarea>							   
					</div>
				<div id="count2" style="color:red;" class="mb-4">
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
				<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
                   <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
                       </div>
					<?php else : ?>
					<div class="widget-payment-request-info m-t-md"> 
					<a href="adm/LINGKUP_MATERI.xlsx" class="btn btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
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
	
	<script>
		$("#guru").change(function() {
		var guru = $(this).val();						
		console.log(guru);
		$.ajax({
		type: "POST",
			url: "adm/ambil.php?pg=level", 
			data: "guru=" + guru, 
			success: function(response) { 
			$("#level").html(response);
			console.log(response);
					}
				});
			});
		</script>
		<script>
			$("#level").change(function() {
				var guru = $("#guru").val();							
				console.log(level + guru);
					$.ajax({
					type: "POST",
					url: "adm/ambil.php?pg=mapelguru", 
					data: "guru=" + guru, 
					success: function(response) { 
					$("#mapel").html(response);
					console.log(response);
						}
					});
				});
			</script>
    <script>
	$('#formcp').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
			$.ajax({
			type: 'POST',
			url: 'adm/tlingkup.php?pg=tambah',
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
			url: 'adm/impor_lingkup.php',
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
$id = intval($_GET['id']);

$sql = "
    SELECT a.*, 
           m.nama_mapel, 
           g.nama
    FROM adm_tp a
    LEFT JOIN mapel m ON m.id = a.mapel
    LEFT JOIN guru g ON g.id_guru = a.guru
    WHERE a.id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$agd = $stmt->fetch(PDO::FETCH_ASSOC);
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
					<input type="hidden" name="id" value="<?= $id; ?>" >
				<div class="col-md-12 mb-1">
					<label class="bold">Guru</label>
						<select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="<?= $agd['guru'] ?>"><?= $agd['nama'] ?></option>  			                                           
						</select>
                      </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Tingkat</label>
						<select name="level" id="level" class='form-select' style='width:100%' required="true" >                                         													                                           
						<option value="<?= $agd['tingkat'] ?>"><?= $agd['tingkat'] ?></option>
						</select>
                      </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Mapel</label>
						<select name="mapel" id="mapel" class='form-select' style='width:100%' required="true" >                                         													                                           
						<option value="<?= $agd['mapel'] ?>"><?= $agd['nama_mapel'] ?></option>
						</select>
                     </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Lingkup Materi</label>
						<textarea name="lingkup" class="form-control" rows="3" required="true" maxlength="200" ><?= $agd['lingkup'] ?></textarea>							   
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
					<label class="bold">Tujuan Pembelajaran</label>
						<textarea name="tujuan" class="form-control textarea" rows="5" required="true" maxlength="200" ><?= $agd['tujuan'] ?></textarea>							   
					</div>
				<div id="count2" style="color:red;" class="mb-4">
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
			<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
               <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
             </div>
			</form>
		</div>
	</div>
  </div>					
<script>
	$('#formedit').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
		$.ajax({
		type: 'POST',
		url: 'adm/tlingkup.php?pg=edit',
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
			window.location.replace("?pg=<?= enkripsi('lingkup') ?>");
					}, 200);
				}
			})
			return false;
		});
	</script>
							
			
 <?php endif ?>
</div>			  
					  
					  
					  	  
					  
					  
					