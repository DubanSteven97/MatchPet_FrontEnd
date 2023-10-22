<?php 
	HeaderTienda($data);

	MercadoPago\SDK::setAccessToken(ACCESSTOKENMERCADOPAGO);
	if(isset($_SESSION['login'])){

		$preference = new MercadoPago\Preference();


		$preference->back_urls = array("success"=>BASE_URL_H.'/Tienda/ResponsePedido',
										"failure"=>BASE_URL_H.'/Tienda/ResponsePedido',
										"pending"=>BASE_URL_H.'/Tienda/ResponsePedido');

		/*$preference->taxes = array("type" => "IVA",
									"value" => 19);*/
		$payer = new MercadoPago\Payer();
		$payer->name =$_SESSION['userData']['nombres'];
		$payer->surname=$_SESSION['userData']['apellidos'];
		$payer->email=$_SESSION['userData']['email_user'];
	}

		// Crea un ítem en la preferencia
		$productos = [];
		$subTotal = 0;
		$total = 0;
		foreach ($_SESSION['arrCarrito'] as $producto) 
		{	
			if(isset($_SESSION['login'])){
				$item = new MercadoPago\Item();
				$item->id = $producto['idproducto'];
				$item->title = $producto['producto'];
				$item->quantity = $producto['cantidad'];
				$item->unit_price = intval($producto['precio']);
				$item->picture_url = $producto['imagen'];
				$item->currency_id = MONEDA;
				array_push($productos, $item);
			}
			$subTotal += $producto['precio']*$producto['cantidad'];
		}
		$item = new MercadoPago\Item();
		$item->id = 0;
		$item->title = 'Costo de envío';
		$item->quantity = 1;
		$item->unit_price = COSTOENVIO;
		$item->currency_id = MONEDA;
		array_push($productos, $item);
		if(isset($_SESSION['login'])){

			$preference->payer = $payer;
			$preference->items = $productos;
			$preference->save();
		}
	$total = $subTotal + COSTOENVIO;
