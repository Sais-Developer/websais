<?php
defined('APK') or exit('No Access');

?>
<?php if ($ac == '') : ?>
    <div class='row'>
      <div class="col-xl-8">
         <div class="card">
		   <div class="card-header">
              <h5 class="card-title">DATA NILAI</h5>                    
                </div>					 
        <div class="card-body">   
            <div id="tablenilai" class='table-responsive'>
                <table id="datatable1" class='table table-bordered table-hover'>
                  <thead>
					<tr>
					<th width='5px'>#</th>                                 
					<th>MATA PELAJARAN</th>
					<th>KODE</th>
					<th>SESI</th>
					<th>TINGKAT</th>								
					<th>KOREKSI</th>
					<th>CETAK</th>
					</tr>
				</thead>
			<tbody>
			   <?php
					$sql = "SELECT u.*, b.*,m.nama_mapel
					FROM ujian u 
							LEFT JOIN banksoal b ON b.id_bank = u.idbank
							LEFT JOIN mapel m ON m.id = b.idmapel";

					$stmt = $pdo->query($sql);
					$no = 0;
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
					$no++;
					?>
				<tr>
					<td><?= $no ?></td>                                       
					<td><?= $data['nama_mapel'] ?></td>
					<td><h5><span class="badge badge-secondary"><?= $data['kode'] ?></span></h5></td> 
					<td><h5><span class="badge badge-success"><?= $data['sesi'] ?></span></h5></td>  										
					<td><h5><span class="badge badge-dark"><?= $data['tingkat'] ?></span> <span class="badge badge-dark"><?= $data['pk'] ?></span></h5></td>
					<td>
					<a href="?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('koreksi') ?>&idb=<?= $data['id_bank']?>&sesi=<?= $data['sesi'] ?>" class="btn btn-sm btn-primary"><i class="material-icons">search</i></a>
					</td>									
					<td>
					<a href="?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('lihat') ?>&idb=<?= $data['id_bank']?>&sesi=<?= $data['sesi'] ?>" class="btn btn-sm btn-primary"><i class="material-icons">print</i></a>
					</td>
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
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
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
   <?php elseif ($ac == enkripsi('lihat')) : ?>
	   <?php 
		$kelas = $_GET['kelas'] ?? '';
		$idb   = $_GET['idb'] ?? '';
		if (!is_numeric($idb)) {
			die("ID Bank tidak valid.");
		}
		$idb = (int) $idb;
		$stmt = $pdo->prepare("SELECT * FROM banksoal WHERE id_bank = :idb");
		$stmt->execute(['idb' => $idb]);
		$bank = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$bank) {
			die("Bank soal tidak ditemukan.");
		}
		?>
 <div class="row">
	<div class="col-md-8">
       <div class="card">
          <div class="card-header">
              <h5 class="card-title"> 
			<?= strtoupper($bank['kode']); ?> | Tingkat <?= $bank['tingkat'] ?> | <?= $kelas ?></h5>
				</div>
             <div class="card-body">
				 <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered" >
                      <thead>
                      <tr>
                      <th width="10%">NO</th>
					  <th>NO PESERTA</th>
                      <th>NAMA SISWA</th>
                      <th>NILAI</th>
                      </tr>
                      </thead>
                      <tbody>
			        <?php
						$no = 0;
						$sesi  = $_GET['sesi'] ?? '';
						$idb   = $_GET['idb'] ?? '';
						$kelas = $_GET['kelas'] ?? '';

						$stmtSiswa = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas AND sesi = :sesi");
						$stmtSiswa->execute([
							'kelas' => $kelas,
							'sesi'  => $sesi
						]);
						$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);
						$stmtNilai = $pdo->prepare("SELECT id_siswa, id_bank, nilai 
								FROM nilai 
							    WHERE id_siswa = :id_siswa AND id_bank = :idb");
								
						 foreach ($siswaList as $data) :
							$id_siswa = $data['id_siswa'];
							$stmtNilai->execute([
								'id_siswa' => $id_siswa,
								'idb'      => $idb
							]);
							$nilai = $stmtNilai->fetch(PDO::FETCH_ASSOC);
							$no++;
						?>
                     <tr>		
					 <td><?= $no; ?></td>
					  <td><?= $data['nopes'] ?></td>
					  <td><?= $data['nama'] ?></td>
					  <td><?= number_format($nilai['nilai'], 2, '.', '') ?></td>
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
				<a href="nilai/nilai.php?idb=<?= $bank['id_bank'] ?>&sesi=<?= $_GET['sesi'] ?>&kls=<?= $kelas ?>" target="_blank" class="btn btn-primary flex-grow-1 m-l-xxs" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Nilai"><i class="material-icons">download</i>NILAI</a>				
					</div>
				<?php endif; ?>
				 <div class="widget-payment-request-info m-t-md">
                     <label class="bold">KELAS</label>
						<div class="input-group mb-1">
						<select class="form-select kelas">						
                            <?php
							$stmt = $pdo->prepare("SELECT kelas, level FROM m_kelas WHERE level = :level");
							$stmt->execute(['level' => $bank['tingkat']]);
							$rombelList = $stmt->fetchAll(PDO::FETCH_ASSOC);
							?>
							<option value=''>Pilih Rombel</option>
							<?php foreach ($rombelList as $kls) : ?>
								<option value="<?= $kls['kelas'] ?>" <?= ($kelas == $kls['kelas']) ? 'selected' : '' ?>>
									<?= $kls['kelas'] ?>
								</option>
							<?php endforeach; ?>
                            </select>	
						</div>	  
					<label class="bold">SESI</label>
						<div class="input-group mb-1">
						<select class="form-select sesi">
                          
                                <option value="<?= $_GET['sesi'] ?>"> <?= $_GET['sesi'] ?></option>
                            </select>	
						</div>
						
                   <div class="widget-payment-request-actions m-t-lg d-flex mb-4">
                          <button id="cari" class="btn btn-success flex-grow-1 m-l-xxs"><i class='material-icons'>search</i> CARI NILAI</button>
                            <script type="text/javascript">
                                $('#cari').click(function() {
                                    var kelas = $('.kelas').val();
                                    var sesi = $('.sesi').val();
									var idb = <?= $_GET['idb'] ?>;
                                    location.replace("?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('lihat') ?>&kelas=" + kelas + "&sesi=" + sesi + "&idb=" + idb);
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
				</div>
				</div>
			</div>
		</div>
	 </div>		
  
<?php elseif ($ac == enkripsi('koreksi')) : ?>
   <?php 
    $idb = $_GET['idb'];
    $sesi = $_GET['sesi'];
	$stmt = $pdo->prepare("SELECT COUNT(*) AS jml FROM soal WHERE id_bank = :idb AND jenis = 5");
	$stmt->execute(['idb' => $idb]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$jsoal = $row['jml'];
	?>
<div class="row">
 <div class="col-xl-8">
	<div class="card">
	<div class="card-header">
		<h5 class="card-title">KOREKSI JAWABAN ESAI <span class="badge badge-primary"><?= strtoupper($bank['kode']); ?></span></h5>
		</div>
		<div class="card-body">
		<?php if($jsoal <>0): ?>
		<div class="card-box table-responsive">
			 <table id="datatable1" class="table table-bordered table-analisis edis2">
				<thead>
					<tr>
					  <th width="10%">NO</th>
					  <th>NAMA SISWA</th>                            
					  <th>TINGKAT</th>													                                                   
					   <th>EDIT</th>
					</tr>
				</thead>
				<tbody>
				 <?php
					$no = 0;
					$sql = "
						SELECT *
						FROM nilai n
						JOIN siswa s ON s.id_siswa = n.id_siswa
						WHERE n.id_bank = :idb 
						  AND s.sesi = :sesi
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						'idb'  => $idb,
						'sesi' => $sesi
					]);

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
					?>
					<tr>
					   <td><?= $no; ?></td>
					   <td><?= $data['nama'] ?></td>
					   <td><h5><span class="badge badge-dark"><?= $data['level'] ?></span> <span class="badge badge-dark"><?= $data['kelas'] ?></span></h5></td>
					   <td>
						<a href="?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('edit') ?>&idn=<?= enkripsi($data['id_nilai']) ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Koreksi Jawaban"><i class="material-icons">edit</i></a>		  				 
						</td>
					</tr>
					<?php endwhile; ?>
					 </tbody>
					</table>
					 </div>
					 <?php else: ?>
					 TIDAK ADA SOAL ESAI
					 <?php endif; ?>
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
	
	<?php elseif ($ac == enkripsi('edit')) : ?>
	 <?php
		$idn = dekripsi($_GET['idn']);
		$sql = "
			SELECT *
			FROM nilai n
			LEFT JOIN banksoal b ON b.id_bank = n.id_bank
			LEFT JOIN mapel m   ON m.id = b.idmapel
			JOIN siswa s        ON s.id_siswa = n.id_siswa
			WHERE n.id_nilai = :idn
		";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['idn' => $idn]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$id_siswa = $data['id_siswa'] ?? null;
		$id_bank  = $data['id_bank'] ?? null;
		?>
<div class='row'>
    <div class="col-md-8">
        <div class="card">
		   <div class="card-header">
               <h5 class="card-title"><?= $data['nama'] ?></small></h5>  
                  </div>              
		    <div class="card-body">
		        <table id="datatable1" class="table table-bordered table-analisis edis2">
                   <thead>
						<tr>
						<th width='8%'>#</th>
						<th><b>SOAL</th>
						<th>JAWABAN</th>
						<th>SKOR</th>
						<th>EDIT</th>
						</tr>
						</thead>
						<tbody>
						   <?php
						$no = 0;
						$sql = "
							SELECT *
							FROM soal s
							JOIN arsip_jawaban a ON a.id_soal = s.id_soal
							WHERE s.id_bank = :id_bank
							  AND s.jenis = '5'
							  AND a.id_siswa = :id_siswa
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([
							'id_bank'  => $id_bank,
							'id_siswa' => $id_siswa
						]);

						while ($soal = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $soal['soal'] ?></td>
							<td><?= $soal['jawaban'] ?></td>
							<td><?= $soal['max_skor'] ?></td>
							<td>
								<a href="?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('edit') ?>&idn=<?= enkripsi($idn); ?>&idj=<?= $soal['id_jawaban'] ?>&sk=<?= $soal['max_skor'] ?>" 
								   class="btn btn-sm btn-icon btn-icon-only btn-primary"
								   data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Skor">
								   <i class="material-icons">edit</i></a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
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
					  <form id="formujian" class="row g2" enctype='multipart/form-data'>
					  <input type="hidden" name="idj" value="<?= $_GET['idj'] ?>" >
					   <div class='col-md-12 mb-4'>
						   <label class="bold">EDIT SKOR</label>
							 <input type='number' name='skor' class='form-control' value="0" autocomplete='off' required='true' />
							</div>
							<?php if($_GET['sk']): ?>
								<div class="col-md-12 mb-2 text-end">
								<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
							</div>

							 <?php endif; ?>
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
$('#formujian').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    $.ajax({
        type: 'POST',
        url: 'nilai/tnilai.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            response = response.trim();

            if (response === 'OK') {
                Swal.fire({
                    icon: 'success',
					width: '320px',
                    title: 'Berhasil!',
                    text: 'Data telah disimpan.',
                    timer: 1000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.replace("?pg=<?= enkripsi('nilai') ?>&ac=<?= enkripsi('edit') ?>&idn=<?= enkripsi($idn); ?>");
                });
            } else {
                Swal.fire({
                    icon: 'info',
					 width: '320px',
                    title: 'Info',
                    text: response,
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        },
        error: function(xhr, status, error) {
            $('#progressbox').html('');
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan',
                text: error,
            });
            console.error('AJAX Error:', xhr.responseText);
        }
    });

    return false;
});
</script>								
<?php endif; ?>
