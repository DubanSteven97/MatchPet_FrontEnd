<?php 
	HeaderHome($data);
?>
<!-- breadcrumb -->
<div class="container">
<br>
<br>
<br>
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="<?=BaseUrl();?>" class="stext-109 cl8 hov-cl1 trans-04">
			Inicio
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>

		<span class="stext-109 cl4">
			<?= $data['page_title'];?>
		</span>
	</div>
	
</div>
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
			<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl">
				<div>
				<?php
				if (isset($_SESSION['login'])) {
				?>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h2>
									¡Hola, <strong><?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?></strong>!<br>
									¿Estás seguro de iniciar el proceso de adopción de <strong><?php echo $_GET["nombreAnimal"]; ?></strong>?
								</h2><br>
								<div class="text-center">
								<button class="btn btn-success" type="button" onclick="confirmacionAdopcion(<?=$_SESSION['userData']['idPersona']?>,<?=$_GET['idAnimal']?>,<?=$_GET['idOrganizacionAnimal']?>)">
									<i class="fa fa-fw fa-lg fa-check-circle"></i>
									<span id="btnText">Confirmar</span>
								</button>
								<button class="btn btn-danger" type="button" onclick="window.history.back();">
									<i class="fa fa-fw fa-lg fa-times-circle"></i>
									<span id="btnText">Cancelar</span>
								</button>
								</div>
							</div>
						</div>
					</div>

				<?php
				}
				else
				{
				?>
					<br><ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Iniciar Sesión</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="profile" aria-selected="false">Registrarse</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
							<br>
							<form id="formLogin">
								<div class="form-group">
									<label for="txtEmail">Usuario</label>
									<input type="email" class="form-control" id="txtEmail" name="txtEmail">
								</div>
								<div class="form-group">
									<label for="txtPassword">Password</label>
									<input type="password" class="form-control" id="txtPassword" name="txtPassword">
								</div>
								<button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Iniciar Sesión</button>
							</form>
						</div>
						<div class="tab-pane fade" id="registro" role="tabpanel" aria-labelledby="profile-tab">
							<br>
							<form id="formRegister">
								<div class="row">
									<div class="col col-md-6 form-group">
										<label for="txtNombre">Nombres:</label>
										<input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
									</div>
									<div class="col col-md-6 form-group">
										<label for="txtApellido">Apellidos:</label>
										<input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
									</div>
								</div>	
								<div class="row">
									<div class="col col-md-6 form-group">
										<label for="txtTelefono">Teléfono:</label>
										<input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return ControlTag(event);">
									</div>
									<div class="col col-md-6 form-group">
										<label for="txtEmailCliente">Email:</label>
										<input type="email" class="form-control valid validEmail" id="txtEmailCliente" name="txtEmailCliente" required="">
									</div>
								</div>	
								<button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Regístrate</button>						
							</form>
						</div>
					</div>
				<?php
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php FooterHome($data);?>