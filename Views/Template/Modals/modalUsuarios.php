<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="formUsuario" name="formUsuario" class="form-horizontal">
            <input type="hidden" name="idUsuario" id="idUsuario" value="">
            <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
            <div class="form-row">
       			<div class="form-group col-md-6">
	             	<label for="txtIdentificacion">Identificación <span class="required">*</span></label>
	             	<input class="form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación del usuario" required>
	            </div>     	
            </div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtNombres">Nombres <span class="required">*</span></label>
	              <input class="form-control valid validText" id="txtNombres" name="txtNombres" type="text" placeholder="Nombres del usuario" required>
	            </div>
	            <div class="form-group col-md-6">
	              <label for="txtApellidos">Apellidos <span class="required">*</span></label>
	              <input class="form-control valid validText" id="txtApellidos" name="txtApellidos" type="text" placeholder="Apellidos del usuario" required>
	            </div>		
       		</div>
        	
       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtTelefono">Teléfono <span class="required">*</span></label>
	              <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono del usuario" onkeypress="return ControlTag(event);" required>
	            </div>
	            <div class="form-group col-md-6">
	              <label for="txtEmail">Correo <span class="required">*</span></label>
	              <input class="form-control valid validEmail" id="txtEmail" name="txtEmail" type="email" placeholder="Correo del usuario" required>
	            </div>		
       		</div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
	            	<label for="listRolId">Tipo usuario <span class="required">*</span></label>
	              	<select class="form-control" data-live-search="true" id="listRolId" name="listRolId" required>
	              	</select>
	            </div>
	            <div class="form-group col-md-6">
	              	<label for="listStatus">Estado <span class="required">*</span></label>
	              	<select class="form-control selectpicker" id="listStatus" name="listStatus" required>
	                	<option value="1">Activo</option>
	                	<option value="2">Inactivo</option>
	              	</select>
	            </div>	
       		</div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtPassword">Password</label>
	              <input class="form-control" id="txtPassword" name="txtPassword" type="password" placeholder="Contraseña del usuario">
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


<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Identificación:</td>
                <td id="celIdentificacion"></td>
              </tr>
              <tr>
                <td>Nombres:</td>
                <td id="celNombres"></td>
              </tr>
              <tr>
                <td>Apellidos:</td>
                <td id="celApellidos"></td>
              </tr>
              <tr>
                <td>Teléfono:</td>
                <td id="celTelefono"></td>
              </tr>
              <tr>
                <td>Email (Usuario):</td>
                <td id="celEmail"></td>
              </tr>
              <tr>
                <td>Tipo Usuario:</td>
                <td id="celTipoUsuario"></td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado"></td>
              </tr>
              <tr>
                <td>Fecha Registro:</td>
                <td id="celFechaRegistro"></td>
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
