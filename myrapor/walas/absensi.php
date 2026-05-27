<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
	<?php
	$ket = $_GET['kt'] ?? '';
	$kelasmu = $_GET['k'] ?? '';
    
 	$semester = $setting['semester'];
	$tapel = $setting['tp'];
	?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card card-header">
					<h5 class="card-title">
					<?php if($_GET['k']==''): ?>
					PENGOLAHAN PRESENSI  
					<?php else: ?>
					PRESENSI <?= $ket ?>
					
					<span class="badge badge-primary"><?= $kelasmu ?></span>
					<span class="badge badge-success"><?= $semester ?></span>
					<?php endif; ?>
					</h5>										
			</div>
	<div class="card-body">
		<table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
			      <thead>
						<tr>
						  <th width="10%">NO</th>												  												 
						  <th>NAMA SISWA</th>
						  <th>S</th>
						  <th>I</th>
						  <th>A</th>
						  <th></th>												  
						</tr>
					</thead>											
						<tbody>	
						<?php
					$no = 0;
					$query = "
						SELECT 
							s.id_siswa, 
							s.nama, 
							COALESCE(a.sakit, 0) AS sakit,
							COALESCE(a.izin, 0) AS izin,
							COALESCE(a.alpha, 0) AS alpha
						FROM siswa s
						LEFT JOIN absen_rapor a 
							ON a.idsiswa = s.id_siswa 
							AND a.semester = :semester
							AND a.tapel = :tapel
							AND a.ket = :ket
						WHERE s.kelas = :kelas
						ORDER BY s.nama ASC
					";

					$stmt = $pdo->prepare($query);
					$stmt->execute([
						':semester' => $semester,
						':tapel'    => $tapel,
						':ket'      => $ket,
						':kelas'    => $kelasmu
					]);

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$no++;
					?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $data['nama'] ?></td>
							<td><?= $data['sakit'] ?></td>
							<td><?= $data['izin'] ?></td>
							<td><?= $data['alpha'] ?></td>

							<td>
								<a href="?pg=<?= enkripsi('absensi') ?>&ids=<?= $data['id_siswa'] ?>&k=<?= $kelasmu; ?>&kt=<?= $ket; ?>"
								   class='btn btn-sm btn-primary'
								   data-bs-toggle="tooltip"
								   data-bs-placement="top"
								   title="Input Presensi">
									<i class="material-icons">edit</i>
								</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="card">                                
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
			</div>
		<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
			<div class="text-muted">HIGH SCHOOL</div>
			</div>
			<?php if($kelasmu==''): ?>
			<div class="col-md-12 mb-1">
			  <label class="bold">Semester</label>
			   <select name="smt"  class='form-select' style='width:100%' required="true" > 
			   <option value="<?= $semester ?>"><?= $semester ?></option>
				</select>
			   </div>
				
			   <div class="col-md-12 mb-1">
			   <label class="bold">Penilaian</label>
					<select name="ket" id="ket" class='form-select' style='width:100%' required="true" >                                         
					<option value="">Pilih Penialain</option> 
					<option value="PTS">PTS</option> 
					<?php if($setting['semester']=='1'): ?>
					<option value="PAS">PAS</option> 
					<?php else: ?>
					<option value="PAT">PAT</option> 
					<?php endif; ?>
					</select>
				</div>
			<div class="col-md-12 mb-1">
			   <label class="bold">Kelas</label>
					<select name="kelas" id="kelas" class='form-select' style='width:100%' required>
						<option value="">Pilih Kelas</option>
						<?php
						if ($user['level'] == 'admin') {
							$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
							$stmt->execute();
						} elseif ($user['level'] == 'guru') {
							$stmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = :kelas");
							$stmt->execute([
								':kelas' => $user['walas']
							]);
						}

						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
							<option value="<?= htmlspecialchars($data['kelas']) ?>">
								<?= htmlspecialchars($data['kelas']) ?>
							</option>
						<?php } ?>
					</select>
				</div>
				
				
				<div class="widget-payment-request-actions m-t-lg d-flex">
				 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
	 
					</div>
					<?php else: ?>
					<?php 
							$ids = $_GET['ids'] ?? '';
							$query = "
								SELECT 
									s.id_siswa, 
									s.nama, s.nis,
									COALESCE(a.sakit, 0) AS sakit,
									COALESCE(a.izin, 0) AS izin,
									COALESCE(a.alpha, 0) AS alpha
								FROM siswa s
								LEFT JOIN absen_rapor a 
									ON a.idsiswa = s.id_siswa 
									AND a.semester = :semester
									AND a.tapel = :tapel
									AND a.ket = :ket
								WHERE s.id_siswa = :ids
							";

							$stmt = $pdo->prepare($query);
							$stmt->execute([
								':semester' => $semester,
								':tapel'    => $tapel,
								':ket'      => $ket,
								':ids'      => $ids
							]);

							$siswa = $stmt->fetch(PDO::FETCH_ASSOC);
							?>
						<div class="widget-payment-request-info m-t-md">
							
							<input type="text" class="form-control" value="<?= $siswa['nama'] ?>" readonly><br>
							<p>Pastikan Presensi <strong><?= $siswa['nama'] ?></strong> sudah di rekap <strong></p>
							<form id='formsiswa' >
							<input type="hidden" class="form-control" name="ids" value="<?= $ids ?>" >
							<input type="hidden" class="form-control" name="nis" value="<?= $siswa['nis'] ?>" >
							<input type="text" class="form-control" name="ket" value="<?= $ket ?>" readonly>
							<div class="row">
							<div class="col-md-4 mb-1">
							  <label class="bold">Sakit</label>
							  <input type="number" class="form-control" name="sakit" value="<?= $siswa['sakit'] ?>" >
							   </div>
							   <div class="col-md-4 mb-1">
							  <label class="bold">Izin</label>
							  <input type="number" class="form-control" name="izin" value="<?= $siswa['izin'] ?>" >
							   </div>
							   <div class="col-md-4 mb-1">
							  <label class="bold">Alpha</label>
							  <input type="number" class="form-control" name="alpha" value="<?= $siswa['alpha'] ?>" >
							   </div>
							   </div>
							 <div class="widget-payment-request-actions m-t-lg d-flex">
							 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
							 </div>
							 </form>
						</div>
					<?php endif; ?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
					  
					
	<script type="text/javascript">
	$('#pilih').click(function() {	
	var k = $('#kelas').val();
	var kt = $('#ket').val();
	location.replace("?pg=<?= enkripsi('absensi') ?>&k=" + k + "&kt=" + kt);
	}); 
</script>
  <script>
	$('#formsiswa').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
			 url: 'walas/tabsensi.php',
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
<?php endif; ?>
 
  



					  
					  
					