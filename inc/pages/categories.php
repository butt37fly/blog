<form class="Form" method="POST" action="<?php echo SITE_URI ."c/category/" ?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Crear categoría</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="CategoryName">Nombre</label>
      <input class="Form__input Input" type="text" name="CategoryName" id="CategoryName" placeholder="Mi categoría" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="CategorySlug">Slug (opcional)</label>
      <input class="Form__input Input" type="text" name="CategorySlug" id="CategorySlug" placeholder="mi-categoria">
    </section>
    <section class="Form__section">
      <input class="Form__submit Button" type="submit" name="CreateCategory" value="Crear categoría">
    </section>
  </div>
</form>