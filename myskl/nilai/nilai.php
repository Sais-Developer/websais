<?php
defined('APK') or exit('No Access');
$id_skl = 1;

$sql = "SELECT * FROM skl WHERE id_skl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null;

$kelas   = $_GET['k'] ?? '';
$mapel   = $_GET['m'] ?? '';
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
		<h5 class="card-title">DATA NILAI SEMESTER 1 - 6 <?php if($kelas<>''): ?> | <?= $pel['kode'] ?> | <?= $kelas ?><?php endif; ?></h5>						
			</div>
		<div class="card-body">
		<?php if($kuri==1): ?>
		 <div class="card-box table-responsive">
			  <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
					<thead>
					<tr>
					 <th width="10%">NO</th>
					<th>NAMA SISWA</th>
					<th>KELAS</th>								
					<th>NR P</th>
					<th>NR K</th>
					</tr>
				   </thead>
				  <tbody> 
				<?php
					$sql = "
						SELECT 
							s.id_siswa, 
							s.nama,
							s.kelas,
							AVG(CASE WHEN n.ki = 'KI3' THEN n.nilai END) AS NRP,
							AVG(CASE WHEN n.ki = 'KI4' THEN n.nilai END) AS NRK
						FROM siswa s
						LEFT JOIN nilai_skl n 
							ON n.idsiswa = s.id_siswa 
							AND n.mapel = :mapel
							AND n.kelas = :kelas
						WHERE s.kelas = :kelas2
						GROUP BY s.id_siswa, s.nama, s.kelas
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						':kelas' => $kelas,
						':mapel' => $mapel,
						':kelas2'=> $kelas
					]);

					$no = 0;
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
					?>
					<tr>
					<td><?= $no; ?></td>
					<td><?= $data['nama'] ?></td>                                                 
					<td><?= $data['kelas'] ?></td>
					 <td><?= $data['NRP'] !== null ? number_format($data['NRP'], 2) : '-' ?></td>
					<td><?= $data['NRK'] !== null ? number_format($data['NRK'], 2) : '-' ?></td>
					 </tr>
					<?php endwhile;?> 
					</tbody>
				</table>
				</div>
			<?php endif; ?>
			<?php if($kuri==2): ?>
		 <div class="card-box table-responsive">
			  <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
					<thead>
					<tr>
					 <th width="10%">NO</th>
					<th>NAMA SISWA</th>
					<th>KELAS</th>								
					<th>NR</th>
					</tr>
				   </thead>
				  <tbody> 
				<?php
				$stmt = $pdo->prepare("
					SELECT 
						s.id_siswa, 
						s.nama,
						s.kelas,
						AVG(n.nilai) AS NR
					FROM siswa s
					LEFT JOIN nilai_skl n 
						ON n.idsiswa = s.id_siswa 
					   AND s.kelas = ?
					   AND n.mapel = ?
					WHERE n.kelas = ?
					  AND n.ki IS NULL
					GROUP BY s.id_siswa, s.nama, s.kelas
				");

				$stmt->execute([$kelas, $mapel, $kelas]);

				$no = 0;
				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
					$no++;
				?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $data['nama'] ?></td>
					<td><?= $data['kelas'] ?></td>
					<td><?= $data['NR'] !== null ? number_format($data['NR'], 2) : '-' ?></td>
				</tr>
				<?php endwhile; ?>
					</tbody>
				</table>
				</div>
			<?php endif; ?>
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
		<div class="alert alert-secondary" role="alert">Pastikan Mapel sudah di isi di Menu E Rapor !!!</div>
                    </div>
			<?php if($kelas !=''): ?>
			<form id="formupload"  class="row g-1">
			<div class="d-flex mb-2 align-items-center">
				
				<div class="ms-auto d-flex gap-2">
					<?php if($kuri=='2'): ?>
						<a href="nilai/proses.php?m=<?= $mapel ?>&k=<?= $kelas ?>&j=<?= $jurusan ?>" 
						   class="btn btn-sm  btn-link">
							<i class="material-icons">download</i> FORMAT
						</a>
					<?php else: ?>
						<a href="nilai/proses3.php?m=<?= $mapel ?>&k=<?= $kelas ?>&j=<?= $jurusan ?>" 
						   class="btn btn-sm  btn-link">
							<i class="material-icons">download</i> PENGETAHUAN
						</a>
						<a href="nilai/proses4.php?m=<?= $mapel ?>&k=<?= $kelas ?>&j=<?= $jurusan ?>" 
						   class="btn btn-sm  btn-link">
							<i class="material-icons">download</i> KETERAMPILAN
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-lg mb-4">
				<input type="file" name="file" class="form-control" required accept=".xlsx">
			</div>							
			<div class="d-grid gap-2 mb-4">
				<button type="submit" class="btn btn-primary">IMPORT</button>
			</div>
			</form>
			
			 <?php endif; ?>
			<?php if($kelas==''): ?>
		<div class="col-md-12">
				<label class="form-label bold">KELAS</label>
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
		<div class="col-md-12">
				<label class="form-label bold">JURUSAN</label>
		<select class="pk form-select" name="pk" id="pk" required style="width: 100%">							  
			</select>
		</div>
		<div class="col-md-12 mb-4">
		<label class="form-label bold">MATA PELAJARAN</label>
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
	location.replace("?pg=<?= enkripsi('nilai') ?>&k=" + k + "&m=" + m + "&j=" + j);
}); 
</script>
<script>
    $('#formupload').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
			<?php if($kuri=='2'): ?>
             url: 'nilai/import_nilai.php',
			 <?php else: ?>
			 url: 'nilai/import_nilai3.php',
			 <?php endif; ?>
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
		
			
	
		
		
			
			