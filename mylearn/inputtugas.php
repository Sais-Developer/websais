<?php
defined('APK') or exit('No Access');
?>
  <div class="row">
     <div class="col-md-8">
		<div class="card">
             <div class="card-header">									
                  <h5 class="card-title">TUGAS BELAJAR</h5>
					</div>
                      <div class="card-body">
                        <form id="formtugas" class="row g-2" >
                         <div class="col-md-6">        
						<label  class="bold">Mata Pelajaran</label>
							<select name='mapel' class='form-select' style='width:100%' required>
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
							<select name='guru' class='form-select' style='width:100%' required>
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
							<label  class="bold">Judul Tugas</label>
							   <input type="text" class="form-control" name="judul"   required>
                           </div>
                                       
						<div class="col-md-12"> 				
							<label  class="bold">Tugas Belajar</label> 
						       <textarea name='isitugas' class='editor1' rows='5' cols='80' style='width:100%;'></textarea>
                            </div>
                         <div class="col-md-6">           
							<label  class="bold">Kelas</label> 
						       <select name='kelas[]'  class='form-control form-control select2' multiple='multiple' style='width:100%' required='true'>
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
							<label  class="bold">Mulai</label>
						    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                         </div>
						 <div class="col-md-6"> 
							<label  class="bold">Selesai</label>
							    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                        </div>
                        <div class="col-md-6 mb-4">
						  <label class="bold">File (Jika ada)</label> 
						    <input type="file" class="form-control" name="file" >
						</div>		
						<div class='text-end'>
                          <button type='submit'  class='btn btn-primary'>Simpan</button>
                        </div>
					</form>
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
<script>
$('#formtugas').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    $.ajax({
        type: 'POST',
        url: 'buat_tugas.php',
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
                    window.location.replace("?pg=<?= enkripsi('tugas') ?>");
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