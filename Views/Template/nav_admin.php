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
    <?php if(!empty($_SESSION['permisos']['Dashboard']['r'])){?>
    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>/Dashboard">
        <i class="app-menu__icon fa fa-dashboard"></i>
        <span class="app-menu__label">Dashboard</span>
      </a>
    </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos']['Usuarios']['r']) || !empty($_SESSION['permisos']['Roles']['r']) || !empty($_SESSION['permisos']['Modulos']['r'])){?>
    <li class="treeview">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
        <span class="app-menu__label">Seguridad</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <?php if(!empty($_SESSION['permisos']['Usuarios']['r'])){ ?>
        <li>
          <a class="treeview-item" href="<?=BaseUrl();?>/usuarios">
            <i class="icon fa fa-circle-o"></i> Usuarios
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos']['Roles']['r'])){?>
        <li>
          <a class="treeview-item" href="<?=BaseUrl();?>/roles">
            <i class="icon fa fa-circle-o"></i> Roles
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos']['Modulos']['r'])){?>
        <li>
          <a class="treeview-item" href="<?=BaseUrl();?>/Modulos">
            <i class="icon fa fa-circle-o"></i> Módulos
          </a>
        </li>
        <?php } ?>
      </ul>
    </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos']['Clientes']['r'])){?>
    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>/clientes">
        <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
        <span class="app-menu__label">Clientes</span>
      </a>
    </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos']['Productos']['r']) || !empty($_SESSION['permisos']['Categorias']['r'])){?>
    <li class="treeview">
    <a class="app-menu__item" href="#" data-toggle="treeview">
      <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
      <span class="app-menu__label">Tienda</span>
      <i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">
      <?php if(!empty($_SESSION['permisos']['Productos']['r'])){?>
      <li>
        <a class="treeview-item" href="<?=BaseUrl();?>/productos">
          <i class="icon fa fa-circle-o"></i> Productos
        </a>
      </li>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos']['Categorias']['r'])){?>
      <li>
        <a class="treeview-item" href="<?=BaseUrl();?>/categorias">
          <i class="icon fa fa-circle-o"></i> Categorias
        </a>
      </li>
      <?php } ?>
    </ul>
  </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos']['Pedidos']['r'])){?>
    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>/pedidos">
        <i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
        <span class="app-menu__label">Pedidos</span>
      </a>
    </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos']['Configuracion']['r'])){?>
            <li>
                <a class="app-menu__item" href="<?=BaseUrl();?>/configuraciones">
                    <i class="app-menu__icon fa fa-cog" aria-hidden="true"></i>
                    <span class="app-menu__label">Configuración</span>
                </a>
            </li>
            <?php } ?>
    <li>
      <a class="app-menu__item" href="<?=BaseUrl();?>/Logout">
        <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
        <span class="app-menu__label">Cerrar Sesión</span>
      </a>
    </li>
  </ul>
</aside>