<?php
defined('APK') or exit('No Access');
$kelas = $_GET['k'] ?? '';
?>           
			   
<div class="row">
	  <div class="col-md-8">
		 <div class="card">
			 <div class="card-header d-flex align-items-center">
					<h5 class="card-title mb-0">
						KEBIASAAN HARIAN BULAN <?= strtoupper(bulan_indo($tanggal)) ?>
					</h5>
					<?php if($kelas != ''): ?>
						<a href="cekebiasaan.php?k=<?= $kelas ?>" target="_blank"
						   class="btn btn-primary ms-auto">
						   <i class="material-icons">print</i> Cetak
						</a>
					<?php endif; ?>
				</div>
		<div class="card-body">									
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:11px">
				<thead>
					<tr>
						<th>No</th>                                               
						<th>Nama Siswa</th>
						<th>Subuh</th>
						<th>Dzuhur</th>
						<th>Ashar</th>
						<th>Maghrib</th>
						<th>Isya</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$bulan = date('m');
					$tahun = date('Y');
					$sql = "
						SELECT 
							s.kelas, 
							s.id_siswa, 
							s.nama, 
							SUM(ks.subuh) AS subuh,
							SUM(ks.dzuhur) AS dzuhur,
							SUM(ks.ashar) AS ashar,
							SUM(ks.maghrib) AS maghrib,
							SUM(ks.isya) AS isya
						FROM siswa s
						LEFT JOIN kebiasaan_harian ks 
							ON s.id_siswa = ks.id_siswa 
							AND MONTH(ks.tanggal) = :bulan 
							AND YEAR(ks.tanggal) = :tahun
							AND ks.kelas = :kelas1
						WHERE s.kelas = :kelas2
						GROUP BY s.id_siswa
						ORDER BY s.kelas, s.nama
					";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						':bulan'  => $bulan,
						':tahun'  => $tahun,
						':kelas1' => $kelas,
						':kelas2' => $kelas
					]);
						$no = 0;
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
							$no++;
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']) ?></td>
							<td><?= $data['subuh'] ?: 0 ?> X</td>
							<td><?= $data['dzuhur'] ?: 0 ?> X</td>
							<td><?= $data['ashar'] ?: 0 ?> X</td>
							<td><?= $data['maghrib'] ?: 0 ?> X</td>
							<td><?= $data['isya'] ?: 0 ?> X</td>
						</tr>
						<?php endwhile; ?>
					 </tbody>
				</table>
			 </div>
		</div>
	</div>
</div>
<?php if ($ac == '') : ?>
<div class="col-xl-4">
	<div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
		<div class="sw-13 position-relative mb-3">
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
			</div>
		<div class="h5 mb-0">KOKURIKULER</div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
			<div class="text-muted">HIGH SCHOOL</div>
				</div>
			<label class="bold">Kelas</label>
			  <div class="input-group mb-1">
				<select id="kelas" class='form-select' required='true' style="width: 100%">
				<option value="<?= $kelas ?>"><?= $kelas ?></option>
						<?php
						$stmt = $pdo->prepare("SELECT kelas FROM m_kelas ORDER BY kelas ASC");
						$stmt->execute();
						$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($kelasList as $row) {
							echo "<option value='" . htmlspecialchars($row['kelas']) . "'>" . 
								  htmlspecialchars($row['kelas']) . 
								 "</option>";
						}
						?>
					</select>
					</div>										
				<div class="widget-payment-request-actions m-t-lg d-flex">
					<button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih Kelas</button>
				</div>
			</div>
	   </div>
	</div>
</div>
<script type="text/javascript">
	$('#pilih').click(function() {
	var k = $('#kelas').val();
	location.replace("?pg=<?= enkripsi('cetakkeb') ?>&k=" + k);
	}); 
</script>
<?php endif ?>
					