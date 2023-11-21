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
			<div class="container">
				<br>
				<!-- Contenido principal -->
				<div class="row justify-content-md-center">
					<div class="col-md-8 ">
						<div class="card">
							<div class="card-header">
								<h2 class="text-center">Realiza una donación</h2>
							</div>
							<div class="card-body">
								<form action="<?= BaseUrl(); ?>/Donar/procesoDonacion" method="post">
									<div class="row">
										<h3><span class="badge badge-secondary">Selecciona una organización a donar..</span></h3>
										
									</div>
									<br>
									<div class="row">
										<?php 
										$org = $data['organizaciones'];
										for ($i=0; $i < count($org); $i++) 
										{
											?>
											<div class="col-sm-6">
											<label class="form-check-label selectOrg" for="radioOrg<?=$org[$i]->idOrganizacion?>">
												<div class="card cardOrg" style="min-height: 150px;" id="selectOrg<?=$org[$i]->idOrganizacion?>" onclick="fntSelectOrg(<?=$org[$i]->idOrganizacion?>)">
													<div class="card-body">
														<h5 class="card-title">
															<b><?=$org[$i]->nombre?></b>
															<input class="form-check-input radioOrg" type="radio" name="radioOrg" id="radioOrg<?=$org[$i]->idOrganizacion?>" value="<?=$org[$i]->idOrganizacion?>" style="display: none;">
														</h5>

														<p class="card-text"> <?=$org[$i]->descripcion?></p>
														<p class="card-text"> <?=$org[$i]->direccion?></p>
														<p class="card-text"> <?=$org[$i]->telefono?></p>
														
													</div>
												</div>
											</label>
											</div>
											<?php
										}
										?>
									</div>


									<div class="form-group">
										<label for="monto">Monto de la donación:</label>
										<input type="number" class="form-control" id="monto" name="monto" min="1" required>
									</div>
									<button type="submit" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">Realizar donación</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?= $data['page']['contenido']; ?>
			</div>

			
			
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