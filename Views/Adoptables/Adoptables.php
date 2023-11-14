<?php 
	HeaderHome($data);
	$arrAnimales = $data['animales'];
	$idPagina = $data['page']['idPagina'];
?>
<br><br><br>
<hr>
<?php
if(ViewPage($idPagina))
{
?>
<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
	<div class="container">
		<div class="flex-w flex-sb-m p-b-52">
			<div class="flex-w flex-l-m filter-tope-group m-tb-10">
				<h3><?=$data['page_title']?></h3>
			</div>
		</div>

		<div class="row isotope-grid">

		<?php 
		if(count($arrAnimales)>0)
		{
			for ($i=0; $i < count($arrAnimales); $i++) 
			{ 
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

							<a href="<?=BaseUrl().'/adoptables/animal/'.$arrAnimales[$i]->idAnimal.'/'.$ruta;?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver animal
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="<?= BaseUrl().'/adoptables/animal/'.$arrAnimales[$i]->idAnimal.'/'.$ruta;?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
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
		}else
		{
			echo "No hay animales para mostrar";
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
</div>
		
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