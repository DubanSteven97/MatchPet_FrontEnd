<?php

$orden = $data['orden'];
$detalle = $data['detalle'];
$cliente = $data['cliente'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Factura</title>
	<style type="text/css">
		table{
			width: 100%;
		}
		table td, table th{
			font-size: 12px;
		}
		h4{
			margin-bottom: 0px;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.tbl-cliente{
			border: 1px solid #ccc;
			border-radius: 10px;
			padding: 5px;
		}
		.wd10{
			width: 10%;
		}
		.wd15{
			width: 15%;
		}
		.wd33{
			width: 33.33%;
		}
		.wd40{
			width: 40%;
		}
		.wd55{
			width: 55%;
		}
		.tbl-detalle{
			border-collapse: collapse;
		}
		.tbl-detalle thead th{
			padding: 5px;
			background-color: #009688;
			color: #FFF;
		}
		.tbl-detalle tbody td{
			padding: 5px;
			border-bottom: 1px solid #ccc;
		}
		.tbl-detalle tfoot td{
			padding: 5px;
		}
	</style>
</head>
<body>
	<table class="tbl-header">
		<tbody>
			<tr>
				<td class="wd33">
					<img  class="logo" src="<?=media();?>/images/logo-01.png" alt="Logo">
				</td>
				<td class="text-center wd33">
					<h4><strong><?=NOMBRE_EMPRESA; ?></strong></h4>
					<p> 
						<?=DIRECCION_EMPRESA;?> <br>
						Teléfono: <?=TELEFONO_EMPRESA;?> <br>
						Email: <?=EMAIL_EMPRESA;?>
					</p>
				</td>
				<td class="text-right wd33">
					<p>
						No. Orden: <strong><?=$orden['idpedido'];?></strong> <br>
						Fecha: <?=$orden['fecha'];?><br>
						Método de Pago: <?php if(empty($orden['idtransaccion'])) {echo "Contra Entrega";} else {echo $orden['tipopago'];}?> <br>
						Transacción: <?php if(empty($orden['idtransaccion'])) {echo $orden['tipopago'];} else {echo $orden['idtransaccion'];}?>  <br>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
<br>
	<table class="tbl-cliente">
		<tr>
			<td class="wd10">Nit:</td>
			<td class="wd40"><?=$cliente['nit'];?></td>
			<td class="wd10">Teléfono:</td>
			<td class="wd40"><?=$cliente['telefono'];?></td>
		</tr>
		<tr>
			<td>Nombre:</td>
			<td><?=$cliente['nombres'];?> <?=$cliente['apellidos'];?></td>
			<td>Dirección:</td>
			<td><?=$cliente['direccionfiscal'];?></td>
		</tr>
	</table>
<br>
	<table class="tbl-detalle">
		<thead class="table-active">
			<tr>
				<th class="wd55">Descripción</th>
				<th class="text-right wd15">Precio</th>
				<th class="text-center wd15">Cantidad</th>
				<th class="text-right wd15">Importe</th>
			</tr>
		</thead>
		<tbody id="detalleOrden">
			<?php
			if(count($detalle)>0){
				$subtotal = 0;
				$total = 0;
				foreach ($detalle as $producto) {
					$importe = $producto['precio']*$producto['cantidad'];
					$subtotal += $importe;
			?>
			<tr>
				<td><?=$producto['producto'];?></td>
				<td class="text-right"><?=FormatMoney($producto['precio']);?></td>
				<td class="text-center"><?=$producto['cantidad'];?></td>
				<td class="text-right"><?=FormatMoney($importe);?></td>
			</tr>
		<?php
				} 
			} ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3" class="text-right">Subtotal:</th>
				<td class="text-right"><?=FormatMoney($subtotal);?></td>
			</tr>
			<tr>
				<th colspan="3" class="text-right">Envío:</th>
				<td class="text-right"><?=FormatMoney($orden['costo_envio']);?></td>
			</tr>
			<tr>
				<th colspan="3" class="text-right">Total:</th>
				<td class="text-right"><?=FormatMoney($orden['monto']);?></td>
			</tr>
		</tfoot>
	</table>
	<br>
	<div class="text-center">
		<p>Si tienes preguntas sobre tu pedido, <br> Ponte en contacto con nombre, teléfono y Email </p>
		<h4>¡Gracias por tu compra!</h4>
	</div>
</body>
</html>