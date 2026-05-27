<?php
defined('APK') or exit('No Access');
?>
   <?php
$kelas = $_GET['kelas'] ?? '';
$stmtLevel = $pdo->prepare("SELECT level FROM m_kelas WHERE kelas = :kelas");
$stmtLevel->execute(['kelas' => $kelas]);
$dataLevel = $stmtLevel->fetch(PDO::FETCH_ASSOC);
$level = $dataLevel['level'] ?? '';
?>


<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card card-header">
                <h5 class="card-title">Tingkat <?= htmlspecialchars($level) ?> | <?= htmlspecialchars($kelas) ?></h5>
            </div>
            <div class="card-body">
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%; font-size:12px">
                        <thead>
                            <tr>
                                <th width="10%">NO</th>
                                <th>N I S</th>
                                <th>N I S N</th>
								 <th>NAMA SISWA</th>
								  <th>JK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$no = 0;
								$stmtSiswa = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas ORDER BY nama ASC");
								$stmtSiswa->execute(['kelas' => $kelas]);
								$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

								foreach ($siswaList as $siswa) :
									$no++;
								?>
								<tr>
									<td><?= $no ?></td>
									<td><?= ucwords(strtolower(htmlspecialchars($siswa['nis']))) ?></td>
									<td><?= ucwords(strtolower(htmlspecialchars($siswa['nisn']))) ?></td>
									<td><?= ucwords(strtolower(htmlspecialchars($siswa['nama']))) ?></td>
									<td><?= ucwords(strtolower(htmlspecialchars($siswa['jk']))) ?></td>
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
		     <?php if($kelas !=''): ?>
			<div class="widget-payment-request-actions m-t-lg d-flex">					
			<a href="nilai/rekapnilai.php?tkt=<?= $level ?>&kls=<?= $kelas ?>" target="_blank" class="btn btn-primary flex-grow-1 m-l-xxs" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Nilai"><i class="material-icons">download</i>REKAP NILAI</a>				
              </div>
			 <?php endif; ?>
				 <div class="widget-payment-request-info m-t-md">
                     <label class="bold">KELAS</label>
						<div class="input-group mb-1">
						<select class="form-select kelas">
							<option value=''>Pilih Rombel</option>
							<?php
							$stmt = $pdo->prepare("SELECT kelas, level FROM m_kelas ORDER BY kelas ASC");
							$stmt->execute();
							$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($kelasList as $kls) :
								$selected = ($kelas == $kls['kelas']) ? 'selected' : '';
							?>
								<option value="<?= htmlspecialchars($kls['kelas']) ?>" <?= $selected ?>>
									<?= htmlspecialchars($kls['kelas']) ?>
								</option>
							<?php endforeach; ?>
						</select>
						</div>	  
					
                   <div class="widget-payment-request-actions m-t-lg d-flex mb-4">
                          <button id="cari" class="btn btn-success flex-grow-1 m-l-xxs"><i class='material-icons'>search</i> CARI NILAI</button>
                            <script type="text/javascript">
                                $('#cari').click(function() {
                                    var kelas = $('.kelas').val();
                                    location.replace("?pg=<?= enkripsi('rekap') ?>&kelas=" + kelas);
                                }); 
                            </script>
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
	</div>		
	
