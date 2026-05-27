<?php
defined('APK') or exit('No Access');
?>
<div class="row">
	  <div class="col-md-8">
		   <div class="card-header mb-4">
             <h5 class="card-title">DATA HAPUS SIDIK JARI</h5>
            </div>			
			<div id="logsis"></div>
		</div>	
<script type="text/javascript">
	$(document).ready(function(){
	setInterval(function(){
	$("#logsis").load('finger/logsis.php')
	}, 1000);  
	});
</script>	
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