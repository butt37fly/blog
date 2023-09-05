<main class="Content">

  <?php

  if ( ! isset( $_GET['page'] )) redirect_to();

  if ($_GET['page'] === "home") {

    include 'inc/pages/home.php';
    
  }
  
  if ($_GET['page'] === "categories") {
    
    if (is_user_logged()) {
      
      include 'inc/pages/categories.php';

    }
  }

  ?>

</main>