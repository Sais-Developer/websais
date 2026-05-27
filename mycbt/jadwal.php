<?php
defined('APK') or exit('No Access');
?>
<div class='row'>
	<div class="col-xl-8" >
		<div class="card" >
			<div class="card-header" >	
				<h5 class="card-title">JADWAL ASESMEN</h5>
			</div>				
	<div class="card-body">                    
	    <div class="table-responsive">
		   <table id="datatable1" class="table  table-bordered" >
				<thead>
					<tr>
					<th width="7%">NO</th>
					<th>TANGGAL</th>
					 <th>MAPEL</th>
                    <th>TINGKAT</th>
					<th>SESI</th>
					<th width="20%"></th>
					</tr>
				</thead>
				<tbody>
				 <?php
					$no = 0;
					try {
						$stmt = $pdo->query("
							SELECT u.*, b.*, m.id 
							FROM ujian u
							LEFT JOIN banksoal b ON b.id_bank = u.idbank
							LEFT JOIN mapel m ON m.id = b.idmapel
						");
						$jadwalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($jadwalList as $jadwal) : 
							$no++;
					?>
				<tr>
					<td style="vertical-align: middle;"><?= $no ?></td>
					<td style="vertical-align: middle;">
						<small style="color:green;"><?= $jadwal['tgl_ujian'] ?></small><br>
						<small style="color:red;"><?= $jadwal['tgl_selesai'] ?></small>
					</td>
					<td style="vertical-align: middle;">
						<?= $jadwal['kode'] ?><br>
						<?php if ($jadwal['status'] == 1) : ?>                           
							Aktif <span class="badge bg-success m-l-xxs"><?= $jadwal['sesi'] ?></span>                       
						<?php elseif ($jadwal['status'] == 0) : ?>                         
							Non Aktif <span class="badge bg-danger m-l-xxs"><?= $jadwal['sesi'] ?></span>                      
						<?php endif; ?>
					</td>    
					<td style="vertical-align: middle;">
						<?= $jadwal['tingkat'] ?> <?= $jadwal['jurusan'] ?><br>
						<?php
						$tingkat = $jadwal['tingkat'];
						$jurusan = strtoupper($jadwal['jurusan']);

						if ($jurusan === 'SEMUA') {
							$kelasStmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE level = :level ORDER BY kelas ASC");
							$kelasStmt->execute([':level' => $tingkat]);
						} else {
							$kelasStmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE level = :level AND jurusan = :jurusan ORDER BY kelas ASC");
							$kelasStmt->execute([':level' => $tingkat, ':jurusan' => $jadwal['jurusan']]);
						}

						$kelasList = $kelasStmt->fetchAll(PDO::FETCH_COLUMN);
						echo !empty($kelasList) ? implode(', ', $kelasList) : '<i>Belum ada kelas</i>';
						?>
					</td>
					<td style="text-align:center">
						<?= $jadwal['sesi'] ?><br>
						<?php
						$now = date('Y-m-d H:i:s');
						if ($jadwal['tgl_ujian'] > $now && $jadwal['tgl_selesai'] > $now) : ?>
							<div class="spinner-grow text-secondary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div> <strong>Belum</strong>
						<?php elseif ($jadwal['tgl_ujian'] < $now && $jadwal['tgl_selesai'] > $now) : ?>
							<div class="spinner-grow text-success" role="status">
								<span class="visually-hidden">Loading...</span>
							</div> <strong>Mulai</strong>
						<?php else : ?>
							<div class="spinner-grow text-danger" role="status">
								<span class="visually-hidden">Loading...</span>
							</div> <strong>Habis</strong>
						<?php endif; ?>
					</td>
					<td style="vertical-align: middle;">
					<?php if($user['level']=='admin'): ?>
						<a href="?pg=<?= enkripsi('jadwaluji') ?>&ac=edit&idu=<?= $jadwal['id_jadwal'] ?>" 
						   class="btn btn-sm btn-icon btn-icon-only btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Jadwal">
						   <i class="material-icons">edit</i></a>    
						   <?php endif; ?>
						<a href="?pg=<?= enkripsi('status') ?>&idu=<?= $jadwal['id_jadwal'] ?>" 
						   class="btn btn-sm btn-icon btn-icon-only btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Status Ujian">
						   <i class="material-icons">wifi</i></a> 
							<?php if($user['level']=='admin'): ?>
						<button data-id="<?= $jadwal['id_jadwal'] ?>" class="hapus btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
							<i class="material-icons">delete</i>
						</button>
						<?php endif; ?>
					</td>                    
				</tr>
				<?php
					endforeach;
				} catch (PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				?>
			</tbody>
		  </table>
		</div>
	</div>
 </div>
</div> 
<script>
$('#datatable1').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'hapus.php',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>	
<?php if ($ac == '') : ?>
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
		          <form id="formujian" class="row g2" enctype='multipart/form-data'>
				   <div class="col-md-12 mb-2">
                      <label class="bold">Nama Ujian</label>
					  <select name='jenis' class='form-select' required='true'>
					  <option value="<?= $setting['jenis_ujian'] ?>"> <?= $setting['jenis_ujian'] ?></option>
                       </select>
                      </div>
					<div class="col-md-12 mb-2">
                      <label class="bold">Bank Soal</label>
                        <select name='idbank' class='form-select' required='true'>
                            <option value=''>Pilih Bank Soal </option>
                           <?php
							foreach ($pdo->query("SELECT b.*, m.id FROM banksoal b LEFT JOIN mapel m ON m.id = b.idmapel WHERE b.status = 1") as $bank) {
								$model = $bank['model'] == 1 ? 'Literasi' : ($bank['model'] == 2 ? 'Numerasi' : '');
								echo "<option value='{$bank['id_bank']}'>{$bank['kode']} | {$bank['tingkat']} {$bank['jurusan']} | {$model}</option>";
							}
							?>
                        </select>
                      </div>   
                            <div class='col-md-12 mb-2'>
                                <label class="bold">Waktu Mulai</label>
                                <input type='text' name='tgl_ujian' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                            <div class='col-md-12 mb-2'>
                                <label class="bold">Waktu Berakhir</label>
                                <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                       	   <div class='col-md-6 mb-2'>                            
                                <label class="bold">Sesi</label>
                                <select name='sesi' class='form-select' required='true'>
                                    <?php
									foreach ($pdo->query("SELECT DISTINCT sesi FROM siswa") as $sesi) {
										echo "<option value='{$sesi['sesi']}'>{$sesi['sesi']}</option>";
									}
									?>
                                </select>
                            </div>                     
                        <div class='col-md-6 mb-2'>                          
                                <label class="bold">Lama ujian</label>
                                <input type='number' name='lama_ujian' value="90" class='form-control' required='true' />
                            </div>	
                           <div class="col-md-12 mb-2">
                            <label class="bold">KKM</label>
                                <input class="form-control" type="number" name="kkm" id="kkm" value="0" >
                                </div>
                       							
								<div class="col-md-12 mb-4">
                            <label class="bold">Durasi Pelanggaran (detik)</label>
                                <input class="form-control" type="number" name="langgar" id="langgar" value="0" >
                                </div>                   
							<div class="col-md-12 mb-2 text-end">
							<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
						</div>
                    </form>          					
				</div>
			</div>
		</div>
	
		<script>
			$('#formujian').submit(function(e) {
					e.preventDefault();
					var data = new FormData(this);
					$.ajax({
						type: 'POST',
						 url: 'tjadwal.php?pg=tambah',
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

<?php elseif($ac == 'edit'): ?>
	<?php
	$idjadwal = $_GET['idu'] ?? 0;
	$stmt = $pdo->prepare("
		SELECT u.*, b.*, m.* 
		FROM ujian u
		LEFT JOIN banksoal b ON b.id_bank = u.idbank
		LEFT JOIN mapel m ON m.id = b.idmapel
		WHERE id_jadwal = ?
	");
	$stmt->execute([$idjadwal]);
	$uji = $stmt->fetch(PDO::FETCH_ASSOC);
	$model = '';
	if ($uji['model'] == 1) $model = 'Literasi';
	if ($uji['model'] == 2) $model = 'Numerasi';
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
            <form id="formedit" class="row g2" enctype='multipart/form-data'>
                <input type="hidden" name="idu" value="<?= $idjadwal; ?>">

                <div class="col-md-12 mb-2">
                    <label class="bold">Nama Ujian</label>
                    <select name='jenis' class='form-select' required>
                        <option value="<?= htmlspecialchars($setting['jenis_ujian'] ?? '') ?>"><?= htmlspecialchars($setting['jenis_ujian'] ?? '') ?></option>
                        
                    </select>
                </div>

                <div class="col-md-12 mb-2">
                    <label class="bold">Bank Soal</label>
                    <select name='idbank' class='form-select' required>
					<option value="<?= $uji['idbank'] ?>"><?= $uji['kode'] ?> | <?= $uji['tingkat'] ?> <?= $uji['jurusan'] ?> | <?= $model ?></option>
                        
                        </select>
                    </select>
                </div>   

                <div class='col-md-12 mb-2'>
                    <label class="bold">Waktu Mulai</label>
                    <input type='text' name='tgl_ujian' class='tgl form-control' 
                           value="<?= htmlspecialchars($uji['tgl_ujian'] ?? '') ?>" autocomplete='off' required>
                </div>

                <div class='col-md-12 mb-2'>
                    <label class="bold">Waktu Berakhir</label>
                    <input type='text' name='tgl_selesai' class='tgl form-control' 
                           value="<?= htmlspecialchars($uji['tgl_selesai'] ?? '') ?>" autocomplete='off' required>
                </div>

                <div class='col-md-6 mb-2'>                            
                    <label class="bold">Sesi</label>
                    <select name='sesi' class='form-select' required>
                       <?php
						foreach ($pdo->query("SELECT DISTINCT sesi FROM siswa") as $sesi) {
							echo "<option value='{$sesi['sesi']}'>{$sesi['sesi']}</option>";
						}
						?>
                    </select>
                </div>                     

                <div class='col-md-6 mb-2'>                          
                    <label class="bold">Lama Ujian</label>
                    <input type='number' name='lama_ujian' 
                           value="<?= htmlspecialchars($uji['lama_ujian'] ?? '90') ?>" 
                           class='form-control' required>
                </div>	

                <div class="col-md-12 mb-2">
                    <label class="bold">KKM</label>
                    <input class="form-control" type="number" name="kkm" id="kkm" 
                           value="<?= htmlspecialchars($uji['kkm'] ?? '0') ?>">
                </div>

                <div class="col-md-12 mb-4">
                    <label class="bold">Durasi Pelanggaran (detik)</label>
                    <input class="form-control" type="number" name="langgar" id="langgar" 
                           value="<?= htmlspecialchars($uji['pelanggaran'] ?? '0') ?>">
                </div>
				<div class="col-md-12 mb-2 text-end">
				  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
				</div>
            </form> 
        </div>
    </div>
<script>
$('#formedit').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		 url: 'tjadwal.php?pg=ubah',
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
				window.location.replace("?pg=<?= enkripsi('jadwaluji') ?>");
			}, 200);
		}
	})
	return false;
});
</script>
<?php endif; ?>
</div>

		
	