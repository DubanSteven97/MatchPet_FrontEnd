<div class="modal fade" id="modalFormPQRS" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">PQRS: Peticiones, Quejas, Reclamos y Sugerencias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPQRS" name="formPQRS" class="form-horizontal">

                    <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son
                        obligatorios.</p>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="tipoPQRS">Tipo de solicitud: <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="tipoPQRS" name="tipoPQRS" required>
                                <option value="Peticion">Petición</option>
                                <option value="Queja">Queja</option>
                                <option value="Reclamo">Reclamo</option>
                                <option value="Sugerencia">Sugerencia</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlTextarea1">Hechos en que se fundamenta la Petición, Queja,
                                Reclamo o Sugerencias<span class="required">*</span></label>
                            <textarea class="form-control" id="razonPQRS" name="razonPQRS" rows="3"></textarea>
                        </div>
                    </div>
                    <h3 style="font-weight: bold">
                        Datos Personales
                    </h3>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Nombre<span class="required">*</span></label>
                            <input class="form-control valid validText" id="txtNombre" name="txtNombre"
                                type="text" placeholder="Apellidos del usuario" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidos">Apellidos<span class="required">*</span></label>
                            <input class="form-control valid validText" id="txtApellidos" name="txtApellidos"
                                type="text" placeholder="Apellidos del usuario" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="txtTelefono">Teléfono contacto<span class="required">*</span></label>
                            <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono"
                                type="text" placeholder="Teléfono del usuario" onkeypress="return ControlTag(event);"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtEmail">Correo contacto<span class="required">*</span></label>
                            <input class="form-control valid validEmail" id="txtEmail" name="txtEmail" type="email"
                                placeholder="Correo del usuario" required>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="button"  onclick="enviarModal()" id="btnActionForm"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i><span
                                id="btnText">Enviar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i><span id="btnText">Cerrar</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>