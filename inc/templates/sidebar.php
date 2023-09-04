<aside class="Sidebar">
  <section class="Sidebar__section">

    <?php

    if (is_user_logged()) {

      include('parts/profile.php');

    } else {

      include('parts/login.php');

      include('parts/signin.php');

    } ?>

  </section>
</aside>