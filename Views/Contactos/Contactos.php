<?php HeaderAdmin($data); ?>
<?php GetModal('modalMensaje',$data);?> 
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1>
        	<i class="fa fa-user-tag"></i> <?= $data['page_title'];?>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/contactos"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableContactos">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombres</th>
                      <th>Email</th>
                      <th>Fecha</th>
                      <td>Acciones</td>
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