<div class="row">
	<div class="col-md-8 mb-4">
		<div class="card">
		   <div class="card-header">
		<h5 class="card-title">UPDATE DATA KOMPETENSI</h5>
		</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="datatable1" class="table table-bordered edis2" style="font-size:12px">
				<thead>
				  <tr>
					<th width="5%">NO</th>
					<th>JURUSAN</th>
					<th>PK</th>
					<th>BK</th>
					<th>KK</th>
					<th width="5%">EDIT</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					$no = 0;
					$stmt = $db->query("SELECT jurusan, pk, bk, kk FROM m_kelas GROUP BY jurusan");
					$dataAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($dataAll as $data) {
						$no++;
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= htmlspecialchars($data['jurusan'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['pk'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['bk'] ?? '', ENT_QUOTES) ?></td>
							<td><?= htmlspecialchars($data['kk'] ?? '', ENT_QUOTES) ?></td>
							<td>
								<a href="?pg=<?= enkripsi('jurusan') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['jurusan']) ?>"
								   class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
									<i class="material-icons">edit</i>
								</a>
							</td>
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
<?php if (($ac ?? '') == ''): ?>
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
		<div class="d-flex justify-content-between mb-2">
			<div class="text-center">
			  <p class="text-small text-muted mb-2">NPSN</p>
			  <p><?= $setting['npsn'] ?></p>
			</div>
			<div class="text-center">
			  <p class="text-small text-muted mb-2">SMT</p>
			  <p><?= $setting['semester'] ?></p>
			</div>
			<div class="text-center">
			  <p class="text-small text-muted mb-2">TP</p>
			  <p><?= $setting['tp'] ?></p>
			</div>                    
		  </div>
		  <div class="mb-4">
			<p class="text-small text-muted mb-4">ALAMAT</p>
			<div class="row g-0 mb-3">
			  <div class="col-auto">
				<div class="sw-3 me-1">
				  <i class="material-icons text-info" style="font-size:18px">home</i>
				</div>
			  </div>
			  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
			</div>
			<div class="row g-0 mb-3">
			  <div class="col-auto">
				<div class="sw-3 me-1">
					<i class="material-icons text-info" style="font-size:18px">star</i>
				</div>
			  </div>
			  <div class="col text-alternate"><?= $setting['desa'] ?></div>
			</div>
			<div class="row g-0 mb-3">
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
			<div class="row g-0 mb-3">
			  <div class="col-auto">
				<div class="sw-3 me-1">
					<i class="material-icons text-info" style="font-size:18px">phone</i>
				</div>
			  </div>
			  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
			</div>
			<div class="row g-0 mb-3">
			  <div class="col-auto">
				<div class="sw-3 me-1">
				   <i class="material-icons text-info" style="font-size:18px">inbox</i>
				</div>
			  </div>
			  <div class="col text-alternate"><?= $setting['email'] ?></div>
			</div>
			<div class="row g-0 mb-3">
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
			<div class="row g-0 mb-3">
			  <div class="col-auto">
				<div class="sw-3 me-1">
				 <i class="material-icons text-info" style="font-size:18px">person</i>
				</div>
			  </div>
			  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
			</div>
			<div class="row g-0 mb-3">
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
<?php elseif ($ac == enkripsi('edit')): ?>
<?php
$id = dekripsi($_GET['ids'] ?? '');

if (!empty($id)) {
    $stmt = $db->prepare("SELECT * FROM m_kelas WHERE jurusan = :jurusan");
    $stmt->execute(['jurusan' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $data = null;
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
			<form id="formedit"  class="row g-1" enctype='multipart/form-data'>
					<input type="hidden" name="id" value="<?= $id ?>">
					<div class="col-md-12">
						<label class="bold">Nama Jurusan</label>
						<input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['jurusan'], ENT_QUOTES) ?>" required>
					</div>
					<div class="col-md-12">
						<label class="bold">Program Keahlian</label>
						<input type="text" name="pk" class="form-control" value="<?= htmlspecialchars($data['pk'], ENT_QUOTES) ?>" required>
					</div>
					<div class="col-md-12">
						<label class="bold">Bidang Keahlian</label>
						<input type="text" name="bk" class="form-control" value="<?= htmlspecialchars($data['bk'], ENT_QUOTES) ?>" required>
					</div>
					 <div class="col-md-12 mb-3">
						<label class="bold">Kompetensi Keahlian</label>
						<input type="text" name="kk" class="form-control" value="<?= htmlspecialchars($data['kk'], ENT_QUOTES) ?>" required>
					</div> 
						<div class="d-flex justify-content-end align-items-center mb-2">
					 <button type="submit" class="btn btn-primary">Simpan</button>
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
             url: 'master/tsiswa.php?pg=jurusan',
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
				window.location.replace("?pg=<?= enkripsi('jurusan') ?>");
					 }, 200);
					}
				});
				return false;
			});
		</script>
<?php endif; ?>
 </div>