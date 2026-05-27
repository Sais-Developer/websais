<?php
defined('APK') or exit('No Access');
?>           
<div class="row">
  <div class="col-md-8">
	<div class="card">
		 <div class="card card-header">       
		<h5 class="card-title">PROGRAM SEMESTER</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<?php
				$no = 0;
				if ($user['level'] === 'admin') {
					$sql = "
						SELECT a.*, m.kode, g.nama
						FROM adm_tp a
						LEFT JOIN mapel m ON m.id = a.mapel
						LEFT JOIN guru g ON g.id_guru = a.guru
						WHERE a.semester = ?
						ORDER BY a.id DESC
						LIMIT 3
					";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$semester]);
				} elseif ($user['level'] === 'guru') {

					$sql = "
						SELECT a.*, m.kode, g.nama
						FROM adm_tp a
						LEFT JOIN mapel m ON m.id = a.mapel
						LEFT JOIN guru g ON g.id_guru = a.guru
						WHERE a.guru = ? AND a.semester = ?
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute([$id_user, $semester]);
				}
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
					$no++;
				?>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
					
					 <div class="sw-13 position-relative mb-3">
						<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
						</div>
					<div class="text-muted">PROMES</div>
					<div class="h5 mb-0"><?= $data['kode'] ?> <?= $data['tingkat'] ?></div>
						  <span><?= $data['nama'] ?></span>
						</div>
					  </div>
					</div>
				</div>		
				<?php endwhile; ?>
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
		<form method="GET" action="adm/promes.php" target="_blank"  enctype="multipart/form-data">
		<div class="col-md-12 mb-1">
		  <label class="bold">Semester</label>
		   <select name="smt"  class='form-select' style='width:100%' required="true" > 
			<option value="<?= $semester ?>"><?= $semester ?></option>
			</select>
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
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					?>
						<option value="<?= $data['id_guru'] ?>"><?= htmlspecialchars($data['nama']) ?></option>
					<?php
					}
					?>		                                           
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
		url: "adm/ambildata.php?pg=kelas", 
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
		url: "adm/ambildata.php?pg=mapel",  
		data: "kelas=" + kelas + "&guru=" + guru, 
		success: function(response) { 
		$("#mapel").html(response);
		console.log(response);
		}
	});
});

$("#mapel").change(function() {
	var mapel = $(this).val();
	var guru = $("#guru").val();							
	console.log(mapel + guru);
	$.ajax({
		type: "POST",
		url: "adm/ambildata.php?pg=elemen",  
		data: "mapel=" + mapel + "&guru=" + guru, 
		success: function(response) { 
		$("#elemen").html(response);
		console.log(response);
		}
	});
});
</script>
	       
             