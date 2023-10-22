<?php HeaderAdmin($data); ?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-file-text-o"></i> <?= $data['page_tag'];?></h1>
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
        if(empty($data['arrPedido'])){
          ?>
          <p>Datos no encontrados</p>
          <?php
        }else
        {
          $cliente = $data['arrPedido']['cliente'];
          $orden = $data['arrPedido']['orden'];
          $detalle = $data['arrPedido']['detalle'];
          $transaccion = $orden['idtransaccion'] != "" ?
                          $orden['idtransaccion'] :
                          $orden['referenciacobro'];
        ?>
        <section class="invoice">
          <div class="row mb-4">
            <div class="col-6">
              <h2 class="page-header"><img src="<?=media();?>/images/loguito.png"></h2>
            </div>
            <div class="col-6">
              <h5 class="text-right">Fecha: <?=$orden['fecha']?></h5>
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-4">
              <address><strong><?= NOMBRE_EMPRESA; ?></strong><br>
                <?= DIRECCION_EMPRESA; ?><br>
                <?= TELEFONO_EMPRESA; ?><br>
                <?= EMAIL_EMPRESA; ?><br>
                <?= WEB_EMPRESA; ?></address>
            </div>
            <div class="col-4">
              <address><strong><?=$cliente['nombres'];?> <?=$cliente['apellidos'];?></strong><br>
                Envío: <?=$orden['direccion_envio'];?><br>
                Teléfono: <?=$cliente['telefono'];?><br>
                Email: <?=$cliente['email_user'];?><br>

              </address>
            </div>
            <div class="col-4">
                <b>Orden #<?=$orden['idpedido'];?></b> <br>
                <b>Pago:</b> <?=$orden['tipopago'];?><br>
                <b>Transacción:</b> <?=$transaccion;?><br>
                <b>Estado:</b> <?=$orden['status'];?><br>
                <b>Monto:</b> <?=FormatMoney($orden['monto']);?><br>
              </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Descripción</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Importe</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $subtotal = 0;
                  if(count($detalle)>0)
                  {
                    foreach ($detalle as $producto) {
                      $subtotal+=$producto['precio']*$producto['cantidad'];
                ?>
                  <tr>
                    <td><?=$producto['producto'];?></td>
                    <td class="text-right"><?=FormatMoney($producto['precio']);?></td>
                    <td class="text-center"><?=$producto['cantidad'];?></td>
                    <td class="text-right"><?=FormatMoney($producto['precio']*$producto['cantidad']);?></td>
                  </tr>
                <?php
                    }
                  }
                ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-right">Sub-Total:</th>
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