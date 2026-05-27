<?php
defined('APK') or exit('No Access');
$kelas = $_GET['kelas'] ?? '';
$dari = $_GET['dari'] ?? '';
?>
<style>
table {
    border-collapse: collapse; 
    width: 100%;               
    font-family: Arial, sans-serif;
    font-size: 12px;
}

th, td {
    border: 1px solid #000;   
    padding: 2px 4px;         
    text-align: left;   
}

th {
    background-color: #f0f0f0;
    font-weight: bold;
    text-align: center;
}

</style>

<div class="row">  
	<div class="col-xl-8">
        <div class="card">
			<div class="card-header">
			<h5 class="card-title">SISWA NAIK KELAS</h5>
		</div>
	<div class="card-body">
		<form id="formsiswa" class="row g-2">
			<input type="hidden" name="kelas" value="<?= $kelas ?>" >
				<?php if($kelas<>''): ?>
				<div class="text-end">
				  <button type="submit" class="btn btn-primary text-end">Simpan</button>
				</div>
				<?php endif; ?>       
				 <table>
				   <thead>
					 <tr> 
                     <th>No.</th>					 
					 <th><input type="checkbox" id="check-all"></th>
					 <th>N I S</th>
					 <th>NAMA SISWA</th>
					 <th>JK</th>
					 </tr>
						</thead>
						<tbody>
						   <?php
						$no = 0;
						try {
							$stmt = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas");
							$stmt->execute(['kelas' => $dari]);
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
								?>
						<tr> 
						    <td class="text-center"><?= $no; ?></td>
							<td class="text-center">
							<input type="checkbox" name="idsiswa[]" id="check<?= $no; ?>" class="checkbox" value="<?= $data['id_siswa'] ?>">
							</td>
							<td class="text-center"><?= htmlspecialchars($data['nis']); ?></td>
							<td><?= htmlspecialchars($data['nama']); ?></td>
							<td class="text-center"><?= htmlspecialchars($data['jk']); ?></td>
						</tr>
					<?php endwhile; ?>
						<?php
						} catch (PDOException $e) {
							echo "Terjadi kesalahan: " . $e->getMessage();
						}
						?>
					</tbody>
				 </table>
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
			<div class="h5" style="color:blue">NAIK KELAS</div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>		
				<div class="col-md-12 mb-1">
					<label class="form-label">Dari Kelas</label>
					   <select class="form-select dari" id="dari" required style="width: 100%">
							<?php
							try {
								$stmt = $pdo->query("SELECT kelas FROM m_kelas");
								$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
							} catch (PDOException $e) {
								echo "Terjadi kesalahan: " . $e->getMessage();
							}
							?>
							<option value=''>Pilih Kelas</option>
							<?php foreach ($kelasList as $kls): ?>
								<option value="<?= htmlspecialchars($kls['kelas']); ?>" 
									<?= ($dari == $kls['kelas']) ? 'selected' : ''; ?>>
									<?= htmlspecialchars($kls['kelas']); ?>
								</option>
							<?php endforeach; ?>
					</select>
					</div>
				<div class="col-md-12 mb-4">
					<label class="form-label">Naik ke Kelas</label>
					  <select class="form-select kelas" id="kelas" required style="width: 100%">
							<?php
								try {
									$stmt = $pdo->query("SELECT kelas FROM m_kelas");
									$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								} catch (PDOException $e) {
									echo "Terjadi kesalahan: " . $e->getMessage();
								}
								?>
								<option value=''>Pilih Kelas</option>
								<?php foreach ($kelasList as $kls): ?>
									<option value="<?= htmlspecialchars($kls['kelas']); ?>" 
										<?= ($kelas == $kls['kelas']) ? 'selected' : ''; ?>>
										<?= htmlspecialchars($kls['kelas']); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
				<div class="text-end mb-3">
						<button id="cari" class="btn btn-primary kanan">Cari</button>
				</div>
				<div class="mb-0">
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
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#cari').click(function() {
		
		var dari = $('.dari').val();
	   var kelas = $('.kelas').val();
		location.replace("?pg=<?= enkripsi('naik') ?>&kelas=" + kelas + "&dari=" + dari);
	}); 
</script>
<script>
$('#formsiswa').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'mutasi/tmutasi.php?pg=naik',
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
				window.location.replace("?pg=<?= enkripsi('naik') ?>");
				}, 2000);
							  
				}
			});
		return false;
	});
</script>	
  <script>
$(function(){ 
 $("#check-all").click(function(){
 if ( (this).checked == true ){
 $('.checkbox').prop('checked', true);
 } else {
 $('.checkbox').prop('checked', false);
}
 });
});
</script>	  