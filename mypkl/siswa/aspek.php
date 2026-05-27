<?php
defined('APK') or exit('No accsess');
?> 		
<div class="row">
   <div class="col-md-8">
	 <div class="card">
		 <div class="card card-header">
			<h5 class="card-title"> ASPEK PENILAIAN</h5>
			</div>
		   <div class="card-body">
			<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>
						<th width="7%">NO</th>                                               
						<th>KODE</th>
						<th>NAMA ASPEK</th>
						<th>DESKRIPSI</th>
						<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
                        <?php
						$sql = "SELECT * FROM pkl_aspek";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						$no = 0;
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
						?>
						<tr>
						<td><?= $no; ?></td>
						<td><?= htmlspecialchars($data['kode_aspek']) ?></td>
						<td><?= htmlspecialchars($data['nama_aspek']) ?></td>
						<td><?= htmlspecialchars($data['deskripsi']) ?></td>
						<td>
							<a href="?pg=<?= enkripsi('aspek') ?>&id=<?= $data['id_aspek'] ?>">
								<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Edit">
									<i class="material-icons">edit</i>
								</button>
							</a>
						</td>
						</tr>
						<?php endwhile; ?>
                        </tbody>
                    </table>
                </div>		
			</div>
		</div>
	</div>
<?php
$id = $_GET['id'] ?? ''; 

if ($id != '') {
    $stmt = $pdo->prepare("SELECT * FROM pkl_aspek WHERE id_aspek = ?");
    $stmt->execute([$id]); 
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
            <form id="formdudi">
				<input type="hidden" name="id" value="<?= $id; ?>" >
                      <div class="col-md-12 mb-1">
						<label class="bold">Nama Aspek</label>
						<textarea name="aspek" class="form-control" rows="2" required><?= $datax['nama_aspek'] ?></textarea>
					</div>
					   <div class="col-md-12 mb-1">
						<label class="bold">Deskripsi</label>
						<textarea name="deskrip" class="form-control" rows="5" required><?= $datax['deskripsi'] ?></textarea>
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
					<?php if($id !=''): ?>
						<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
						<?php endif; ?>
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
	 url: 'siswa/taspek.php?',
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
		window.location.replace("?pg=<?= enkripsi('aspek') ?>");
				}, 200);
							  
				}
			});
		return false;
	});
</script>							
	