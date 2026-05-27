<?php
defined('APK') or exit('No Access');
?>           
<?php
if ($user['level'] == 'admin') {
    $sql = "SELECT j.*, g.nama, m.kode
            FROM jurnal j
            LEFT JOIN guru g ON g.id_guru = j.guru
            LEFT JOIN mapel m ON m.id = j.mapel
            ORDER BY j.tanggal DESC";
    $stmt = $pdo->query($sql); 
} else {
    $sql = "SELECT j.*, g.nama, m.kode
            FROM jurnal j
            LEFT JOIN guru g ON g.id_guru = j.guru
            LEFT JOIN mapel m ON m.id = j.mapel
            WHERE j.guru = :id_guru
            ORDER BY j.tanggal DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_guru' => $user['id_guru']]);
}

$jurnal = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row">
	 <div class="col-md-8">
		<div class="card">
			 <div class="card-header">
				<h5 class="card-title">CETAK JURNAL GURU</h5>
			</div>
			<div class="card-body">
			<div class="card-box table-responsive">
		<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Mapel</th>
							<th>Materi</th>
							<th>Ketercapaian</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						foreach($jurnal as $row): 
							$warna = "black";
							if($row['ketercapaian'] == "Tercapai") $warna = "green";
							elseif($row['ketercapaian'] == "Belum Tercapai") $warna = "red";
							elseif($row['ketercapaian'] == "Perlu Pengayaan") $warna = "orange";
							elseif($row['ketercapaian'] == "Perlu Remedial") $warna = "purple";
						?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $row['tanggal']; ?></td>
							<td><span class="badge badge-primary"><?= htmlspecialchars($row['kelas']); ?></span>
							<span class="badge badge-dark"><?= htmlspecialchars($row['kode']); ?></span><p>
							<span class="badge badge-danger"><?= htmlspecialchars($row['nama']); ?></span></td>
							<td><?= htmlspecialchars($row['materi']); ?></td>
							<td style="color:<?= $warna ?>; font-weight:bold;"><?= $row['ketercapaian']; ?></td>
						</tr>
						<?php endforeach; ?>
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
									
				<form method="GET" action="cetakjurnal.php" target="_blank" enctype="multipart/form-data">
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
					<label class="bold">Kelas</label>
						<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true" >                                         													                                           
						</select>
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Mapel</label>
						<select name="mapel" id="mapel" class='form-select' style='width:100%' required="true" >                                         													                                           
							</select>
                    </div>
					<div class="col-md-12 mb-1">
					<label class="bold">Bulan</label>
						<select class="form-select" name="bulan" style="width: 100%;" required>
							<option value="">Pilih Bulan</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM bulan");
							$stmt->execute();
							while ($mt = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= htmlspecialchars($mt['bln']) ?>">
									<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
					 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">CETAK</button>
						</div>
					</form>
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
		</script>
		<script>
		$("#kelas").change(function() {
			var kelas = $(this).val();
			var guru = $("#guru").val();							
			console.log(kelas + guru);
				$.ajax({
				type: "POST",
				url: "adm/ambildata.php?pg=mapel", 
				data: "guru=" + guru + "&kelas=" + kelas, 
				success: function(response) { 
				$("#mapel").html(response);
				console.log(response);
					}
				});
			});
		</script>
					  
					  
					  	  
					  
					  
					