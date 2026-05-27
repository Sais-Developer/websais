<?php
defined('APK') or exit('No Access');
$hari = date('D');
?>           
	<?php if ($ac == '') : ?>
	<?php
    $kelas = $_GET['k'] ?? '';
   
	?>
    <div class="row">
       <div class="col-md-8">
         <div class="card">
           <div class="card-header">
               <h5 class="card-title">CETAK RAPOR PAT <span class="badge badge-success"><?= $semester ?></span></h5>
				</div>	  
             <div class="card-body">
				<div class="card-box table-responsive">
                <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                    <thead>
                     <tr>
                    <th width="5%">NO</th>												  
					<th>N I S</th>
					<th>NAMA SISWA</th>
                    <th></th>				 
                    </tr>
                    </thead>											
                    <tbody>	
					<?php
						$no = 0;
						try {
							$stmt = $pdo->prepare("SELECT id_siswa, nis, nama FROM siswa WHERE kelas = :kelas");
							$stmt->execute([':kelas' => $kelas]);
							$siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($siswaList as $data) {
								$no++;
								?>
					<tr style="vertical-align:middle;">
                        <td><?= $no; ?></td>
                        <td><?= $data['nis'] ?></td>
						<td><?= $data['nama'] ?></td>
						<td>
						<a href="cetak/print_cover.php?ids=<?= $data['id_siswa'] ?>&k=PAT" target="_blank" class="btn btn-sm btn-primary"><i class="material-icons">print</i></a>			
						<a href="cetak/rapor_pat.php?ids=<?= $data['id_siswa'] ?>" target="_blank" class="btn btn-sm btn-warning"><i class="material-icons">print</i></a>					
						</td>
						</tr>
						<?php
							}
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
				<div class="col-md-12 mb-1">
					<label class="bold">Semester</label>
                        <select name="smt"  class='form-select' style='width:100%' required="true" > 
						<option value="<?= $semester ?>"><?= $semester ?></option>
						</select>
                    </div>
										
			     <div class="col-md-12 mb-1">
					<label class="bold">Kelas</label>
						<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true">
							<option value="">Pilih Kelas</option>
							<?php 
							try {
								if ($user['level'] == 'admin') {
									$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
									$stmt->execute();
								} elseif ($user['level'] == 'guru') {
									$stmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = :walas");
									$stmt->execute([':walas' => $user['walas']]);
								}
								$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($kelasList as $data) { ?>
									<option value="<?= htmlspecialchars($data['kelas']); ?>">
										<?= htmlspecialchars($data['kelas']); ?>
									</option>
								<?php }
							} catch (PDOException $e) {
								echo "<option value=''>Error: " . $e->getMessage() . "</option>";
							}
							?>
						</select>
                      </div>				
<div class="widget-payment-request-actions m-t-lg d-flex mb-4">
	<button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
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
<script type="text/javascript">
				$('#pilih').click(function() {
				var k = $('#kelas').val();
				location.replace("?pg=<?= enkripsi('cetakpat') ?>&k=" + k);
				}); 
			</script>
<?php endif ?>
					  
					  
					  
					  	  
					  
					  
					