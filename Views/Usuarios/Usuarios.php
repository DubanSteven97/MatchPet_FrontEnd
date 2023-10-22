<?php HeaderAdmin($data); ?>
<main class="app-content">
<?php GetModal('modalUsuarios',$data); ?>
    <div class="app-title">
      <div>
        <h1>
        	<i class="fa fa-user-tag"></i> <?= $data['page_title'];?>
          <?php if($_SESSION['permisosMod']['w']){?>
        	<button class="btn btn-primary" type="button" onclick="openModal();"><i class="fa-solid fa-circle-plus"></i> Nuevo</button>
          <?php }?>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/usuarios"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableUsuarios">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Rol</th>
                      <th>Status</th>
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