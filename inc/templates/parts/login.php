<form class="Form" method="POST" action="<?php echo SITE_URI ."c/account/" ?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Inicia sesión</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="loginEmail">Correo electrónico</label>
      <input class="Form__input Input" type="email" name="loginEmail" id="loginEmail" placeholder="myblog@gmail.com" autocomplete="on" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="loginPassword">Contraseña</label>
      <input class="Form__input Input" type="password" name="loginPassword" id="loginPassword" placeholder="yourpassword123!_" required>
    </section>
    <section class="Form__section">
      <input class="Form__submit Button" type="submit" name="Login" value="Ingresar">
    </section>
  </div>
</form>