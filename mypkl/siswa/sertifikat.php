<?php
defined('APK') or exit('No accsess');
	$kelas = $_GET['k'] ?? '';
	$d = $_GET['d'] ?? '';
$dudi = fetch('pkl_dudi',['id'=>$d]);

?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
				<h5 class="card-title">CETAK SERTIFIKAT</h5>
					</div>
				<div class="card-body">
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
					<thead>
					 <tr>
					  <th>NO</th>									  
					  <th>NAMA SISWA</th>       
					  <th>LOKASI</th>
					<th></th>										  
					  </tr>
					  </thead>
					  <tbody>
						<?php
						$no = 0;
						$sql = "
							SELECT pkl_siswa.idsiswa, s.nama AS nama_siswa
							FROM pkl_siswa
							LEFT JOIN siswa s ON s.id_siswa = pkl_siswa.idsiswa
							WHERE pkl_siswa.kelas = ? AND pkl_siswa.dudi = ?
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([$kelas, $d]);
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
							?>
							<tr style="vertical-align:middle;">
								<td class="text-center"><?= $no; ?></td>                                           
								<td><?= htmlspecialchars($dudi['nama_dudi']) ?></td>
								<td><?= htmlspecialchars($data['nama_siswa']) ?></td>
								<td>
									<a href="cetak/cetak5.php?ids=<?= $data['idsiswa'] ?>&d=<?= $d ?>" target="_blank" class="btn btn-sm btn-primary">
										<i class="material-icons">print</i>
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
<?php if ($ac == '') : ?>
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
			<label class="bold">KELAS</label>
				<div class="input-group mb-1">
					<select class="form-select" name="kelas" id="kelas" required style="width: 100%">
						<option value="<?= $kelas ?>"><?= $kelas ?></option>
						<?php
							$stmt = $pdo->prepare("SELECT kelas FROM pkl_siswa GROUP BY kelas");
							$stmt->execute();
							while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . htmlspecialchars($kelas['kelas']) . "'>" . htmlspecialchars($kelas['kelas']) . "</option>";
							}
							?>
						</select>
					</div>	
		  <label class="bold">LOKASI</label>
			 <div class="input-group mb-1">
				   <select class="form-select" name="dudi" id="dudi" required style="width: 100%">
						<option value="<?= $d ?>"><?= $dudi['nama_dudi'] ?></option>
							</select>
						 </div>	
			<div class="widget-payment-request-actions m-t-lg d-flex">
				     <button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">PILIH</button>
				  </div>
				</div>
			</div>
		</div>
	</div>
<script>	
$("#kelas").change(function() {
var kelas = $(this).val();
console.log(kelas);
$.ajax({
type: "POST",
url: "siswa/ambildata.php?pg=dudi", 
data: "kelas=" + kelas, 
success: function(response) { 
$("#dudi").html(response);
		}
	});
});

</script>
						
<script type="text/javascript">
	$('#pilih').click(function() {
		var k = $('#kelas').val();
		var d = $('#dudi').val(); 
		location.replace("?pg=<?= enkripsi('sertifikat') ?>&k=" + k + "&d=" + d);
	}); 
</script>
<?php endif ?>
	
     