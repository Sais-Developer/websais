<?php
defined('APK') or exit('No Access');
$hari = date('D');
?>           
<?php if ($ac == '') : ?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card card-header">
					<h5 class="bold">CETAK NILAI HARIAN</h5>										
				</div>
		<div class="card-body">									
			<div class="card-box table-responsive">
				  <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>																  
						  <th>KODE</th>
						  <?php
							$stmt = $pdo->query("SELECT * FROM m_kelas");
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) : 
							?>
								<th><?= htmlspecialchars($data['kelas']) ?></th>
							<?php endwhile; ?>							 
						</tr>
					</thead>											
					<tbody>	
					<?php
						$no = 0;
						$stmt = $pdo->query("SELECT * FROM mapel");
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
					   <tr style="vertical-align:middle;">
						  <td><?= $data['kode'] ?></td>
							<?php
								$stmtX = $pdo->query("SELECT * FROM m_kelas");
								while ($datax = $stmtX->fetch(PDO::FETCH_ASSOC)) :
									$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM nilai_harian WHERE mapel = ? AND kelas = ?");
									$stmtCount->execute([$data['id'], $datax['kelas']]);
									$jum = $stmtCount->fetchColumn(); 
								?>
						  <td>
						  <?php if($jum<>0): ?>
						  <?= $jum ?> data
						  <?php endif; ?>
						  </td>
						  <?php endwhile; ?>
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
		<div class="d-flex align-items-center flex-column mb-4">
		  <div class="sw-13 position-relative mb-3">
		<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
		   </div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			<div class="text-muted">HIGH SCHOOL</div>
		   </div>	
		  <form method="GET" action="<?= $baseurl ?>/mykbm/ctnilai.php" target="_blank"  enctype="multipart/form-data">
		<div class="col-md-12 mb-1">
		   <label class="bold">Guru</label>
				<select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
				<option value="">Pilih Guru</option>
					<?php
					if ($user['level'] == 'admin') {
						$stmt = $pdo->query("SELECT * FROM guru");
					} elseif ($user['level'] == 'guru') {
						$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
						$stmt->execute([$id_user]);
					}

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>	
						<option value="<?= htmlspecialchars($data['id_guru']) ?>"><?= htmlspecialchars($data['nama']) ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12 mb-1">
				<label class="bold">Kelas</label>
				<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true" >                                         													                                           
				 </select>
			</div>
			<div class="col-md-12 mb-1">
				<label class="bold">Mapel</label>
				<select name="mapel" id="mapel" class='form-select' style='width:100%' required="true" >                                         													                                           
				 </select>
			</div>
			<div class="widget-payment-request-actions m-t-lg d-flex">
			 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">CETAK</button>                           
			</div>
			</form>
		 </div>
	</div>
	</div>
</div>
<script>
$("#guru").change(function() {
	var guru = $(this).val();						
	console.log(guru);
	$.ajax({
		type: "POST",
		url: "<?= $baseurl ?>/mykbm/adm/ambildata.php?pg=kelas", 
		data: "guru=" + guru, 
		success: function(response) { 
		$("#kelas").html(response);
		console.log(response);
		}
	});
});

$("#kelas").change(function() {
	var kelas = $(this).val();
	var guru = $("#guru").val();							
	console.log(kelas + guru);
	$.ajax({
		type: "POST",
		url: "<?= $baseurl ?>/mykbm/adm/ambildata.php?pg=mapel",  
		data: "kelas=" + kelas + "&guru=" + guru, 
		success: function(response) { 
		$("#mapel").html(response);
		console.log(response);
		}
	});
});
</script>
<?php endif ?>
	  
	  
	  
		  
	  
	  
	