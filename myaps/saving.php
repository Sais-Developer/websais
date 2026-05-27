<style>
li.divider {
    margin: 5px 0;      
    padding: 0;          
    border-top: 1px solid #ccc; 
    list-style: none;    
}
</style>
<div class="app-content">
		<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> content</a>
		<div class="content-menu content-menu-right">
			<ul class="list-unstyled">
			    <li><a href="?pg=<?= enkripsi('arsip') ?>">Beranda</a></li>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>" class="active">Live Mesin Tabungan</a></li>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>&ac=<?= enkripsi('debet') ?>">Data Tabungan Siswa</a></li>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>&ac=<?= enkripsi('tarik') ?>">Data Penarikan Saldo</a></li>
				<li class="divider"></li>
				<?php if($user['level']=='admin' || $user['level']=='staff'): ?>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>&ac=<?= enkripsi('simpanan') ?>">Input Simpanan Manual</a></li>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>&ac=<?= enkripsi('ambil') ?>">Tarik Simpanan Manual</a></li>
				<li><a href="tabungan/cetaktab.php" target="_blank">Rekap Simpanan Bulan ini</a></li>
				<li><a href="tabungan/cetaktarik.php" target="_blank">Rekap Penarikan Bulan ini</a></li>
				<li class="divider"></li>
				 <li><a href="?pg=<?= enkripsi('tabungan') ?>&ac=<?= enkripsi('reset') ?>">Reset Data Simpanan</a></li>
				 <li class="divider"></li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="content-wrapper">
			<div class="container-fluid">
				<?php if (($ac ?? '') == ''): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card-header mb-4">
							<h5 class="card-title">LIVE MESIN TABUNGAN</h5>
						 </div>
					  <div id="logs"></div>
				  </div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
					setInterval(function(){
					$("#logs").load('tabungan/log.php')
					}, 1000);  
					});
				</script>
			<?php elseif($ac == enkripsi('debet')): ?>
			<div class="row">
			  <div class="col-md-12">
				 <div class="card">
					 <div class="card-header">
					<h5 class="card-title">SIMPANAN TABUNGAN HARI INI</h5>
				   </div>
						<div class="card-body">									
						<div class="card-box table-responsive">
							<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
								<thead>
									<tr>
									<th>NO</th>                                               
									<th>TANGGAL</th>
									<th>NAMA SISWA</th>
									<th>DEBET</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 0;
									$zero = 0;
									$sql = "SELECT t.id_saldo, t.tanggal, t.debet, s.nama 
											FROM saldo t
											LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
											WHERE t.tanggal = :tanggal AND t.debet > :zero";

									$stmt = $pdo->prepare($sql);
									if (!$stmt) {
										die("Query prepare failed: " . $pdo->errorInfo());
									}
									$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
									$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
									$stmt->execute();
									while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
										$no++;
									?>
										<tr>
											<td><?= $no; ?></td>
											<td><?= htmlspecialchars($data['tanggal']) ?></td>
											<td><?= htmlspecialchars($data['nama']) ?></td>
											<td><?= number_format($data['debet'], 0, ',', '.') ?></td>
										</tr>
									<?php endwhile; ?>
									<?php
									$stmt->closeCursor();
									?>
								</tbody>
							</table>
						 </div>
					</div>
				</div>
			</div>
		</div>
<?php elseif($ac == enkripsi('simpanan')): ?>
<div class="row">
    <div class="col-xl-6">
<?php
	$ada = false;
	$zero = 0;
	$sql = "SELECT t.id_saldo, t.tanggal, t.debet, s.nama 
			FROM saldo t
			LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
			WHERE t.tanggal = :tanggal AND t.debet > :zero
			ORDER BY id_saldo DESC LIMIT 2
			";

	$stmt = $pdo->prepare($sql);
	if (!$stmt) {
		die("Query prepare failed: " . $pdo->errorInfo());
	}
	$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
	$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
	$stmt->execute();
	while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
	$ada = true;
	?>	
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					<?= $data['nama']; ?>
					<span class="widget-bank-card-number mt-auto">
						<?= $data['tanggal']; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
	<?php
	$stmt->closeCursor();
	?>
	<?php if($ada==false): ?>
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					Tidak ada aktifitas
					<span class="widget-bank-card-number mt-auto">
						<?= $tanggal; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	</div>
	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">SIMPAN SALDO</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id='formSaldo' >										
				 <label>Pilih Kelas</label>
					<div class="input-group mb-1">
						<select class="form-select" name="kelas" id="kelas" required style="width: 100%">
							<option value=''>Pilih Kelas</option>
								<?php
								$sql = "SELECT kelas FROM m_kelas";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								while ($kl = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value='{$kl['kelas']}'>{$kl['kelas']}</option>";
								}
								$stmt->closeCursor();
								?>
							</select>
						</div>
					<label>Nama Siswa</label>
						<div class="input-group mb-1">
							<select class="form-select" name="idsiswa" id="siswa" required style="width: 100%">
							</select>
						</div>
					<label>Jumlah Simpanan</label>
						<div class="input-group mb-1">
							<input type='text' name='saldo' id="duit" class='form-control' required >
						  </div>		
						<div class="widget-payment-request-actions m-t-lg d-flex">
							<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
						</div>
					</form>
				 </div>
			</div>
		</div>
	</div>
