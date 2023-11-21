<?php 
	HeaderHome($data);
?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">Gracias por tu Donación</h1>
  <p class="lead">Transacción procesada exitosamente</p>
  <p>No. Transacción: <strong> <?=$data['orden']; ?> </strong></p>

  <?php
  if(!empty($data['transaccion']))
  {
  	?>
  	<p>Transacción: <strong><?=$data['transaccion']; ?></strong></p>
  	<?php
  }

  ?>
  <hr class="my-4">
  <p>Muy pronto estaremos en contacto para contarte en qué ayusate.</p>
  <p>Puedes ver un consolidado de tus donaciones en el dashboard</p>
  <br>
  <a class="btn btn-primary btn-lg" href="<?=BaseUrl();?>" role="button">Continuar</a>
</div>

<?php FooterHome($data);?>