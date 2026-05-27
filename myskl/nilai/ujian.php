<?php
defined('APK') or exit('No Access');
$id_skl = 1;
$sql = "SELECT * FROM skl WHERE id_skl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null;

$kelas = $_GET['k'] ?? '';
$mapel = $_GET['m'] ?? '';
$jurusan = $_GET['j'] ?? '';

$sql = "SELECT * FROM mapel WHERE id = ?";
$stmt2 = $pdo->prepare($sql);
$stmt2->execute([$mapel]);
$pel = $stmt2->fetch(PDO::FETCH_ASSOC);
    ?>
<div class="row">
	<div class="col-xl-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-titl">DATA NILAI UJIAN SEKOLAH <?php if($kelas<>''): ?> | <?= $pel['kode'] ?> | <?= $kelas ?><?php endif; ?></h5>						
			</div>
		<div class="card-body">				 
			<div class="card-box table-responsive">
				 <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px;">
					<thead>
					<tr>
					   <th width="5%" rowspan="2">NO</th>
						 <th rowspan="2">NAMA</th>
						 <th rowspan="2">KELAS</th>
						<th colspan="2" class="text-center">UJIAN</th>
						 </tr>
						 <tr>
						<th>PRAKTEK</th>
						<th>TEORI</th>									
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 0;
						$stmtSiswa = $pdo->prepare("SELECT id_siswa, nama, kelas FROM siswa WHERE kelas = ?");
						$stmtSiswa->execute([$kelas]);
						$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

						$stmtNilai = $pdo->prepare("
							SELECT nilai 
							FROM nilai_skl 
							WHERE idsiswa = ? AND mapel = ? AND ket = 'US'
						");

						foreach ($siswaList as $siswa) {
							$no++;
							$stmtNilai->execute([$siswa['id_siswa'], $mapel]);
							$nilaiList = $stmtNilai->fetchAll(PDO::FETCH_ASSOC);
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($siswa['nama']); ?></td>
								<td><?= htmlspecialchars($siswa['kelas']); ?></td>

								<?php if (!empty($nilaiList)): ?>
								<?php foreach ($nilaiList as $data): ?>
									<td><?= htmlspecialchars($data['nilai']); ?></td>
								<?php endforeach; ?>
								<?php else: ?>
								<td></td>
								<td></td>
								<?php endif; ?>
							</tr>
						<?php
						}
						?>
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
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			<div class="text-muted mb-4">HIGH SCHOOL</div>
				<div class="alert alert-secondary" role="alert">Pastikan Mapel sudah di isi di Menu E Rapor !!!</div>
                    </div>
						<?php if($kelas<>''): ?>
						<form id="formupload"  class="row g-2">
							<div class="d-flex mb-2 align-items-center">
							<label>FILE XLSX</label>
							<div class="ms-auto d-flex gap-2">
						<a href="nilai/proses2.php?m=<?= $mapel ?>&k=<?= $kelas ?>&j=<?= $jurusan ?>" class="btn btn-sm btn-icon btn-link kanan"><i class="material-icons">download</i>FORMAT</a>
						</div>
						</div>
                        <input type="hidden" name="kuri" value="<?= $kuri ?>" >	
                        <div class="col-md-12 mb-4">
                            <input type='file' name='file' class='form-control' required accept=".xlsx">
						</div>							
						<div class="d-grid gap-2 mb-4">
							<button type="submit" class="btn btn-primary kanan">IMPORT</button>
							</div>
							</form>
						<?php endif; ?>
						<?php if($kelas==''): ?>
						<div class="col-md-12 mb-2">
						<label>KELAS</label>
						<select class="kelas form-select" name="kelas" id="kelas" required style="width: 100%">
							<option value='' selected>Pilih Kelas</option>
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
				<div class="col-md-12 mb-2">
						<label>JURUSAN</label>
				<select class="pk form-select" name="pk" id="pk" required style="width: 100%">
					</select>
				</div>
				<div class="col-md-12 mb-4">
				<label>MATA PELAJARAN</label>
					<select class="mapel form-select" name="mapel" id="mapel" required style="width: 100%">
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
<script>
$("#kelas").change(function() {
	var kelas = $(this).val();						
	console.log(kelas);
	$.ajax({
		type: "POST",
		url: "nilai/ambildata.php?pg=pk", 
		data: "kelas=" + kelas, 
		success: function(response) { 
		$("#pk").html(response);
		console.log(response);
		}
	});
});
</script>
<script>
$("#pk").change(function() {
	var pk = $(this).val();	
	var kelas = $('#kelas').val();	
	console.log(pk + kelas);
	$.ajax({
		type: "POST",
		url: "nilai/ambildata.php?pg=mapel", 
		data: "kelas=" + kelas + "&pk=" + pk, 
		success: function(response) { 
		$("#mapel").html(response);
		console.log(response);
		}
	});
});
</script>
<script type="text/javascript">
	$('#cari').click(function() {
		var k = $('.kelas').val();
		var m = $('.mapel').val();
		 var j = $('.pk').val();
		location.replace("?pg=<?= enkripsi('ujian') ?>&k=" + k + "&m=" + m + "&j=" + j);
	}); 
</script>
<script>
$('#formupload').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'nilai/import_nilai2.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="<?= $baseurl ?>/images/animasi.gif" style="width:50px;"></div>');
	$('.progress-bar').animate({
	width: "30%"
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
<?php endif; ?>