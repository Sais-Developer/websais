<?php defined('APK') or exit('No Access'); ?>
<?php if ($ac == ''): ?>
    <div class='row'>
        <div class='col-md-8'>
		 <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">MAPEL RAPOR</h5>
					<a href="?pg=<?= enkripsi('mapel') ?>&ac=<?= enkripsi('tambah') ?>" 
					   class="btn btn-link">
						<i class="material-icons">add</i> Mapel
					</a>
				</div>
				<div class="card-body">	
                    <div class='table-responsive'>
                        <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                             <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>TKT</th>                                 
                                    <th>JURUSAN</th>
                                    <th>MATA PELAJARAN</th>
                                    <th>GROUP</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
								$no = 0;
								$query = "
									SELECT * FROM mapel_rapor mr
									LEFT JOIN mapel m ON m.id = mr.idmapel
									LEFT JOIN kode k ON k.id = mr.kelompok
								";
								$stmt = $pdo->prepare($query);
								$stmt->execute();

								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
									$no++;
								?>
									<tr>
										<td><?= $no ?></td>
										<td><?= htmlspecialchars($data['tingkat']) ?></td>
										<td><?= htmlspecialchars($data['jurusan']) ?></td>
										<td><?= htmlspecialchars($data['nama_mapel']) ?></td>
										<td><?= htmlspecialchars($data['kd']) ?></td>
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
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="text-muted"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>
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
                </div>
              </div>             
            </div>					
		 </div>
		 
<?php  elseif ($ac == enkripsi('tambah')): ?>	
<?php 
$tingkat = $_GET['tingkat'] ?? '';
$kode  = $_GET['kode'] ?? '';
$jurusan  = $_GET['jurusan'] ?? '';
?>	 
		 <div class='row'>
        <div class='col-md-8'>
		 <div class="card">
             <div class="card-header">
			 <h5 class='card-title'>MAPEL RAPOR</h5>				
                </div>
				 <div class="card-body">
                   <form id="formpelajaran">				 
                        <table id="datatable1" class="table table-bordered" style="width:100%;font-size:12px">
                             <thead>
                                <tr>
                                    <th>#</th>
                                    <th>KODE</th>                                 
                                    <th>NAMA MAPEL</th>
									<th></th>
                                </tr>
                            </thead>
                            <tbody>
							<?php if ($tingkat<>''): ?>
                              <?php
								$query = "
									SELECT * FROM mapel m
									WHERE NOT EXISTS (
										SELECT 1
										FROM mapel_rapor mr
										WHERE mr.idmapel = m.id
										  AND mr.tingkat = ?
										  AND mr.jurusan = ?
									)
									ORDER BY m.id ASC
								";
								$stmt = $pdo->prepare($query);
								$stmt->execute([$tingkat, $jurusan]);
								$no = 0;
								while ($mapel = $stmt->fetch(PDO::FETCH_ASSOC)):
									$no++;
								?>
								<tr>
									<td><?= $no ?></td>
									<td><?= htmlspecialchars($mapel['kode']) ?></td>
									<td><?= htmlspecialchars($mapel['nama_mapel']) ?></td>
									<td style="text-align:center">
										<input type="checkbox" name="mapel[]" value="<?= $mapel['id'] ?>">
										<input type="hidden" name="tingkat[]" value="<?= $tingkat ?>">
										<input type="hidden" name="jurusan[]" value="<?= $jurusan ?>">
										<input type="hidden" name="kelompok[]" value="<?= $kode ?>">
									</td>
								</tr>
								<?php endwhile; ?>
                                <?php endif; ?>								
                            </tbody>
                        </table>
						 <?php if ($tingkat !== ''): ?>
						 <div class="mb-4"></div>
                        <div class="text-end">
							<button type="submit" class="btn btn-primary">SIMPAN</button>
						</div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
<script>
$('#formpelajaran').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: 'tmapel.php',
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
			<div class="col-md-12 mb-2">           
				<label  class="bold">Tingkat</label> 
				   <select name="tingkat" id="tingkat" class="form-select" style="width:100%" required>
						<option value="">Pilih Tingkat</option>
						<?php
						$stmt = $pdo->prepare("SELECT DISTINCT level FROM m_kelas ORDER BY level ASC");
						$stmt->execute();
						$levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($levels as $kelas) :
						?>
							<option value="<?= htmlspecialchars($kelas['level']) ?>"
								<?= isset($tingkat) && $tingkat === $kelas['level'] ? 'selected' : '' ?>>
								<?= htmlspecialchars($kelas['level']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-12 mb-2">           
				<label  class="bold">Jurusan</label> 
				   <select name="jurusan" id="jurusan" class="form-select" style="width:100%" required>
						<option value="">Pilih Jurusan</option>
						<?php
						$stmt = $pdo->prepare("SELECT DISTINCT jurusan FROM m_kelas ORDER BY jurusan ASC");
						$stmt->execute();
						$jurusans = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($jurusans as $kelas) :
						?>
							<option value="<?= htmlspecialchars($kelas['jurusan']) ?>"
								<?= isset($jurusan) && $jurusan === $kelas['jurusan'] ? 'selected' : '' ?>>
								<?= htmlspecialchars($kelas['jurusan']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-12 mb-4">           
				<label  class="bold">Kelompok</label> 
				   <select name="kode" id="kode" class="form-select" style="width:100%" required>
						<option value="">Pilih Kelompok</option>
						<?php
						$stmt = $pdo->prepare("SELECT * FROM kode WHERE jenjang = ?");
						$stmt->execute([$setting['jenjang']]);
						$kodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($kodes as $kd) :
						?>
							<option value="<?= htmlspecialchars($kd['id']) ?>"
								<?= isset($kode) && $kode == $kd['id'] ? 'selected' : '' ?>>
								<?= htmlspecialchars($kd['ket']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="text-end">
				  <button id="pilih"  class='btn btn-primary'>Pilih</button>
				</div> 
		  </div>
		</div>				
	  </div>             
	</div>					
   <script>
	document.getElementById('pilih').addEventListener('click', () => {
		const tingkat = document.querySelector('#tingkat').value;
		const jurusan = document.querySelector('#jurusan').value;
		const kode = document.querySelector('#kode').value;
		location.replace(`?pg=<?= enkripsi('mapel') ?>&ac=<?= enkripsi('tambah') ?>&tingkat=${tingkat}&jurusan=${jurusan}&kode=${kode}`);
	});
   </script>
<?php endif; ?>