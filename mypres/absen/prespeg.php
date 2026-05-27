<?php
defined('APK') or exit('No Access');
?>      			
<div class="row">
 <div class="col-md-8">
  <div class="card">
   <div class="card-header">
	<h5 class="card-title">PRESENSI <?= strtoupper(date('d M Y')); ?></h5>
		</div>                  
	<div class="card-body">		
	<div class="card-box table-responsive">
		 <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA LENGKAP</th>
					<th>JABATAN</th>
					<th>KET</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			  <?php
					$tgl = date('Y-m-d');
					$no = 0;
					$sql = "SELECT * FROM absensi WHERE tanggal = :tanggal AND level = 'pegawai' ORDER BY id DESC";
					$stmt = $db->prepare($sql);
					$stmt->execute([':tanggal' => $tgl]);
					$absensis = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($absensis as $data) :
						$no++;
						$stmt2 = $db->prepare("SELECT * FROM guru WHERE id_guru = :id_guru");
						$stmt2->execute([':id_guru' => $data['idpeg']]);
						$peg = $stmt2->fetch(PDO::FETCH_ASSOC);
					?>
					<tr>
						<td><?= $no; ?></td>                                              
						<td><?= htmlspecialchars($peg['nama'] ?? '') ?></td>
						<td><?= htmlspecialchars($peg['jabatan'] ?? '') ?></td>
						<td>
							<?php
							switch ($data['ket'] ?? '') {
								case 'H':
									echo "HADIR";
									break;
								case 'S':
									echo "<strong style='color:blue;'>SAKIT</strong>";
									break;
								case 'I':
									echo "<strong style='color:blue;'>IZIN</strong>";
									break;
								case 'A':
									echo "<strong style='color:red;'>ALPHA</strong>";
									break;
							}
							?>
						</td>
						<td>
							<a href="?pg=<?= enkripsi('prespeg') ?>&ac=<?= enkripsi('edit') ?>&id=<?= enkripsi($data['id']) ?>"
							   class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
							   <i class="material-icons">edit</i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
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
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
	 <form id="formabsen" class="row g-2" method="GET" action="cetak/harianpeg.php" target="_blank" enctype="multipart/form-data">                                    
		   <input type="hidden" name="tanggal" value="<?= $tanggal ?>" >
		   <div class="d-grid gap-2 mb-4">              
				<button type="submit"  class="btn btn-primary flex-grow-1 m-l-xxs">CETAK HARIAN</button>
			</div>
		</form>
		<div class="mb-4">
				<p class="text-small text-muted mb-2">ALAMAT</p>
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
				<p class="text-small text-muted mb-2">CONTACT</p>
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
				<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
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
	
<?php elseif($ac == enkripsi('edit')): ?>	
<?php
$id = dekripsi($_GET['id'] ?? 0);

$sql = "SELECT a.*, g.nama
        FROM absensi a
        LEFT JOIN guru g ON g.id_guru = a.idpeg
        WHERE a.id = :id
        LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}
?>
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
	<form id='formedit'>	
	   <input type="hidden" class="form-control" name="id" value="<?= $id ?>" readonly>
	 <label class="bold">TANGGAL</label>
	  <div class="input-group mb-1">
	   <input type='text' name='nisn' value="<?= $data['tanggal'] ?>" class='form-control' readonly>
	   
		</div>
		 <label class="bold">NAMA PEGAWAI</label>
	  <div class="input-group mb-1">
	   <input type='text' name='nama' value="<?= $data['nama'] ?>" class='form-control' required='true' />
		</div>
		<label class="bold">KETERANGAN</label>
	  <div class="input-group mb-1">
	    <select name="ket" class="form-select" required="true">
		   <option value="">Pilih Keterangan</option>
			<option value="S">Sakit</option>
			<option value="I">Izin</option>
			<option value="A">Alpha</option>
			<option value="H">Hadir</option>
	     </select>
		</div>
		
		<div class="widget-payment-request-actions m-t-lg d-flex">
		 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
			</div>
		</form>
	 </div>
   </div>
</div>
<script>
$('#formedit').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		url: 'absen/edit.php?pg=pegawai',
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
<?php endif; ?>		 