<?php
defined('APK') or exit('No access');

$kelas = $_GET['k'] ?? '';
$idk   = $_GET['g'] ?? '';
$dudi  = $_GET['d'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM pkl_kompetensi WHERE id_kompetensi = ? LIMIT 1");
$stmt->execute([$idk]); // Kirim parameter sebagai array
$mpl = $stmt->fetch(PDO::FETCH_ASSOC);

$komp = $mpl['kompeten'] ?? '';
?>
<div class="row">
   <div class="col-md-8">
	 <div class="card">
		 <div class="card-header">
			<h5 class="card-title"> NILAI PRAKERIN</h5>
				</div>
			   <div class="card-body">
				<div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                            <th width="10%">NO</th>                                               
                            <th>NAMA SISWA</th>
                            <th>KELAS</th>
							<th>NR</th>
							<th>PRED</th>
                            </tr>
                        </thead>
                        <tbody>
                       <?php
						$sql = "
							SELECT s.nama, s.kelas, 
								   AVG(p.nilai) AS rata_rata
							FROM pkl_nilai p 
							LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
							WHERE p.kelas = ? AND p.iddudi = ? 
							GROUP BY p.idsiswa
						";
						$stmt = $pdo->prepare($sql);
						$stmt->execute([$kelas, $dudi]); 

						$no = 0;
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
							$rata = round($data['rata_rata'], 2);

							if ($rata >= 90) {
								$predikat = "A";
							} elseif ($rata >= 80) {
								$predikat = "B";
							} elseif ($rata >= 70) {
								$predikat = "C";
							} elseif ($rata >= 60) {
								$predikat = "D";
							} else {
								$predikat = "E";
							}
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']) ?></td>
							<td><?= htmlspecialchars($data['kelas']) ?></td>
							<td><?= $rata; ?></td>
							<td><?= $predikat; ?></td>
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
					<img src="<?= $baseurl ?>/images/pkl.png" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">PRAKERIN</div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
				  <div class="text-muted">HIGH SCHOOL</div>
				</div>
			<?php if($kelas == ''): ?>
		   <div class="col-md-12 mb-1">
			<label class="bold">Tempat Prakerin (DUDI)</label>
				<select  id="dudi" class="form-select" style="width:100%" required>
					<option value="">Pilih Dudi</option>
					<?php
						$stmt = $pdo->prepare("SELECT id, nama_dudi FROM pkl_dudi");
						$stmt->execute();
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$selected = ($dudi == $data['id']) ? 'selected' : '';
							?>
							<option value="<?= htmlspecialchars($data['id']) ?>" <?= $selected; ?>>
								<?= htmlspecialchars($data['nama_dudi']) ?>
							</option>
						<?php
						}
						?>
				</select>
		  </div>
		  <script type="text/javascript">
			$('#dudi').change(function() {
			var d = $('#dudi').val();	
			location.replace("?pg=<?= enkripsi('inputnilai') ?>&d=" + d);
			}); 
		</script>
		 <div class="col-md-12 mb-1">
			<label class="bold">Kelas</label>
			<select  id="kelas" class="form-select" style="width:100%" required>
			<option value="">Pilih Kelas</option>
			<?php
				$stmt = $pdo->prepare("SELECT kelas FROM pkl_siswa WHERE dudi = ? GROUP BY kelas");
				$stmt->execute([$dudi]); 
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$selected = ($kelas == $data['kelas']) ? 'selected' : '';
					?>
					<option value="<?= htmlspecialchars($data['kelas']) ?>" <?= $selected; ?>>
						<?= htmlspecialchars($data['kelas']) ?>
					</option>
				<?php
				}

				?>
				</select>
			   </div>
		<script type="text/javascript">
			$('#kelas').change(function() {
			var d = $('#dudi').val();
			var k = $('#kelas').val();										
			location.replace("?pg=<?= enkripsi('inputnilai') ?>&k=" + k + "&d=" + d);
			}); 
		</script>
		
		<?php else: ?>
	  <div class="widget-payment-request-actions m-t-lg d-flex">
		<form id='formnilai' >	
				<label class="bold">Pilih File</label>
				<a href="nilai/proses.php?k=<?= $kelas; ?>&d=<?= $dudi; ?>" class="btn btn-link text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format"> <i class="material-icons">download</i> Format</a>	   				            
				<div class="input-group mb-2">
			   <input type='file' name='file' class='form-control' required accept=".xlsx">
					<span class="input-group-text">
						<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
						</span>
					</div>	
					</form>
		   </div>
		   <div class="widget-payment-request-actions m-t-lg d-flex">
		   <a href="?pg=<?= enkripsi('inputnilai') ?>" class="btn btn-primary flex-grow-1 m-l-xxs"> Kembali</a>
			</div>
		<?php endif; ?>
	   </div>
	</div>
</div>
						
	<script>
    $('#formnilai').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'nilai/upload.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			$('.progress-bar').animate({
			
			}, 500);
			},			
			success: function(data){  			
			setTimeout(function()
				{
				window.location.reload();
						}, 2000);
									  
						}
					});
				return false;
			});
		</script>	
     