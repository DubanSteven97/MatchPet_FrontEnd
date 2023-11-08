<?php HeaderAdmin($data); 
  $fotoActual = $data['infoPage']['portada'];
  $fotoRemove = 0;
  $imgPortada = $fotoActual != "" ? '<img id="img" src="'.Media().'/images/uploads/'.$fotoActual.'">' : "";

  $option = $data['infoPage']['status'];

  $pageRuta = BaseUrl().'/'.$data['infoPage']['ruta'];
?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1>
        	<i class="fa fa-file-text-o"></i> <?= $data['page_title'];?>
          <a href="<?= BaseUrl() ?>/Paginas/Crear" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Crear Página</a>
    	</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/paginas">Páginas</a> | <a href="<?= $pageRuta  ?>" target="_blanck" > <i class="fa fas fa-globe" aria-hidden="true"></i> Ver página </a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">

            <form id="formPaginas" name="formPaginas" class="form-horizontal">
              <input type="hidden" name="idPagina" id="idPagina" value="<?= $data['infoPage']['idpost']  ?>">
              <input type="hidden" name="foto_actual" id="foto_actual" value="<?= $fotoActual; ?>">
              <input type="hidden" name="foto_remove" id="foto_remove" value="0">
              <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                      <label class="control-label">Titulo <span class="required">*</span></label>
                      <input class="form-control" id="txtTitulo" name="txtTitulo" type="text" value="<?= $data['infoPage']['titulo']  ?>" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Contenido</label>
                      <textarea class="form-control" id="txtContenido" name="txtContenido" > <?= $data['infoPage']['contenido']  ?> </textarea>
                    </div>
                </div>
                <div class="col-md-2">
                    
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label for="exampleSelect1">Estado <span class="required">*</span></label>
                        <select class="form-control selectpicker" id="listStatus" name="listStatus">
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                     <div class="form-group col-md-12">
                        <button class="btn btn-primary btn-lg btn-block" type="submit" id="btnActionForm"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                     </div>
                    </div>
                  <div id="form_alert"></div>
                </div>
              </div>  
              
              <div class="tile-footer">
                <div class="form-group col-md-12">
                  <div id="containerGallery">
                    <h4>Portada</h4>
                    <span>Tamaño sugerido de (1920px X 239px)</span>
                    <button class="btnAddImage btn btn-info btn-sm" type="button"><i class="fas fa-plus"></i></button>
                  </div>
                  <hr>
                  <div id="containerImage">
                    <div class="photo">
                      <div class="prevPhoto prevPortada">
                        <span class="delPhoto">X</span>
                        <label for="foto"></label>
                        <div>
                          <?= $imgPortada;  ?>
                        </div>
                      </div>
                      <div class="upimg">
                        <input type="file" name="foto" id="foto">
                      </div>
                      <div id="form_alert"></div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </main>
<?php FooterAdmin($data); ?>   


<script type="text/javascript">
  document.querySelector("#listStatus").value = <?= $option?>;
</script>