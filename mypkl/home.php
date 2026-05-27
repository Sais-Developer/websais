<?php
defined('APK') or exit('No Access');
?>
<?php if (($ac ?? '') == ''): ?>
<div class="row">
   <div class="col-xl-8">
		<div class="card widget widget-action-list">
			<div class="card-body">
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<!-- <li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypres">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">select_all</i>
								</span>
								<span class="widget-action-list-item-title">
									Presensi
								</span>
							</a>
						</li> -->
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mycbt">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">wifi</i>
								</span>
								<span class="widget-action-list-item-title">
									Asesmen
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykbm">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">auto_stories</i>
								</span>
								<span class="widget-action-list-item-title">
									K B M
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myrapor">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">rate_review</i>
								</span>
								<span class="widget-action-list-item-title">
									Rapor SP
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myskl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">school</i>
								</span>
								<span class="widget-action-list-item-title">
									Graduation
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mylearn">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">library_books</i>
								</span>
								<span class="widget-action-list-item-title">
									Elearn
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykonsel">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">laptop</i>
								</span>
								<span class="widget-action-list-item-title">
									Konseling
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypkl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">extension</i>
								</span>
								<span class="widget-action-list-item-title">
									Prakerin
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypayment">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">money</i>
								</span>
								<span class="widget-action-list-item-title">
									Payment
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myaps">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">apps</i>
								</span>
								<span class="widget-action-list-item-title">
									Dashboard
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	  <div class="col-xl-4">
        <div class="card widget widget-info">
			<div class="card-body">
				<div class="widget-info-container">
					<div class="widget-info-image" style="background: url('../images/<?= $setting['logo'] ?>')"></div>
					<h5 class="widget-info-title"><?= $setting['sekolah'] ?></h5>
					<p class="widget-info-text m-t-n-xs">
					<?= $setting['alamat'] ?> Desa <?= $setting['desa'] ?> Kec. <?= $setting['kecamatan'] ?>
					Kab. <?= $setting['kabupaten'] ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class='row'>
		<div class="col-xl-6" >
			<div class="card" >
				<div class="card-header" >	
				<h5 class="card-title">LIVE PRESENSI</h5>		
			</div>				
			<div id="live"></div>
			</div>
		</div>
		<div class="col-xl-6" >
			<div class="card" >
				<div class="card-header" >	
				<h5 class="card-title">LIVE JURNAL</h5>		
			</div>				
			<div id="jurnal"></div>
			</div>
		</div>			
	</div>
<?php elseif($ac == enkripsi('jurnal')): ?>	
 <?php
$id = $_GET['id'] ?? '';

$sql = "
    SELECT j.*, s.nama, d.nama_dudi
    FROM pkl_jurnal j
    LEFT JOIN siswa s ON s.id_siswa = j.idsiswa
    LEFT JOIN pkl_dudi d ON d.id = j.dudi
    WHERE j.id = :id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null; 
?>

   <div class='row'>	 
        <div class="col-xl-6" >
			<div class="card" >
				<div class="card-header" >	
				<h5 class="card-title">JURNAL PRAKERIN</h5>		
			</div>	
          <div class="card-body">
		      <div class="d-flex align-items-center flex-column mb-4">
		        <div class="sw-13 position-relative mb-3">
		         <img src="<?= $baseurl ?>/images/fotopkl/<?= $data['foto_jurnal'] ?>" style="width:200px;">
		     </div>
		  </div>
         <p><?= $data['jurnal'] ?></p>
          </div>		 
		</div>
	</div>
		<div class="col-xl-6" >
			<div class="card" >
				<div class="card-header" >	
				<h5 class="card-title">APROVE JURNAL</h5>		
			</div>		
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-4">
					<div class="sw-13 position-relative mb-3">
						<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
							</div>
			<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
			   <div class="text-muted">HIGH SCHOOL</div>
			</div>
			 <form id="formdudi">
                <input type="hidden" name="id" value="<?= $id; ?>" >
			<div class="col-md-12 mb-2">
				<label class="bold">NAMA SISWA</label>
					<input type="text" value="<?= $data['nama'] ?>" class="form-control">
				</div>
			<div class="col-md-12 mb-2">
				<label class="bold">LOKASI DUDI</label>
					<input type="text" value="<?= $data['nama_dudi'] ?>" class="form-control">
				</div>
            <div class="col-md-12 mb-2">
				<label class="bold">CATATAN</label>
					<textarea name="catat" class="form-control" rows="3" required></textarea>
			</div>
			<div class="widget-payment-request-actions m-t-lg d-flex">
				<button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Aprove Jurnal</button>
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
		 url: 'siswa/taprove.php',
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
			window.location.replace(".");
					}, 200);
								  
					}
				});
			return false;
		});
	</script>	
<?php endif; ?>

  <script>
	var autoRefresh = setInterval(
	function() {
	$('#live').load("log.php?level=<?= $user['level'] ?>&idus=<?= $id_user ?>");	
	$('#jurnal').load("logs.php?lvl=<?= $user['level'] ?>&idu=<?= $id_user ?>");								
	}, 2000
	);
	</script>