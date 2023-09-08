<?php

$title = $_GET['entry'] ?? null;
$entry = get_entries(null, null, $title);
$entry = $entry[0];

include 'inc/templates/parts/post.php';

if (user_owns_post()): ?>

<section class="Post__actions">
  <a href="" class="Post__action Button">Editar</a>
  <a href="<?php echo SITE_URI ."c/entry/delete/$entry->id/" ?>" class="Post__action Button Button--dark">Eliminar</a>
</section>

<?php endif ?>