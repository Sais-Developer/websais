<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
	<?php
	    $ids = $_GET['ids'] ?? '';
		$ket = $_GET['kt'] ?? '';
        $kelasmu = $_GET['k'] ?? '';
		$semester = $setting['semester'];
		$tapel = $setting['tp'];
	?>
<div class="row">
  <div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">
				<?php if($_GET['k']==''): ?>
				PENGOLAHAN KOKURIKULER 
				<?php else: ?>
				KOKURIKULER <?= $ket ?>
				<span class="badge badge-success"><?= $kelasmu ?></span>
				<?php endif; ?>
				</h5>										
			</div>
			<div class="card-body">
					<table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
						<thead>
							<tr>
							  <th width="10%">NO</th>												  
							 
							  <th>NAMA SISWA</th>
							  <th>DESKRIPSI</th>
							  <th></th>												  
							</tr>
						</thead>											
						<tbody>	
						<?php
							$no = 0;
							$stmt = $pdo->prepare("
								SELECT s.*, k.idk, k.mampu, k.kurang
								FROM siswa s
								LEFT JOIN kokurikuler k 
									ON k.idsiswa = s.id_siswa 
									AND k.keter = :ket
									AND k.smt = :semester
									AND k.tapel = :tapel
								WHERE s.kelas = :kelas
								ORDER BY s.id_siswa ASC
							");
							$stmt->execute([
								':ket' => $ket,
								':semester' => $semester,
								':tapel' => $tapel,
								':kelas' => $kelasmu
							]);
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$no++;
						?>
						<?php
							$idsiswa  = $data['id_siswa'];
							$keter    = $ket;
							$semester = $setting['semester'];
							$tapel    = $setting['tp'];

							$stmtJ = $pdo->prepare("
								SELECT COUNT(*) AS total
								FROM kokurikuler
								WHERE idsiswa = :idsiswa
								  AND keter = :keter
								  AND smt = :semester
								  AND tapel = :tapel
							");

							$stmtJ->execute([
								':idsiswa' => $idsiswa,
								':keter'   => $keter,
								':semester'=> $semester,
								':tapel'   => $tapel
							]);
							$jumlah = $stmtJ->fetch(PDO::FETCH_ASSOC);
							$total   = $jumlah['total'] ?? 0;
							?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $data['nama'] ?></td>
							<?php if (!empty($data['mampu'])): ?>
							<td>mampu <?= $data['mampu'] ?>, namun perlu bimbingan dalam <?= $data['kurang'] ?></td>
							<?php else: ?>
							<td></td>
							<?php endif; ?>
							<td>
							<?php if($jumlah['total']==0): ?>
								<a href="?pg=<?= enkripsi('kokupts') ?>&ids=<?= $data['id_siswa'] ?>&k=<?= $kelasmu; ?>&kt=<?= $ket; ?>">
									<button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Deskripsi Kokurikuler">
										<i class="material-icons">add</i>
									</button>
								</a>
								<?php else: ?>
								<button data-id="<?= $data['idk']; ?>" 
								class="hapus btn btn-sm btn-danger" 
								data-bs-toggle="tooltip" 
								data-bs-placement="top" 
								title="Hapus">
							<i class="material-icons">delete</i>
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
			<?php if($kelasmu===''): ?>
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
							<select name="kelas" id="kelas" class="form-select" style="width:100%" required>
								<option value="">Pilih Kelas</option>
								<?php
								if ($user['level'] == 'admin') {
									$stmt = $pdo->query("SELECT kelas FROM m_kelas");
									$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								} elseif ($user['level'] == 'guru') {
									$stmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = :walas");
									$stmt->execute([':walas' => $user['walas']]);
									$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								foreach ($kelasList as $data) {
									$kelas = htmlspecialchars($data['kelas']);
									echo "<option value='{$kelas}'>{$kelas}</option>";
								}
								?>
							</select>
						</div>
						<div class="widget-payment-request-actions m-t-lg d-flex">
						   <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
			            </div>
						<?php else: ?>
							<?php
							$stmtSiswa = $pdo->prepare("SELECT nis, nama FROM siswa WHERE id_siswa = :id_siswa LIMIT 1");
							$stmtSiswa->execute([':id_siswa' => $ids]);
							$siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC);
							?>
						<div class="widget-payment-request-info m-t-md">
							<input type="text" class="form-control" value="<?= $siswa['nama'] ?>" ><br>
							<form id='formcapaian' >
									<input type="hidden" name="ids" value="<?= $ids; ?>" >
									<input type="hidden" name="nis"  value="<?= $siswa['nis'] ?>" >
									<input type="hidden" name="ket" value="<?= $ket; ?>" >
									<table  style="font-size:12px">
									<tr>
									<th>Capaian Kokurikuler Kurang Tercapai</th>
									<tr>
										<?php
										$stmt = $pdo->prepare("SELECT * FROM deskrip_kebiasaan");
										$stmt->execute();
										while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
										?>
									<tr>
									<td><input type="radio" name="rendah" value="<?= $data['deskripsi'] ?>" required> <?= $data['kebiasaan'] ?></td>
									</tr>
									<?php endwhile; ?>
									</table>
									<br>
									<table class="table-analisis" style="font-size:13px">
									<tr>
									<th>Capaian Kokurikuler Tercapai</th>
									<tr>
									<?php
										$stmt = $pdo->prepare("SELECT * FROM deskrip_kebiasaan");
										$stmt->execute();
										while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
										?>
									<tr>
									<td><input type="radio" name="tinggi" value="<?= $data['deskripsi'] ?>" required> <?= $data['kebiasaan'] ?></td>
									</tr>
									<?php endwhile; ?>
									</table>
									
									 <div class="widget-payment-request-actions m-t-lg d-flex">
									 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
									 </div>
									 </form>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif ?>
					
<script type="text/javascript">
	$('#pilih').click(function() {	
	var k = $('#kelas').val();
	var kt = $('#ket').val();
	location.replace("?pg=<?= enkripsi('kokupts') ?>&k=" + k + "&kt=" + kt);
	}); 
</script>
									
<script>
$('#formcapaian').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'nilai/tkoku.php',
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
            } else if(response === "SD") {
                Swal.fire({
                    icon: 'error',
					width: '320px',
                    title: 'Error!',
                    text: 'Sudah diinput',
                    confirmButtonColor: '#3085d6',
                });
            } else {
                Swal.fire({
                    icon: 'error',
					width: '320px',
                    title: 'Error!',
                    text: 'Capaian Tidak Boleh Sama',
                    confirmButtonColor: '#3085d6',
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX Error!',
                text: "Terjadi kesalahan: " + error,
                confirmButtonColor: '#3085d6',
            });
        }
    });
    return false;
});
</script>

<script>
	$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
		console.log(id);
		Swal.fire({
		title: 'Hapus Data',
		text: "Hapus Deskripsi",
		icon: 'warning',
		width:'320px',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
		$.ajax({
		url: 'nilai/hapus.php',
		method: "POST",
		data: 'id=' + id,
		success: function(data) {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		setTimeout(function() {
		window.location.reload();
		}, 200);
			}
		});
		}
		return false;
		})

		});

	</script>									  
					  
					  	  
					  
					  
					