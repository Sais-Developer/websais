<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
                   <div class="row">
                      <div class="col-md-8">
                        <div class="card">
                             <div class="card-header">       
							<h5 class="card-title">INPUT ATP</h5>
							</div>
                            <div class="card-body">
								<div class="card-box table-responsive">
                                    <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                                       <thead>
                                       <tr>
                                        <th>#</th> 
										<th>MAPEL</th>
										<th>LINGKUP</th>
										<th>ELEMEN</th>
										<th>WAKTU</th>
										<th></th>
                                       </tr>
                                       </thead>
                                       <tbody>
									<?php
									$no = 0;
									if ($user['level'] === 'admin') {

										$sql = "
											SELECT a.*, m.kode, g.nama, ce.id_elemen, ce.waktu, ce.elemen
											FROM adm_tp a
											LEFT JOIN mapel m ON m.id = a.mapel
											LEFT JOIN guru g ON g.id_guru = a.guru
											LEFT JOIN cp_elemen ce ON ce.id_lingkup = a.id
											WHERE a.semester = ?
										";
										$stmt = $pdo->prepare($sql);
										$stmt->execute([$semester]);

									} elseif ($user['level'] === 'guru') {

										$sql = "
											SELECT a.*, m.kode, g.nama, ce.id_elemen, ce.waktu, ce.elemen
											FROM adm_tp a
											LEFT JOIN mapel m ON m.id = a.mapel
											LEFT JOIN guru g ON g.id_guru = a.guru
											LEFT JOIN cp_elemen ce ON ce.id_lingkup = a.id
											WHERE a.semester = ? AND a.guru = ?
										";
										$stmt = $pdo->prepare($sql);
										$stmt->execute([$semester, $id_user]);
									}

									while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
										$no++;
									?>

									<tr>
										<td><?= $no; ?></td>
										<td><?= $data['kode'] ?></td>
										<td><?= $data['lingkup'] ?></td>
										<td><?= $data['elemen'] ?></td>
										<td>
											<?php if ($data['waktu'] != ''): ?>
												<?= $data['waktu'] ?> JP
											<?php endif; ?>
										</td>
										
										<td>
											<a href="?pg=<?= enkripsi('atp') ?>&idel=<?= $data['id_elemen'] ?>" 
											   class="btn btn-sm btn-primary" 
											   data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ATP">
												<i class="material-icons">edit</i>
											</a>
										</td>
									</tr>

									<?php endwhile; ?>
							   </tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>	
				<?php
					if (empty($_GET['idel'])) {
						$idel = "";
					} else {
						$idel = $_GET['idel'];
					}
					
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
				<?php if($idel<>''): ?>
					<form id='formcpel'>
						<input type="hidden" name="idel" value="<?= $idel; ?>" >
						<div class="col-md-12 mb-1">
							<label class="bold">Alokasi Waktu (JP)</label>
							<input type="number" name="waktu" class="form-control" required="true" autocomplete="off">						   
					   </div>
						
						<div class="widget-payment-request-actions m-t-lg d-flex">

						 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
							</div>
						</form>
						<?php else: ?>
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
						<?php endif; ?>
					 </div>
				</div>
				</div>
			</div>
	
		<script>
		$('#formcpel').submit(function(e) {
				e.preventDefault();
				var data = new FormData(this);
				$.ajax({
					type: 'POST',
					 url: 'adm/tatp.php?pg=tambah',
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
							window.location.replace("?pg=<?= enkripsi('atp') ?>");
						}, 200);
					}
				})
				return false;
			});
			</script>
	       
					  <?php endif ?>
					  
					  
					  
					  	  
					  
					  
					