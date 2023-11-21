<?php
$infoPagePreguntas = !empty(GetPageRout('preguntas-frecuentes')) ? GetPageRout('preguntas-frecuentes') : "";
?>

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


	<!-- Modal -->
	<div class="modal fade" id="modalAyuda" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?= $infoPagePreguntas['titulo']  ?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="page-content">
				
				<?= $infoPagePreguntas['contenido']  ?>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
		</div>
	</div>
	</div>

	<div id="divLoading">
      <div>
        <img src="<?=media();?>/images/loading.svg" alt="Loading">
      </div>
    </div>
	<!-- Header -->
	<header>
	<!-- Header desktop -->
		<div class="container-menu-desktop">
		
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<?php
							if(isset($_SESSION['login']))
							{
							?>	
								Bienvenido usuario: <?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?>
							<?php
							}
							?>
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25" data-target="#modalAyuda" data-toggle="modal">
							Ayuda
						</a>
						<?php
							if(isset($_SESSION['login']))
							{
						?>	
						<a href="<?=BaseUrl();?>/Usuarios/Perfil" class="flex-c-m trans-04 p-lr-25">
							Mi cuenta
						</a>
						<?php
							}
						?>
						<?php
							if(isset($_SESSION['login']))
							{
						?>	
						<a href="<?=BaseUrl();?>/Logout" class="flex-c-m trans-04 p-lr-25">
							Salir
						</a>
						<?php
							}else{
						?>
						<a href="<?=BaseUrl();?>/login" class="flex-c-m trans-04 p-lr-25">
							Iniciar Sesión
						</a>
						<?php
							}
						?>
					</div>
				</div>
			</div>
			<div class="wrap-menu-desktop">
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
								<a href="<?= BaseUrl(); ?>/contacto">Contacto</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 menu-right">
							<a href="<?= BaseUrl(); ?>/apadrinar"><i class="zmdi zmdi-thumb-up"></i> Apadrinar</a>
						</div>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 menu-right">
							<a href="<?= BaseUrl(); ?>/donar"><i class="zmdi zmdi-favorite"></i> Donar</a>
						</div>
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
	
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						<?php
							if(isset($_SESSION['login']))
							{
						?>	
								Bienvenido usuario: <?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?>
						<?php
							}
						?>
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" data-toggle="modal" data-target="#modalAyuda" class="flex-c-m trans-04 p-lr-25">
							Ayuda
						</a>
						<?php
						if(isset($_SESSION['login']))
						{
						?>	
						<a href="<?=BaseUrl();?>/Usuarios/Perfil" class="flex-c-m p-lr-10 trans-04">
							Mi cuenta
						</a>
						<?php
						}
						if(isset($_SESSION['login']))
						{
						?>	
						<a href="<?=BaseUrl();?>/Logout" class="flex-c-m p-lr-10 trans-04">
							Salir
						</a>
						<?php
						}else{
						?>
						<a href="<?=BaseUrl();?>/login" class="flex-c-m p-lr-10 trans-04">
							Iniciar Sesión
						</a>
						<?php
						}
						?>
					</div>
				</li>
			</ul>
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
				<hr>
				<li>
					<a href="<?= BaseUrl(); ?>/apadrinar"><i class="zmdi zmdi-thumb-up"></i> Apadrinar</a>
				</li>

				<li>
					<a href="<?= BaseUrl(); ?>/donar"><i class="zmdi zmdi-favorite"></i> Donar</a>
				</li>
			</ul>
		</div>

	</header>