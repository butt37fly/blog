<main class="Content">

  <?php

  $pages = ["home", "category", "entry", "categories", "entries", "account"];

  if (!isset($_GET['page']))
    redirect_to();

  if (!in_array($_GET['page'], $pages)) {

    include 'inc/pages/404.php';

  }

  if ($_GET['page'] === "home") {

    include 'inc/pages/home.php';

  }

  if ($_GET['page'] === "category") {

    include 'inc/pages/category.php';

  }

  if ($_GET['page'] === "entry") {

    include 'inc/pages/entry.php';

  }

  if (is_user_logged()) {

    if ($_GET['page'] === "categories") {

      include 'inc/pages/admin/categories.php';

    }

    if ($_GET['page'] === "entries") {

      include 'inc/pages/admin/entries.php';

    }

    if ($_GET['page'] === "account") {

      include 'inc/pages/admin/account.php';

    }

  }

  ?>

</main>