 <?php
 require("konek/koneksi.php"); 
 ?>
 <html lang="id" translate="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="id">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sandik All in One">
    <meta name="keywords" content="Sandik All in One">
    <meta name="author" content="sandik">   
    <title><?= $setting['sekolah'] ?></title>
    <link href="<?= $baseurl ?>/font/material.css" rel="stylesheet">
     <link href="<?= $baseurl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
	
	<link rel="stylesheet" href="<?= $baseurl ?>/assets/css/sweetalert2.min.css"> 
	<link href="<?= $baseurl ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/css/custom.css" rel="stylesheet"> 
    <link id="darkTheme" href="<?= $baseurl ?>/assets/css/darktheme.css" rel="stylesheet" disabled>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
    <script src="face/jquery.min.js"></script>
   <script src="face/bootstrap.min.js"></script>
   <script src="face/face-api.js"></script>
   <script src="<?= $baseurl ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
</head>
<body style="background-color:#f2f4f4">

<link href="assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">

        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
						 <ul class="navbar-nav">
                                <li class="nav-item active">
                                  <a class="nav-link" href="#" style="color:#fff;">LIVE PRESENSI</a>
                                </li> 
                            </ul>
                        </div>
						<div class="d-flex" id='progressbox'></div>
                        <div class="d-flex align-items-center gap-3">
							<style>
							.dropdown-item i.material-icons {
							font-size: 18px;
							margin-right: 8px;
							transform: translateY(2px);
							}
						</style>
				<span id="toggleSandik" class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					light
				</span>
				<span id="toggleTheme"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					dark_mode
				</span>             
				
		      <span id="toggleFullscreen"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					fullscreen
				</span>
                
				</div>
			</div>
		</nav>
	</div>
	<div class="app-content">
		<div class="content-wrapper" style="margin-top:-50px;padding:10px">
				<div class="row">
				   <div class="col-md-12">
				   <div class="card-header mb-2">
					  <marquee style="font-size:20px;color:red;">
					  Selamat datang di halaman Live Presensi <?= $setting['sekolah'] ?> menggunakan sistem Presensi Digital dan auto Notifikasi
					  </marquee>
				       </div>
					</div>
				  </div>
					<div class="row">
						<div class="col-md-4">
						<div id="data"></div>
						  </div>
						<div class="col-md-4">
						 <div id="logs"></div>
						 </div>
					   <div class="col-md-4">
						 <div id="hadir"></div>
					 </div>
				  </div>
				</div>
			  </div>
			</div>
		 </div>
	   </div>
	</div>
 </div>

<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/pace/pace.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/highlight/highlight.pack.js"></script>
<script src="<?= $baseurl ?>/assets/js/sweetalert2.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/main.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/custom.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/datatables.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/dashboard.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	setInterval(function(){
		$("#logs").load('logs/logs.php');
		$("#hadir").load('logs/log_kehadiran.php');
		$("#data").load('logs/log_data.php');
	}, 1000);  
});
</script>

</body>
</html>