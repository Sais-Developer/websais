<?php
defined('APK') or exit('No Access!');
?>
<?php if (($ac ?? '') == ''): ?>
  <div class="row">
     <div class="col-md-8">
		<div class="card">
             <div class="card-header">									
                  <h5 class="card-title">MATERI BELAJAR</h5>
					</div>
                      <div class="card-body">               
                    <form id="form-materi" class="row g-2"> 
                        <div class="col-md-6">        
						<label  class="bold">Mata Pelajaran</label>
							<select name="mapel" class="form-select" style="width:100%" required>
								<option value="">Pilih Mata Pelajaran</option>
								<?php
								$stmt = $pdo->prepare("SELECT * FROM mapel");
								$stmt->execute();
								$mapelList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($mapelList as $mapel) :
								?>
									<option value="<?= htmlspecialchars($mapel['id']) ?>">
										<?= htmlspecialchars($mapel['nama_mapel']) ?>
									</option>
								<?php endforeach; ?>
							</select>
                        </div>
						 <div class="col-md-6">        
						<label  class="bold">Guru Pengampu</label>
							<select name="guru" class="form-select" style="width:100%" required>
								<option value="">Pilih Guru</option>
								<?php
								if ($user['level'] == 'admin') {
									$stmt = $pdo->prepare("SELECT * FROM guru");
									$stmt->execute();
								} else {
									$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = :id_user");
									$stmt->execute([':id_user' => $id_user]);
								}
								$guruList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($guruList as $guru) :
								?>
									<option value="<?= htmlspecialchars($guru['id_guru']) ?>">
										<?= htmlspecialchars($guru['nama']) ?>
									</option>
								<?php endforeach; ?>
							</select>
                        </div>
						<div class="col-md-12">  
							<label  class="bold">Judul Materi</label>
							   <input type="text" class="form-control" name="judul"  placeholder="Judul materi" required>
                           </div>
                                       
						<div class="col-md-12"> 				
							<label  class="bold">Materi Belajar</label> 
						       <textarea name='isimateri' class='editor1' rows='5' cols='80' style='width:100%;'></textarea>
                            </div>
									 
                        <div class="col-md-6">           
							<label  class="bold">Kelas</label> 
						      <select name="kelas[]" class="form-control form-control select2" multiple="multiple" style="width:100%" required>
									<option value="">Pilih Kelas</option>
									<?php
									$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
									$stmt->execute();
									$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

									foreach ($kelasList as $kelas) :
									?>
										<option value="<?= htmlspecialchars($kelas['kelas']) ?>">
											<?= htmlspecialchars($kelas['kelas']) ?>
										</option>
									<?php endforeach; ?>
								</select>
                        </div>
						<div class="col-md-6"> 					 
						<label  class="bold">Berlaku Sampai Tanggal</label>
						    <input type='text' name='sampai' class='datepicker form-control' autocomplete='off' required='true' />
                        </div>
						<div class="col-md-6">
						  <label class="bold">File (Jika ada)</label> 
						    <input type="file" class="form-control" name="file" >
						</div>					
						<div class="col-md-6">
						  <label class="bold">Youtube (Jika ada)</label> 
						    <input type="text" class="form-control" name="youtube" >
						</div>						
						<div class="col-sm-12 mb-4">
						<label>Cara memasukan Link Youtube  Contoh Link : <b>https://youtu.be/42cqGZY9VTc</b> maka yang dimasukan adalah :<b>42cqGZY9VTc</b></label>
						</div>
									
                       <div class='text-end'>
                          <button type='submit'  class='btn btn-primary'>Simpan</button>
                        </div>
                      
					  </form>
                  </div>
               </div>
			 </div>    
 <div class="col-md-4 mb-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                  </div>
                <div class="d-flex justify-content-between mb-4">
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
                  <div class="mb-4">
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
                  <div class="mb-4">
                    <p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                         <i class="material-icons text-info" style="font-size:18px">person</i>
                        </div>
                      </div>
                      <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
                    </div>
                    <div class="row g-0 mb-3">
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
$('#form-materi').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    $.ajax({
        type: 'POST',
        url: 'buat_materi.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },
        success: function(response) {
            if (response.trim() == 'OK') {
                Swal.fire({
                    icon: 'success',
					width:'320px',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.replace("?pg=<?= enkripsi('materi') ?>");
                });
            } else {
                Swal.fire({
                    icon: 'error',
					width:'320px',
                    title: 'Gagal!',
                    text: 'Data sudah ada.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
            }
        }
    });

    return false;
});
</script>

<?php elseif($ac == enkripsi('edit')): ?>			
 <?php
