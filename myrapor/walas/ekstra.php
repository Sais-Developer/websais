<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
	<?php
	$ket = $_GET['kt'] ?? '';
	$kelasmu = $_GET['k'] ?? '';
    $eskulmu = $_GET['e'] ?? '';
    $ids = $_GET['ids'] ?? '';
 	$semester = $setting['semester'];
	$tapel = $setting['tp'];
	?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">
					<?php if($_GET['k']==''): ?>
					PENGOLAHAN EKSTRAKURIKULER  
					<?php else: ?>
					EKSTRAKURIKULER <?= $ket ?>
					<span class="badge badge-primary"><?= $eskulmu ?></span>
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
					  <th>PRED</th>
					  <th></th>												  
					</tr>
				</thead>											
				<tbody>	
				<?php
					$no = 0;
					$query = "
						SELECT s.*, p.nilai
						FROM siswa s
						LEFT JOIN peskul p 
							ON p.idsiswa = s.id_siswa
							AND p.ket = :ket
							AND p.eskul = :eskul
							AND p.semester = :semester
							AND p.tapel = :tapel
						WHERE s.kelas = :kelas
					";
					$stmt = $pdo->prepare($query);
					$stmt->execute([
						':ket'      => $ket,
						':eskul'    => $eskulmu,
						':semester' => $semester,
						':tapel'    => $tapel,
						':kelas'    => $kelasmu
					]);

					$siswaData = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($siswaData as $data) {
						$no++;
						$stmt2 = $pdo->prepare("
							SELECT COUNT(*) 
							FROM peskul 
							WHERE idsiswa = :idsiswa 
							  AND eskul = :eskul 
							  AND ket = :ket 
							  AND semester = :semester 
							  AND tapel = :tapel
						");
						$stmt2->execute([
							':idsiswa'  => $data['id_siswa'],
							':eskul'    => $eskulmu,
							':ket'      => $ket,
							':semester' => $semester,
							':tapel'    => $tapel
						]);
						$jumlah = $stmt2->fetchColumn();
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']) ?></td>
							<td><?= htmlspecialchars($data['nilai']) ?></td>
							<td>
							<?php if($jumlah == 0): ?>
								<a href="?pg=<?= enkripsi('ekstra') ?>&ids=<?= $data['id_siswa'] ?>&k=<?= $kelasmu; ?>&e=<?= $eskulmu; ?>&kt=<?= $ket; ?>">
									<button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Input Capaian">
										<i class="material-icons">add</i>
									</button>
								</a>
							<?php else: ?>
								<button class='btn btn-sm btn-secondary'>
									<i class="material-icons">lock</i>
								</button>
							<?php endif; ?>
							</td>
						</tr>
					<?php } ?>
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
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
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
									try {
										if ($user['level'] === 'admin') {
											$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
											$stmt->execute();
										} elseif ($user['level'] === 'guru') {
											$stmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = :kelas");
											$stmt->execute([':kelas' => $user['walas']]);
										}

										$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
										foreach ($kelasList as $data) {
											$kelas = htmlspecialchars($data['kelas']);
											echo "<option value=\"{$kelas}\">{$kelas}</option>";
										}
									} catch (PDOException $e) {
										echo "<option value=''>Error: {$e->getMessage()}</option>";
									}
									?>
								</select>
						</div>
						<div class="col-md-12 mb-1">
					   <label class="bold">Ekstrakurikuler</label>
							<select name="eskul" id="eskul" class='form-select' style='width:100%' required>
								<option value="">Pilih Eskul</option>
								<?php
								try {
									$stmt = $pdo->prepare("SELECT * FROM m_eskul");
									$stmt->execute();
									while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
										$eskul = htmlspecialchars($data['eskul']);
										echo "<option value=\"{$eskul}\">{$eskul}</option>";
									}
								} catch (PDOException $e) {
									echo "<option value=''>Error: {$e->getMessage()}</option>";
								}
								?>
							</select>
						</div>
						<div class="widget-payment-request-actions m-t-lg d-flex">
						 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
			 
							</div>
							<?php else: ?>
							
								<?php
									try {
										$stmtSiswa = $pdo->prepare("SELECT nis,nama FROM siswa WHERE id_siswa = :id_siswa LIMIT 1");
										$stmtSiswa->execute([':id_siswa' => $ids]);
										$siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC);
									} catch (PDOException $e) {
										echo "Error: " . $e->getMessage();
									}
									?>
								<?php if($ids !=''): ?>
								 <div class="widget-payment-request-info m-t-md">
									<input type="text" class="form-control" value="<?= $siswa['nama'] ?>" ><br>
									<p>Pastikan <strong><?= $siswa['nama'] ?></strong> mengikuti Ekstrakurikuler <strong><?= $eskulmu ; ?></strong></p>
									<form id='formcapaian' >
									<input type="hidden" class="form-control" name="ids" value="<?= $ids ?>" >
									<input type="hidden" class="form-control" name="nis" value="<?= $siswa['nis'] ?>" >
									<input type="hidden" class="form-control" name="eskul" value="<?= $eskulmu ?>" >
									<input type="hidden" class="form-control" name="ket" value="<?= $ket ?>" >
									<div class="col-md-12 mb-1">
								   <label class="bold">Predikat</label>
										<select name="nilai" id="nilai" class='form-select' style='width:100%' required="true" >                                         
										<option value="">Pilih Predikat</option>
										<option value="A">Sangat Baik</option>
										<option value="B">Baik</option>
										<option value="C">Cukup</option>
										<option value="D">Perlu Bimbingan</option>
										</select>
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
	<?php endif ?>
					
<script type="text/javascript">
	$('#pilih').click(function() {	
	var k = $('#kelas').val();
	var e = $('#eskul').val();
	var kt = $('#ket').val();
	location.replace("?pg=<?= enkripsi('ekstra') ?>&k=" + k + "&e=" + e + "&kt=" + kt);
	}); 
</script>
									 
<script>
$('#formcapaian').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'walas/ekstra_pts.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            if(response === "OK") {
                $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>'); 
                setTimeout(function() {
                    window.location.reload();
                }, 500); 
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Sudah diinput',
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    background: 'rgba(0, 0, 0, 0.5)',
                    color: '#fff'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX Error',
                text: "Terjadi kesalahan: " + error
            });
        }
    });
    return false;
});
</script>
<?php endif; ?>
									 
									  
					  
					  
					  	  
					  
					  
					