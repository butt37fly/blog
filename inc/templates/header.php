<?php
  require_once 'src/db.php'; 
  require_once 'src/functions.php'; 
  custom_session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog</title>
  <link rel="stylesheet" href="<?php echo SITE_URI ."assets/css/style.css"?>">
</head>
<body>
  <section class="Main">
    <header class="Header">
      <section class="Header__wrapper">
        <h1 class="Header__title Title">My Blog</h1>
      </section>
      <section class="Header__wrapper Header__wrapper--bottom">

        <?php include('parts/nav.php'); ?>
        
        <form class="Searchbar">
          <input class="Searchbar__input Input" type="text" name="Searchbar" id="Searchbar" placeholder="Busca tu juego favorito">
          <button class="Searchbar__button" type="submit"> X </button>
        </form>
      </section>
    </header>