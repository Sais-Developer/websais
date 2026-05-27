<?php
defined('APK') or exit('No Access');
$bulan = date('m');
$hari = date('D');
?>           
<div class="row">
  <div class="col-md-8">
	<div class="card">
		 <div class="card-header">       
		<h5 class="card-title">AGENDA GURU BULAN <?= strtoupper(bulan_indo($tanggal)) ?></h5>
		</div>
		<div class="card-body">
			<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover">
				   <thead>
				   <tr>
					<th>#</th>  	
					<th>TANGGAL</th>
					<th>NAMA GURU</th>										
					<th>KEGIATAN</th>													
					<th></th>
				   </tr>
				   </thead>
				   <tbody>
					<?php
						$no = 0;
						if ($user['level'] == 'admin') {
							$sql = "
								SELECT a.*, g.nama 
								FROM agenda a
								LEFT JOIN guru g ON g.id_guru = a.guru
								ORDER BY a.id DESC
							";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
						} elseif ($user['level'] == 'guru') {
							$sql = "
								SELECT a.*, g.nama
								FROM agenda a
								LEFT JOIN guru g ON g.id_guru = a.guru
								WHERE a.guru = ?
								ORDER BY a.id DESC
							";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$id_user]);
						}
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
				   <tr>
						<td><?= $no; ?></td>
						<td><?= $data['tanggal'] ?></td>
						<td><?= $data['nama'] ?></td>
						<td><?= $data['kegiatan'] ?> </td>
						
						<td>
						<a href="?pg=<?= enkripsi('agenda') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $data['id'] ?>" class="btn btn-sm btn-primary" 
						data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="material-icons">edit</i> </a>
						<button data-id="<?= $data['id'] ?>"  class="hapus btn btn-sm btn-danger" 
						data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="material-icons">delete</i> </button>
						</td>
				   </tr>
					<?php endwhile;?>
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
        url: 'tagenda.php?pg=hapus',
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
		          <form id='formagenda'>
		             <div class="col-md-12 mb-1">
		               <label class="bold">Tanggal</label>
			            <input type="text" name="tgl" class="datepicker form-control" value="<?= $tanggal; ?>" required="true" autocomplete="off">
		            </div>	
		        <div class="col-md-12 mb-1">
		           <label class="bold">Guru</label>
				    <select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="">Pilih Guru</option>
							<?php
							if ($user['level'] == 'admin') {
								$stmt = $pdo->prepare("SELECT * FROM guru");
								$stmt->execute();
							} elseif ($user['level'] == 'guru') {
								$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
								$stmt->execute([$id_user]);
							}

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
								<option value="<?= $data['id_guru'] ?>"><?= htmlspecialchars($data['nama']) ?></option>
							<?php } ?>                                   
					</select>
			    </div>
			<div class="col-md-12 mb-1">
				<label class="bold">Kegiatan</label>
				 <textarea name="kegiatan" class="form-control" rows="5" required></textarea>
			</div>
			<div class="col-md-12 mb-1">
				<label class="bold">Keterangan</label>
				 <textarea name="keterangan" class="form-control" rows="5" required></textarea>
			</div>
			<div class="widget-payment-request-actions m-t-lg d-flex">
			 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				</div>
			</form>
		 </div>
	   </div>
	</div>
<script>
$('#formagenda').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		 url: 'tagenda.php?pg=tambah',
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
$id = $_GET['id'];
$sql = "
    SELECT 
        a.*, 
        g.nama 
    FROM agenda a
    LEFT JOIN guru g ON g.id_guru = a.guru
    WHERE a.id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$agd = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
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
				  <label class="bold">Tanggal</label>
					<input type="text" name="tgl" class="datepicker form-control" value="<?= $tanggal; ?>" required="true" autocomplete="off">
				   </div>					
				<div class="col-md-12 mb-1">
				   <label class="bold">Guru</label>
						<select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="<?= $agd['guru'] ?>"><?= $agd['nama'] ?></option>  			                                           
						</select>
					</div>
					<div class="col-md-12 mb-1">
				<label class="bold">Kegiatan</label>
				 <textarea name="kegiatan" class="form-control" rows="5" required><?= $agd['kegiatan'] ?></textarea>
			</div>
			<div class="col-md-12 mb-1">
				<label class="bold">Keterangan</label>
				 <textarea name="keterangan" class="form-control" rows="5" required><?= $agd['keterangan'] ?></textarea>
			</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">

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
		 url: 'tagenda.php?pg=edit',
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
				window.location.replace("?pg=<?= enkripsi('agenda') ?>");
			}, 200);
		}
	})
	return false;
});
</script>
<?php elseif ($ac == enkripsi('jurnal')): ?>
<?php $id = $_GET['id']; ?>					                      
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
		<form id='formjurnal'>
		<input type="hidden" name="id" value="<?= $id; ?>" >								
			<div class="col-md-12 mb-1">
				<label class="bold">Hambatan</label>
				<textarea name="hambat" class="form-control" rows="3" required="true" maxlength="200" ></textarea>							   
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
				<label class="bold">Pemecahan</label>
				<textarea name="pecah" class="form-control textarea" rows="3" required="true" maxlength="200" ></textarea>							   
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
<script>
$('#formjurnal').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			 url: 'tagenda.php?pg=jurnal',
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
					window.location.replace("?pg=<?= enkripsi('agenda') ?>");
				}, 200);
			}
		})
		return false;
	});
	</script>
<?php endif ?>
</div>					  
					  
					  
					  	  
					  
					  
					