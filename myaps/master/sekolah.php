<?php
defined('APK') or exit('No Access');
if($setting['mesin']=='1'){$mesinku='RFID';}
if($setting['mesin']=='2'){$mesinku='MULTI RFID';}
if($setting['mesin']=='3'){$mesinku='BARCODE';}
if($setting['mesin']=='4'){$mesinku='FINGER PRINT';}
if($setting['mesin']=='5'){$mesinku='FACE RECOGNITION';}
?>
<div class="row">
    <div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">SETTING SEKOLAH</h5>
			</div>
		<div class="card-body">
		    <form id='formsekolah' class="row g-2" enctype="multipart/form-data">
				<div class='col-md-8'>
					<label class="bold">Nama Sekolah</label>
                    <input type='text' name='sekolah' value="<?= $setting['sekolah'] ?>"  class='form-control' required='true' />
                </div>
				<div class='col-md-4'>
					<label class="bold">Jenjang</label>
						<select name='jenjang' id="jenjang" class='form-select'  required='true'>
							<option value="<?= $setting['jenjang'] ?>"><?= $setting['jenjang'] ?></option> 
							<option value="SMK">SMK</option>  
							<option value="SMA">MAN / SMA</option>		   
							<option value="SMP">MTs / SMP</option>  
							<option value="SD">MI / SD</option>	
							<option value="PKBM">P K B M</option>
							</select>
						</div>
				
				<div class='col-md-3'>
                <label class="bold">NPSN</label>
                    <input type='text' name='npsn' value="<?= $setting['npsn'] ?>"  class='form-control' required='true' />
                       </div>
									
				<div class='col-md-3'>
                <label class="bold">Semester</label>
                    <select name='semester' class='form-select' required='true'>
					<option value="<?= $setting['semester'] ?>"><?= $setting['semester'] ?></option>
					<option value='1'>1</option>
					<option value='2'>2</option>
					</select>
                    </div>
				<div class='col-md-3'>
                <label class="bold">Tahun Pelajaran</label>
                    <input type='text' name='tp' value="<?= $setting['tp'] ?>" class='form-control' required='true' />
                        </div>
				
				<div class='col-md-3'>
                <label class="bold">Nomor WA</label>
                    <input type='text' name='nowa' value="<?= $setting['nowa'] ?>"  class='form-control' required='true' />
                      </div>	  
				<div class='col-md-8'>
                <label class="bold">Alamat</label>
                    <input type='text' name='alamat' value="<?= $setting['alamat'] ?>" class='form-control' required='true' />
                      </div>
				<div class='col-md-4'>
                <label class="bold">Desa</label>
                    <input type='text' name='desa' value="<?= $setting['desa'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-4'>
                <label class="bold">Kecamatan</label>
                    <input type='text' name='kec' value="<?= $setting['kecamatan'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-4'>
                <label class="bold">Kabupaten / Kota</label>
                    <input type='text' name='kab' value="<?= $setting['kabupaten'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-4'>
                <label class="bold">Propinsi</label>
                    <input type='text' name='prop' value="<?= $setting['propinsi'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-5'>
                <label class="bold">Kepala Sekolah</label>
                    <input type='text' name='kepsek' value="<?= $setting['kepsek'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-3'>
                <label class="bold">NIP </label>
                    <input type='text' name='nip' value="<?= $setting['nip'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-4'>
                <label class="bold">Email</label>
                    <input type='text' name='email' value="<?= $setting['email'] ?>" class='form-control' required='true' />
                        </div>
				<div class='col-md-6'>
                <label class="bold">Server<small style="color:red">(jangan gunakan tanda / dibelakang)</small></label>
                    <input type='text' name='server' class='form-control' value="<?= $setting['server'] ?>" required="true"/>
                        </div>						
				<div class='col-md-6'>
                <label class="bold">Url Api WA <small style="color:red">(jangan gunakan tanda / dibelakang)</small></label>
                    <input type='text' name='apiwa' class='form-control' value="<?= $setting['url_api'] ?>" required="true"/>
                        </div>
				<div class='col-md-4'>
                <label class="bold">Time Zona</label>
                    <select name='waktu' class='form-select' required='true' >
                    <option value="<?= $setting['waktu'] ?>"><?= $setting['waktu'] ?></option>
                    <option value='Asia/Jakarta'>Asia/Jakarta</option>
                    <option value='Asia/Makassar'>Asia/Makassar</option>
                    <option value='Asia/Jayapura'>Asia/Jayapura</option>
                    </select>   
                    </div>
				<div class='col-md-4'>
                <label class="bold">Logo Sekolah</label>
                    <input type='file' name='logo' class='form-control' />
                        </div>
				<div class="col-sm-4">	
					<?php if($setting['logo']<>''): ?>
						<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" height='50px' >
					<?php endif; ?>
				</div>	
					
				<div class="col-sm-12">
				<label class="bold">Header Laporan</label>
					<textarea name="laporan" class="form-control" rowspan="3" ><?= $setting['header'] ?></textarea>
                   </div>
				<div class="d-flex justify-content-end align-items-center mb-2">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form>
		</div>
	</div>
</div>
				
	<script>
    $('#formsekolah').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
            url: 'master/tsekolah.php',
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
						}, 500);
					}
				});
		  return false;
	 });
</script>	
 <div class="col-md-4">
  <div class="card">
   <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
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
	</div>
			
			<script>
				$("#ttdd").click(function(){
		    	Swal.fire({
				  title: 'Hapus',
				  text: "Hapus Tanda Tangan",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya, Hapus'
				}).then((result) => {
				  if (result.value) {
					$.ajax({
					url: 'pengaturan/crud_setting.php?pg=hapusttd',
					success: function(data) {
						 Swal.fire(
				      'Success!',
				      'Your file has been Optimize.',
				      'success'
				    )
				   setTimeout(function() {
					window.location.reload();
					}, 1000);
						}
					});
					}
					return false;
						})

						});
					</script>
			<script>
				$("#stp").click(function(){
		    	Swal.fire({
				  title: 'Hapus',
				  text: "Hapus Tanda Tangan",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya, Hapus'
				}).then((result) => {
				  if (result.value) {
					$.ajax({
					url: 'pengaturan/crud_setting.php?pg=hapusstp',
					success: function(data) {
						 Swal.fire(
				      'Success!',
				      'Your file has been Optimize.',
				      'success'
				    )
				   setTimeout(function() {
					window.location.reload();
					}, 1000);
						}
					});
					}
					return false;
						})

						});
					</script>	
					<script>
				$("#cth").click(function(){
		    	Swal.fire({
				  title: 'Hapus',
				  text: "Hapus Kop Sekolah",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya, Hapus'
				}).then((result) => {
				  if (result.value) {
					$.ajax({
					url: 'pengaturan/crud_setting.php?pg=hapuskop',
					success: function(data) {
						 Swal.fire(
				      'Success!',
				      'Your file has been Optimize.',
				      'success'
				    )
				   setTimeout(function() {
					window.location.reload();
					}, 1000);
						}
					});
					}
					return false;
						})

						});
					</script>