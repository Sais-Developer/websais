 <?php include "header.php"; ?> 
 
<script>
document.addEventListener('DOMContentLoaded', function() {
    function isChrome() {
        const ua = navigator.userAgent;
        return /Chrome/.test(ua) && !/Edg|OPR|Brave/.test(ua);
    }

    if (!isChrome()) {
        Swal.fire({
            icon: 'error',
            title: 'Browser Tidak Didukung',
            text: 'Silakan gunakan Google Chrome untuk melanjutkan.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: 'Tutup'
        }).then(() => {
            window.location.href = 'blank.php'; 
        });
    }
});
</script>

<?php if($pg == enkripsi('asesmen')) : ?>
<link href="assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
<?php else: ?>
<div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                  <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="logo-img">
                <div class="sidebar-user-switcher">
                    <a href="#">
                        <span class="user-info-text"><?= $setting['sekolah'] ?><br>
						<span class="user-state-info">NPSN : <?= $setting['npsn'] ?></span>
						</span>
                    </a>
                </div>
            </div>
             <?php include"menu.php"; ?>
        </div>
		<?php endif; ?>
        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
							<?php if($pg == enkripsi('asesmen')) : ?>
							
							<?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                              <?php endif; ?>  
                                <li class="nav-item hidden-on-mobile">
                                  <a class="nav-link" href="#"><i class="material-icons">menu</i></a>
                                </li> 
                            </ul>
                        </div>
						<div class="d-flex" id='progressbox'></div>
                        <div class="d-flex align-items-center gap-3">
                           <ul class="navbar-nav">
				<li class="nav-item hidden-on-mobile">
					<a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">
					
							<img src="images/siswa.png" alt="">
					</a>
					<ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
						<?php if($pg == enkripsi('asesmen')) : ?>
						<?php else: ?>
						<li><a class="dropdown-item" href="<?= $baseurl ?>/logout.php"><i class="material-icons">logout</i> Log Out</a></li>
						<?php endif; ?>
					</ul>
				</li>
				</ul>
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
				<?php if($pg == enkripsi('asesmen')) : ?>
						<?php else: ?>
		      <span id="toggleFullscreen"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					fullscreen
				</span>
                 <?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
	<div class="app-content">
		<div class="content-wrapper">
		<?php if($pg == enkripsi('asesmen')) : ?>
		<div class="container" style="margin-top:-50px">
		  <?php include"pages.php"; ?>   
		</div>
		<?php else: ?>
		 <?php include"pages.php"; ?>  
		<?php endif; ?>
		</div>
	</div>
</div>
<?php include "footer.php"; ?>  
