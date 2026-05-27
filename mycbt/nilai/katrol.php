<?php
defined('APK') or exit('No Access');
?>
<?php if ($ac == '') : ?>
    <div class='row'>
      <div class="col-md-8">
        <div class="card">
		    <div class="card-header">
                 <h5 class="card-title">DATA NILAI</h5> 
                </div>					 
	 <div class="card-body">   
		<div id="tablenilai" class='table-responsive'>
		   <table id="datatable1" class='table table-bordered table-analisis edis2'>
			<thead>
			<tr>
				<th width='8%'>#</th>                                 
				<th>MATA PELAJARAN</th>
				 <th>SESI</th>
				<th>TKT</th>                                									
				<th></th>
			</tr>
			</thead>
		   <tbody>
				<?php
				$no = 0;
				$stmt = $pdo->prepare("
					SELECT u.*, b.id_bank, b.tingkat, m.nama_mapel
					FROM ujian u
					LEFT JOIN banksoal b ON b.id_bank = u.idbank
					LEFT JOIN mapel m ON m.id = b.idmapel
				");
				$stmt->execute();
				$siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($siswaList as $data):
					$no++;
				?>
				<tr>
					<td><?= $no ?></td>
					<td><?= htmlspecialchars($data['nama_mapel']) ?></td>
					<td><h5><span class="badge badge-success"><?= htmlspecialchars($data['sesi']) ?></span></h5></td>
					<td><h5><span class="badge badge-dark"><?= htmlspecialchars($data['tingkat']) ?></span></h5></td>
					<td>
						<a href="?pg=<?= enkripsi('katrol') ?>&k=<?= enkripsi($data['tingkat']) ?>&m=<?= enkripsi($data['id_bank']) ?>" 
						   class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Setting Katrol">
						   <i class="material-icons">edit</i>
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
	$kelasmu = dekripsi($_GET['k'] ?? '');
	$idbank = dekripsi($_GET['m'] ?? '');
	
	$stmt = $pdo->prepare("
		SELECT b.*, m.*
		FROM banksoal b
		LEFT JOIN mapel m ON m.id = b.idmapel
		WHERE b.id_bank = :idbank
	");
	$stmt->execute(['idbank' => $idbank]);
	$map = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <div class="widget-payment-request-info m-t-md">
        <?php if($idbank !=''): ?>	
			<form id="formkatrol">
			<label class="bold">Mata Pelajaran</label>
			  <div class="input-group mb-1">
				<select name="idb" class='form-select' style='width:100%' required>
				 <option value="<?= $idbank ?>"><?= $map['nama_mapel'] ?></option> 
				  </select>                                                    
				</div>
			<label class="bold">Kelas</label>
			  <div class="input-group mb-1">
				<select name="kelas" class="form-select" style="width:100%" required>
						<option value=''>Pilih Kelas</option>
						<?php
						$stmt = $pdo->prepare("SELECT kelas, level FROM m_kelas WHERE level = :level");
						$stmt->execute(['level' => $kelasmu]);
						$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($kelasList as $kls) :
							$selected = ($kelas ?? '') === $kls['kelas'] ? 'selected' : '';
						?>
							<option value="<?= htmlspecialchars($kls['kelas']) ?>" <?= $selected ?>>
								<?= htmlspecialchars($kls['kelas']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<label class="bold">Nilai Terendah yg diinginkan </label>
					<div class="input-group mb-1">
						<input type="number" name="rendah" class="form-control" value="70" required="true" >                                                 
					</div>
				<label class="bold">Nilai Tertinggi yg diinginkan </label>
					<div class="input-group mb-1">
					<input type="number" name="tinggi" class="form-control" value="90" required="true" >                                                 
				</div>
				<div class="widget-payment-request-actions m-t-lg d-flex">
					<button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">SIMPAN</button>
					</div>
				</form>
				 <?php endif; ?>
			 </div>
		</div>
		</div>
	</div>
</div>

<script>
$('#formkatrol').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			 url: 'nilai/katrolnilai.php',
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
					window.location.replace("?pg=<?= enkripsi('ckatrol') ?>&idb=<?= $idbank ?>");
				}, 200);
			}
		})
		return false;
	});
	</script>
<?php endif; ?>
