<?php defined('APK') or exit('Anda tidak dizinkan mengakses langsung script ini!'); ?>
<?php if ($ac == '') { ?>
	
    <div class='row'>
        <div class='col-md-8'>
            <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">TUGAS BELAJAR</h5>
					<a href="?pg=<?= enkripsi('inputtugas') ?>" class="btn btn-link">
						<i class="material-icons">add</i>Tugas
					</a>
				</div>			
				 <div class="card-body">	
                    <div id='tablemateri' class='table-responsive'>
                       <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MAPEL</th>
                                    <th>TANGGAL</th>
                                    <th>KELAS</th>
                                    <th>FILE</th>									
                                    <th></th>
									
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$no = 0;
									$query = "SELECT * FROM tugas t
											  LEFT JOIN guru g ON g.id_guru = t.guru
											  LEFT JOIN mapel p ON p.id = t.mapel";

									$stmt = $pdo->prepare($query);
									$stmt->execute();
									while ($tugas = $stmt->fetch(PDO::FETCH_ASSOC)) :
										$no++;
									?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $tugas['kode'] ?></td>
										<td><?= $tugas['tgl_mulai'] ?><br><?= $tugas['tgl_selesai'] ?></td>
                                        <td>
                                            <?php $kelas = unserialize($tugas['kelas']);
                                            foreach ($kelas as $kelas) {
                                                echo $kelas . " ";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                           <?php if ($tugas['file'] <> null) { ?>
                                                <a href="../tugas/<?= $tugas['file'] ?>" target="_blank">Lihat</a>
                                            <?php } ?>
                                        </td>										 
                                        <td style="text-align:center">                                         
                                          <a href='?pg=<?= enkripsi('tugas') ?>&ac=<?= enkripsi('jawaban') ?>&id=<?= $tugas['id_tugas'] ?>' 
										  class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Nilai Tugas">
										  <i class='material-icons'>visibility</i></a>
                                          <a href='?pg=<?= enkripsi('tugas') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $tugas['id_tugas'] ?>' 
										  class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
										  <i class='material-icons'>edit</i></a>
                                          <button data-id='<?= $tugas['id_tugas'] ?>' 
										  class="hapus btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
										  <i class="material-icons">delete</i></button>                                          
                                        </td>
									     </tr>
                                    <?php endwhile ?>
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
			
   <?php } elseif ($ac == enkripsi('edit')) { ?>
    <?php
		$id = $_GET['id'] ?? 0;
		try {
			$query = "SELECT * FROM tugas t
					  LEFT JOIN guru g ON g.id_guru = t.guru
					  LEFT JOIN mapel p ON p.id = t.mapel
					  WHERE t.id_tugas = :id";

			$stmt = $pdo->prepare($query);
			$stmt->execute([':id' => $id]);
			$tugas = $stmt->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			echo "Terjadi kesalahan: " . $e->getMessage();
			exit;
		}
		?>
 <div class='row'>
      <div class="col-md-8">
		<div class="card">
             <div class="card-header">									
                  <h5 class="card-title">EDIT TUGAS BELAJAR</h5>
					</div>
                      <div class="card-body">
					 <form id="formedit" class="row g-2">
						 <input type="hidden" value="<?= $tugas['id_tugas'] ?>" name='id'>
						   <div class="col-md-6">        
						<label  class="bold">Mata Pelajaran</label>
							<select name='mapel' class='form-select' style='width:100%' required>
                               <option value="<?= $tugas['mapel'] ?>"><?= $tugas['nama_mapel'] ?></option>
							   <option value=''>Pilih Mata Pelajaran</option>
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
                                <option value="<?= $tugas['guru'] ?>"><?= $tugas['nama'] ?></option>
							   <option value=''>Pilih Guru</option>
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
							   <input type="text" class="form-control" name="judul" value="<?= $tugas['judul'] ?>"  required>
                           </div>
                                       
						<div class="col-md-12"> 				
							<label  class="bold">Tugas Belajar</label> 
						       <textarea name='isitugas' class='editor1' rows='5' cols='80' style='width:100%;'><?= $tugas['tugas'] ?></textarea>
                            </div>
                         <div class="col-md-6">           
							<label  class="bold">Kelas</label> 
						       <select name='kelas[]' class='form-control form-control select2' multiple='multiple' style='width:100%' required='true'>
									<?php
									$stmt = $pdo->query("SELECT kelas FROM m_kelas ORDER BY kelas ASC");
									$allKelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
									$selectedKelas = unserialize($tugas['kelas']);
									foreach ($allKelas as $kelas) :
										$isSelected = in_array($kelas['kelas'], $selectedKelas) ? 'selected' : '';
									?>
										<option value="<?= htmlspecialchars($kelas['kelas']) ?>" <?= $isSelected ?>>
											<?= htmlspecialchars($kelas['kelas']) ?>
										</option>
									<?php endforeach; ?>
								</select>
                        </div>
						 <div class="col-md-6">   
							<label  class="bold">Mulai</label>
						    <input type='text' name='tgl_mulai' class='tgl form-control' value="<?= $tugas['tgl_mulai'] ?>" autocomplete='off' required='true' />
                         </div>
						 <div class="col-md-6"> 
							<label  class="bold">Selesai</label>
							    <input type='text' name='tgl_selesai' class='tgl form-control' value="<?= $tugas['tgl_selesai'] ?>" autocomplete='off' required='true' />
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
        $('#formedit').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
        type: 'POST',
        url: 'edit_tugas.php',
        enctype: 'multipart/form-data',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		$('.progress-bar').animate({
				width: "30%"
				}, 500);
			setTimeout(function() {
			window.location.replace('?pg=<?= enkripsi("tugas") ?>');
					}, 200);

				}
			});
			return false;
			});
 
      </script>	            
