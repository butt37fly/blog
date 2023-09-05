<main class="Content">

  <?php

  $pages = ["home", "categories"];

  if (!isset($_GET['page']))
    redirect_to();

  if (!in_array($_GET['page'], $pages)) {

    include 'inc/pages/404.php';

  }

  if ($_GET['page'] === "home") {

    include 'inc/pages/home.php';

  }

  if ($_GET['page'] === "categories") {

    if (is_user_logged()) {

      include 'inc/pages/categories.php';

    } else {

      redirect_to();

    }
  }

  ?>

</main>