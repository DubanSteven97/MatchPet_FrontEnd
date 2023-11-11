<?php HeaderAdmin($data); ?>
  <div id="contentAjax"></div>
  <main class="app-content">
<?php GetModal('modalAnimales',$data);?> 
    <div class="app-title">
      <div>
        <h1>
        	<i class="app-menu__icon fa-solid fa-paw"></i> <?= $data['page_title'];?>
          <?php if($_SESSION['permisosMod']['w']){?>
        	<button class="btn btn-primary" type="button" onclick="openModal();"><i class="fa-solid fa-circle-plus"></i> Nuevo</button>
          <?php }?>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/productos"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableAnimales">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Organización</th>
                      <th>Tipo animal</th>
                      <th>Género</th>
                      <th>Fecha nacimiento</th>
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