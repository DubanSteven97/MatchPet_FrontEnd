<div class="modal fade" id="modalFormOrganizacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Organización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formOrganizacion" name="formOrganizacion" class="form-horizontal">
                    <input type="hidden" name="idOrganizacion" id="idOrganizacion" value="">
                    <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son
                        obligatorios.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Nombre <span class="required">*</span></label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text"
                                placeholder="Nombre de la organización" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtTelefono">Teléfono</label>
                            <input class="form-control" id="txtTelefono" name="txtTelefono" type="text"
                                placeholder="Teléfono de la organización">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtDireccion">Dirección</label>
                            <input class="form-control" id="txtDireccion" name="txtDireccion" type="text"
                                placeholder="Dirección de la organización">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="listStatus" name="listStatus">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtDescripcion">Descripcion de la dirección</label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit" id="btnActionForm"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i><span
                                id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i><span id="btnText">Cerrar</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalViewOrganizacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la organización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombre:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Teléfono:</td>
                            <td id="celTelefono"></td>
                        </tr>
                        <tr>
                            <td>Dirección:</td>
                            <td id="celDireccion"></td>
                        </tr>
                        <tr>
                            <td>Descipción:</td>
                            <td id="celDescripcion"></td>
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


<div class="modal fade" id="modalViewUserByOrganizacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header headerRegister">
                <h5 class="modal-title">Usuarios de la organización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="table-responsive">
                            <table class="table" id="tableUsersByOrganizaciones">
                                <thead class="thead-warning">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Identificación</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>