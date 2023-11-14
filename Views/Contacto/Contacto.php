<?php 
	HeaderHome($data);
	$baner = $data['page']['portada'];
	$idPagina = $data['page']['idPagina'];
?>
<script type="text/javascript">
	document.querySelector('header').classList.add('header-v4');

</script>

<?php 

	if(ViewPage($idPagina))
	{
	?>
		<!-- Title page -->
			<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url(<?=$baner?>);">
				<h2 class="ltext-105 cl0 txt-center">
					Contacto
				</h2>
			</section>	

			<!-- Content page -->
			<section class="bg0 p-t-104 p-b-116">
				<div class="container">
					<div class="flex-w flex-tr">
						<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
							<form id="frmContacto">
								<h4 class="mtext-105 cl2 txt-center p-b-30">
									Envíanos un mensaje
								</h4>

								<div class="bor8 m-b-20 how-pos4-parent">
									<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="nombreContacto" name="nombreContacto" placeholder="Nombre contacto">
									<img class="how-pos4 pointer-none" src="<?=Media()?>/matchpet/images/icons/icon-name.png" alt="ICON" style="width: 28px;">
								</div>

								<div class="bor8 m-b-20 how-pos4-parent">
									<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" id="emailContacto" name="emailContacto" placeholder="Correo electrónico">
									<img class="how-pos4 pointer-none" src="<?=Media()?>/matchpet/images/icons/icon-email.png" alt="ICON">
								</div>

								<div class="bor8 m-b-30">
									<textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" id="mensaje" name="mensaje" placeholder="¿Cuál es tu pregunta o mensaje?"></textarea>
								</div>

								<button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
									Enviar
								</button>
							</form>
						</div>

						<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
							<div class="flex-w w-full p-b-42">
								<span class="fs-18 cl5 txt-center size-211">
									<span class="lnr lnr-map-marker"></span>
								</span>

								<div class="size-212 p-t-2">
									<span class="mtext-110 cl2">
										Dirección
									</span>

									<p class="stext-115 cl6 size-213 p-t-18">
										<?=DIRECCION_EMPRESA?>
									</p>
								</div>
							</div>

							<div class="flex-w w-full p-b-42">
								<span class="fs-18 cl5 txt-center size-211">
									<span class="lnr lnr-phone-handset"></span>
								</span>

								<div class="size-212 p-t-2">
									<span class="mtext-110 cl2">
										Teléfono
									</span>

									<p class="stext-115 cl1 size-213 p-t-18">
										<a class="" href="tel:<?= TELEFONO_EMPRESA  ?>"><?= TELEFONO_EMPRESA  ?></a>
									</p>
								</div>
							</div>

							<div class="flex-w w-full">
								<span class="fs-18 cl5 txt-center size-211">
									<span class="lnr lnr-envelope"></span>
								</span>

								<div class="size-212 p-t-2">
									<span class="mtext-110 cl2">
										Correo electrónico
									</span>

									<p class="stext-115 cl1 size-213 p-t-18">
										<a class="" href="mailto:<?= EMAIL_EMPRESA  ?>"><?= EMAIL_EMPRESA  ?></a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
			
			<?= $data['page']['contenido']; ?>
	<?php
	}else{

	 ?>


			<div>
				<div class="container-fluid py-5 text-center">
					<img src="<?= Media() ?>/images/construction.png" alt="En Construcción">
					<h3>Estamos trabajando para usted.</h3>
				</div>
			</div>
			
	<?php 
	} ?>
	
<?php FooterHome($data);?>