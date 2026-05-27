 <?php 
defined('APK') or exit('No Access');
?>
<?php if ($ac == '') : ?>
<div class="row">
  <div class="col-md-8 mb-4">
     <div class="card">
        <div class="card-header">
		<h5 class="card-title">PRESENSI SISWA</h5>
		 </div>
	<div class="card-body">
     <div class="table-responsive">
        <table id="datatable1" class="table table-bordered">
            <thead>
             <tr>
               <th>NO</th>                                                   
               <th>ROMBEL</th>
               <th>L &nbsp;</th>
               <th>P &nbsp;</th>
		       <th>TOTAL &nbsp;</th>
			   <th>WALI KELAS</th>
             </tr>
            </thead>
            <tbody>
			<?php
					$no = 0;
					$sql = "
						SELECT 
							s.kelas,
							SUM(CASE WHEN s.jk = 'L' THEN 1 ELSE 0 END) AS laki,
							SUM(CASE WHEN s.jk = 'P' THEN 1 ELSE 0 END) AS prp,
							COUNT(s.id_siswa) AS total,
							u.nama AS walas_nama,
							u.id_guru AS walas_id
						FROM siswa s
						LEFT JOIN guru u ON u.walas = s.kelas
						GROUP BY s.kelas
						ORDER BY s.kelas ASC
					";

					$stmt = $db->prepare($sql);  
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['kelas']); ?></td>
						<td class="text-center"><?= $data['laki']; ?></td>
						<td class="text-center"><?= $data['prp']; ?></td>
						<td class="text-center"><?= $data['total']; ?></td>
						<td><?= htmlspecialchars($data['walas_nama'] ?? '-'); ?></td>
					</tr>
					<?php endwhile; ?>
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
        <div class="text-muted">HIGH SCHOOL</div>
       </div>              
    <form id="formabsen" method="GET" action="cetak/cetakkelas.php" target="_blank"  enctype="multipart/form-data">
       <div class="col-md-12 mb-2">
			<label class="bold">KELAS</label>
			<select name="kelas" class="form-select" style="width: 100%;" required>
				<option value=''>Pilih Kelas</option>
				<?php
				$stmt = $db->prepare("SELECT kelas FROM m_kelas ORDER BY kelas ASC");
				$stmt->execute();

				while ($Q = $stmt->fetch(PDO::FETCH_ASSOC)):
				?>
					<option value="<?= htmlspecialchars($Q['kelas']) ?>">
						<?= htmlspecialchars($Q['kelas']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		 </div>
		<div class="col-md-12 mb-4">
				<label class="bold">BULAN</label>
				<select name="bulan" class="form-select" style="width: 100%;" required>
					<option value="">Pilih Bulan</option>
					<?php
					$stmt = $db->prepare("SELECT bln, ket FROM bulan ORDER BY bln ASC");
					$stmt->execute();

					while ($mt = $stmt->fetch(PDO::FETCH_ASSOC)):
					?>
						<option value="<?= htmlspecialchars($mt['bln']) ?>">
							<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>
		<div class="d-grid gap-2 mb-4">                                             
             <button type="submit"  class="btn btn-primary flex-grow-1 m-l-xxs">CETAK REKAP</button>
            </div>
		</form>
      </div>
    </div>
  </div>
</div> 
<?php elseif ($ac == enkripsi('pegawai')) : ?>
 <?php 
$bulan = date('m');
$bln = $_GET['bln'] ?? '';
?>
<div class="row">
    <div class="col-md-8">
       <div class="card">
	   <div class="card-header">
		<h5 class="card-title">PRESENSI PEGAWAI</h5>
		 </div>
	<div class="card-body">
     <div class="table-responsive">	
        <table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
            <thead>
            <tr>
            <th width="5%">No</th>
            <th>NAMA LENGKAP</th>
            <th>JABATAN</th>
            <th>H &nbsp;</th>
            <th>I &nbsp;</th>
			<th>S &nbsp;</th>
			<th>A &nbsp;</th>
            <th>DETAIL</th>
           </tr>
           </thead>
           <tbody>
			<?php
					$no = 0;
					$stmt = $pdo->prepare("
						SELECT 
							g.id_guru,
							g.nama,
							g.jabatan,
							g.nip,
							SUM(CASE WHEN a.ket='H' THEN 1 ELSE 0 END) AS hadir,
							SUM(CASE WHEN a.ket='I' THEN 1 ELSE 0 END) AS izin,
							SUM(CASE WHEN a.ket='S' THEN 1 ELSE 0 END) AS sakit,
							SUM(CASE WHEN a.ket='A' THEN 1 ELSE 0 END) AS alpha
						FROM guru g
						LEFT JOIN absensi a 
							ON g.id_guru = a.idpeg 
							AND a.bulan = ? 
							AND a.tahun = ?
						GROUP BY g.id_guru
						ORDER BY g.nama ASC
					");

					$stmt->execute([$bln, $tahun]);

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
						$no++;
					?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['nama']); ?></td>
							<td><?= htmlspecialchars($data['jabatan']); ?></td>
							<td><?= $data['hadir']; ?></td>
							<td><?= $data['izin']; ?></td>
							<td><?= $data['sakit']; ?></td>
							<td><?= $data['alpha']; ?></td>
							<td>
								<?php if ($bln != ''): ?>
									<a href="cetak/detailabsenguru.php?idg=<?= $data['id_guru'] ?>&bln=<?= $bln ?>" 
									   target="_blank" class="btn btn-sm btn-danger">
									   <i class="material-icons">print</i>
									</a>
								<?php endif; ?>
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
  <div class="card">
    <div class="card-body">
	   <div class="d-flex align-items-center flex-column mb-4">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>   
		<div class="col-md-12 mb-3">
			<label class="bold">BULAN</label>                               
			<select class="form-select bln" id="bln" style="width: 100%;" required>
				<?php
				$stmt = $pdo->prepare("SELECT * FROM bulan");
				$stmt->execute();
				$bulan = $stmt->fetchAll(PDO::FETCH_ASSOC);
				?>
				<option>Pilih Bulan</option>
				<?php foreach ($bulan as $mt): ?>
					<option 
						value="<?= htmlspecialchars($mt['bln']) ?>"
						<?= ($bln == $mt['bln']) ? 'selected' : '' ?>
					>
						<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
					</option>
				<?php endforeach; ?>
			</select>                 
           </div>
			<script type="text/javascript">
				$('#bln').change(function() {
				var bln = $('.bln').val();
				location.replace("?pg=<?= enkripsi('cetakpresensi') ?>&ac=<?= enkripsi('pegawai') ?>&bln=" + bln);
					}); 
				</script>
				<?php if($bln!=''): ?>
            <div class="d-grid gap-2 mb-4">
		     <a href="cetak/cetakpeg.php?bln=<?= $bln ?>" target="_blank" 
			 class="btn btn-primary flex-grow-1 m-l-xxs"><i class="ri-printer-fill"></i> CETAK REKAP</a>
			</div>
		      <?php endif; ?>
        <div class="mb-4">
					<p class="text-small text-muted mb-4">ALAMAT</p>
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
					<p class="text-small text-muted mb-4">CONTACT</p>
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
					<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
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
<?php elseif ($ac == enkripsi('eskul')) : ?>		
<div class="row">
  <div class="col-md-8">
     <div class="card">
        <div class="card-header">
		<h5 class="card-title">PRESENSI ESKUL SISWA</h5>
		 </div>
	<div class="card-body">
     <div class="table-responsive">
        <table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
            <thead>
             <tr>
               <th>NO</th>                                                   
               <th>ROMBEL</th>
               <th>L &nbsp;</th>
               <th>P &nbsp;</th>
		       <th>TOTAL &nbsp;</th>
			   <th>WALI KELAS</th>
             </tr>
            </thead>
            <tbody>
			<?php
					$no = 0;
					$sql = "
						SELECT 
							s.kelas,
							SUM(CASE WHEN s.jk = 'L' THEN 1 ELSE 0 END) AS laki,
							SUM(CASE WHEN s.jk = 'P' THEN 1 ELSE 0 END) AS prp,
							COUNT(s.id_siswa) AS total,
							u.nama AS walas_nama,
							u.id_guru AS walas_id
						FROM siswa s
						LEFT JOIN guru u ON u.walas = s.kelas
						GROUP BY s.kelas
						ORDER BY s.kelas ASC
					";

					$stmt = $db->prepare($sql);  
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['kelas']); ?></td>
						<td class="text-center"><?= $data['laki']; ?></td>
						<td class="text-center"><?= $data['prp']; ?></td>
						<td class="text-center"><?= $data['total']; ?></td>
						<td><?= htmlspecialchars($data['walas_nama'] ?? '-'); ?></td>
					</tr>
					<?php endwhile; ?>
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
        <div class="text-muted">HIGH SCHOOL</div>
       </div>                    
    <form id="formabsen" method="GET" action="cetak/cetakkelas2.php" target="_blank"  enctype="multipart/form-data">
        <div class="col-md-12 mb-2">
			<label class="bold">EKSTRAKURIKULER</label>                               
			<select name="eskul" class="form-select" style="width: 100%;" required>
				<option value="">Pilih Eskul</option>
				<?php
				$stmt = $pdo->prepare("SELECT eskul FROM m_eskul ORDER BY eskul ASC");
				$stmt->execute();
				$eskulRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($eskulRows as $eskul):
				?>
					<option value="<?= htmlspecialchars($eskul['eskul']) ?>">
						<?= htmlspecialchars($eskul['eskul']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-12 mb-2">
			<label class="bold">KELAS</label>                               
			<select name="kelas" class="form-select" style="width: 100%;" required>
				<option value="">Pilih Kelas</option>
				<?php
				$stmt = $pdo->prepare("SELECT kelas FROM m_kelas ORDER BY kelas ASC");
				$stmt->execute();
				$kelasRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($kelasRows as $Q):
				?>
					<option value="<?= htmlspecialchars($Q['kelas']) ?>">
						<?= htmlspecialchars($Q['kelas']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-12 mb-4">
			<label class="bold">BULAN</label>
			<select name="bulan" class="form-select" style="width: 100%;" required>
				<option value="">Pilih Bulan</option>
				<?php
				$stmt = $pdo->prepare("SELECT bln, ket FROM bulan ORDER BY bln ASC");
				$stmt->execute();
				$bulanRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($bulanRows as $mt):
				?>
					<option 
						value="<?= htmlspecialchars($mt['bln']) ?>"
						<?= ($bln == $mt['bln']) ? 'selected' : '' ?>
					>
						<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="d-grid gap-2 mb-4">                                             
             <button type="submit"  class="btn btn-primary flex-grow-1 m-l-xxs">CETAK REKAP</button>
            </div>
		</form>
      </div>
    </div>
  </div>
 </div>
 <?php elseif ($ac == enkripsi('pembina')) : ?>
 <?php 
$bulan = date('m');
$bln = $_GET['bln'] ?? '';
?>
 <div class="row">
  <div class="col-md-8">
     <div class="card">	  
        <div class="card-header">
		<h5 class="card-title">PRESENSI PEMBINA ESKUL</h5>
		 </div>
	<div class="card-body">
        <div class="table-responsive">
            <table id="datatable1" class="table table-bordered edis2" style="width:100%;font-size:12px">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>NAMA LENGKAP</th>
						<th>JABATAN</th>
						<th>H &nbsp;</th>
						<th>I &nbsp;</th>
						<th>S &nbsp;</th>
						<th>A &nbsp;</th>
					   </tr>
				   </thead>
				   <tbody>
						<?php
						$tahun = date('Y');
						$sql = "
							SELECT 
								e.id,
								e.eskul,
								g.nama AS nama_guru,
								g.id_guru,
								SUM(a.ket = 'H') AS hadir,
								SUM(a.ket = 'I') AS izin,
								SUM(a.ket = 'S') AS sakit,
								SUM(a.ket = 'A') AS alpha
							FROM m_eskul e
							LEFT JOIN guru g ON g.id_guru = e.guru
							LEFT JOIN absensi_les a 
								ON a.idpeg = e.guru 
								AND a.bulan = ? 
								AND a.tahun = ?
							GROUP BY e.id, e.eskul, g.id_guru, g.nama
							ORDER BY e.id ASC
						";

						$stmt = $pdo->prepare($sql);
						$stmt->execute([$bulan, $tahun]);
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

						$no = 1;
						foreach ($rows as $row):
						?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= htmlspecialchars($row['nama_guru']); ?></td>
							<td><?= strtoupper($row['eskul']); ?></td>

							<td class="text-center"><?= $row['hadir'] ?? 0; ?></td>
							<td class="text-center"><?= $row['izin'] ?? 0; ?></td>
							<td class="text-center"><?= $row['sakit'] ?? 0; ?></td>
							<td class="text-center"><?= $row['alpha'] ?? 0; ?></td>
						</tr>
					<?php endforeach; ?>
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
        <div class="text-muted">HIGH SCHOOL</div>
       </div>   
		<div class="col-md-12 mb-3">
			<label class="bold">BULAN</label>                               
			<select  class="form-select bln" id="bln" style="width: 100%;" required >
				<?php
				$stmt = $pdo->prepare("SELECT * FROM bulan");
				$stmt->execute();
				$bulan = $stmt->fetchAll(PDO::FETCH_ASSOC);
				?>
				<option>Pilih Bulan</option>
				<?php foreach ($bulan as $mt): ?>
					<option 
						value="<?= htmlspecialchars($mt['bln']) ?>"
						<?= ($bln == $mt['bln']) ? 'selected' : '' ?>
					>
						<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
					</option>
				<?php endforeach; ?>
			</select>                                                 
           </div>
			<script type="text/javascript">
				$('#bln').change(function() {
				var bln = $('.bln').val();
				location.replace("?pg=<?= enkripsi('cetakpresensi') ?>&ac=<?= enkripsi('pembina') ?>&bln=" + bln);
					}); 
				</script>
				<?php if($bln!=''): ?>
            <div class="d-grid gap-2 mb-4">
		     <a href="cetak/cetakpeg2.php?bln=<?= $bln ?>" target="_blank" 
			 class="btn btn-primary flex-grow-1 m-l-xxs"><i class="ri-printer-fill"></i> CETAK REKAP PEMBINA</a>
			</div>
		      <?php endif; ?>
             <div class="mb-4">
					<p class="text-small text-muted mb-4">ALAMAT</p>
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
					<p class="text-small text-muted mb-4">CONTACT</p>
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
					<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
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
<?php endif; ?>