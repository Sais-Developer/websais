 <?php include "../top/header.php"; ?>  
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
        <div class="app-container">
          <?php include"../top/topbar.php"; ?>
	<div class="app-content">
		<div class="content-wrapper">
			  <?php include"pages.php"; ?>   
		</div>
	</div>
</div>
<?php include "../top/footer.php"; ?>  
