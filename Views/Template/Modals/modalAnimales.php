<div class="modal fade" id="modalFormAnimal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Animal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAnimal" name="formAnimal" class="form-horizontal">
                    <input type="hidden" name="idAnimal" id="idAnimal" value="">
                    <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son
                        obligatorios.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Nombre Animal <span class="required">*</span></label>
                                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" required>
                                </div>

                               <!--<div class="form-group">
                                <label class="control-label">Descripción Animal</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"> </textarea>
                            </div>-->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="control-label">Genero<span class="required">*</span></label>
                                    <input class="form-control" id="txtGenero" name="txtGenero" type="text" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="listOrganizacionId">Organización<span class="required">*</span></label>
                                    <select class="form-control" data-live-search="true" id="listOrganizacionId"
                                        name="listOrganizacionId" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="listTipoAnimalId">Tipo animal <span class="required">*</span></label>
                                    <select class="form-control" id="listTipoAnimalId" name="listTipoAnimalId"
                                        data-live-search="true" required></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Fecha nacimiento</label>
                                    <input class="form-control" id="fechaNacimiento" name="fechaNacimiento" type="date">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleSelect1">Estado <span class="required">*</span></label>
                                    <select class="form-control selectpicker" id="listStatus" name="listStatus">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="btnActionForm"><i
                                            class="fa fa-fw fa-lg fa-check-circle"></i><span
                                            id="btnText">Guardar</span></button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger  btn-lg btn-block" type="button"
                                        data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i><span
                                            id="btnText">Cerrar</span></button>
                                </div>
                            </div>
                            <div id="form_alert"></div>
                        </div>

                    </div>

                    <div class="tile-footer">
                        <div class="form-group col-md-12">
                            <div id="containerGallery">
                                <span>Agregar foto (440 x 545)</span>
                                <button class="btnAddImage btn btn-info btn-sm" type="button"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                            <hr>
                            <div id="containerImage">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalViewAnimal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Código:</td>
                            <td id="celCodigo"></td>
                        </tr>
                        <tr>
                            <td>Nombre:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Organización:</td>
                            <td id="celOrganizacion"></td>
                        </tr>
                        <tr>
                            <td>Tipo animal:</td>
                            <td id="celTipoAnimal"></td>
                        </tr>
                        <tr>
                            <td>Género:</td>
                            <td id="celGenero"></td>
                        </tr>
                        <tr>
                            <td>Fecha nacimiento:</td>
                            <td id="celFechaNacimiento"></td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celEstado"></td>
                        </tr>
                        <tr>
                            <td>Fotos de referencia:</td>
                            <td id="celFotos"></td>
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