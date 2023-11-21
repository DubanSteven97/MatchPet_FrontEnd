<?php
$transaccion = $data['transaccion'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orden</title>
	<style type="text/css">
		p{
			font-family: arial;letter-spacing: 1px;color: #7f7f7f;font-size: 10px;
		}

		hr{
			border: 0;border-top: 1px solid #CCC;
		}

		h4{
			font-family: arial; margin: 0;
		}
		table{
			width: 100%; max-width: 650px; margin: 10px auto; border: 1px solid #CCC;border-spacing: 0; 
		}

		table tr td, table tr th{
			padding: 5px 10px; font-family: arial; font-size: 12px
		}

		#detalleOrden tr td{
			border: 1px solid #CCC;
		}

		.table-active{
			background-color: #CCC;
		}

		.text-center{
			text-align: center;
		}

		.text-right{
			text-align: right;
		}

		@media screen and (max-width: 470px) {
			.logo{
				width: 90px;
			}
			p, table tr td, table tr th {
				font-style: 9px;
			}
		}

	</style>
</head>
<body>
	<div>
		<p class="text-center">
			<?=$data['asunto'];?>
		</p>
		<br>
		<hr>
		<br>
		<table>
			<tr>
				<td width="33.33%">
					<img  class="logo" src="<?=media();?>/images/logo-01.png" alt="Logo">
				</td>
				<td width="33.33%">
					<div class="text-center">
						<h4><strong><?=NOMBRE_EMPRESA; ?></strong></h4>
						<p> 
							<?=DIRECCION_EMPRESA;?> <br>
							Teléfono: <?=TELEFONO_EMPRESA;?> <br>
							Email: <?=EMAIL_EMPRESA;?>
						</p>
					</div>
				</td>
				<td width="33.33%">
					<div class="text-right">
						<p>
							No. transaccion: <strong><?=$transaccion['idtransaccion'];?></strong> <br>
							Fecha: <?=date("d-m-Y h:i:s")?><br>
						</p>
					</div>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td width="140"> Nombre:</td>
				<td><?=$_SESSION['userData']['nombres'];?> <?=$_SESSION['userData']['apellidos'];?></td>
			</tr>
			<tr>
				<td>Teléfono:</td>
				<td><?=$_SESSION['userData']['telefono'];?></td>
			</tr>
			<tr>
				<td>Monto:</td>
				<td><?=$transaccion['monto'];?></td>
			</tr>
		</table>

		
		<br>
		<div class="text-center">
			<p>Si tienes preguntas sobre tu donacion, <br> Ponte en contacto con nombre, teléfono y Email </p>
			<h4>¡Gracias por tu aporte!</h4>
		</div>
	</div>
</body>
</html>