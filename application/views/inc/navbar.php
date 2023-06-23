
<header class="app-header fixed-top">	   	            
	<div class="app-header-inner">  
		<div class="container-fluid py-2">
			<div class="app-header-content"> 
				<div class="row justify-content-between align-items-center">
				
					<div class="col-auto">
						<a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>メニュー</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
						</a>
					</div><!--//col-->
					
					
					<div class="app-utilities col-auto">
						
						<div class="app-utility-item app-user-dropdown dropdown">
							<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="<?= base_url();?>assets/images/user.png" alt=""></a>
							<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
								<li><a class="dropdown-item" href="<?= base_url();?>auth/logout" >ログアウト</a></li>
							</ul>
						</div><!--//app-user-dropdown--> 
					</div><!--//app-utilities-->
				</div><!--//row-->
			</div><!--//app-header-content-->
		</div><!--//container-fluid-->
	</div><!--//app-header-inner-->
	<div id="app-sidepanel" class="app-sidepanel"> 
		<div id="sidepanel-drop" class="sidepanel-drop"></div>
		<div class="sidepanel-inner d-flex flex-column">
			<a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
			<div class="app-branding">
				<a class="app-logo" href="#"><img class="logo-icon me-2" src="<?= base_url();?>assets/images/T-System.ico" alt="logo"><span class="logo-text">T-System</span></a>

			</div><!--//app-branding-->  
			
			<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
				<ul class="app-menu list-unstyled accordion" id="menu-accordion">
					<li class="nav-item">
						<a class="nav-link <?php if(uri_string() =='dashboard') echo 'active';?>" href="<?= base_url();?>dashboard">
							<span class="nav-icon">
							<i class="fas fa-home fa-lg"></i>	
							</span>
							
							<span class="nav-link-text">ダッシュボード</span>
						</a><!--//nav-link-->
					</li><!--//nav-item-->
					
					<li class="nav-item has-submenu">
						<a class="nav-link submenu-toggle collapsed <?= hasSubmenuActive('finance');?>" 
						href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1" 
						aria-expanded="<?= hasSubmenuExpanded('finance');?>" aria-controls="submenu-1">
							<span class="nav-icon">
								<i class="fas fa-yen-sign fa-lg"></i>
							</span>
							<span class="nav-link-text">家計簿</span>
							<span class="submenu-arrow">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
								</svg>
							</span><!--//submenu-arrow-->
						</a><!--//nav-link-->
						<div id="submenu-1" class="collapse submenu submenu-1  <?= hasSubmenuShow('finance');?>" data-bs-parent="#menu-accordion">
							<ul class="submenu-list list-unstyled">
								<li class="submenu-item"><a class="submenu-link <?= menuActive('finance/entry');?>" href="<?= base_url("finance/entry");?>">記入</a></li>
							</ul>
						</div>
					</li><!--//nav-item-->
					<li class="nav-item has-submenu">
						<a class="nav-link submenu-toggle collapsed  <?= hasSubmenuActive('daily');?>" 
						href="#" data-bs-toggle="collapse" data-bs-target="#submenu-2" 
						aria-expanded="<?= hasSubmenuExpanded('daily');?>" aria-controls="submenu-2">
							<span class="nav-icon">
								<i class="far fa-calendar-alt fa-lg"></i>
							</span>
							<span class="nav-link-text">日記</span>
							<span class="submenu-arrow">
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
								</svg>
							</span><!--//submenu-arrow-->
						</a><!--//nav-link-->
						<div id="submenu-2" class="collapse submenu submenu-2 <?= hasSubmenuShow('daily');?>" data-bs-parent="#menu-accordion">
							<ul class="submenu-list list-unstyled">
								<li class="submenu-item"><a class="submenu-link <?= menuActive('daily/entry');?>" href="<?= base_url("daily/entry");?>">記入</a></li>
							</ul>
						</div>
					</li><!--//nav-item-->
				</ul><!--//app-menu-->
			</nav><!--//app-nav-->
			<div class="app-sidepanel-footer">
				<nav class="app-nav app-nav-footer">
					<ul class="app-menu footer-menu list-unstyled">
						<li class="nav-item">
							<a class="nav-link" href="">
								<span class="nav-link-text"><?php print_r($this->session->userdata('name'))?>でログイン中</span> 
							</a>
						</li>
					</ul>
				</nav>
			</div>
			
			
		</div><!--//sidepanel-inner-->
	</div><!--//app-sidepanel-->
</header><!--//app-header-->