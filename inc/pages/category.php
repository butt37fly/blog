<?php

$category = $_GET['category'] ?? null;
$entries = get_entries(null, $category);

if (empty($entries)): ?>

  <section class="Not-Found">
    <h1 class="Not-Found__title Title">
      Aún no hay entradas en esta categoría :(
    </h1>
  </section>

<?php else:

  include 'inc/templates/parts/feed.php';

endif;