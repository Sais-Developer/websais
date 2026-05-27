<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
	<?php
	    $ket = 'PAS';
        $kelasmu  = $_GET['k']   ?? '';
		$gurumu   = $_GET['g']   ?? '';
		$mapelmu  = $_GET['m']   ?? '';
		$ids      = $_GET['ids'] ?? '';

		$stmt = $pdo->prepare("SELECT * FROM mapel WHERE id = ? LIMIT 1");
		$stmt->execute([$mapelmu]);
		$mpl = $stmt->fetch(PDO::FETCH_ASSOC); 

		$semester = $setting['semester'];
		$tapel    = $setting['tp'];
	?>
<div class="row">
  <div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">
				<?php if($_GET['kt']==''): ?>
				PENGOLAHAN NILAI PAS 
				<?php else: ?>
				NILAI PAS 
				<span class="badge badge-success"><?= $semester ?></span>
				<span class="badge badge-primary"><?= $mpl['kode'] ?></span>
				<span class="badge badge-primary"><?= $kelasmu ?></span>
				<span class="badge badge-primary"><?= $_GET['ki'] ?></span>
				<?php endif; ?>
				</h5>										
			</div>
		<div class="card-body">
				<table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
					<thead>
						<tr>
						  <th width="10%">NO</th>												  
						 
						  <th>NAMA SISWA</th>
						  <th>PH</th>
						  <th>PTS</th>
						   <th>PAS</th>
						  <th>NR</th>
						  <th></th>												  
						</tr>
					</thead>											
					<tbody>	
					<?php
							$no = 0;
							$stmt = $pdo->prepare("
								SELECT s.id_siswa, s.nama, nr.nilai, nr.kodenilai, nr.ket
								FROM siswa s
								JOIN nilai_rapor nr ON nr.idsiswa = s.id_siswa
								WHERE s.kelas = :kelas AND nr.idmapel = :mapel AND nr.ket = 'PAS' AND nr.semester = :semester AND nr.tapel = :tapel
							");
							$stmt->execute([
								':kelas' => $kelasmu,
								':mapel' => $mapelmu,
								':semester' => $semester,
								':tapel' => $tapel
							]);

							$siswaData = [];
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$id = $row['id_siswa'];
								if (!isset($siswaData[$id])) {
									$siswaData[$id] = [
										'ids' => $row['id_siswa'],
										'nama' => $row['nama'],
										'PH' => [],
										'PTS' => [],
										'PAS' => [],
									];
								}

								if ($row['kodenilai'] === 'PH') {
									$siswaData[$id]['PH'][] = $row['nilai'];
								} elseif ($row['kodenilai'] === 'PTS') {
									$siswaData[$id]['PTS'][] = $row['nilai'];
								} elseif ($row['kodenilai'] === 'PAS') {
									$siswaData[$id]['PAS'][] = $row['nilai'];
								}
							}
							foreach ($siswaData as $id => $data):
								$no++;
								$phSum  = !empty($data['PH']) ? array_sum($data['PH']) : 0;
								$ptsSum = !empty($data['PTS']) ? array_sum($data['PTS']) : 0;
								$pasSum = !empty($data['PAS']) ? array_sum($data['PAS']) : 0;
								$nr = ($phSum + $ptsSum + $pasSum) / 3;

								$stmt2 = $pdo->prepare("
									SELECT COUNT(*) FROM nilai_capaian 
									WHERE idsiswa = :ids AND idmapel = :mapel AND ket = :ket AND semester = :semester AND tapel = :tapel
								");
								$stmt2->execute([
									':ids' => $data['ids'],
									':mapel' => $mapelmu,
									':ket' => 'PAS',
									':semester' => $semester,
									':tapel' => $tapel
								]);
								$jumlah = $stmt2->fetchColumn();
								?>

								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars($data['nama']); ?></td>
									<td><?= implode(", ", $data['PH']); ?></td>
									<td><?= implode(", ", $data['PTS']); ?></td>
									<td><?= implode(", ", $data['PAS']); ?></td>
									<td><?= round($nr); ?></td>
									<td>
										<?php if ($jumlah == 0): ?>
											<a href="?pg=<?= enkripsi('pas') ?>&ids=<?= $data['ids'] ?>&g=<?= $gurumu; ?>&k=<?= $kelasmu; ?>&m=<?= $mapelmu; ?>&nr=<?= $nr ?>">
												<button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Input Capaian">
													<i class="material-icons">add</i>
												</button>
											</a>
										<?php else: ?>
											<a href="?pg=<?= enkripsi('pas') ?>&ids=<?= $data['ids'] ?>&g=<?= $gurumu; ?>&k=<?= $kelasmu; ?>&m=<?= $mapelmu; ?>&nr=<?= $nr ?>">
												<button class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Capaian">
													<i class="material-icons">edit</i>
												</button>
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
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
				<p style="color:red;text-align:justify">Pastikan Rapor PTS sudah pernah diisi dan akan ikut terbackup ke Download Format, Jika belum silahkan diisi di Format Excel nya</p>
				<div class="col-md-12 mb-1">
				  <label class="bold">Semester</label>
				   <select name="smt"  class='form-select' style='width:100%' required="true" > 
				   <option value="<?= $semester ?>"><?= $semester ?></option>
					</select>
				   </div>
					<input type="hidden" name="kodenilai"  id="kodenilai" class='form-control kodenilai' value="PH" > 
				   
				<div class="col-md-12 mb-1">
				   <label class="bold">Guru</label>
						<select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="">Pilih Guru</option>  
						<?php
							if ($user['level'] == 'admin') {
								$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = 'guru'");
								$stmt->execute();
							} elseif ($user['level'] == 'guru') {
								$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE id_guru = ?");
								$stmt->execute([$id_user]);
							}
							$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
							foreach ($gurus as $data):
							?>
								<option value="<?= htmlspecialchars($data['id_guru']) ?>">
									<?= htmlspecialchars($data['nama']) ?>
								</option>
							<?php endforeach; ?>		                                           
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
					 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
		 
						</div>
						<?php else: ?>
						<?php if($ids ==''): ?>
						 <div class="widget-payment-request-info m-t-md"> 						      
					<form id='formmapel' >	
						<label class="bold">Pilih File</label>
						<a href="nilai/proses_pas.php?k=<?= $kelasmu; ?>&m=<?= $mapelmu; ?>&g=<?= $gurumu; ?>" class="btn btn-link kanan" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format"> <i class="material-icons">download</i> Format</a>	   				            
						<div class="input-group mb-2">
					   <input type='file' name='file' class='form-control' required accept=".xlsx">
							<span class="input-group-text">
								<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
								</span>
							</div>	
							</form>
							</div> 
						<?php endif; ?>
							<?php 
							$nilai_rata = round($_GET['nr'] ?? 0);
							$stmt = $pdo->prepare("SELECT level FROM m_kelas WHERE kelas = ? LIMIT 1");
							$stmt->execute([$kelasmu]);
							$level = $stmt->fetch(PDO::FETCH_ASSOC);

							$stmtSiswa = $pdo->prepare("SELECT nis, nama FROM siswa WHERE id_siswa = ? LIMIT 1");
							$stmtSiswa->execute([$ids]);
							$siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC);
							?>
							<?php if($ids !=''): ?>
							 <div class="widget-payment-request-info m-t-md">
								<p style="color:red;">Pastikan sudah mengisi Administrasi di menu E-KBM</p>
								
								<input type="text" class="form-control" value="<?= $siswa['nama'] ?>" ><br>
								<form id='formcapaian' >
								<input type="hidden" name="ids" value="<?= $ids; ?>" >
								<input type="hidden" name="nis" value="<?= $siswa['nis']; ?>" >
								<input type="hidden" name="mapel" value="<?= $mapelmu; ?>" >
								<input type="hidden" name="kelas" value="<?= $kelasmu; ?>" >
								<input type="hidden" name="guru" value="<?= $gurumu; ?>" >
								<input type="hidden" name="smt" value="<?= $semester; ?>" >
								<input type="hidden" name="tp" value="<?= $tapel; ?>" >
								<input type="hidden" name="nilai" value="<?= $nilai_rata; ?>" >
								
								<table  style="font-size:12px">
								<tr>
								<th>Capaian Pembelajaran Kurang Tercapai</th>
								<tr>
								<?php
								 $ket = 'PAS';
								if (!empty($ids)) {
									$stmt = $db->prepare("SELECT * FROM nilai_capaian WHERE idsiswa = :idsiswa AND idmapel=:idmapel AND ket=:ket AND semester=:semester AND tapel=:tapel");
									$stmt->execute(['idsiswa' => $ids, 'idmapel'=>$mapelmu, 'ket'=>$ket, 'semester'=>$semester, 'tapel'=>$tapel]);
									$datax = $stmt->fetch(PDO::FETCH_ASSOC);
								} else {
									$datax = null;
								}
								?>
								<?php
								$stmt = $pdo->prepare("
								SELECT * 
								FROM cp_elemen cp
								LEFT JOIN adm_tp a ON a.id = cp.id_lingkup
								WHERE a.tingkat = ? AND a.mapel = ? AND a.semester = ?
									");
									$stmt->execute([$level['level'], $mapelmu, $semester]);
									$elemenList = $stmt->fetchAll(PDO::FETCH_ASSOC);
									foreach ($elemenList as $data):
								?>
								<tr>
								<td><input type="radio" name="rendah" value="<?= $data['capaian'] ?>" required
								 <?= (!empty($datax['rendah']) && $datax['rendah'] == $data['capaian']) ? 'checked' : '' ?>> 
								 <?= $data['capaian'] ?>
								 </td>
								</tr>
								<?php endforeach; ?>
								</table>
								<br>
								<table  style="font-size:12px">
								<tr>
								<th>Capaian Pembelajaran Tercapai</th>
								<tr>
								<?php
								$stmt = $pdo->prepare("
								SELECT * 
								FROM cp_elemen cp
								LEFT JOIN adm_tp a ON a.id = cp.id_lingkup
								WHERE a.tingkat = ? AND a.mapel = ? AND a.semester = ?
									");
									$stmt->execute([$level['level'], $mapelmu, $semester]);
									$elemenList = $stmt->fetchAll(PDO::FETCH_ASSOC);
									foreach ($elemenList as $data):
								?>
								<tr>
								<td>
								<input type="radio" name="tinggi" value="<?= $data['capaian'] ?>" required
                                <?= (!empty($datax['tinggi']) && $datax['tinggi'] == $data['capaian']) ? 'checked' : '' ?>>
  <?=                            $data['capaian'] ?>
								</td>
								</tr>
								<?php endforeach; ?>
								</table>
								
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
	</div>
 </div>
</div>
	<?php endif ?>
					
<script type="text/javascript">
	$('#pilih').click(function() {
	var kt = $('#kodenilai').val();	
	var k = $('#kelas').val();
	var g = $('#guru').val();
	var m = $('#mapel').val();
	
	location.replace("?pg=<?= enkripsi('pas') ?>&k=" + k + "&g=" + g + "&m=" + m + "&kt=" + kt);
	}); 
</script>
									 
<script>
$("#guru").change(function() {
	var guru = $(this).val();						
	console.log(guru);
	$.ajax({
		type: "POST",
		url: "nilai/ambildata.php?pg=kelas", 
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
		url: "nilai/ambildata.php?pg=mapel", 
		data: "kelas=" + kelas + "&guru=" + guru, 
		success: function(response) { 
		$("#mapel").html(response);
		console.log(response);
		}
	});
});

</script>
<script>
$('#formmapel').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: 'nilai/import_pas.php',
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
$('#formcapaian').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		url: 'nilai/tcapaian_pas.php',
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
                    icon: 'success',
					width:'320px',
                    title: 'Sukses!',
                    text: 'Capaian berhasil di update',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: 'rgba(0,0,0,0.5)',
                    color: '#fff'
                }).then(() => {
                    window.location.reload();
                });
			}else {
				  Swal.fire({
                    icon: 'error',
					width:'320px',
                    title: 'Error!',
                    text: 'Capaian Tidak Boleh Sama',
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    background: 'rgba(0,0,0,0.5)',
                    color: '#fff'
                });
            }
        },
		error: function(xhr, status, error) {
			
			alert("An error occurred: " + error);
		}
	})
	return false;
});
</script>

<?php endif; ?>
 
  
					  
					  
					  	  
					  
					  
					