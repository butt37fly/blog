<?php

$entries = get_entries();

if (empty($entries)): ?>

  <section class="Not-Found">
    <h1 class="Not-Found__title Title">
      Oops!, parece que aún no tenemos entradas :(
    </h1>
  </section>

<?php else:

  include 'inc/templates/parts/feed.php';

endif;