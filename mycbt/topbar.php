<div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                  <a class="nav-link" href="#"><i class="material-icons">menu</i></a>
                                </li>
								<?php if($user['level']=='admin'): ?>
								<li class="nav-item hidden-on-mobile">
                                  <a class="nav-link" href="?pg=<?= enkripsi('sinkron') ?>"><i class="material-icons">sync</i> Sync Asesmen</a> 
                                </li>
								<?php endif; ?>
                            </ul>
                        </div>
						<div class="d-flex" id='progressbox'></div>
                        <div class="d-flex align-items-center gap-3">
                        <ul class="navbar-nav">
						<li class="nav-item hidden-on-mobile">
							<a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">
							<?php if(empty($user['foto'])): ?>
									<img src="../images/user.png" alt="" style="width:50px; height:50px; border-radius:50%;">
								<?php else: ?>
								  <img src="../images/fotoguru/<?= $user['foto'] ?>" alt="" style="width:50px; height:50px; border-radius:50%;">
								<?php endif; ?> <?= $user['nama'] ?> <i class="material-icons">keyboard_arrow_down</i>
							</a>
							<ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
								<li><a class="dropdown-item" href="logout.php"><i class="material-icons">logout</i> Log Out</a></li>
								
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
		      <span id="toggleFullscreen"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					fullscreen
				</span>
                      
				</div>
			</div>
		</nav>
	</div>