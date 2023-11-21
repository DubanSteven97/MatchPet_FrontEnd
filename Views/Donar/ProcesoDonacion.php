<?php 
	HeaderHome($data);
    MercadoPago\SDK::setAccessToken(ACCESSTOKENMERCADOPAGO);
    if(isset($_SESSION['login'])){

		$preference = new MercadoPago\Preference();


		$preference->back_urls = array("success"=>BASE_URL_H.'/Donar/ResponseTransaccion',
										"failure"=>BASE_URL_H.'/Donar/ResponseTransaccion',
										"pending"=>BASE_URL_H.'/Donar/ResponseTransaccion');

		/*$preference->taxes = array("type" => "IVA",
									"value" => 19);*/
		$payer = new MercadoPago\Payer();
		$payer->name =$_SESSION['userData']['nombres'];
		$payer->surname=$_SESSION['userData']['apellidos'];
		$payer->email=$_SESSION['userData']['email'];

        $item = new MercadoPago\Item();
        $item->id = $data["organizacion"]->idOrganizacion;
        $item->title = "Donación a organización ". $data["organizacion"]->nombre;
        $item->quantity = 1;
        $item->unit_price = $data['monto'];
        $item->currency_id = MONEDA;
        $preference->payer = $payer;
        $preference->items = array($item);
        $preference->save();
	}

?>
<script src="https://sdk.mercadopago.com/js/v2"></script>
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
									¡Hola, <strong><?=$_SESSION['userData']['nombres']?> <?=$_SESSION['userData']['apellidos']?></strong>!<br></h2>
								<p>¿Estás seguro de iniciar el proceso de donación de <strong><?= FormatMoney($data["monto"]); ?></strong> a la organización seleccionada?</p>
								<br>
								<div class="text-center">
								<div id="divMetodoPago">
                                <hr>
                                    <div id="divCondiciones">
                                        <input type="checkbox" id="condiciones"></input>
                                        <label for="condiciones"> Aceptar </label>
                                        <a href="#" data-toggle="modal" data-target="#modalAyuda"> Términos y Condiciones</a>
                                    </div>
                                    <div id="optMetodoPago" >
                                        <hr>
                                        <h4 class="mtext-109 cl2 p-b-30"> Método de pago</h4>
                                        <div class="metodosPago">
                                            <label for="mercadopago">
                                                <input type="radio" id="mercadopago" class="methodpago" name="payment-method" checked="" value="MercadoPago">
                                                <img src="<?=media();?>/images/img-mercadoPago.png" alt="Icono de Mercado Pago" class="ml-space-sm" width="74" heigth="20">
                                            </label>
                                        </div>
                                        
                                        <div class="metodosPago">
                                            <label for="contraentrega">
                                                <input type="radio" id="contraentrega" class="methodpago" name="payment-method" value="CT">
                                                <span>Nequi/Bancolombia/Transferencia</span>
                                            </label>
                                        </div>
                                        <div id="msgmercadopago">
                                            <p>Para completar la transacción, te enviaremos a los servidores seguros de Mercado.</p>
                                            <br>
                                            <div class="mercadopago-btn-container"></div>
                                        </div>
                                    </div>
                                </div>
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


<?php 

if(isset($_SESSION['login'])){
	?>
<script>
	const mp = new MercadoPago('<?=KEYPUBLICMERCADOPAGO;?>', {
		locale: 'es-CO'
	});

	mp.checkout({
		preference: {
		  id: '<?= $preference->id;?>'
		},
		render: {
		  container: '.mercadopago-btn-container',
		  label: 'Donar',
		},
	    theme: {
	    	elementsColor: '#6B2737',
	    	headerColor: '#6B2737'
	    }
	});
</script>
<?php }?>
<?php FooterHome($data);?>