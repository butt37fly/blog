<section class="Profile">
  <div class="Profile__wrapper">
    <h3 class="Profile__title Text"> 
      ¡Bienvenido de nuevo, <span class="Profile__name"><?php echo $_SESSION['user']['username'];?></span>!
    </h3>
    <div class="Profile__actions">
      <a class="Profile__button Button" href="">Añadir entrada</a>
      <a class="Profile__button Button" href="">Datos personales</a>
      <a class="Profile__button Button Button--dark" href="<?php echo SITE_URI ."account/logout/"?>">Cerrar sesión</a>
    </div>
  </div>
</section>