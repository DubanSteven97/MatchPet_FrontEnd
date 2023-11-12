
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$data['page_tag'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="icon" type="image/png" href="<?= media(); ?>/matchpet/images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/fonts/linearicons-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/MagnificPopup/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/vendor/perfect-scrollbar/perfect-scrollbar.css">

	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/css/main.css">
	
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/matchpet/css/style.css">
</head>
<body class="animsition">
	<div id="divLoading">
      <div>
        <img src="<?=media();?>/images/loading.svg" alt="Loading">
      </div>
    </div>
	<!-- Header -->
	<header>
	<!-- Header desktop -->
		<div class="container-menu-desktop">
		
		<?php
		if(isset($_SESSION['login']))
		{
		?>	
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Bienvenido usuario: <?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?>
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>

						<a href="<?=BaseUrl();?>/Usuarios/perfil" class="flex-c-m trans-04 p-lr-25">
							Mi cuenta
						</a>

						<a href="<?=BaseUrl();?>/Logout" class="flex-c-m trans-04 p-lr-25">
							Salir
						</a>
					</div>
				</div>
			</div>
			<div class="wrap-menu-desktop">
		<?php
		}else
		{
		?>
			<div class="wrap-menu-desktop" style="top: 0px;">		
		<?php
		}
		?>
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="<?= BaseUrl(); ?>" class="logo">
						<img src="<?= media(); ?>/images/logo-01.png" alt="MatchPet">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="<?= BaseUrl(); ?>">Inicio</a>
								
							</li>

							<li>
								<a href="<?= BaseUrl(); ?>/adoptables">Adoptables</a>
							</li>

							<li>
								<a href="<?= BaseUrl(); ?>/nosotros">Nosotros</a>
							</li>

							<li>
								<a href="<?= BaseUrl(); ?>contacto">Contacto</a>
							</li>
						</ul>
					</div>	

				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="<?=BaseUrl();?>"><img src="<?= media(); ?>/matchpet/images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
		<?php
		if(isset($_SESSION['login']))
		{
		?>	
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Bienvenido: <?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?>
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="<?=BaseUrl();?>/Usuarios/perfil" class="flex-c-m p-lr-10 trans-04">
							Mi cuenta
						</a>

						<a href="<?=BaseUrl();?>/Logout" class="flex-c-m p-lr-10 trans-04">
							Salir
						</a>
					</div>
				</li>
			</ul>
		<?php
		}
		?>
			<ul class="main-menu-m">
				<li>
					<a href="<?= BaseUrl(); ?>">Inicio</a>
				</li>

				<li>
					<a href="<?= BaseUrl(); ?>/adoptables">Adoptables</a>
				</li>

				<li>
					<a href="<?= BaseUrl(); ?>/nosotros">Nosotros</a>
				</li>

				<li>
					<a href="<?= BaseUrl(); ?>/contacto">Contacto</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="<?= media(); ?>/matchpet/images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Buscar...">
				</form>
			</div>
		</div>
	</header>