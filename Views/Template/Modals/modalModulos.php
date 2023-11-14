<div class="modal fade" id="modalFormModulo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Módulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="formModulo" name="formModulo" class="form-horizontal">
            <input type="hidden" name="idModulo" id="idModulo" value="">
            <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
         		<div class="form-row">
       			  <div class="form-group col-md-6">
	             	<label for="txtTitulo">Título <span class="required">*</span></label>
	             	<input class="form-control" id="txtTitulo" name="txtTitulo" type="text" placeholder="Nombre del módulo" required>
	            </div>     	
  	           <div class="form-group col-md-6">
  	              <label for="txtIcono">Icono <span class="required">*</span></label>
  	              <input class="form-control" id="txtIcono" name="txtIcono" type="text" placeholder="Ícono del módulo" required>
  	           </div>	
               <div class="form-group col-md-6">
                <label for="txtRuta">Ruta</label>
                <input class="form-control" id="txtRuta" name="txtRuta" type="text" placeholder="Ruta del módulo" required>
              </div>      
               <div class="form-group col-md-6">
                  <label for="exampleSelect1">Estado <span class="required">*</span></label>
                  <select class="form-control selectpicker" id="listStatus" name="listStatus">
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>	
         			<div class="form-group col-md-12">
  	              <label for="txtDescripcion">Descripcion <span class="required">*</span></label>
  	              <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
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


<div class="modal fade" id="modalViewModulo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Modulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Titulo:</td>
                <td id="celTitulo"></td>
              </tr>
              <tr>
                <td>Descripcion:</td>
                <td id="celDescripcion"></td>
              </tr>
              <tr>
                <td>Icono:</td>
                <td id="celIcono"></td>
              </tr>
              <tr>
                <td>Ruta:</td>
                <td id="celRuta"></td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado"></td>
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