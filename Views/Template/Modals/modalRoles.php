<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="formRol" name="formRol" class="form-horizontal">
            <input type="hidden" name="idrol" id="idrol" value="">
            <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
            <div class="form-row">
       			<div class="form-group col-md-6">
	             	<label for="txtNombre">Nombre<span class="required">*</span></label>
	             	<input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del rol" required>
	            </div>     	
            </div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtDescripcion">Descripción<span class="required">*</span></label>
	              <input class="form-control valid validText" id="txtDescripcion" name="txtDescripcion" type="text" placeholder="Descripción del rol" >
	            </div>	
       		</div>
        	
       		<div class="form-row">
	            <div class="form-group col-md-6">
	              	<label for="listStatus">Estado <span class="required">*</span></label>
	              	<select class="form-control form-select" id="listStatus" name="listStatus" >
	                	<option value="1">Activo</option>
	                	<option value="2">Inactivo</option>
	              	</select>
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