<script>
$('#formSaldo').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'tabungan/simpan.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>	
<?php elseif($ac == enkripsi('tarik')): ?>
<div class="row">
			  <div class="col-md-12">
				 <div class="card">
					 <div class="card-header">
					<h5 class="card-title">TARIK TUNAI TABUNGAN</h5>
				   </div>
						<div class="card-body">									
						<div class="card-box table-responsive">
							<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
								<thead>
									<tr>
									<th>NO</th>                                               
									<th>TANGGAL</th>
									<th>NAMA SISWA</th>
									<th>KREDIT</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 0;
									$zero = 0;
									$sql = "SELECT t.id_saldo, t.tanggal, t.kredit, s.nama 
											FROM saldo t
											LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
											WHERE t.tanggal = :tanggal AND t.kredit > :zero";

									try {
										$stmt = $pdo->prepare($sql);
										$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
										$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
										$stmt->execute();
										
										while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
											$no++;
									?>
											<tr>
												<td><?= $no; ?></td>
												<td><?= $data['tanggal']; ?></td>
												<td><?= $data['nama']; ?></td>
												<td><?= number_format($data['kredit'], 0, ',', '.'); ?></td>
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
		</div>
<?php elseif($ac == enkripsi('ambil')): ?>
<div class="row">
 <div class="col-xl-6">
<?php
	$ada = false;
	$zero = 0;
	$sql = "SELECT t.id_saldo, t.tanggal, t.kredit, s.nama 
			FROM saldo t
			LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
			WHERE t.tanggal = :tanggal AND t.kredit > :zero
			ORDER BY id_saldo DESC LIMIT 2
			";

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
		$stmt->bindParam(':zero', $zero, PDO::PARAM_INT);
		$stmt->execute();
		
		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ada = true;
	?>
    <div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?>
					</span>
					<?= $data['nama']; ?>
					<span class="widget-bank-card-number mt-auto">
						<?= $data['tanggal']; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	?>
	<?php if($ada==false): ?>
	<div class="col-xl-12">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['debet'], 0, ',', '.'); ?>
					</span>
					Tidak ada aktifitas
					<span class="widget-bank-card-number mt-auto">
						<?= $tanggal; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	</div>
	<div class="col-xl-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
			<div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="h5 mb-0">TARIK SALDO</div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
				</div>
			<form id='formAmbil' >										
				 <label>Pilih Kelas</label>
					<div class="input-group mb-1">
						<select class="form-select" name="kelas" id="kelas" required style="width: 100%">
							<option value=''>Pilih Kelas</option>
								<?php
								$sql = "SELECT kelas FROM m_kelas";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								while ($kl = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value='{$kl['kelas']}'>{$kl['kelas']}</option>";
								}
								$stmt->closeCursor();
								?>
							</select>
						</div>
					<label>Nama Siswa</label>
						<div class="input-group mb-1">
							<select class="form-select" name="idsiswa" id="siswa" required style="width: 100%">
							</select>
						</div>
					<label>Saldo Saat ini</label>
						<div class="input-group mb-1">
                            <select class="form-select" name="saldo" id="saldo" required style="width: 100%">
                            </select>
					   </div>
					<label>Jumlah Penarikan</label>
						<div class="input-group mb-1">
							<input type='text' name='besar' id="duit" class='form-control' required >
						  </div>		
						<div class="widget-payment-request-actions m-t-lg d-flex">
							<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
						</div>
					</form>
				 </div>
			</div>
		</div>
	</div>
<script>
$('#formAmbil').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'tabungan/tarik_saldo.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');},
	success: function(data){   		
	setTimeout(function(){
	window.location.reload();}, 200);			  
				}
			});
		return false;
	});
</script>	
<?php elseif($ac == enkripsi('reset')): ?>
	<div class="row">
	<div class="col-xl-12">
		<div class="card widget widget-list">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="card-title mb-0">RESET DATA SIMPANAN</h5>
				<button id="confirm" class="btn btn-danger">RESET</button>
			</div>
	<div class="card-body">
			<ul class="widget-list-content list-unstyled">
				<li class="widget-list-item widget-list-item-red">
					<span class="widget-list-item-icon"><i class="material-icons-outlined">storage</i></span>
					<span class="widget-list-item-description">
						<a href="#" class="widget-list-item-description-title">
						  RESET DATA SIMPANAN
						</a>
						<span class="widget-list-item-description-subtitle">
						 Table simpanan dikosongkan kembali ke awal
						</span>
					</span>
				</li>
			</ul>
			</div>
		</div>
	</div>
</div>
<script>
$("#confirm").click(function(){
Swal.fire({
  title: 'RESET DATABASE',
  text: "Database akan dikosongkan !",
  icon: 'warning',
  width:'320px',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Reset!'
}).then((result) => {
  if (result.value) {
	$.ajax({
	url: 'tabungan/reset.php',
	 beforeSend: function() {
	 $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
	},	
	success: function(data) {
   setTimeout(function() {
	window.location.reload();
	}, 1000);
		}
	});
	}
	return false;
		})

		});
</script>	
<?php endif; ?>
	</div>
</div>
<script>
$("#kelas").change(function() {
	var kelas = $(this).val();						
	console.log(kelas);
	$.ajax({
		type: "POST",
		url: "tabungan/ambildata.php?pg=siswa", 
		data: "kelas=" + kelas, 
		success: function(response) { 
		$("#siswa").html(response);
		console.log(response);
		}
	});
});
$("#siswa").change(function() {
	var siswa = $(this).val();						
	console.log(kelas);
	$.ajax({
		type: "POST",
		url: "tabungan/ambildata.php?pg=saldo", 
		data: "siswa=" + siswa, 
		success: function(response) { 
		$("#saldo").html(response);
		console.log(response);
		}
	});
});
</script>
<script>
var duit = document.getElementById('duit');
	duit.addEventListener('keyup', function(e)
	{
		duit.value = formatRupiah(this.value);
	});
	  function formatRupiah(angka, prefix)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split    = number_string.split(','),
			sisa     = split[0].length % 3,
			rupiah     = split[0].substr(0, sisa),
			ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
</script>