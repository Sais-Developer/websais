<?php
defined('APK') or exit('No Access');
?>     

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card card-header">
                <h5 class="card-title"> KOMPETENSI PRAKERIN</h5>
            </div>
            <div class="card-body">									
               <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered tabel-hover edis2" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th>NO</th>                                               
                                <th>PK</th>
                                <th>KOMPETENSI</th>	
                                <th>DESKRIPSI</th>
								<th width="18%"></th>    
                            </tr>
                        </thead>
                        <tbody>
                       <?php
						$sql = "SELECT * FROM pkl_kompetensi ORDER BY id_kompetensi DESC";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

						$no = 0;
						foreach ($results as $data):
							$no++;
						?>
						<tr>
							<td class="text-center"><?= $no; ?></td>
							<td><?= htmlspecialchars($data['jurusan']); ?></td>
							<td><?= htmlspecialchars($data['kompeten']); ?></td>
							<td><?= htmlspecialchars($data['deskrip']); ?></td>
							<td>
								<a href="?pg=<?= enkripsi('kompetensi') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $data['id_kompetensi'] ?>">
									<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
										<i class="material-icons">edit</i>
									</button>
								</a>
								<button data-id="<?= $data['id_kompetensi'] ?>" class="hapus btn btn-sm btn-danger"
										data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
									<i class="material-icons">delete</i>
								</button>
							</td>
						</tr>
						<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<script>
	$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
		console.log(id);
		Swal.fire({
		title: 'Hapus Data',
		text: "Hapus Data Kompetensi",
		icon: 'warning',
		width:'320px',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
		$.ajax({
		url: 'pkl/tkom.php?pg=hapus',
		method: "POST",
		data: 'id=' + id,
		success: function(data) {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		setTimeout(function() {
		window.location.replace("?pg=<?= enkripsi('kompetensi') ?>");
		}, 200);
			}
		});
		}
		return false;
		})

		});

	</script>
	<?php if (($ac ?? '') == ''): ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-column mb-4">
                        <div class="sw-13 position-relative mb-3">
                            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                        </div>
                        <div class="text-muted"><?= $setting['sekolah'] ?? '' ?></div>
                        <div class="text-muted">HIGH SCHOOL</div>
                    </div>
				 <form id="formtambah">
                     <div class="col-md-12 mb-1">
						<label class="bold">TINGKAT</label>
							<select  name="tingkat" class="form-select" style="width:100%" required>
								<option value="">Pilih Tingkat</option>
								<?php
								$stmt = $pdo->prepare("SELECT level FROM m_kelas GROUP BY level");
								$stmt->execute();
								$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach ($results as $data) {
								?>
									<option value="<?= htmlspecialchars($data['level']); ?>"><?= htmlspecialchars($data['level']); ?></option>
								<?php
								}
								?>
							</select>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">JURUSAN</label>
							<select  name="pk" class="form-select" style="width:100%" required>
								<option value="">Pilih Jurusan</option>
								<?php
								$stmt = $pdo->prepare("SELECT jurusan FROM m_kelas GROUP BY jurusan");
								$stmt->execute();
								$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($results as $data) {
								?>
									<option value="<?= htmlspecialchars($data['jurusan']); ?>"><?= htmlspecialchars($data['jurusan']); ?></option>
								<?php
								}
								?>
							</select>
					</div>
					  <div class="col-md-12 mb-1">
						<label class="bold">KOMPETENSI</label>
							<textarea name="kompeten" class="form-control" rows="3" required></textarea>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">DESKRIPSI</label>
							<textarea name="deskrip" class="form-control" rows="8" required></textarea>
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
						<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
						</div>
					  </form>
					</div>
				</div>
			</div>                  
<script>
$('#formtambah').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'pkl/tkom.php?pg=tambah',
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
<?php elseif($ac == enkripsi('edit')): ?>
<?php
$id = $_GET['id'] ?? '';

if ($id != '') {
    $stmt = $pdo->prepare("SELECT * FROM pkl_kompetensi WHERE id_kompetensi = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $datax = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-column mb-4">
                        <div class="sw-13 position-relative mb-3">
                            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                        </div>
                        <div class="text-muted"><?= $setting['sekolah'] ?? '' ?></div>
                        <div class="text-muted">HIGH SCHOOL</div>
                    </div>
				 <form id="formedit">
                     <input type="hidden" name="idk" value="<?= $id; ?>" >
					<div class="col-md-12 mb-1">
						<label class="bold">JURUSAN</label>
							<select  name="pk" class="form-select" style="width:100%" required>
								<option value="<?= $datax['jurusan'] ?>"><?= $datax['jurusan'] ?></option>
								<option value="">Pilih Jurusan</option>
								<?php
								$stmt = $pdo->prepare("SELECT jurusan FROM m_kelas GROUP BY jurusan");
								$stmt->execute();
								$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($results as $data) {
								?>
									<option value="<?= htmlspecialchars($data['jurusan']); ?>"><?= htmlspecialchars($data['jurusan']); ?></option>
								<?php
								}
								?>
							</select>
					</div>
					  <div class="col-md-12 mb-1">
						<label class="bold">KOMPETENSI</label>
							<textarea name="kompeten" class="form-control" rows="3" required><?= $datax['kompeten'] ?></textarea>
					</div>
					<div class="col-md-12 mb-1">
						<label class="bold">DESKRIPSI</label>
						<textarea name="deskrip" class="form-control" rows="8" required><?= $datax['deskrip'] ?></textarea>
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
	 url: 'pkl/tkom.php?pg=edit',
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
		window.location.replace("?pg=<?= enkripsi('kompetensi') ?>");
				}, 200);
							  
				}
			});
		return false;
	});
</script>	
<?php endif; ?>
</div>
