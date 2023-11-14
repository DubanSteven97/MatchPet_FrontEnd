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
					<?= $data['page']['titulo']; ?>
				</h2>
			</section>	
			<!-- Content page -->

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