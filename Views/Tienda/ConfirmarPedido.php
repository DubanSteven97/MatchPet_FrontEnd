<?php 
	HeaderTienda($data);
?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">Gracias por tu compra</h1>
  <p class="lead">Pedido procesado exitosamente</p>
  <p>No. Orden: <strong> <?=$data['orden']; ?> </strong></p>

  <?php
  if(!empty($data['transaccion']))
  {
  	?>
  	<p>Transacción: <strong><?=$data['transaccion']; ?></strong></p>
  	<?php
  }

  ?>
  <hr class="my-4">
  <p>Muy pronto estaremos en contacto para coordinar la entrega.</p>
  <p>Puedes ver el estado de tu pedido en la sección de <strong>Pedidos</strong> de tu usuario</p>
  <br>
  <a class="btn btn-primary btn-lg" href="<?=BaseUrl();?>" role="button">Continuar</a>
</div>

<?php FooterTienda($data);?>