<?php

$entry = get_entries(null, null, $_GET['id']);
$entry = $entry[0];

$post_title = $entry->title;
$post_content = $entry->content;
$post_category = $entry->category; ?>

<form class="Form" method="POST" action="<?php echo SITE_URI . "c/entry/" ?>">
  <input type="hidden" name="EntryId" value="<?php echo $_GET['id']?>">
  <div class="Form__wrapper">
    <h3 class="Form__title Text">Editar entrada</h3>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryTitle">Título</label>
      <input class="Form__input Input" type="text" name="EntryTitle" id="EntryTitlte" placeholder="Nueva entrada"
        required value="<?php echo $post_title ?>">
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryContent">Contenido</label>
      <textarea class="Form__textarea Textarea" name="EntryContent" id="EntryContent" rows="10"
        required><?php echo $post_content ?></textarea>
    </section>
    <section class="Form__section">
      <label class="Form__label Label" for="EntryCategory">Categoría</label>
      <select class="Form__select Select" name="EntryCategory" id="EntryCategory" required>

        <?php foreach (get_categories() as $category):
          $selected = $post_category == $category->name ? "selected" : ""; ?>

          <option value="<?php echo $category->id ?>" <?php echo $selected ?>>
            <?php echo $category->name ?>
          </option>

        <?php endforeach; ?>

      </select>
    </section>
    <section class="Form__section">
      <input class="Form__submit Button" type="submit" name="EditEntry" value="Editar entrada">
    </section>
  </div>
</form>