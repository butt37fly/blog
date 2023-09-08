<section class="Profile">
  <div class="Profile__wrapper">
    <h3 class="Profile__title Text">
      ¡Bienvenido de nuevo, <span class="Profile__name">
        <?php echo $_SESSION['user']['username']; ?>
      </span>!
    </h3>
    <div class="Profile__actions">
      <a class="Profile__button Button" href="<?php echo SITE_URI . "entries/" ?>">Añadir entrada</a>
      <a class="Profile__button Button" href="<?php echo SITE_URI . "categories/" ?>">Añadir categoría</a>
      <a class="Profile__button Button" href="<?php echo SITE_URI . "account/" ?>">Actualizar datos</a>
      <a class="Profile__button Button Button--dark" href="<?php echo SITE_URI . "c/account/logout/" ?>">Cerrar sesión</a>
    </div>
  </div>
</section>