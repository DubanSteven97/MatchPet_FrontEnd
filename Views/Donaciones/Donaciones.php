<?php HeaderAdmin($data); ?>
  <main class="app-content">
<?php GetModal('modalProcesoAdopcion',$data); ?>
    <div class="app-title">
      <div>
        <h1>
        	<i class="fa-solid fa-hand-holding-heart"></i> <?= $data['page_title'];?>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/Organizaciones"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableProcesosAdopcion">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Transacción</th>
                      <th>Amigo</th>
                      <th>Organización</th>
                      <th>Fecha</th>
                      <th>Monto</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </main>
<?php FooterAdmin($data); ?> 