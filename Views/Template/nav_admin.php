<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?=media();?>/images/avatar.png" alt="User Image">
    <div>
      <p class="app-sidebar__user-name"><?=$_SESSION['userData']['nombres']; ?></p>
      <p class="app-sidebar__user-designation"><?=$_SESSION['userData']['nombreRol']; ?></p>
    </div>
  </div>
  <ul class="app-menu">
    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>" target="_blank">
        <i class="app-menu__icon fa fas fa-globe" aria-hidden="true"></i>
        <span class="app-menu__label">Ver sitio web</span>
      </a>
    </li>

      <?php
      if(isset($_SESSION['permisos'])){

          foreach ($_SESSION['permisos'] as $permiso) {
            if($permiso['r'])
            {
              ?>
              <li>
                <a class="app-menu__item" href="<?=BaseUrl();?>/<?=$permiso['ruta'];?>">
                <i class="<?=$permiso['icono'];?>"></i>
                  <span class="app-menu__label"><?=$permiso['modulo'];?></span>
                </a>
              </li>
              <?php
            }
          }
        
      }
      ?>

    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>/Logout">
        <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
        <span class="app-menu__label">Cerrar Sesión</span>
      </a>
    </li>
  </ul>
</aside>