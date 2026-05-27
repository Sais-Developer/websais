
<?php
defined('APK') or exit('No Access');

?>           
	<?php if ($ac == '') : ?>
	<div class="row">
    <div class="col-xl-12">		
        <div class="card">
		 <div class="card-header d-flex justify-content-between align-items-center">
		 <h5 class="card-title">BANK SOAL</h5>          
                    <a href="?pg=<?= enkripsi('banksoal') ?>&ac=tambah" 
					class="btn btn-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Buat Bank Soal">
                      <i class="material-icons">add</i>Bank Soal
                    </a>   
                </div>
			<div class="card-body">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover">
                        <thead>
                            <tr style="vertical-align:middle">
                                <th width="4%">NO</th>
                                <th>KODE</th>
                                <th>TINGKAT</th>
                                <th>PEMBUAT SOAL</th>
                                <th>SOAL</th>
                                <th>FILE ZIP</th>
                                <th width="25%">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$no = 0;
							$stmt = $pdo->prepare("SELECT b.*, g.nama FROM banksoal b LEFT JOIN guru g ON g.id_guru = b.idguru");
							$stmt->execute();
							$banks = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($banks as $bank) {
								$id_bank = $bank['id_bank'];
								$stmtSoal = $pdo->prepare("SELECT COUNT(*) AS jml FROM soal WHERE id_bank = :id_bank");
								$stmtSoal->execute(['id_bank' => $id_bank]);
								$jumlahsoal = $stmtSoal->fetchColumn() ?: 0;

								$directory = '../';
								$files = glob($directory . $id_bank . '.zip');
								$jfile = ($files !== false) ? count($files) : 0;
								$model = ($bank['model'] == 1) ? 'Literasi' : (($bank['model'] == 2) ? 'Numerasi' : '');

								$no++;
								
							?>
                            <tr style="vertical-align:middle">
                                <td><?= $no ?></td>
                                <td><?= htmlspecialchars($bank['kode']) ?></td>
                                <td>
                                    <h5>
                                        <span class="badge badge-primary"><?= htmlspecialchars($bank['tingkat']) ?></span>
                                        <span class="badge badge-success"><?= htmlspecialchars($bank['jurusan']) ?></span>
                                    </h5>												 
                                </td>
                                <td><?= htmlspecialchars($bank['nama'] ?? '-') ?></td>		
                                <td><?= $model ?> <span class="badge badge-danger"><?= $jumlahsoal ?></span></td>
                                <td>
                                    <?php if ($jfile == 0): ?>
                                        <b style="color: red;">Zip Belum dibuat</b>
                                    <?php else: ?>
                                        <b style="color: blue;">Zip Sudah dibuat</b>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center">
                                    <a href="?pg=<?= $pg ?>&ac=lihat&id=<?= $bank['id_bank'] ?>" 
                                        class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Input">
										<i class="material-icons">search</i>
                                       </a>
                                    <a href="?pg=<?= enkripsi('banksoal') ?>&ac=<?= enkripsi('impor') ?>&id=<?= $bank['id_bank'] ?>"
                                        class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="top" title="Import">
                                            <i class="material-icons">upload</i>
                                    </a>
                                    <a href="?pg=<?= enkripsi('banksoal') ?>&ac=edit&id=<?= enkripsi($bank['id_bank']) ?>"
                                        class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="material-icons">edit</i>
                                    </a>
                                    <button data-id="<?= $bank['id_bank'] ?>" class="hapus btn-sm btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="material-icons">delete</i> 
                                    </button>
                                    <?php if ($jfile == 0): ?>
                                        <button data-idzip="<?= $bank['id_bank'] ?>" class="zip btn-sm btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Buat File Zip">
                                            <i class="material-icons">folder</i>
                                        </button>
                                    <?php else: ?>
                                        <button data-idz="<?= $bank['id_bank'] ?>" class="busek btn-sm btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus File Zip">
                                           <i class="material-icons">close</i>
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
    </div>
 </div>
<script>
$('#datatable1').on('click', '.zip', function() {
  var idzip = $(this).data('idzip');
  Swal.fire({
    title: 'Buat Zip?',
    text: "Buat Zip Soal Bergambar",
    icon: 'success',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Zip!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'bank/proseszip.php',
        method: "POST",
        data: { idzip: idzip },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Suksess!',
            text: 'Data berhasil dizip.',
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
<script>
$('#datatable1').on('click', '.busek', function() {
  var idz = $(this).data('idz');
  Swal.fire({
    title: 'Hapus Zip?',
    text: "Data Zip Soal akan dihapus",
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
        url: 'bank/hapuszip.php',
        method: "POST",
        data: { idz: idz },
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
        url: 'bank/tbanksoal.php?pg=hapus',
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
<?php elseif ($ac == 'tambah') : ?>					
			
			<div class="row">          
				<div class="col-xl-8 mb-4">
                   <div class="card">
				   <div class="card-header">
				    <h5 class="card-title">INPUT BANK SOAL </h5>
					</div>
					<div class="card-body">
						<form id='formbank' class="row g-2">                         
                           <div class="col-md-6">								 
								<label class="bold">Jenis Soal</label>
								<select name='model' id='model' class='form-select' required='true' style="width: 100%">
								    <option value='1'>Literasi</option>
									 <option value='2'>Numerasi</option>	
									 </select>
							</div>
							<div class="col-md-6">								 
								<label class="bold">Tingkat</label>
								<select name='level' id='level' class='form-select' required style="width: 100%">
									<option value=''>Pilih Tingkat</option>
									<?php
										$stmt = $pdo->prepare("SELECT DISTINCT level FROM m_kelas ORDER BY level ASC");
										$stmt->execute();
										$levels = $stmt->fetchAll(PDO::FETCH_ASSOC);
										foreach ($levels as $level) {
											$lvl = htmlspecialchars($level['level']);
											echo "<option value='{$lvl}'>{$lvl}</option>";
										}
										?>
								</select>
							</div>
							<div class="col-md-6">								 
								<label class="bold">Jurusan</label>
								<select name='pk' id="pk" class='form-select' required='true' style="width: 100%">
								</select>
							</div>							
							<div class="col-md-6">
								<label class="bold">Kode Bank</label>
								<input type="text" name="kode" class="form-control" required="true">
							</div>
							<div class="col-md-6">
								<label class="bold">Mata Pelajaran</label>
								<select name='mapel' class='form-select' required style="width: 100%">
									<option value=''>Pilih Mapel</option>
									<?php
										$stmt = $pdo->prepare("SELECT id, nama_mapel FROM mapel ORDER BY nama_mapel ASC");
										$stmt->execute();
										$mapels = $stmt->fetchAll(PDO::FETCH_ASSOC);

										foreach ($mapels as $map) {
											$id   = htmlspecialchars($map['id']);
											$nama = htmlspecialchars($map['nama_mapel']);
											echo "<option value='{$id}'>{$nama}</option>";
										}
										?>
								</select>
							</div>								
							<div class="col-md-6">
								<label class="bold">Guru Pengampu</label>
								<select name="guru" class="form-select" required style="width: 100%">
									<option value="">Pilih Guru Pengampu</option>
									<?php
										if ($user['level'] === 'admin') {
											$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = 'guru'");
											$stmt->execute();
										} elseif ($user['level'] === 'guru') {
											$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = 'guru' AND id_guru = :id_guru");
											$stmt->bindParam(':id_guru', $id_user, PDO::PARAM_STR);
											$stmt->execute();
										}
										$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);

										foreach ($gurus as $guru) {
											$id   = htmlspecialchars($guru['id_guru']);
											$nama = htmlspecialchars($guru['nama']);
											echo "<option value='{$id}'>{$nama}</option>";
										}
										?>
								</select>
							</div>							
							<div class="col-md-6">
								<label class="bold">Status Soal</label>
								<select name='status' class='form-select' required='true' style="width: 100%">
									<option value='1'>Aktif</option>
									<option value='0'>Non Aktif</option>
								</select>
							</div>
							
							<div class='col-md-6 mb-4'>
                                <label class="boldl">Soal Agama</label>
                                <select name='agama' class='form-select' style="width: 100%">
                                    <option value=''>Bukan Soal Agama</option>                    
                                    <option value='Islam'>Islam</option>
									<option value='Kristen'>Kristen</option>
									<option value='Katolik'>Katholik</option>
									<option value='Hindu'>Hindu</option>
									<option value='Budha'>Budha</option>
								</select>						
                            </div>															
							<div class="d-flex justify-content-between align-items-center">
							<div class="form-check m-0">
								<input class="form-check-input" type="checkbox" id="checkme">
								<label class="form-check-label" for="checkme">
									Saya Setuju
								</label>
							</div>
							<button type="submit" id="blo1" class="btn btn-primary" disabled="disabled">
								Simpan
							</button>
						</div>	
					   </form>
					</div>
				</div>	
			</div>
<script>	
$("#level").change(function() {
	var level = $(this).val();
	console.log(level);
	$.ajax({
	type: "POST",
	url: "ambildata.php?pg=jurusan", 
	data: "level=" + level, 
	success: function(response) { 
	$("#pk").html(response);
			}
		});
	});				
				
	var checker = document.getElementById('checkme');
	var sendbtn = document.getElementById('blo1');
	checker.onchange = function(){
		if(this.checked){
		sendbtn.disabled = false;
	}else {
		sendbtn.disabled = true;
		}
	}
</script>	
<script>
$(document).ready(function () {
    $('#formbank').on('submit', function (e) {
        e.preventDefault();
        const data = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'bank/tbanksoal.php?pg=tambah',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'text',
            beforeSend: function () {
                $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
            },
            success: function (response) {
                if (response.trim() === 'OK') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                       
                        showConfirmButton: false,
                        timer: 1300,
                        width: '320px',
                        customClass: {
                        popup: 'swal2-small-popup'
                        }
                    }).then(() => {
                        window.location.replace('?pg=<?= enkripsi("banksoal") ?>');
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal!',
                        text: 'Kode sudah digunakan!',
                        confirmButtonText: 'OK',
                        width: '320px',
                        customClass: {
                            popup: 'swal2-small-popup'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem.',
                    confirmButtonColor: '#d33',
                    width: '280px',
                    padding: '0.75rem',
                    customClass: {
                    popup: 'swal2-small-popup'
                    }
                });
            }
        });

        return false;
    });
});
</script>
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
			<div class="mb-2">
		<p class="text-small text-muted mb-4">ALAMAT</p>
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
		<div class="row g-0 mb-4">
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
		<div class="row g-0 mb-4">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
	  <div class="mb-0">
		<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
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
<?php elseif ($ac == 'edit'): ?>
<?php
$id = dekripsi($_GET['id']);
$sql = "
    SELECT 
        b.*, 
        m.nama_mapel, 
        g.nama AS nama_guru 
    FROM banksoal b
    LEFT JOIN mapel m ON m.id = b.idmapel
    LEFT JOIN guru g ON g.id_guru = b.idguru
    WHERE b.id_bank = :id
";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$bank = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">          
 <div class="col-md-8">
 <div class="card">
   <div class="card-header">
	<h5 class="card-title">EDIT BANK SOAL </h5> 
	</div>
	<div class="card-body">
		<form id="formeditbank" class="row g-2"> 
			<input type="hidden" name="idm" value="<?= $id ?>">
			<div class="col-md-6">								 
				<label class="bold">Tingkat</label>
				<select name='level' id='level' class='form-select' required='true' style="width: 100%">
					  <option value="<?= $bank['tingkat'] ?>" selected><?= $bank['tingkat'] ?></option>
					  <option value=''>Pilih Tingkat</option>
					  <?php
						$stmt = $pdo->prepare("SELECT DISTINCT level FROM m_kelas ORDER BY level ASC");
						$stmt->execute();
						$levels = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($levels as $level) {
							$lvl = htmlspecialchars($level['level']);
							echo "<option value='{$lvl}'>{$lvl}</option>";
						}
						?>
					 </select>
					</div>
					<div class="col-md-6">								 
						<label class="bold">Jurusan</label>
						<select name='pk' id="pk" class='form-select' required='true' style="width: 100%">
						  <option value="<?= $bank['jurusan'] ?>" selected><?= $bank['jurusan'] ?></option>
						</select>
					</div>
					
					<div class="col-md-4">
						<label class="bold">Kode Bank</label>
						<input type="text" name="kode" value="<?= $bank['kode'] ?>" class="form-control" required="true">
					</div>
					<div class="col-md-8">
						<label class="bold">Mata Pelajaran</label>
						<select name='mapel' class='form-select' required='true' style="width: 100%">
							<option value="<?= $bank['idmapel'] ?>"><?= $bank['nama_mapel'] ?></option>
							<option value=''>Pilih Mapel</option>
							<?php
								$stmt = $pdo->prepare("SELECT id, nama_mapel FROM mapel ORDER BY nama_mapel ASC");
								$stmt->execute();
								$mapels = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($mapels as $map) {
									$id   = htmlspecialchars($map['id']);
									$nama = htmlspecialchars($map['nama_mapel']);
									echo "<option value='{$id}'>{$nama}</option>";
								}
								?>
						</select>
					</div>	
					<div class="col-md-12">
						<label class="bold">Guru Pengampu</label>
						<select name="guru" class='form-select' required='true' style="width: 100%">
							<option value="<?= $bank['idguru'] ?>" selected><?= $bank['nama_guru'] ?></option>
							<option value="">Pilih Guru Pengampu</option>
							<?php
								if ($user['level'] === 'admin') {
									$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = 'guru'");
									$stmt->execute();
								} elseif ($user['level'] === 'guru') {
									$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = 'guru' AND id_guru = :id_guru");
									$stmt->bindParam(':id_guru', $id_user, PDO::PARAM_STR);
									$stmt->execute();
								}
								$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($gurus as $guru) {
									$id   = htmlspecialchars($guru['id_guru']);
									$nama = htmlspecialchars($guru['nama']);
									echo "<option value='{$id}'>{$nama}</option>";
								}
								?>
						</select>
					</div>
					<div class="col-md-6">
						<label class="bold">Status Soal</label>
						<select name='status' class='form-select' required='true' style="width: 100%">
						  <option value="1" <?= $bank['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
						  <option value="0" <?= $bank['status'] == '0' ? 'selected' : '' ?>>Non Aktif</option>
						</select>
					</div>
					
					<div class='col-md-6 mb-4'>
						<label class="bold">Soal Agama</label>
						<select name='agama' class='form-select' style="width: 100%">
						<option value="<?= $bank['soal_agama'] ?>"><?= $bank['soal_agama'] ?></option>
							<option value=''>Bukan Soal Agama</option>                    
							<option value='Islam'>Islam</option>
							<option value='Kristen'>Kristen</option>
							<option value='Katolik'>Katholik</option>
							<option value='Hindu'>Hindu</option>
							<option value='Budha'>Budha</option>
						</select>						
					</div>
					<div class="d-flex justify-content-between align-items-center">
					<div class="form-check m-0">
						<input class="form-check-input" type="checkbox" id="checkme">
						<label class="form-check-label" for="checkme">
							Saya Setuju
						</label>
					</div>
					<button type="submit" id="blo1" class="btn btn-primary" disabled="disabled">
						Simpan
					</button>
				</div>				
			</form>
			</div>
		</div>
      </div>				
<script>	
$("#level").change(function() {
	var level = $(this).val();
	console.log(level);
	$.ajax({
	type: "POST",
	url: "ambildata.php?pg=jurusan", 
	data: "level=" + level, 
	success: function(response) { 
	$("#pk").html(response);
			}
		});
	});				
				
	var checker = document.getElementById('checkme');
	var sendbtn = document.getElementById('blo1');
	checker.onchange = function(){
		if(this.checked){
		sendbtn.disabled = false;
	}else {
		sendbtn.disabled = true;
		}
	}
</script>			
<script>
$(document).ready(function () {
    $('#formeditbank').on('submit', function (e) {
        e.preventDefault();
        const data = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'bank/tbanksoal.php?pg=ubah',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'text',
            beforeSend: function () {
                $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
            },
            success: function (response) {
                if (response.trim() === 'OK') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                       
                        showConfirmButton: false,
                        timer: 1300,
                        width: '320px',
                        customClass: {
                        popup: 'swal2-small-popup'
                        }
                    }).then(() => {
                        window.location.replace('?pg=<?= enkripsi("banksoal") ?>');
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal!',
                        text: 'Kode sudah digunakan!',
                        confirmButtonText: 'OK',
                        width: '320px',
                        customClass: {
                            popup: 'swal2-small-popup'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem.',
                    confirmButtonColor: '#d33',
                    width: '280px',
                    padding: '0.75rem',
                    customClass: {
                    popup: 'swal2-small-popup'
                    }
                });
            }
        });

        return false;
    });
});
</script>
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
			<div class="mb-2">
		<p class="text-small text-muted mb-4">ALAMAT</p>
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
		<div class="row g-0 mb-4">
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
		<div class="row g-0 mb-4">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
	  <div class="mb-0">
		<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
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
	<?php
$basepath = $_SERVER['DOCUMENT_ROOT'];
?>
<?php elseif ($ac == enkripsi('impor')): ?>
    <?php include '../mycbt/bank/upload.php'; ?>
    <?php elseif ($ac == 'pg'): ?>
    <?php include '../mycbt/input/input_soal.php'; ?>
	<?php elseif ($ac == 'multi'): ?>
    <?php include '../mycbt/input/input_soal2.php'; ?>
	<?php elseif ($ac == 'bs'): ?>
    <?php include '../mycbt/input/input_soal3.php'; ?>
	<?php elseif ($ac == 'urut'): ?>
    <?php include '../mycbt/input/input_soal4.php'; ?>
	<?php elseif ($ac == 'lihat'): ?>		
    <?php include '../mycbt/bank/soal.php'; ?>	
<?php endif; ?>
 
<script>
    $('#formsoal').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'bank/tsoal.php?pg=simpan_soal',
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
        });
        return false;
    });
    </script>
			