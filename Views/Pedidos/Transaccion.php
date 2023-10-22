<?php HeaderAdmin($data); 
$logo = $data['tipopago'] == "paypal" ? "img-paypal.jpg" : "img-mercadoPago.png";
?>
<div id="divModal"></div>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'];?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/pedidos"><?= $data['page_title'];?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <?php 
        //dep($data['objTransaccion']);
        if(empty($data['objTransaccion'])){
          ?>
          <p>Datos no encontrados</p>
          <?php
        }else
        {
          if(empty($data['objTransaccion']->transaccion))
          {
            $trs = $data['objTransaccion']->purchase_units[0];
            $cl = $data['objTransaccion']->payer;
            $idtransaccion = $trs->payments->captures[0]->id;
            $fecha = $trs->payments->captures[0]->create_time;
            $estado = $trs->payments->captures[0]->status;
            $monto =  $trs->payments->captures[0]->amount->value;
            $moneda =  $trs->payments->captures[0]->amount->currency_code;
            //Datos cliente
            $nombreCliente = $cl->name->given_name . ' '. $cl->name->surname;
            $emailCliente = $cl->email_address;
            $telCliente = $_SESSION['userData']['telefono'];
            $codCiudad = $cl->address->country_code;

            $direccion1 = $trs->shipping->address->address_line_1;
            $direccion2 = $trs->shipping->address->admin_area_1;
            $direccion3 = $trs->shipping->address->admin_area_2;
            $codPostal = $trs->shipping->address->postal_code;

            $correoComercio = $trs->payee->email_address;

            $descripcion = $trs->description;


            $totalCompra = $trs->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
            $comision = $trs->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
            $importeNeto = $trs->payments->captures[0]->seller_receivable_breakdown->net_amount->value;

            if($estado == "COMPLETED")
            {
              $estado = "COMPLETADO"; 
            }

            $reembolso = false;
            if (isset($trs->payments->refunds)) {
              $reembolso = true;
              $importeBruto = $trs->payments->refunds[0]->seller_payable_breakdown->gross_amount->value;
              $comision = $trs->payments->refunds[0]->seller_payable_breakdown->paypal_fee->value;
              $importeNeto = $trs->payments->refunds[0]->seller_payable_breakdown->net_amount->value;
              $fechaReembolso = $trs->payments->refunds[0]->update_time;
            }
          }else
          {
            $trs = $data['objTransaccion']->transaccion;
            $rs = $data['objTransaccion']->reembolso;
            $cl = $trs->additional_info->payer;
            $idtransaccion = $trs->id;
            $fecha = $data['objTransaccion']->date_created;
            $estado = $trs->status;
            $monto = $data['objTransaccion']->total_amount;
            $moneda =  $trs->currency_id;
            $nombreCliente = $cl->first_name . ' ' . $cl->last_name;
            $emailCliente = $trs->payer->email;
            $telCliente = $trs->payer->phone->number;
            $codCiudad = 'CO';

            $direccion1 = $_SESSION['userData']['direccionfiscal'];
            $direccion2 = "";
            $direccion3 = "";
            $codPostal = "";

            $correoComercio = $data['objTransaccion']->collector->email;

            $descripcion = $trs->description;

            $totalCompra = $monto;
            $comision = 0;
            $importeNeto = $monto-$comision;
            if($estado == "approved")
            {
              $estado = "APROBADO"; 
            }

            $reembolso = false;
            if (isset($rs[0])) {
              $estado = "REEMBOLSADO";
              $reembolso = true;
              $importeBruto = $rs[0]->amount_refunded_to_payer;
              $comision = 0;
              $importeNeto = $importeBruto-$comision;
              $fechaReembolso = $rs[0]->date_created;
            }
          }
        ?>
        <section class="invoice">
          <div class="row mb-4">
            <div class="col-6">
              <h2 class="page-header"><img style="width: 111px; height: 30px;" src="<?=media();?>/images/<?=$logo;?>"></h2>
            </div>
            <?php if(!$reembolso){
                if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['nombrerol'] != "Cliente"){
              ?>
            <div class="col-6 text-right">
              <?php if($data['tipopago'] == "paypal") {?>
                <button class="btn btn-outline-primary" onclick="fntTransaccionPP('<?=$idtransaccion;?>')"><i class="fa fa-reply-all" aria-hidden="true"></i>Hacer Reembolso</button>
              <?php }
              if($data['tipopago'] == "mercadopago") { ?>
                <button class="btn btn-outline-primary" onclick="fntTransaccionMP('<?=$idtransaccion;?>')"><i class="fa fa-reply-all" aria-hidden="true"></i>Hacer Reembolso</button>
            <?php } ?>
            </div>
            <?php  }
            } ?>
          </div>
          <div class="row invoice-info">
            <div class="col-4">
              <address><strong>Transacción: <?= $idtransaccion; ?></strong><br><br>
                <strong>Fecha: <?= $fecha; ?></strong><br>
                <strong>Estado: <?= $estado; ?></strong><br>
                <strong>Importe bruto: <?= FormatMoney($monto); ?></strong><br>
                <strong>Moneda: <?= $moneda; ?></strong><br>
              </address>
            </div>
            <div class="col-4">
              <address><strong>Enviado por: </strong><br><br>
                <strong>Nombre: </strong> <?= $nombreCliente;?> <br>
                <strong>Telefono: </strong> <?= $telCliente;?> <br>
                <strong>Dirección: </strong> <?= $direccion1;?> <br>
                <?=$direccion2. ', ' .$direccion3. ' ' .$codPostal;?> <br>
                <?=$codCiudad;?>
              </address>
            </div>
            <div class="col-4">
              <strong>Enviado a: </strong> <br><br>
              <strong>Email: </strong><?= $correoComercio;?> <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
            <?php if($reembolso){?>
              <table class="table table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>Movimiento</th>
                    <th class="text-right">Importe bruto</th>
                    <th class="text-right">Comisión</th>
                    <th class="text-right">Importe Neto</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?=$fechaReembolso.' Reembolso para '.$nombreCliente ?></td>
                    <td class="text-right">- <?=FormatMoney($importeBruto);?> <?=$moneda;?></td>
                    <td class="text-right">- <?=FormatMoney($comision);?> <?=$moneda;?></td>
                    <td class="text-right">- <?=FormatMoney($importeNeto);?> <?=$moneda;?></td>
                  </tr>
                  <?php if($_SESSION['userData']['nombrerol'] != "Cliente"){ ?>
                  <tr>
                    <td><?=$fechaReembolso?> Cancelación de la comisión</td>
                    <td class="text-right"><?=FormatMoney($comision);?> <?=$moneda;?></td>
                    <td class="text-right"><?=FormatMoney(0);?> <?=$moneda;?></td>
                    <td class="text-right"><?=FormatMoney($comision);?> <?=$moneda;?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            <?php } ?>
              <table class="table table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>Detalle Pedido</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">SubTotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?=$descripcion;?></td>
                    <td class="text-right">1</td>
                    <td class="text-right"><?=FormatMoney($monto)?> <?=$moneda;?></td>
                    <td class="text-right"><?=FormatMoney($monto)?> <?=$moneda;?></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-right">Total de la compra:</th>
                    <td class="text-right"><?=FormatMoney($monto);?> <?=$moneda;?></td>
                  </tr>
                </tfoot>
              </table>
              <?php if($_SESSION['userData']['nombrerol'] != "Cliente"){ ?>
              <table class="table table-sm">
                <thead class="thead-light">
                  <tr>
                    <th colspan="2">Detalles del pago</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="250"><strong>Total de la compra</strong></td>
                    <td><?=FormatMoney($totalCompra);?> <?=$moneda;?></td>
                  </tr>
                  <tr>
                    <td width="250"><strong>Comisión de la pasarela</strong></td>
                    <td>- <?=FormatMoney($comision);?> <?=$moneda;?></td>
                  </tr>
                  <tr>
                    <td width="250"><strong>Importe Neto</strong></td>
                    <td><?=FormatMoney($importeNeto);?> <?=$moneda;?></td>
                  </tr>
                </tbody>
              </table>
            <?php } ?>
            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
          </div>
        </section>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</main>
<?php FooterAdmin($data); ?> 