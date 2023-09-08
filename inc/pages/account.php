<?php custom_session_start(); ?>

<form class="Form" method="POST" action="<?php echo SITE_URI ."c/account/" ?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Actualizar datos</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="UpdateUsername">Nombre de usuario</label>
      <input class="Form__input Input" type="text" name="UpdateUsername" id="UpdateUsername" placeholder="pepito_rodriguez123" value="<?php echo $_SESSION['user']['username']; ?>">
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="UpdateEmail">Correo electrónico</label>
      <input class="Form__input Input" type="email" name="UpdateEmail" id="UpdateEmail" placeholder="myblog@gmail.com" value="<?php echo $_SESSION['user']['email']; ?>">
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="UpdateCurrentPassword">Contraseña actual</label>
      <input class="Form__input Input" type="password" name="UpdateCurrentPassword" id="UpdateCurrentPassword">
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="UpdatePassword">Contraseña nueva</label>
      <input class="Form__input Input" type="password" name="UpdatePassword" id="UpdatePassword" placeholder="yourpassword123!_" >
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="UpdatePasswordRep">Repite tu Contraseña</label>
      <input class="Form__input Input" type="password" name="UpdatePasswordRep" id="UpdatePasswordRep" placeholder="yourpassword123!_" >
    </section>
    <section class="Form__section">
    <input class="Form__submit Button" type="submit" name="Update" value="Actualizar cuenta">
    </section>
  </div>
</form>