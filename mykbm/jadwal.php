<?php
defined('APK') or exit('No Access');
$ket = $_GET['ket'] ?? '';
?>     
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">JADWAL GURU DAN STAFF </h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover">
                        <thead>
						<tr>
							<th width="10%">NO</th>                                               
							<th>HARI</th>
							<th>KELAS</th>
							<th>MATA PELAJARAN</th>	                                
							<th></th>
						</tr>
                        </thead>
                        <tbody>
                       <?php
					$sql = "
						SELECT *
						FROM jadwal_mengajar jm
						LEFT JOIN m_hari mh ON mh.inggris = jm.hari
						LEFT JOIN mapel mp ON mp.id = jm.mapel
						LEFT JOIN guru u ON u.id_guru = jm.guru
					";

					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $data['hari'] ?? '-' ?><br><?= $data['dari'] ?> - <?= $data['sampai'] ?></td>
						<td>
							<h5>
								<span class="badge badge-dark"><?= $data['tingkat'] ?></span> 
								<span class="badge badge-primary"><?= $data['kelas'] ?></span>
							</h5>
						</td>
						<td>
							<?php if ($data['nama_mapel'] != ''): ?>
								<?= $data['nama_mapel'] ?? '-' ?>
							<?php else: ?>
								Waktu Kerja Staff
							<?php endif; ?>
							<br>
							<span class="badge badge-secondary"><?= $data['nama'] ?? '-' ?></span>
						</td>
						<td>
							<button data-id="<?= $data['id_jadwal'] ?>" class="hapus btn btn-sm btn-danger" 
									data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
								<i class="material-icons">delete</i> 
							</button>
						</td>
					</tr>
					<?php endwhile; ?>
					<?php $stmt = null; ?>
				</tbody>
			</table>
		</div>
	</div>
  </div>
</div>
<script>
$('#datatable1').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Jadwal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'tjadwal.php?pg=hapus',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>
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
					<form id="formguru">
					<div class="col-md-12 mb-1">
						<label class="bold">PEGAWAI</label>
							<select id="ket" name="ket" class="form-select" style="width:100%" required>
								<option value="">Pilih Pegawai</option>
								<option value="Guru"  <?= ($ket == 'Guru')  ? 'selected' : '' ?>>Guru</option>
								<option value="Staff" <?= ($ket == 'Staff') ? 'selected' : '' ?>>Staff</option>
							</select>
						</div>
					<script>
						$('#ket').change(function() {
							var ket = $('#ket').val();
							location.replace("?pg=<?= enkripsi('jadwalkbm') ?>&ket=" + ket);
						});
					</script>
					<div class="col-md-12 mb-1">
						<label class="bold">HARI</label>
						<select name="hari" class="form-select" style="width:100%" required>
							<option value="">Pilih Hari</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM m_hari");
							$stmt->execute();
							while ($hari = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?= $hari['inggris'] ?>"><?= $hari['hari'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<?php if ($ket == 'Guru'): ?>
					<div class="col-md-12 mb-1">
						<label class="bold">MATA PELAJARAN</label>
						<select name="mapel" class="form-select" style="width:100%" required>
							<option value="">Pilih Mata Pelajaran</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM mapel");
							$stmt->execute();
							while ($mapel = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?= $mapel['id'] ?>"><?= $mapel['nama_mapel'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">KELAS</label>
						<select name="kelas" class="form-select" style="width:100%" required>
							<option value="">Pilih Kelas</option>
							<?php
							$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
							$stmt->execute();
							while ($kls = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?= $kls['kelas'] ?>"><?= $kls['kelas'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">GURU PENGAMPU</label>
						<select name="guru" class="form-select" style="width:100%" required>
							<option value="">Pilih Guru</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM guru WHERE level='guru'");
							$stmt->execute();
							while ($guru = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?= $guru['id_guru'] ?>"><?= $guru['nama'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<?php endif; ?>
					<?php if ($ket == 'Staff'): ?>
					<div class="col-md-12 mb-1">
						<label class="bold">STAFF</label>
						<select name="guru" class="form-select" style="width:100%" required>
							<option value="">Pilih Staf</option>
							<?php
							$stmt = $pdo->prepare("SELECT * FROM guru WHERE level='staff'");
							$stmt->execute();
							while ($guru = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?= $guru['id_guru'] ?>"><?= $guru['nama'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<?php endif; ?>
					<?php if ($ket == 'Guru' || $ket == 'Staff'): ?>
					<div class="col-md-12 mb-1">
						<label class="bold">Dari Jam</label>
						<input type="text" name="dari" class="form-control timer" required autocomplete="off">
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">Sampai Jam</label>
						<input type="text" name="sampai" class="form-control timer" required autocomplete="off">
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
						<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
					</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$('#formguru').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'tjadwal.php?pg=tambah',
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

	