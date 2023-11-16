<div class="modal fade" id="modalProcesoAdopcion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gestión - Solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formProcesoAdopcion" name="formProcesoAdopcion" class="form-horizontal">
                    <input type="hidden" name="idProcesoAdopcion" id="idProcesoAdopcion" value="">
                    <input type="hidden" name="idAnimalProceso" id="idAnimalProceso" value="">
                    <p class="text-primary">Todos los campos con asterisco (<span class="required">*</span>) son
                        obligatorios.</p> <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="listStatus" name="listStatus">
                                <option value="1">Aprobado</option>
                                <option value="2">Rechazado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Descripción de la gestión <span
                                            class="required">*</span></label>
                                    <textarea class="form-control" id="txtDescripcion"
                                        name="txtDescripcion"> </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
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
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>