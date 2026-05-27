<?php
defined('APK') or exit('No Access');
?>           
	<?php if ($ac == '') : ?>
	<?php
	$kelasmu = $_GET['k'] ?? '';
 	$semester = $setting['semester'];
	$tapel = $setting['tp'];
	?>
<div class="row">
   <div class="col-md-8">
      <div class="card">
	<div class="card-header">
		<h5 class="bold">
		UPDATE DATA SISWA
		</h5>										
	</div>
    <div class="card-body">
		<table id="datatable1" class="table table-bordered" style="width:100%;font-size:12px">
			<thead>
				<tr>
				  <th width="10%">NO</th>												  												 
				  <th>NAMA SISWA</th>
				  <th>TMP LAHIR</th>
				  <th>TGL LAHIR</th>
				  <th>ALAMAT</th>												  
				</tr>
			</thead>											
			<tbody>	
			<?php
				$no = 0;
				$stmt = $pdo->prepare("SELECT * FROM siswa WHERE kelas = ?");
				$stmt->execute([$kelasmu]);

				foreach ($stmt as $data) :
				$no++;
				?>

				<tr>
					<td><?= $no; ?></td>
					<td><?= htmlspecialchars($data['nama']); ?></td>
					<td><?= htmlspecialchars($data['t_lahir']); ?></td>
					<td><?= htmlspecialchars($data['tgl_lahir']); ?></td>
					<td><?= htmlspecialchars($data['alamat']); ?></td>
				</tr>
				<?php endforeach; ?>
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
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				  <div class="text-muted">HIGH SCHOOL</div>
				</div>
				<?php if($kelasmu==''): ?>
				<div class="col-md-12 mb-1">
				   <label class="bold">Kelas</label>
						<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true" >                                         
						<option value="">Pilih Kelas</option>
							<?php 
							if ($user['level'] == 'admin') {
								$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
								$stmt->execute();

							} elseif ($user['level'] == 'guru') {
								$stmt = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = ?");
								$stmt->execute([$user['walas']]);

							}

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
								<option value="<?= htmlspecialchars($data['kelas']); ?>">
									<?= htmlspecialchars($data['kelas']); ?>
								</option>
							<?php endwhile; ?>
                        </select>
					</div>
						
					<div class="widget-payment-request-actions m-t-lg d-flex">
						 <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
							</div>
							<?php else: ?>
					<div class="widget-payment-request-info m-t-md"> 						      
						<form id='formsiswa' >	
							<div class="d-flex justify-content-between align-items-center mb-2">
									<label class="bold mb-0">Pilih File</label>
									<a href="proses.php?k=<?= $kelasmu; ?>" 
									   class="btn btn-link" 
									   data-bs-toggle="tooltip" 
									   data-bs-placement="top" 
									   title="Download Format">
									   <i class="material-icons">download</i> Format
									</a>
								</div>	            
							<div class="input-group mb-2">
						   <input type='file' name='file' class='form-control' required accept=".xlsx">
								<span class="input-group-text">
									<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
									</span>
								</div>	
							</form>
							</div> 
						<?php endif; ?>
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
<?php endif ?>
					
<script type="text/javascript">
$('#pilih').click(function() {	
var k = $('#kelas').val();

location.replace("?pg=<?= enkripsi('update') ?>&k=" + k);
}); 
</script>
<script>
$('#formsiswa').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'timpor.php',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(function()
			{
			window.location.reload();
			}, 200);
								  
			}
		});
		return false;
	});
</script>	
					            

									  
					  
					  
					  	  
					  
					  
					