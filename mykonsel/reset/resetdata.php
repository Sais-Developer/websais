<?php
defined('APK') or exit('No access');
$langgar   = countRows($db, "catatan_pelanggaran");
$bina   = countRows($db, "konseling");

?>

<style>
.card-header {
    display: flex;
    justify-content: space-between; 
    align-items: center;           
}
</style>
<div class="row">
    <div class="col-xl-8">
	   <div class="card-header">
		  <h5 class="card-title">RESET DATABASE</h5>
		 <button id="confirm" class="btn btn-danger"><i class="material-icons">delete</i> RESET</button>
		</div>
		<div class="mb-3"></div>
			<div class="row">
			<div class="col-xl-6">
			<div class="card widget widget-stats">
				<div class="card-body">
					<div class="widget-stats-container d-flex">
						<div class="widget-stats-icon widget-stats-icon-primary">
							<i class="material-icons-outlined">select_all</i>
						</div>
						<div class="widget-stats-content flex-fill">
							<span class="widget-stats-title">Pelanggaran</span>
							<span class="widget-stats-amount"><?= $langgar ?></span>
							<span class="widget-stats-info"></span>
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
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">school</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Pembinaan</span>
						<span class="widget-stats-amount"><?= $bina ?></span>
						<span class="widget-stats-info"></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<script>
$("#confirm").click(function(){
    Swal.fire({
        title: 'Reset Database?',
        text: "Database Konseling akan direset",
        icon: 'warning',
        width: '320px',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'swal-mini',
            confirmButton: 'swal-btn-mini',
            cancelButton: 'swal-btn-mini'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'reset/reset.php',
                type: 'GET',
				 beforeSend: function() {
					 $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
					},	
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data berhasil direset.',
                        timer: 1200,
                        showConfirmButton: false,
                        width: '280px',
                        customClass: { popup: 'swal-mini' }
                    });
                    setTimeout(() => window.location.reload(), 1200);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghapus data.',
                        width: '280px',
                        customClass: { popup: 'swal-mini' }
                    });
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
			                     

					