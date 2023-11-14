<?php 
	HeaderHome($data);
	//$arrProductos = $data['productos'];
	$arrAnimal = $data['animal'];

	//$rutaCategoria = $arrAnimal['categoriaid'].'/'.$arrAnimal['ruta_categoria'];
?>
<br><br><br>
<hr>



	<!-- Animal Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
							<?php
							if(count($arrAnimal->images)>0)
							{
								for ($i=0; $i < count($arrAnimal->images); $i++) { 							
								?>
									<div class="item-slick3" data-thumb="<?= $arrAnimal->images[$i]->url_image;?>">
										<div class="vista-prev-foto pos-relative">
											<img src="<?= $arrAnimal->images[$i]->url_image;?>" alt="<?=$arrAnimal->nombre.$i;?>">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= $arrAnimal->images[$i]->url_image;?>">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
							<?php
								}
							}
							?>
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							<?=$arrAnimal->nombre;?>
						</h4>

						<span class="mtext-106 cl2">
						<?=$arrAnimal->edad." Años.";?>
						</span>

						<?=$arrAnimal->descripcion;?><br>
						
						<a href="<?= BaseUrl(); ?>/Adopcion" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Iniciar proceso de adopción
						</a>
						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

		</div>

	</section>


<?php FooterHome($data);?>