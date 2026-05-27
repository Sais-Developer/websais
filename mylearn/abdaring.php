<div class="row">
  <div class="col-md-8 mb-4">
     <div class="card">
        <div class="card-header">
		<h5 class="card-title">PRESENSI DARING</h5>
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
    <form id="formabsen" method="GET" action="cetakkelas.php" target="_blank"  enctype="multipart/form-data">
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