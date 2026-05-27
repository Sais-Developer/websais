<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card card-header">
					<h5 class="card-title">JENIS TEGURAN</h5>
					
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="10%">NO</th>  												
							<th>MIN</th>
							<th>MAX</th>
							<th>TEGURAN</th>
							<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
						$no = 0;
						$stmt = $pdo->prepare("SELECT * FROM teguran ORDER BY min_poin ASC");
						$stmt->execute();
						$dataTeguran = $stmt->fetchAll(PDO::FETCH_ASSOC);
						?>
						<?php foreach ($dataTeguran as $data): $no++; ?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $data['min_poin']; ?></td>
							<td><?= $data['max_poin']; ?></td>
							<td><?= htmlspecialchars($data['jenis_teguran']); ?></td>
							<td>
								<a href="?pg=<?= enkripsi('teguran') ?>&id=<?= $data['id_teguran'] ?>">
									<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
										<i class="material-icons">edit</i>
									</button>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php
$id = $_GET['id'] ?? '';
$stmt = $pdo->prepare("
    SELECT * 
    FROM teguran 
    WHERE id_teguran = :id 
    LIMIT 1
");
$stmt->execute(['id' => $id]);
$jenis = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null; 
?>
  <div class="col-md-4">
		<div class="card">                                
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
			 <div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				  <div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id='formkate' >	
			<input type="hidden" name="id" value="<?= $id ?>" >
			 <label class="bold">Minimal Poin</label>
			  <div class="input-group mb-1">
			   <input type='number' name='minpoin' value="<?= $jenis['min_poin'] ?>" class='form-control' required>									   
				</div>
			 <label class="bold">Maximal Poin</label>
			  <div class="input-group mb-1">
			   <input type='number' name='maxpoin' value="<?= $jenis['max_poin'] ?>" class='form-control' required>									   
				</div>											
				 <label class="bold">Jenis Teguran</label>
			  <div class="input-group mb-1">
			   <input type='text' name='jenis' value="<?= $jenis['jenis_teguran'] ?>" class='form-control' required>									   
				</div>
			   <label class="bold">Keterangan</label>
			  <div class="input-group mb-1">
			   <textarea name="keter" class='form-control' rows="3" required><?= $jenis['keterangan'] ?></textarea>									   
				</div>
				 <?php if($id !=''): ?>										
				<div class="widget-payment-request-actions m-t-lg d-flex">
				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
					<?php endif; ?>
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
			 url: 'master/ttegur.php',
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
				window.location.replace("?pg=<?= enkripsi('teguran') ?>");
				}, 200);
									  
				}
			});
			return false;
		});
	</script>	
							   