$id = $_GET['id'] ?? '';
try {
    $query = "SELECT * FROM materi m
              LEFT JOIN guru g ON g.id_guru = m.guru
              LEFT JOIN mapel p ON p.id = m.mapel
              WHERE m.idm = :id
              LIMIT 1";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $materi = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

 <div class="row">
     <div class="col-md-8">
		<div class="card">
             <div class="card-header">									
                  <h5 class="card-title">EDIT MATERI BELAJAR</h5>
			</div>
            <div class="card-body">                
               <form id="formedit" class="row g-2">                             
                <input type="hidden" class="form-control" name="id" value="<?= $id ?>">
            <div class="col-md-6">        
						<label class="bold">Mata Pelajaran</label>
						<select name='mapel' class='form-select' style='width:100%' required>
							<option value="<?= htmlspecialchars($materi['mapel']) ?>"><?= htmlspecialchars($materi['nama_mapel']) ?></option>
							<option value=''>Pilih Mata Pelajaran</option>
							<?php
							$stmtMapel = $pdo->prepare("SELECT * FROM mapel ORDER BY nama_mapel ASC");
							$stmtMapel->execute();
							while ($mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= htmlspecialchars($mapel['id']) ?>">
									<?= htmlspecialchars($mapel['nama_mapel']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="col-md-6">        
						<label class="bold">Guru Pengampu</label>
						<select name='guru' class='form-select' style='width:100%' required>
							<option value="<?= htmlspecialchars($materi['guru']) ?>"><?= htmlspecialchars($materi['nama']) ?></option>
							<option value=''>Pilih Guru</option>
							<?php
							if ($user['level'] == 'admin') {
								$stmtGuru = $pdo->prepare("SELECT * FROM guru ORDER BY nama ASC");
								$stmtGuru->execute();
							} else {
								$stmtGuru = $pdo->prepare("SELECT * FROM guru WHERE id_guru = :id_user");
								$stmtGuru->execute([':id_user' => $id_user]);
							}

							while ($guru = $stmtGuru->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= htmlspecialchars($guru['id_guru']) ?>">
									<?= htmlspecialchars($guru['nama']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
				<div class="col-md-12">  
					<label  class="bold">Judul Materi</label>
					   <input type="text" class="form-control" name="judul" value="<?= $materi['judul'] ?>" placeholder="Judul materi" required>
				   </div>
				<div class="col-md-12"> 				
					<label  class="bold">Materi Belajar</label> 
					   <textarea name='isimateri' class='editor1' rows='5' cols='80' style='width:100%;'><?= $materi['isimateri'] ?></textarea>
					</div>
				 <div class="col-md-6">
						<label class="bold">Kelas</label> 
						<select name='kelas[]' id='soalkelas' class='form-control form-control-sm select2' multiple='multiple' style='width:100%' required='true'>
							<?php
							$stmtKelas = $pdo->prepare("SELECT kelas FROM m_kelas ORDER BY kelas ASC");
							$stmtKelas->execute();
							$selectedKelas = unserialize($materi['kelas']); 

							while ($kelas = $stmtKelas->fetch(PDO::FETCH_ASSOC)) :
								$isSelected = in_array($kelas['kelas'], $selectedKelas) ? 'selected' : '';
							?>
								<option value="<?= htmlspecialchars($kelas['kelas']) ?>" <?= $isSelected ?>>
									<?= htmlspecialchars($kelas['kelas']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="col-md-6"> 					 
				<label  class="bold">Berlaku Sampai Tanggal</label>
					<input type='text' name='sampai' class='datepicker form-control' value="<?= $materi['sampai'] ?>" autocomplete='off' required='true' />
				</div>	
				<div class="col-md-6">
				  <label class="bold">File (Jika ada)</label> 
					<input type="file" class="form-control" name="file" >
				</div>					
				<div class="col-md-6">
				  <label class="bold">Youtube (Jika ada)</label> 
					<input type="text" class="form-control" name="youtube" value="<?= $materi['youtube'] ?>">
				</div>						
				<div class="col-sm-12 mb-4">
				<label>Cara memasukan Link Youtube  Contoh Link : <b>https://youtu.be/42cqGZY9VTc</b> maka yang dimasukan adalah :<b>42cqGZY9VTc</b></label>
				</div>
				<div class='text-end'>
				  <button type='submit'  class='btn btn-primary'>Simpan</button>
				</div>       
			 </form>
		  </div>
		</div>
	   </div>
	 <div class="col-md-4 mb-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                  </div>
                <div class="d-flex justify-content-between mb-4">
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
                  <div class="mb-4">
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
                  <div class="mb-4">
                    <p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
                    <div class="row g-0 mb-3">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                         <i class="material-icons text-info" style="font-size:18px">person</i>
                        </div>
                      </div>
                      <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
                    </div>
                    <div class="row g-0 mb-3">
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
    $('#formedit').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        //console.log(data);
        $.ajax({
            type: 'POST',
            url: 'edit.php',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
			 beforeSend: function() {
             $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
            },
            success: function(data) {
                if (data = 'OK') {
                    setTimeout(function() {
                        window.location.replace("?pg=<?= enkripsi('materi') ?>");
                    }, 200);
                } else {
                  Swal.fire({
                    icon: 'error',
					width:'320px',
                    title: 'Gagal!',
                    text: 'Data sudah ada.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
                }
            }
        });
        return false;
    });
	
</script>

 <?php endif; ?>
 <script>
    tinymce.init({
        selector: '.editor1',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
        ],

        toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        paste_data_images: true,

        images_upload_handler: function(blobInfo, success, failure) {
            success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        },
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>