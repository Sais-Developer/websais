<?php
defined('APK') or exit('No Access');
?>     
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">DATA DUDI </h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:13px">
                        <thead>
                            <tr>
                                <th width="10%">NO</th>                                               
                                <th>NAMA DUDI</th>
                                <th>ALAMAT</th>
                                <th>INSTRUKTUR</th>	                          
                                <th width="18%"></th>
                            </tr>
                        </thead>
                        <tbody>
                       <?php
							$no = 0;
							$sql = "SELECT * FROM pkl_dudi";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$dudiList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($dudiList as $data):
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nama_dudi']) ?></td>
								<td><?= htmlspecialchars($data['alamat']) ?></td>
								<td><?= htmlspecialchars($data['instruktur']) ?></td>
								<td>
									<a href="?pg=<?= enkripsi('dudi') ?>&id=<?= $data['id'] ?>">
										<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
											<i class="material-icons">edit</i>
										</button>
									</a>
									<button data-id="<?= $data['id'] ?>" class="hapus btn btn-sm btn-danger" 
											data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
										<i class="material-icons">delete</i> 
									</button>
								</td>
							</tr>
							<?php
							endforeach;
							$stmt = null; 
							?>
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
		text: "Hapus Data Dudi",
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
		url: 'dudi/tdudi.php?pg=hapus',
		method: "POST",
		data: 'id=' + id,
		success: function(data) {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		setTimeout(function() {
		 window.location.reload(true);
		}, 200);
			}
		});
		}
		return false;
		})

		});

	</script>
	<?php
$id = $_GET['id'] ?? ''; 
if ($id != '') {
    $stmt = $pdo->prepare("SELECT * FROM pkl_dudi WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $datax = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null; 
}
?>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-column mb-4">
                    <div class="d-flex align-items-center flex-column">
                        <div class="sw-13 position-relative mb-3">
                            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                        </div>
                        <div class="text-muted"><?= $setting['sekolah'] ?? '' ?></div>
                        <div class="text-muted">HIGH SCHOOL</div>
                    </div>
                </div>

                <form id="formdudi">
				<input type="hidden" name="iddudi" value="<?= $id; ?>" >
                     <div class="col-md-12 mb-1">
						<label class="bold">NAMA DUDI</label>
						<input type="text" name="dudi" value="<?= $datax['nama_dudi'] ?>"  class="form-control" required>
					</div>
                      <div class="col-md-12 mb-1">
						<label class="bold">ALAMAT LENGKAP</label>
						<textarea name="alamat" class="form-control" rows="3" required><?= $datax['alamat'] ?></textarea>
					</div>
					  <div class="col-md-12 mb-1">
						<label class="bold">NO TELP / WA (Jika ada)</label>
						<input type="number" name="telp" value="<?= $datax['telp'] ?>" class="form-control">
					</div>
					  <div class="col-md-12 mb-1">
						<label class="bold">PEMBIMBING DARI DUDI (Jika tahu)</label>
						<input type="text" name="pembina" value="<?= $datax['instruktur'] ?>" class="form-control" >
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
						<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
<script>
$('#formdudi').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'dudi/tdudi.php?pg=tambah',
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
			window.location.replace("?pg=<?= enkripsi('dudi') ?>");
					}, 200);
								  
					}
				});
			return false;
		});
	</script>	

							