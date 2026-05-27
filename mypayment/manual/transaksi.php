<?php
defined('APK') or exit('No Access');
?>           
<?php if ($ac == '') : ?>
<div class="row">
   <div class="col-md-8">
		<div class="card">
			<div class="card card-header">
				<h5 class="card-title">PEMBAYARAN</h5>
				</div>
			<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="9%">NO</th>  												
							<th>KODE</th>
							<th>TOTAL RP</th>
							<th>MODEL</th>													 
							<th>JML X</th>
							<th>JML BAYAR RP</th>											
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$stmt = $pdo->prepare("SELECT * FROM m_bayar");
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
								$model = ($data['model'] == '1') ? 'Sekali Bayar' : 'Bulanan';
								$no++;
							?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars($data['kode']); ?></td>
									<td><?= 'Rp ' . number_format($data['total'], 0, ',', '.'); ?></td>
									<td><?= $model ?></td>
									<td><h5><span class="badge badge-primary"><?= $data['jumlah'] ?> X</span></h5></td>
									<td><?= 'Rp ' . number_format($data['angsuran'], 0, ',', '.'); ?></td>
								</tr>
							<?php endwhile; ?>
					   <tbody>
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
			 <label class="bold">Kode</label>
			  <div class="input-group mb-1">
			  <select  name="idb" id="idb" class='form-select' style='width:100%' required>
				<option value="">Pilih Pembayaran</option> 									   
				  <?php
					$stmt = $pdo->prepare("SELECT * FROM m_bayar");
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						echo '<option value="'.$data['id'].'">'.$data['nama'].'</option>';
					}
					?>
				</select>
					</div>
					<label class="bold">Model Pembayaran</label>
				  <div class="input-group mb-1">
				   <select name="model" id="model" class="form-select" style="width:100%" required>
				 
				  </select>
					</div>										
					 <label class="bold">Kelas</label>
				  <div class="input-group mb-1">
				   <select  id="kelas" class='form-select' style='width:100%' required>
					<option value="">Pilih Kelas</option> 									   
					  <?php
						$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
						$stmt->execute();
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo '<option value="' . htmlspecialchars($data['kelas']) . '">' . htmlspecialchars($data['kelas']) . '</option>';
						}
						?>
					  </select>
					</div>										
					<div class="widget-payment-request-actions m-t-lg d-flex">
					   <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Pembayaran</button>
				   </div>
				 </div>
			  </div>
			</div>
		</div>
	<script>
	$("#idb").change(function() {
		var idb = $(this).val();					
		console.log(idb);
		$.ajax({
			type: "POST",
			url: "manual/trx.php?pg=model", 
			data: "idb=" + idb, 
			success: function(response) { 
				$("#model").html(response);
				console.log(response);
			},
			error: function(xhr, status, error) {
				console.log(error);
			}
		});
	});
	</script>
	<script type="text/javascript">
	$('#pilih').click(function() {
	var b = $('#idb').val();	
	var k = $('#kelas').val();
	
		location.replace("?pg=<?= enkripsi('transaksi') ?>&ac=<?= enkripsi('input') ?>&b=" + b + "&k=" + k);
	}); 
	</script>				
<?php elseif ($ac == enkripsi('input')): ?>
<?php
$kelas = $_GET['k'] ?? '';
$idb   = $_GET['b'] ?? '';
$ids   = $_GET['s'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :idb");
$stmt->execute([':idb' => $idb]);
$byr = $stmt->fetch(PDO::FETCH_ASSOC);
$jumlah = $byr['jumlah'] ?? 0;

$stmt2 = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :ids");
$stmt2->execute([':ids' => $ids]);
$siswa = $stmt2->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">INPUT PEMBAYARAN KELAS <?= $kelas; ?></h5>
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
						 <tr>
						   <th width="5%">NO</th>  												
						   <th>NIS</th>
						   <th>NAMA SISWA</th>												 
						   <th>ANGSURAN</th>
						   <th width="10%"></th>
						  </tr>
						</thead>
					   <tbody>
						<?php
								$no = 0;
								$bulan = date('m');
								$tahun = date('Y');

								$sql = "
									SELECT * FROM siswa s
									WHERE NOT EXISTS (
										SELECT 1
										FROM trx_bayar t
										WHERE s.id_siswa = t.idsiswa
										  AND t.bulan = :bulan
										  AND t.tahun = :tahun
									)
									AND kelas = :kelas
								";

								$stmt = $pdo->prepare($sql);
								$stmt->execute([
									':bulan' => $bulan,
									':tahun' => $tahun,
									':kelas' => $kelas
								]);

								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
									$no++;
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars($data['nis']); ?></td>
									<td><?= htmlspecialchars($data['nama']); ?></td>
									<td><?= htmlspecialchars($data['kelas']); ?></td>
									<td>
										<a href="?pg=<?= enkripsi('transaksi') ?>&ac=<?= enkripsi('input') ?>&s=<?= $data['id_siswa'] ?>&b=<?= $idb ?>&k=<?= $kelas ?>"> 
											<button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Input Pembayaran">
												<i class="material-icons">add</i>
											</button>
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
	<div class="col-md-4">                    
		<div class="card widget widget-payment-request">
			<div class="card-header">
				<h5 class="card-title">INPUT PAYMENT</h5>										
			</div>
			<div class="card-body">
				<div class="widget-payment-request-container">
					<div class="widget-payment-request-author">
						<div class="avatar m-r-sm">
							<img src="../images/laporan.png" alt="">
						</div>
						<div class="widget-payment-request-author-info">
							<span class="widget-payment-request-author-name">E-PAYMENT</span>
							<span class="widget-payment-request-author-about"><?= $setting['sekolah'] ?></span>
						</div>
					</div>
			<div class="widget-payment-request-info m-t-md">
			<form id='formbayar'>
			 <input type="hidden" name="kelas" value="<?= $kelas ?>" >									
			 <label class="bold">Pembayaran</label>
			  <div class="input-group mb-1">
			  <select  name="idb" id="idb" class='form-select' style='width:100%' required>
				<option value="<?= $idb ?>"><?= $byr['nama'] ?></option>
				  </select>
				</div>
				<label class="bold">Jumlah dibayar RP</label>
			  <div class="input-group mb-1">
			   <input type="text" name="besar" id="duit" class="form-control" value="<?= number_format($byr['angsuran'],0,",",".") ?>" required>
				</div>									
				 <label class="bold">Nama Siswa</label>
			  <div class="input-group mb-1">
			   <select  name="idsiswa" class='form-select' style='width:100%' required>
					<option value="<?= $ids ?>"><?= $siswa['nama'] ?></option>
				  </select>
				</div>										
				<div class="widget-payment-request-actions m-t-lg d-flex">
				 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
				</form>
			 </div>
		</div>
		</div>
	</div>
</div>
<script>
	$('#formbayar').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
			 url: 'manual/trx.php?pg=bayar',
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
<?php endif ?>
<script>
	$("#idb").change(function() {
		var idb = $(this).val();					
		console.log(idb);
		$.ajax({
			type: "POST",
			url: "manual/trx.php?pg=model", 
			data: "idb=" + idb, 
			success: function(response) { 
				$("#model").html(response);
				console.log(response);
			},
			error: function(xhr, status, error) {
				console.log(error);
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
		