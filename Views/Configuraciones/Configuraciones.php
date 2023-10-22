<?php HeaderAdmin($data); ?>


<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cog"></i> <?= $data['page_title'];?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/dashboard"><?= $data['page_title'];?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form id="formEmpresa" name="formEmpresa">
                        <h2>Datos de la empresa</h2>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtDireccion">Dirección</label>
                                <input class="form-control" id="txtDireccion" name="txtDireccion" type="text"
                                    placeholder="Dirección" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="txtTelefono">Teléfono</span></label>
                                <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono"
                                    type="text" placeholder="Teléfono del usuario"
                                    onkeypress="return ControlTag(event);" disabled>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="txtEmailEmpresa">Correo empresa</label>
                                <input class="form-control valid validEmail" id="txtEmailEmpresa" name="txtEmailEmpresa"
                                    type="email" placeholder="Correo de la empresa" disabled>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="txtEmailPedidos">Correo pedidos</label>
                                <input class="form-control valid validEmail" id="txtEmailPedidos" name="txtEmailPedidos"
                                    type="email" placeholder="Correo para los pedidos" disabled>
                            </div>
                        </div>
                        <h2>Envió de correos</h2>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtNombreRemitente">Nombre remitente</label>
                                <input class="form-control" id="txtNombreRemitente" name="txtNombreRemitente"
                                    type="text" placeholder="Nombre del remitente" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="txtEmailRemitente">Correo remitente</label>
                                <input class="form-control valid validEmail" id="txtEmailRemitente"
                                    name="txtEmailRemitente" type="email" placeholder="Correo del remitente" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtNombreEmpresa">Nombre empresa</label>
                                <input class="form-control" id="txtNombreEmpresa" name="txtNombreEmpresa" type="text"
                                    placeholder="Nombre de la empresa" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="txtNombreAplicación"> Nombre aplicación</label>
                                <input class="form-control" id="txtNombreAplicación" name="txtNombreAplicación"
                                    type="text" placeholder="Nombre de la aplicación" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="txtSitioWeb">Sitio web</label>
                                <input class="form-control" id="txtSitioWeb" name="txtSitioWeb" type="text"
                                    placeholder="Url del sitio web" disabled>
                            </div>
                        </div>
                        <h2>Moneda</h2>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtSimboloMoneda">Símbolo moneda</label>
                                <input class="form-control" id="txtSimboloMoneda" name="txtSimboloMoneda"
                                    type="text" placeholder="Símbolo moneda" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="txtMoneda">Moneda</label>
                                <input class="form-control" id="txtMoneda"
                                    name="txtMoneda" type="text" placeholder="Moneda" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtDivisa">Divisa</label>
                                <input class="form-control" id="txtDivisa" name="txtDivisa" type="text"
                                    placeholder="Divisa" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="txtSeparadorDecimal">Separador de decimales</label>
                                <input class="form-control" id="txtSeparadorDecimal" name="txtSeparadorDecimal"
                                    type="text" placeholder="Separador de decimales" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="txtSeparadorMilesMillones">Separador de miles y millones</label>
                                <input class="form-control" id="txtSeparadorMilesMillones" name="txtSeparadorMilesMillones"
                                    type="text" placeholder="Separador de miles y millones" disabled>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="button" onClick="fntEditEmpresa()" id="editar"><i
                                    class="fa fa-fw fa-lg fa-pencil-alt"></i><span>Editar</span></button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn btn-danger" type="button" onClick="fntCancelEditEmpresa()"
                                id="cancelar" style="display:none"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i><span>Cancelar</span></button>&nbsp;&nbsp;&nbsp;
                            <?php
                            if($_SESSION['permisosMod']['u']){
                        ?>
                            <button class="btn btn-success" type="submit" disabled onClick="fntEditEmpresa()"
                                id="actualizar" style="display:none"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>
                            <?php
                            }
                        ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
<?php FooterAdmin($data); ?>
<script>
window.onload = fntViewEmpresa(<?= $data['codigo_empresa'];?>);
</script>