<?php
defined('APK') or exit('No Access');
$kelas = $_GET['k'] ?? '';
$tingkat = $_GET['t'] ?? '';
?>

<?php if ($ac == '') : ?>
                   
<div class="row"> 
    <div class="col-md-8">
       <div class="card">
        <div class="card card-header">
			<h5 class="card-title">CETAK KARTU PESERTA </h5>
			</div> 	
	<div class="card-body">
			<div class="row mb-2">
                <label  class="col-sm-2 control-label bold">Header</label>
				<div class="col-md-10">
					<textarea id='headerkartu' name="jawab" class='form-control text-center' onchange='kirim_form();' rows='2'><?= $setting['header_kartu'] ?></textarea>
				</div>
				</div>
				<div class="row mb-2">
                 <label  class="col-sm-2 control-label bold">Tingkat</label>
				<div class="col-md-10">
                   <select name="tingkat" id="tingkat" class="form-select tingkat" style="width: 100%;" required>
						<option value="<?= htmlspecialchars($tingkat) ?>"><?= htmlspecialchars($tingkat) ?></option>
						<?php
						$stmt = $pdo->prepare("SELECT DISTINCT level FROM m_kelas ORDER BY level ASC");
						$stmt->execute();
						$levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($levels as $Q): ?>
							<option value="<?= htmlspecialchars($Q['level']); ?>"><?= htmlspecialchars($Q['level']); ?></option>
						<?php endforeach; ?>
					</select>
                        </div>
						</div>
					<div class="row mb-2">
                        <label  class="col-sm-2 control-label bold">Kelas</label>
						 <div class="col-md-10 mb-4">
                            <select name="kelas" id="kelas" class="form-select kelas" style="width: 100%;" required>
								<option value="<?= htmlspecialchars($kelas) ?>"><?= htmlspecialchars($kelas) ?></option>
								<?php
								echo "<option value=''>Pilih Kelas</option>";
								$stmt = $pdo->prepare("SELECT level, kelas FROM m_kelas WHERE level = :tingkat ORDER BY kelas ASC");
								$stmt->bindParam(':tingkat', $tingkat, PDO::PARAM_STR);
								$stmt->execute();
								$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($kelasList as $data) {
									$selected = ($data['kelas'] == $kelas) ? 'selected' : '';
									echo "<option value='" . htmlspecialchars($data['kelas']) . "' $selected>" . htmlspecialchars($data['kelas']) . "</option>";
								}
								?>
							</select>
                           </div>
						</div>
                    <div class="row mb-4">
                           <label  class="col-sm-2 control-label bold"></label>
					    <div class="col-md-10 text-end"> 
							<button class="btn btn-primary" onclick="frames['frameresult'].print()">
								<i class="material-icons">print</i> Print
							</button>
							<iframe 
								id="loadframe" 
								name="frameresult" 
								src="cetak/cetak_kartu.php?kelas=<?= htmlspecialchars($kelas) ?>" 
								style="display:none">
							</iframe>
						</div>
						</div>
                       </div>
					</div>
				</div>
					
					<script type="text/javascript">
					$('#kelas').change(function() {
					var k = $('.kelas').val();
					var t = $('.tingkat').val();
					location.replace("?pg=<?= enkripsi('kartu') ?>&k=" + k + "&t=" + t);
					}); 
					</script>
					<script>
					$("#tingkat").change(function() {
					var tingkat = $(this).val();
					console.log(tingkat);
					$.ajax({
					type: "POST", 
					url: "cetak/ambildata.php?pg=kelas", 
					data: "tingkat=" + tingkat, 
					success: function(response) { 
					$("#kelas").html(response);
							}
						});
					});
					</script>					
					<script>
						function kirim_form() {			
						var jawab = $('#headerkartu').val();
						$.ajax({
						type: 'POST',
						url: 'cetak/tberita.php?pg=header',
						data: 'jawab=' + jawab,
						success: function(response) {
						location.reload();
								}
							});
							}
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
					   
		<?php endif; ?>
		