?>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="https://www.paypal.com/sdk/js?client-id=<?=IDCLIENTEPAYPAL;?>&currency=<?=CURRENCY;?>"></script>
<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Términos y Condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non deserunt exercitationem, ratione, quam, quos dolore facere veniam in voluptate ea voluptatem. Quae repellendus numquam optio, iste explicabo, facilis architecto alias. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque cum nobis ea ipsum iure consequatur illo molestiae recusandae eligendi facilis quibusdam dolorem molestias, aperiam quae facere repellendus? Iste, modi, iusto. <br> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<br><br><br>
<hr>
<!-- breadcrumb -->
<div class="container">
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
					<div>
						<label for="tipoPago">Dirección de envío:</label>
						<div class="bor8 bgo m-b-12">
							<input id="txtDireccion" type="text" class="stext-111 cl8 plh3 size-111 p-lr-15" name="state" placeholder="Dirección de envío"></input>
						</div>
						<div class="bor8 bgo m-b-12">
							<input id="txtCiudad" type="text" class="stext-111 cl8 plh3 size-111 p-lr-15" name="postCode" placeholder="Ciudad"></input>
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
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

		<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
			<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
				<h4 class="mtext-109 cl2 p-b-30">
					Resumen
				</h4>

				<div class="flex-w flex-t bor12 p-b-13">
					<div class="size-208">
						<span class="stext-110 cl2">
							Subtotal:
						</span>
					</div>

					<div class="size-209" >
						<span class="mtext-110 cl2" id="subTotalCompra">
							<?= FormatMoney($subTotal); ?>
						</span>
					</div>

					<div class="size-208">
						<span class="stext-110 cl2">
							Envío:
						</span>
					</div>

					<div class="size-209">
						<span class="mtext-110 cl2">
							<?= FormatMoney(COSTOENVIO); ?>
						</span>
					</div>
				</div>

				<div class="flex-w flex-t p-t-27 p-b-33">
					<div class="size-208">
						<span class="mtext-101 cl2">
							Total:
						</span>
					</div>

					<div class="size-209 p-t-1">
						<span class="mtext-110 cl2" id="totalCompra">
							<?= FormatMoney($total); ?>
						</span>
					</div>
				</div>
				<?php
				if (isset($_SESSION['login'])) {
				?>
				
				<div id="divMetodoPago" class="notBlock">
				<hr>
					<div id="divCondiciones">
						<input type="checkbox" id="condiciones"></input>
						<label for="condiciones"> Aceptar </label>
						<a href="#" data-toggle="modal" data-target="#modalTerminos"> Términos y Condiciones</a>
					</div>
					<div id="optMetodoPago" class="notBlock">
						<hr>
						<h4 class="mtext-109 cl2 p-b-30"> Método de pago</h4>
						<div class="metodosPago">
							<label for="mercadopago">
								<input type="radio" id="mercadopago" class="methodpago" name="payment-method" checked="" value="MercadoPago">
								<img src="<?=media();?>/images/img-mercadoPago.png" alt="Icono de Mercado Pago" class="ml-space-sm" width="74" heigth="20">
							</label>
						</div>
						<div class="metodosPago">
							<label for="paypal">
								<input type="radio" id="paypal" class="methodpago" name="payment-method" value="Paypal">
								<img src="<?=media();?>/images/img-paypal.jpg" alt="Icono de paypal" class="ml-space-sm" width="74" heigth="20">
							</label>
						</div>
						<div class="metodosPago">
							<label for="contraentrega">
								<input type="radio" id="contraentrega" class="methodpago" name="payment-method" value="CT">
								<span>Contra Entrega</span>
							</label>
						</div>
						<div id="divtipopago" class="notBlock">
							<label for="listTipoPago">Tipo de pago</label>
							<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
								<select id="listTipoPago" class="js-select2" name="listTipoPago">
								<?php
								if(count($data['tiposPago'])>0){
									foreach ($data['tiposPago'] as $tipoPago) {
										if($tipoPago['tipopago'] != 'PayPal' && $tipoPago['tipopago'] != 'Mercado Pago'){

								?>
									<option value="<?=$tipoPago['idtipopago'];?>"><?=$tipoPago['tipopago'];?></option>
								<?php
										}
									}
								}
								?>
								</select>
								<div class="dropDownSelect2"></div>
							</div>
							<hr>
							<br>
							<button id="btnComprar" type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
								Pagar
							</button>
						</div>
						<div id="msgpaypal" class="notBlock">
							<p>Para completar la transacción, te enviaremos a los servidores seguros de Paypal. Recuerda que el cobro, por este medio de pago se realiza en dólares.</p>
							<br>
							<div id="paypal-btn-container"></div>
						</div>
						<div id="msgmercadopago">
							<p>Para completar la transacción, te enviaremos a los servidores seguros de Mercado.</p>
							<br>
							<div class="mercadopago-btn-container"></div>
						</div>
					</div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<?php 

if(isset($_SESSION['login'])){
	$totalpp = round(CambioMoneda($total, 'COP', 'USD')->result,2);?>
<script>
	paypal.Buttons({
		createOrder: function(data, actions){
	  	return actions.order.create({
	    	purchase_units: [{
	      		amount: {
	        	value: <?=$totalpp;?>
	      		},
	      		description: "Compra de artículos en <?=NOMBRE_EMPRESA;?> por USD<?=FormatMoney($totalpp);?>."
	    	}]
	  	});
	},
	onApprove: function(data, actions){
	  	return actions.order.capture().then(function(details) {
	    	let BaseUrl = "<?= BaseUrl();?>";
	    	let dir = document.querySelector("#txtDireccion").value;
	    	let ciudad = document.querySelector("#txtCiudad").value;
	    	let intTipoPago = 1; //paypal
	    	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
			let ajaxUrl = BaseUrl+'/Tienda/ProcesarVenta';
			let formData = new FormData();
			formData.append('direccion',dir);
			formData.append('ciudad',ciudad);
			formData.append('inttipopago',intTipoPago);
			formData.append('datapay',JSON.stringify(details));
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState != 4) return;
				if(request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						window.location = BaseUrl+"/tienda/ConfirmarPedido/";
					}else
					{
						swal("", objData.msg, "error");
					}
				}
				return false;
			}
	  });
	}
	}).render('#paypal-btn-container');
	
	const mp = new MercadoPago('<?=KEYPUBLICMERCADOPAGO;?>', {
		locale: 'es-CO'
	});

	mp.checkout({
		preference: {
		  id: '<?= $preference->id;?>'
		},
		render: {
		  container: '.mercadopago-btn-container',
		  label: 'Pagar',
		},
	    theme: {
	    	elementsColor: '#6B2737',
	    	headerColor: '#6B2737'
	    }
	});
</script>
<?php }?>
<?php FooterTienda($data);?>