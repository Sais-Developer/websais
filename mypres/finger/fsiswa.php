<?php
defined('APK') or exit('No Access');

try {
    $stmt = $pdo->prepare("SELECT MAX(idjari) as kodejari FROM datareg");
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $idjari = $data['kodejari'] + 1;
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$n=10;
function getName($n) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';		 
	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}
 
	return $randomString;
}
$serial = getName($n);
?>  
<?php if ($ac == '') : ?>
<div class="row">
	  <div class="col-md-8">
		<div class="card">
		   <div class="card-header">
			  <h5 class="card-title">DATA FINGER PRINT</h5>										
				</div>
			<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>                                         
							<th>ID</th>
							<th>SERIAL NUMBER</th>
							<th>NAMA LENGKAP</th>
							 <th>KELAS</th>
							 <th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$no = 0;
							$stmt = $pdo->prepare("SELECT * FROM datareg WHERE serial <> '' AND level = 'siswa' ORDER BY id DESC");
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)):
								$no++;  
						?>
						<tr>
							<td><?= $data['idjari'] ?></td>
							<td><?= $data['serial'] ?></td>
							<td><?= $data['nama'] ?></td>
							<td><?= $data['kelas'] ?></td>
							<td>
								<button data-id="<?= $data['id'] ?>"  class="hapus btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus RFID"><i class="material-icons">delete</i> </button>
							</td>
						</tr>
						<?php endwhile; ?>
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
	<label>ROMBEL</label>
	<div class="col-md-12 mb-4">
	<select class="form-select" id="kelas">
		<option value="">Pilih Kelas</option>
	   <?php
		try {
			$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
			$stmt->execute();
			while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$val = htmlspecialchars($kelas['kelas'] ?? '');
				echo "<option value='$val'>$val</option>";
			}
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		?>
	</select>
	</div>	
	 <script>
		$('#kelas').change(function(){
			var k = $('#kelas').val();
			location.replace("?pg=<?= enkripsi('fsis') ?>&ac=<?= enkripsi('siswa') ?>&k=" + k );
		});
		</script>										
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
 </div>   						
<script>
	$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
	console.log(id);
	Swal.fire({
	  title: 'Hapus Data',
	  text: "Hapus Registrasi Sidik Jari",
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
			   url: 'finger/tfinger.php?pg=hapus',
				method: "POST",
				data: 'id=' + id,
				success: function(data) {
				$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
				setTimeout(function() {
				window.location.replace('?pg=<?= enkripsi("temp") ?>');
					}, 500);
				}
			});
		}
		return false;
	})

});
</script>    
<?php elseif ($ac == enkripsi('siswa')) : ?>
<div class="row">
	  <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">REGISTRASI SISWA</h5>										
				</div>
				<div class="card-body">									
				<div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th>NO</th>                                               
							<th>N I S</th>
							<th>NAMA SISWA</th>
							<th>ROMBEL</th>
							<th>REG</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$kelas = $_GET['k'];
							$no = 0;
							try {
								$stmt = $pdo->prepare("SELECT * FROM siswa WHERE kelas = :kelas AND sts = 0");
								$stmt->bindParam(':kelas', $kelas, PDO::PARAM_STR); 
								$stmt->execute();
								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$no++;
									?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nis'], ENT_QUOTES, 'UTF-8'); ?></td> 
								<td><?= htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($data['kelas'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<a href="?pg=<?= enkripsi('fsis') ?>&ac=<?= enkripsi('siswa') ?>&ids=<?= $data['id_siswa'] ?>&k=<?= $kelas; ?>">
										<button class='btn btn-sm btn-success' data-bs-toggle="tooltip" data-bs-placement="top" title="Registrasi Finger">
											<i class="material-icons">edit</i>
										</button>
									</a>
								</td>
							</tr>
							<?php
						}
					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage();
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
			<div class="text-muted "><?= $setting['sekolah'] ?></div>
				  <div class="text-muted mb-3">HIGH SCHOOL</div>
				</div>
					 <?php 
					$ids = $_GET['ids'];
					$siswa = fetch('siswa',['id_siswa'=>$ids]);
					?>
				<form id='formkartu' class="row g-2">			
					  <input type='hidden' name='idjari' class='form-control' value="<?= $idjari ?>"  />                                      
				  <div class="col-md-12 mb-1">
				   <label>Serial Number</label>
				   <input type='text' name='serial' class='form-control' value="<?= $serial ?>" readonly />
					<input type='hidden' name='id' class='form-control' value="<?= $siswa['id_siswa'] ?>"   />			   
					</div>	
					 
				  <div class="col-md-12 mb-1">
				  <label>Nama Lengkap</label>
				   <input type='text' name='nama' class='form-control' value="<?= $siswa['nama'] ?>"  readonly />
					</div>

				  <div class="col-md-12 mb-1">
				  <label>Rombel</label>
				   <input type='text' name='kelas' class='form-control' value="<?= $siswa['kelas'] ?>" readonly />
					</div>
					<div class="col-md-12 mb-4">
				  <label>Nomor WA</label>
				   <input type='text' name='nowa' class='form-control' value="<?= $siswa['nowa'] ?>"  />
					</div>
					<div class="d-grid gap-2 mb-4">
					<button class="btn btn-dark" type="button" disabled>
						<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						Setelah di Register silahkan <b>Tekan Tombol Registrasi</b> di Mesin, Tempel jari lalu angkat dan tempel sekali lagi, hingga muncul Nama Siswa
					</button>
					 </div>
				
					<div class="d-grid gap-2">
					<?php if($ids !=''): ?>
					 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Register</button>
						 <?php endif; ?>
						</div>
					</form>
				 </div>
			</div>
		</div>
	</div>
   <script>
$('#formkartu').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'finger/tfinger.php?pg=siswa',
        data: $(this).serialize(),
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },
        success: function(data) {
            console.log(data);
            if (data == 'OK') {
                setTimeout(function() {
                    window.location.replace("?pg=<?= enkripsi('fsis') ?>&ac=<?= enkripsi('siswa') ?>&k=<?= $kelas; ?>");
                }, 500);
            } else {
                Swal.fire({
                    icon: 'info',              
                    title: 'Gagal!',
                    text: 'Data Siswa Belum dipilih',
                    background: 'rgba(0, 0, 0, 0.5)',
                    color: '#fff',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end'
                }).then(() => {
                    window.location.reload();
                });
            }
        }
    });
    return false;
});
</script>


  <?php endif ?>
