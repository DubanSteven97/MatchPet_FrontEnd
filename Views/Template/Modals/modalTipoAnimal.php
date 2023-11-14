<div class="modal fade" id="modalFormTipoAnimal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo tipo de animal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="formTipoAnimal" name="formTipoAnimal" class="form-horizontal">
            <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
         	<div class="row">
         		<div class="col-md-6">
         			<input type="hidden" name="idTipoAnimal" id="idTipoAnimal" value="">
              <input type="hidden" name="foto_actual" id="foto_actual" value="">
              <input type="hidden" name="foto_remove" id="foto_remove" value="0">
	                <div class="form-group">
	                  <label class="control-label">Nombre <span class="required">*</span></label>
	                  <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre de categoría">
	                </div>
	                <div class="form-group">
	                  <label class="control-label">Descripción <span class="required">*</span></label>
	                  <textarea class="form-control" rows="2" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción de categoría"></textarea>
	                </div>
	                <div class="form-group">
	                  <label for="exampleSelect1">Estado <span class="required">*</span></label>
	                  <select class="form-control selectpicker" id="listStatus" name="listStatus">
	                    <option value="1">Activo</option>
	                    <option value="2">Inactivo</option>
	                  </select>
	                </div>
         		</div>
         		<div class="col-md-6">
         			<div class="photo">
					    <label for="foto">Foto (570x380) <span class="required">*</span></label>
					    <div class="prevPhoto">
					      <span class="delPhoto notBlock">X</span>
					      <label for="foto"></label>
					      <div>
					        <img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
					      </div>
					    </div>
					    <div class="upimg">
					      <input type="file" name="foto" id="foto">
					    </div>
					    <div id="form_alert"></div>
					</div>
         		</div>
         	</div>	
            
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit" id="btnActionForm"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i><span id="btnText">Cerrar</span></button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalViewTipoAnimal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de tipos de animales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>ID:</td>
                <td id="celId"></td>
              </tr>
              <tr>
                <td>Nombre:</td>
                <td id="celNombre"></td>
              </tr>
              <tr>
                <td>Descripción:</td>
                <td id="celDescripcion"></td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado"></td>
              </tr>
              <tr>
                <td>Foto:</td>
                <td id="imgAnimal"></td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