<?php } elseif ($ac == enkripsi('jawaban')) { ?>
    <?php $id = $_GET['id']; ?>
    <div class='row'>
        <div class='col-md-8'>
            <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">	
			 <h5 class='card-title'>TUGAS BELAJAR</h5>
				<button class='btn btn-link' onclick="frames['frameresult'].print()"><i class='material-icons'>print</i>Nilai</button>
			</div>
                <div class='card-body' id="tablejawaban">
				 <div class='table-responsive'>
                   <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>File</th>
                                <th>Nilai</th>
                                <th width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
								$jawabx = $pdo->prepare("SELECT * FROM jawaban_tugas WHERE id_tugas = ?");
								$jawabx->execute([$id]);
								$jawab_list = $jawabx->fetchAll(PDO::FETCH_ASSOC);
								$no = 0;
								foreach ($jawab_list as $jawab) {
									$no++;

									$stmt_siswa = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
									$stmt_siswa->execute([$jawab['id_siswa']]);
									$siswa = $stmt_siswa->fetch(PDO::FETCH_ASSOC);
									$stmt_siswa = null;

									$stmt_jumlah = $pdo->prepare("SELECT COUNT(*) FROM jawaban_tugas WHERE id_siswa = ? AND id_tugas = ? AND nilai > 0");
									$stmt_jumlah->execute([$jawab['id_siswa'], $jawab['id_tugas']]);
									$jumlah = $stmt_jumlah->fetchColumn();
									$stmt_jumlah = null;
								?>
                                <tr>
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $siswa['kelas'] ?></td>
									
                                    <td>
                                        <?php if ($jawab['file'] <> null) { ?>												
							          <a href="<?= $baseurl ?>/tugas/<?= $jawab['file'] ?>"  class="btn btn-sm btn-success" target="_blank"><i class="material-icons">download</i></a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $jawab['nilai'] ?></td>

                                    <td>
                                       
                                        <?php if($jumlah==0){ ?>
										<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalnilai<?= $no ?>">
                                            <i class="material-icons">add</i>
                                        </button>
										<?php }else{ ?>
										<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalnilai<?= $no ?>" disabled>
                                            <i class="material-icons">lock</i>
                                        </button>
										<?php } ?>
                                        <button data-id='<?= $jawab['id_jawaban'] ?>' class="hapus btn btn-danger btn-sm"><i class="material-icons">delete</i></button>
                                      
                                        <div class="modal fade" id="modalnilai<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                              <div class="modal-dialog">
										   <div class="modal-content">
											  <div class="modal-header">
												<h5 class="modal-title" id="tambahjadwal">Input Nilai</h5>
												   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														 <div class="modal-body">
                                                    <form id="formnilaitugas<?= $jawab['id_jawaban'] ?>">
                                                        
                                                            <input type="hidden" class="form-control" name="id" value="<?= $jawab['id_jawaban'] ?>">
                                                            <div class="form-group">
                                                                <label class="bold">Jawaban</label>
                                                                <p><?= $jawab['jawaban'] ?></p>
                                                            </div>
															<div class="form-group">
                                                                <label class="bold">Nilai</label>
                                                                <input type="number" class="form-control" name="nilai" required="true">                                                                
                                                            </div>
                                                            
													<div class='modal-footer'>	
													<button type='submit' class='btn btn-primary kanan'> Simpan</button>
														
														</div>
														</form>
                                                       </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $("#formnilaitugas<?= $jawab['id_jawaban'] ?>").submit(function(e) {
                                                e.preventDefault();
                                                var id = '<?= $jawab['id_jawaban'] ?>';
                                                $.ajax({
                                                    type: "POST",
                                                    url: "simpan_nilai.php",
                                                    data: $(this).serialize(),
                                                    success: function(result) {
                                                     $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
													
													setTimeout(function() {
														window.location.reload();
													}, 200);

												}
											});
											return false;
										});
                                        </script>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<iframe id='loadframe' name='frameresult' src='print_jawaban.php?id=<?= $_GET['id'] ?>' style='display:none'></iframe>
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
	</div>
<?php } ?>

<script>
    $('#datatable1').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "akan menghapus tugas ini!",
            icon:'warning',
			width:'320px',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'hapus_tugas.php',
                    method: "POST",
                    data: 'id=' + id,
					 beforeSend: function() {
                    $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
                    },
                    success: function(data) {
                      
                        setTimeout(function() {
                            window.location.reload();
                        }, 200);
                    }
                });
            }
            return false;
        })

    });
	
    $('#tablejawaban').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "akan menghapus nilai ini!",
            icon:'warning',
			width:'320px',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'hapus_nilai.php',
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