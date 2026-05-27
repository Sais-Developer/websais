<?php
defined('APK') or exit('No Access');
$hari = date('D');
?>           
	<?php if ($ac == '') : ?>
	<?php
        $kelasmu = $_GET['k'] ?? '';
        $gurumu = $_GET['g'] ?? '';
        $mapelmu = $_GET['m'] ?? '';
	    $tgl = $_GET['t'] ?? '';
 		
	?>
<style>
.nilai-table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    font-size: 14px;
    background: #fff;
}

.nilai-table th {
	 border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}

.nilai-table td {
    border: 1px solid #ccc;
    padding: 6px;
}
.mini-textbox {
    width: 110px;
    padding: 4px 6px;
    font-size: 12px;
    border: 1px solid #aaa;
    border-radius: 4px;
    box-sizing: border-box;
}

.mini-textbox:focus {
    border-color: #4CAF50;
    outline: none;
    box-shadow: 0 0 3px rgba(76,175,80,0.5);
}
</style>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="bold">NILAI HARIAN</h5>										
				</div>
			<div class="card-body">									
			   <form id="formnilai">			
					<table class="nilai-table">
						  <tr>
						  <th width="5%">NO</th>												  
						  <th>N I S</th>
						  <th>NAMA SISWA</th>
						  <th>NILAI</th>														 
					     </tr>
						<?php
						$no = 0;
						$sql = "SELECT id_siswa, nis, kelas, nama FROM siswa WHERE kelas = :kelas";
						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':kelas', $kelasmu, PDO::PARAM_STR);
						$stmt->execute();

						$siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($siswaList as $data) :
							$no++;
						?>
							<tr style="vertical-align:middle;">
								<td><?= $no; ?></td>
								<td><?= $data['nis'] ?></td>
								<td><?= ucwords(strtolower($data['nama'])) ?></td>
								
								<td class="text-center">
									<input type="number" 
										   name="nilai[<?= $no ?>]" 
										   class="mini-textbox" 
										   value="0" 
										   required 
										   style="width:100px;">

									<input type="hidden" name="tanggal[<?= $no ?>]" value="<?= $tgl ?>">
									<input type="hidden" name="idsiswa[<?= $no ?>]" value="<?= $data['id_siswa'] ?>">
									<input type="hidden" name="kelas[<?= $no ?>]" value="<?= $data['kelas'] ?>">
									<input type="hidden" name="mapel[<?= $no ?>]" value="<?= $mapelmu ?>">
									<input type="hidden" name="guru[<?= $no ?>]" value="<?= $gurumu ?>">
								</td>
							</tr>
						<?php endforeach; ?>
							</table>
							<div class="mb-3"></div>
							<?php if($kelasmu !=''): ?>
							<div class="d-flex justify-content-end align-items-center">
								<button type="submit" class="btn btn-primary">SIMPAN</button>
							</div>
						<?php endif; ?>							
					</form>
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
				<?php if($kelasmu==''): ?>
				<div class="col-md-12 mb-1">
				  <label class="bold">Tanggal</label>
					<input type="text" name="tgl" class="datepicker form-control" value="<?= $tanggal; ?>" required="true" autocomplete="off">
				   </div>
					
				<div class="col-md-12 mb-1">
				   <label class="bold">Guru</label>
						<select name="guru" id="guru" class='form-select guru' style='width:100%' required>
							<option value="">Pilih Guru</option>
							<?php
							if ($user['level'] == 'admin') {
								$sql = "SELECT * FROM guru";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
							} elseif ($user['level'] == 'guru') {
								$sql = "SELECT * FROM guru WHERE id_guru = :id_guru";
								$stmt = $pdo->prepare($sql);
								$stmt->bindParam(':id_guru', $id_user, PDO::PARAM_INT);
								$stmt->execute();
							}
							$guruList = $stmt->fetchAll(PDO::FETCH_ASSOC);
							foreach ($guruList as $data) :
							?>
								<option value="<?= $data['id_guru'] ?>">
									<?= $data['nama'] ?>
								</option>
							<?php endforeach; ?>

						</select>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">Kelas</label>
						<select name="kelas" id="kelas" class='form-select kelas' style='width:100%' required="true" >                                         													                                           
						 </select>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">Mapel</label>
						<select name="mapel" id="mapel" class='form-select mapel' style='width:100%' required="true" >                                         													                                           
						 </select>
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
					 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
		 
						</div>
						<?php else: ?>
					 <div class="d-flex justify-content-between mb-2">
						<div class="text-center">
						  <p class="text-small text-muted mb-1">NPSN</p>
						  <p><?= $setting['npsn'] ?></p>
						</div>
						<div class="text-center">
						  <p class="text-small text-muted mb-1">SMT</p>
						  <p><?= $setting['semester'] ?></p>
						</div>
						<div class="text-center">
						  <p class="text-small text-muted mb-1">TP</p>
						  <p><?= $setting['tp'] ?></p>
						</div>                    
					  </div>
					  <div class="mb-4">
						<p class="text-small text-muted mb-2">ALAMAT</p>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							  <i class="material-icons text-info" style="font-size:18px">home</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
						</div>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
								<i class="material-icons text-info" style="font-size:18px">star</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['desa'] ?></div>
						</div>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							   <i class="material-icons text-info" style="font-size:18px">sync</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
						</div>
					  </div>
					  <div class="mb-4">
						<p class="text-small text-muted mb-2">CONTACT</p>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
								<i class="material-icons text-info" style="font-size:18px">phone</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
						</div>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							   <i class="material-icons text-info" style="font-size:18px">inbox</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['email'] ?></div>
						</div>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							  <i class="material-icons text-info" style="font-size:18px">language</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['server'] ?></div>
						</div>
					  </div>
					  <div class="mb-4">
						<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							 <i class="material-icons text-info" style="font-size:18px">person</i>
							</div>
						  </div>
						  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
						</div>
						<div class="row g-0 mb-2">
						  <div class="col-auto">
							<div class="sw-3 me-1">
							  <i class="material-icons text-info" style="font-size:18px">payment</i>
							</div>
						  </div>
						  <div class="col text-alternate"><?= $setting['nip'] ?></div>
						</div>
					  </div>
						
						<?php endif; ?>
					<script type="text/javascript">
					$('#pilih').click(function() {
					var k = $('.kelas').val();
					var g = $('.guru').val();
					var m = $('.mapel').val();
					var tgl = $('.datepicker').val();
					location.replace("?pg=<?= enkripsi('nilph') ?>&k=" + k + "&g=" + g + "&m=" + m + "&t=" + tgl);
					}); 
				</script>
				 </div>
			</div>
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
</script>
<script>
	$('#formnilai').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: 'input.php',
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
			window.location.replace('?pg=<?= enkripsi("nilph") ?>');
				}, 200);
			}
		})
		return false;
	});
	</script>
 <?php endif ?>
					  
					  
					  
					  	  
					  
					  
					