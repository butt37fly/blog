<main class="Content">

  <?php

  $pages = ["home", "categories", "entries", "account"];

  if (!isset($_GET['page']))
    redirect_to();

  if (!in_array($_GET['page'], $pages)) {

    include 'inc/pages/404.php';

  }

  if ($_GET['page'] === "home") {

    include 'inc/pages/home.php';

  }

  if ( is_user_logged() ){

    if ($_GET['page'] === "categories") {

      include 'inc/pages/categories.php';

    }

    if ($_GET['page'] === "entries") {

      include 'inc/pages/entries.php';

    }

    if ($_GET['page'] === "account") {

      include 'inc/pages/account.php';

    }

  } 

  ?>

</main>