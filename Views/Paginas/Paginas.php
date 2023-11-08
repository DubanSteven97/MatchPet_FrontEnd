<?php HeaderAdmin($data); ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1>
        	<i class="fa fa-user-tag"></i> <?= $data['page_title'];?>
          <?php if($_SESSION['permisosMod']['w']){?>
          <a href="<?= BaseUrl() ?>/Paginas/Crear" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Crear Página</a>
          <?php }?>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/paginas"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tablePaginas">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Título</th>
                      <th>Fecha</th>
                      <th>Ruta</th>
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