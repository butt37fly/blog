<form class="Form" method="POST" action="<?php echo SITE_URI ."account/" ?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Regístrate</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="signInUsername">Nombre de usuario</label>
      <input class="Form__input Input" type="text" name="signInUsername" id="signInUsername" placeholder="pepito_rodriguez123" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="signInEmail">Correo electrónico</label>
      <input class="Form__input Input" type="email" name="signInEmail" id="signInEmail" placeholder="myblog@gmail.com" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="signInPassword">Contraseña</label>
      <input class="Form__input Input" type="password" name="signInPassword" id="signInPassword" placeholder="yourpassword123!_" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="signInPasswordRep">Contraseña</label>
      <input class="Form__input Input" type="password" name="signInPasswordRep" id="signInPasswordRep" placeholder="yourpassword123!_" required>
    </section>
    <section class="Form__section">
    <input class="Form__submit Button" type="submit" name="SignIn" value="Crear cuenta">
    </section>
  </div>
</form>