<?php
defined('APK') or exit('No accsess');
$pdb = fetch('pdb');
$siswa   = countRows($db, "siswa");
?>
<div class="row">
    <div class="col-xl-8">       
	   <div class="row">
	<div class="col-xl-6">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">person</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Peserta Didik Baru</span>
						<span class="widget-stats-amount"><?= $pdb['jumlah'] ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-warning">
						<i class="material-icons-outlined">school</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Total Peserta Didik</span>
						<span class="widget-stats-amount"><?= $siswa ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_up</i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="col-xl-4">
	<div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="h5 mb-0">IMPOR SISWA BARU</div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>
				<div class="widget-payment-request-info m-t-md"> 						      
				<form id='formsiswa'>	
					<div style="display: flex; justify-content: space-between; align-items: center;" class="mb-2">
					<label>Pilih File</label>
							<a href="mutasi/M_SISWA_BARU.xlsx" class="btn btn-link" 
							   data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">
								<i class="material-icons">download</i> Format
							</a>
						</div>	            
						<div class="input-group mb-4">
					   <input type='file' name='file' class='form-control' required accept=".xlsx" >
							<span class="input-group-text">
								<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
							</span>
						</div>	
					</form>
					</div>                  
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">NPSN</p>
                      <p><?= $setting['npsn'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">SMT</p>
                      <p><?= $setting['semester'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">TP</p>
                      <p><?= $setting['tp'] ?></p>
                    </div>                    
                  </div>
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
                </div>
              </div>             
            </div>					
		 </div>
		
							  
	<script>
    $('#formsiswa').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'mutasi/import_siswa.php',
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
						}, 2000);
									  
						}
					});
				return false;
			});
		</script>	
          