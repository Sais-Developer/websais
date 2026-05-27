<?php
defined('APK') or exit('No Access');
$id_skl = 1;

$sql = "SELECT * FROM skl WHERE id_skl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null;

$kelas = $_GET['k'] ?? '';
?>

<div class="row">
 <div class="col-xl-8">
  <div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="card-title">UPDATE DATA KELULUSAN  <?php if($kelas<>''): ?> KELAS <?= $kelas ?><?php endif; ?></h5>						
			<?php if(!empty($kelas)): ?>
			<form id="formreset">
			<input type="hidden" name="kelas" value="<?= $kelas ?>" >
			<button type="submit" class="btn btn-sm btn-danger">
          <i class="material-icons">delete</i> Reset
           </button>
		   </form>
		   <?php endif; ?>
		</div>
		<div class="card-body">
		 <div class="card-box table-responsive">
			  <table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
					<tr>
					 <th width="10%">NO</th>
					<th>NAMA SISWA</th>
					<th>KELAS</th>								
					<th>KET</th>
					</tr>
				   </thead>
				  <tbody> 
				<?php
					$stmt = $pdo->prepare("
						SELECT nama, kelas, ket
						FROM siswa 
						WHERE kelas = ? AND ket IS NOT NULL
					");
					$stmt->execute([$kelas]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					$no = 0;
					foreach ($result as $data):
						$no++;
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']); ?></td>
							<td><?= htmlspecialchars($data['kelas']); ?></td>
							<td>
								<?php 
								if ($data['ket'] == 1) {
									echo "LULUS";
								} elseif ($data['ket'] == 2) {
									echo "LULUS BERSYARAT";
								} elseif ($data['ket'] == 0) {
									echo "TIDAK LULUS";
								}
								?>
							</td>
						</tr>
					<?php
					endforeach;
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
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			<div class="text-muted mb-4">HIGH SCHOOL</div>
                 </div>
			<?php if($kelas !=''): ?>
			<form id="formupload"  class="row g-1">
			<div class="d-flex mb-2 align-items-center">
				<label>FILE XLSX</label>
				<div class="ms-auto d-flex gap-2">
			<a href="skl/proses.php?k=<?= $kelas ?>" class="btn btn-sm  btn-link"><i class="material-icons">download</i>FORMAT</a>
			</div>
			</div>
			<div class="col-lg mb-4">
				<input type='file' name='file' class='form-control' required accept=".xlsx">
			  </div>							
			<div class="d-grid gap-2 mb-4">
			<button type="submit" class="btn btn-primary kanan">IMPORT</button>
			</div>
			</form>
			 <?php endif; ?>
			<?php if($kelas==''): ?>
		<div class="col-md-12 mb-4">
					<label class="form-label">KELAS</label>
					<select class="kelas form-select" name="kelas" id="kelas" required style="width: 100%">
						<option value=''>Pilih Kelas</option>
						<?php
						if ($user['level'] == 'admin') {
							$sql = "SELECT kelas FROM m_kelas WHERE level = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$skl['tingkat']]);
						} else {
							$sql = "SELECT kelas FROM m_kelas WHERE level = ? AND kelas = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$skl['tingkat'], $user['walas']]);
						}
						while ($kl = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='{$kl['kelas']}'>{$kl['kelas']}</option>";
						}
						?>
					</select>
				</div>
			<div class="d-grid gap-2">
				<button  id="cari" class="btn btn-primary kanan">Cari Data</button>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#cari').click(function() {
		var k = $('.kelas').val();
		location.replace("?pg=<?= enkripsi('update') ?>&k=" + k);
	}); 
</script>
<script>
$('#formupload').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'skl/timpor.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="<?= $baseurl ?>/images/animasi.gif" style="width:50px;"></div>');
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
<script>
$('#formreset').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'skl/treset.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="<?= $baseurl ?>/images/animasi.gif" style="width:50px;"></div>');
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