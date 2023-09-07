<form class="Form" method="POST" action="<?php echo SITE_URI ."c/entry/" ?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Crear entrada</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryTitle">Título</label>
      <input class="Form__input Input" type="text" name="EntryTitle" id="EntryTitlte" placeholder="Nueva entrada" required>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryContent">Contenido</label>
      <textarea class="Form__textarea Textarea" name="EntryContent" id="EntryContent" rows="10" required ></textarea>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryCategory">Categoría</label>
      <select class="Form__select Select" name="EntryCategory" id="EntryCategory" required>

        <?php foreach( get_categories() as $category ):?>
          
          <option value="<?php echo $category->id?>"><?php echo $category->name?></option>
        
        <?php endforeach;?>

      </select>
    </section>
    <section class="Form__section">
      <input class="Form__submit Button" type="submit" name="CreateEntry" value="Crear entrada">
    </section>
  </div>
</form>