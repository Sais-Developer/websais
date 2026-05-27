<?php
defined('APK') or exit('No Access');
$bulanmu = $_GET['b'] ?? '';
$tgl = $_GET['t'] ?? '';
$bln = fetch ('bulan', ['bln' =>$bulanmu]);
 ?>   
	<div class="row">
	    <div class="col-md-8">
		  <div class="card">
			  <div class="card-header">
				<h5 class="card-title">PEMBAYARAN PEGAWAI </h5>							
				</div>
			  <div class="card-body">
					<div class="card-box table-responsive">
						<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
							<thead>
							<tr>
							<th width="5%">NO</th> 
							<th>NAMA PEGAWAI</th>
							 <th>JABATAN</th>
							<th>TOTAL RP</th>
							<th></th>
						  </tr>
					   </thead>
					<tbody>
					 <?php
						$no = 0;
						$total_semua = 0;
						$sql = "
							SELECT 
								g.id_guru,
								g.nama,
								g.jabatan,
								COALESCE(pl.total_lain, 0) AS total_lain,
								COALESCE(aj.total_jjm, 0) AS total_jjm
							FROM guru g
							LEFT JOIN (
								SELECT idpeg, SUM(besar) AS total_lain
								FROM pay_lain
								GROUP BY idpeg
							) AS pl ON pl.idpeg = g.id_guru
							LEFT JOIN (
								SELECT idpeg, SUM(jjm) AS total_jjm
								FROM absen_jjm
								WHERE bulan = :bulan AND tahun = :tahun
								GROUP BY idpeg
							) AS aj ON aj.idpeg = g.id_guru
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([':bulan' => $bulanmu, ':tahun' => $tahun]);

						while ($peg = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$no++;
							$total = ($peg['total_jjm'] * $setting['honor']) + $peg['total_lain'];
							$total_semua += $total;

							if ($bulanmu != '') {
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= htmlspecialchars($peg['nama']); ?></td>
									<td><?= htmlspecialchars($peg['jabatan']); ?></td>
									<td><?= number_format($total, 0, ',', '.'); ?></td>
									<td>
									<?php if ($tgl != ''): ?>
										<a href="cetak/cetakabsen.php?idpeg=<?= $peg['id_guru'] ?>&b=<?= $bulanmu; ?>" target="_blank" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Absen"><i class="material-icons">print</i></a>
										<a href="cetak/cetakrinci.php?idpeg=<?= $peg['id_guru'] ?>&b=<?= $bulanmu; ?>&t=<?= $tgl ?>" target="_blank" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Rincian"><i class="material-icons">print</i></a>
									<?php endif; ?>
									</td>
								</tr>
								<?php
							}
						}
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
					<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
			</div>
			<form id="formbayar" action='cetak/cetakgaji.php' target="_blank" method='GET'  enctype='multipart/form-data'>	  
			   <div class="col-md-12 mb-2">
				<label class="form-label bold">BULAN</label>
					<select name="bulan"  id="bulan" class="form-select bulan" style="width: 100%;" required >
						<option value="<?= $bulanmu ?>"><?= $bln['ket'] ?></option>
						<option value=''>Pilih Bulan</option>
						<?php
						$stmt = $pdo->query("SELECT * FROM bulan"); 
						while ($mt = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
							<option value="<?= htmlspecialchars($mt['bln']) ?>"><?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?></option>
						<?php endwhile; ?>
					</select>   
				</div>				
			<div class="col-md-12 mb-4">
				<label class="form-label bold">TANGGAL BAYAR</label>
				<input type="text" name="tanggal" value="<?= $tgl ?>" class="form-control datepicker" autocomplete="off" >
			</div>
   
			<?php if($tgl<>''): ?>
			<div class="text-end">
				<button type="submit" class="btn btn-primary kanan">CETAK</button>
				</div>
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>
				
<script type="text/javascript">
 $('.datepicker').change(function() {
var t = $('.datepicker').val();
var b = $('#bulan').val();
location.replace("?pg=<?= enkripsi('trxpeg') ?>&t=" + t + "&b=" + b);
  }); 
</script>