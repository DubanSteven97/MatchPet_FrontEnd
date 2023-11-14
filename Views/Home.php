<?php 
	HeaderHome($data);
	$arrSlider = $data['slider'];
	$arrBanner = $data['banner'];
	$arrAnimales = $data['animales'];

	$baner = $data['page']['portada'];
	$idPagina = $data['page']['idPagina'];
?>

<?php
if(ViewPage($idPagina))
{
?>
	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
			<?php
			for ($i=0; $i < count($arrSlider); $i++) { 
				$ruta = $arrSlider[$i]->ruta;
			?>
				<div class="item-slick1" style="background-image: url(<?= $arrSlider[$i]->img; ?>);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5" >
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0" style="background-color: rgba(255, 255, 255, 0.5);  border-radius: 5px;    padding: 5px;  margin-bottom: 5px;">
								<span class="ltext-101 cl2 respon2">
									<?= $arrSlider[$i]->descripcion; ?>
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800" style="background-color: rgba(255, 255, 255, 0.5);  border-radius: 5px;    padding: 5px;  margin-bottom: 5px;">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									<?= $arrSlider[$i]->nombre; ?>
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="<?= BaseUrl().'/Adoptables/TipoAnimal/'.$arrSlider[$i]->idTipoAnimal.'/'.$ruta;?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Ver adoptables
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</section>


	<!-- Banner -->
	<div class="sec-banner bg0 p-t-80 p-b-50">
		<div class="container">
			<div class="row">
			<?php
			for ($i=0; $i < count($arrBanner); $i++) {
				$ruta = $arrSlider[$i]->ruta; 
			?>
				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img src="<?= $arrBanner[$i]->img;?>" alt="<?=$arrBanner[$i]->nombre;?>">

						<a href="<?= BaseUrl().'/Adoptables/TipoAnimal/'.$arrSlider[$i]->idTipoAnimal.'/'.$ruta;?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l" style="background-color: rgba(255, 255, 255, 0.5);  border-radius: 5px;    padding: 5px;  margin-bottom: 5px;">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?= $arrBanner[$i]->nombre; ?>
								</span>

								<!--<span class="block1-info stext-102 trans-04">
									Spring 2018
								</span>-->
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Adopta ahora
								</div>
							</div>
						</a>
					</div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>


	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Nuestros animalitos
				</h3>
			</div>
			<hr>
			<div class="row isotope-grid">
			<?php 
			for ($i=0; $i < count($arrAnimales); $i++) { 
				$ruta = $arrAnimales[$i]->ruta;
				if(count($arrAnimales[$i]->images)>0)
				{
					$portada = $arrAnimales[$i]->images[0]->url_image;
				}else
				{
					$portada = media().'/images/uploads/product.jpg';
				}
			?>
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							<img src="<?= $portada; ?>" alt="<?=$arrAnimales[$i]->nombre; ?>">

							<a href="<?=BaseUrl().'/Adoptables/animal/'.$arrAnimales[$i]->idAnimal.'/'.$ruta;?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver Animal
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="<?=BaseUrl().'/Adoptables/Animal/'.$arrAnimales[$i]->idAnimal.'/'.$ruta;?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?=$arrAnimales[$i]->nombre;?>
								</a>

								<span class="stext-105 cl3">
									<?=$arrAnimales[$i]->edad." Años.";?>
								</span>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
									<img class="icon-heart1 dis-block trans-04" src="<?= media(); ?>/matchpet/images/icons/icon-heart-01.png" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?= media(); ?>/matchpet/images/icons/icon-heart-02.png" alt="ICON">
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			</div>

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Ver más
				</a>
			</div>
		</div>

		<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="¿Necesita ayuda?, de clic aquí">
		<img class="btn-whatsapp" src="https://clientes.dongee.com/whatsapp.png" width="64" height="64" alt="Whatsapp" onclick="window.open('<?= contactoWshatsapp(); ?>','_blank')">
		</span>
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