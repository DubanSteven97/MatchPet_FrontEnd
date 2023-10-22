<!DOCTYPE html>
<html>

<head>
    <title><?= $data['page_title'];?></title>
    <link rel="stylesheet" type="text/css" href="<?=media();?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=media();?>/css/styles.css">
    <script type="text/javascript" href="<?=media();?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" href="<?=media();?>/js/jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <meta charset="utf-8">
</head>

<body>
    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1><?= $data['page_tag'];?> Hola Mundo</h1><br>
                    <form class="row g-3" action="" id="formRegister" nombre="formRegister" >
                        <div class="col-12">
                            <label for="numero_identificacion" class="form-label">Número de identificación</label>
                            <input type="number" class="form-control" id="numero_identificacion"
                                name="numero_identificacion" pattern="^[0-9]+" required>
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" >
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" >
                            <label for="numero_telefono" class="form-label">Número de teléfono</label>
                            <input type="number" class="form-control" id="numero_telefono"
                                name="numero_telefono" pattern="^[0-9]+" required>
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo"
                                aria-describedby="emailHelp" required>
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" id="contrasena" class="form-control"
                                aria-describedby="passwordHelpBlock">
                        </div>

                        <div class="col-12">
                            <center> <button type="submit" class="btn btn-primary" id="registrarse"
                                    name="registrarse">Registrarse</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div><br>
    </main>

    
    <!-- Essential javascripts for application to work-->
    <script src="<?=media();?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?=media();?>/js/popper.min.js"></script>
    <script src="<?=media();?>/js/bootstrap.min.js"></script>
    <script src="<?=media();?>/js/fontawesome.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?=media();?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?=media();?>/js/plugins/pace.min.js"></script>
    <script src="<?=media();?>/js/<?= $data['page_functions_js']; ?>"></script>
<?php FooterTienda($data); ?>   