<?php
defined('APK') or exit('No Access');
$id_skl = 1;

$sql = "SELECT * FROM skl WHERE id_skl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null;
$kelas = $_GET['kelas'] ?? '';
?>
<div class="row">
  <div class="col-xl-8">
	  <div class="card">
   <div class="card-header">
		   <h5 class="card-title">CETAK DATA SKL</h5>
		 </div>
		   <div class="card-body">
				 <div class="card-box table-responsive">
					  <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px;">
							<thead>
							<tr>
							<th width="5%">NO</th>
							<th>NIS</th>
							<th>NISN</th>
							<th>NAMA SISWA</th>
							<th>#</th>
							</tr>
							</thead>
							<tbody>
							   <?php
								$no = 0;
								$stmt = $pdo->prepare("SELECT id_siswa, nis, nisn, nama FROM siswa WHERE kelas = ?");
								$stmt->execute([$kelas]);
								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
									$no++;
								?>
							<tr>
							<td><?= $no; ?></td>
							<td><?= $data['nis'] ?></td>							  
							<td><?= $data['nisn'] ?></td>                                                 
							<td><?= $data['nama'] ?></td>      												
							<td>
							<a href="skl/cetakskkb.php?ids=<?= $data['id_siswa'] ?>" target="_blank"> 
							<button class="btn btn-sm  btn-danger mb-1" type="button" data-bs-toggle="tooltip" title="Cetak SKKB">
							<i class="material-icons">print</i></button></a>
							<a href="skl/print_skl.php?ids=<?= $data['id_siswa'] ?>" target="_blank"> 
							<button class="btn btn-sm  btn-primary mb-1" type="button" data-bs-toggle="tooltip" title="Cetak SKL">
							<i class="material-icons">print</i></button></a>		
												
							</td>
						   </tr>
						<?php endwhile;?>
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
					<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				  </div>
				  <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
				  <div class="text-muted">HIGH SCHOOL</div>
				</div>
				<div class="col-md-12 mb-4">
					<label class="form-label bold">KELAS / ROMBEL</label>
					<select class="kelas form-select" name="kelas" required style="width: 100%">
					  <option value='' selected>Pilih Kelas</option>
						<?php
						if ($user['level'] == 'admin') {
							$sql = "SELECT kelas FROM m_kelas WHERE level = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$skl['tingkat']]);
						} else {
							$sql = "SELECT kelas FROM m_kelas WHERE level = ? AND kelas = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$skl['tingkat'], $user['walas']]);
						}
						while ($kl = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='{$kl['kelas']}'>{$kl['kelas']}</option>";
						}
						?>
						</select>
					</div>
					<div class="d-grid gap-2 mb-4">
					<button  id="cari" class="btn btn-primary">Cari Data</button>
					</div>
					 <div class="mb-4">
					<p class="text-small text-muted mb-4">ALAMAT</p>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
						  <i class="material-icons text-info" style="font-size:18px">home</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
					</div>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
							<i class="material-icons text-info" style="font-size:18px">star</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['desa'] ?></div>
					</div>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
						   <i class="material-icons text-info" style="font-size:18px">sync</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
					</div>
				  </div>
				  <div class="mb-2">
					<p class="text-small text-muted mb-4">CONTACT</p>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
							<i class="material-icons text-info" style="font-size:18px">phone</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
					</div>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
						   <i class="material-icons text-info" style="font-size:18px">inbox</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['email'] ?></div>
					</div>
					<div class="row g-0 mb-3">
					  <div class="col-auto">
						<div class="sw-3 me-1">
						  <i class="material-icons text-info" style="font-size:18px">language</i>
						</div>
					  </div>
					  <div class="col text-alternate"><?= $setting['server'] ?></div>
					</div>
				  </div>	  

				  </div>
				</div>
			  </div>
			 </div>
                
<script type="text/javascript">
	$('#cari').click(function() {
		var kelas = $('.kelas').val();
		
		location.replace("?pg=<?= enkripsi('cskl') ?>&kelas=" + kelas);
	}); 
</script>
		