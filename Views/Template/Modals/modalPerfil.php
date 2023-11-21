<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="formPerfil" name="formPerfil" class="form-horizontal">
            <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
            <div class="form-row">
       			<div class="form-group col-md-6">
	             	<label for="txtIdentificacion">Identificación <span class="required">*</span></label>
	             	<input class="form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación del usuario" required value="<?= $_SESSION['userData']['numero_identificacion']?>" readonly disabled>
	            </div>     	
            </div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtNombres">Nombres <span class="required">*</span></label>
	              <input class="form-control valid validText" id="txtNombres" name="txtNombres" type="text" placeholder="Nombres del usuario" required value="<?= $_SESSION['userData']['nombres']?>">
	            </div>
	            <div class="form-group col-md-6">
	              <label for="txtApellidos">Apellidos <span class="required">*</span></label>
	              <input class="form-control valid validText" id="txtApellidos" name="txtApellidos" type="text" placeholder="Apellidos del usuario" required value="<?= $_SESSION['userData']['apellidos']?>">
	            </div>		
       		</div>
        	
       		<div class="form-row">
       			<div class="form-group col-md-6">
	              <label for="txtTelefono">Teléfono <span class="required">*</span></label>
	              <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono del usuario" onkeypress="return ControlTag(event);" required value="<?= $_SESSION['userData']['telefono']?>">
	            </div>
	            <div class="form-group col-md-6">
	              <label for="txtEmail">Correo</label>
	              <input class="form-control valid validEmail" id="txtEmail" name="txtEmail" type="email" placeholder="Correo del usuario" required value="<?= $_SESSION['userData']['email']?>" readonly disabled>
	            </div>		
       		</div>

       		<div class="form-row">
       			<div class="form-group col-md-6">
              <label for="txtPassword">Password</label>
              <input class="form-control" id="txtPassword" name="txtPassword" type="password" placeholder="Contraseña del usuario">
            </div>
            <div class="form-group col-md-6">
              <label for="txtPasswordConfirm">Confirmar Password</label>
              <input class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" type="password" placeholder="Contraseña del usuario">
            </div>
	        </div>
            <div class="tile-footer">
              <button class="btn btn-info" type="submit" id="btnActionForm"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i><span id="btnText">Cerrar</span></button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>