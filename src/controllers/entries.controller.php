<?php

require_once '../db.php';
require_once '../functions.php';

custom_session_start();

if (isset($_GET['a']) && $_GET['a'] === "delete") {

  if (isset($_GET['id'])) {

    try {
      delete_entry($_GET['id']);
      server_says('custom', 'La entrada se ha eliminado exitosamente.');
    } catch (\Throwable $e) {
      server_says('e000');
    }

    redirect_to();

  }
}

if (isset($_POST['CreateEntry'])) {

  $title = trim($_POST['EntryTitle']);
  $slug = create_slug($title);
  $content = trim($_POST['EntryContent']);
  $user_id = $_SESSION['user']['id'];
  $category = $_POST['EntryCategory'];

  if (empty($title)) {
    server_says('e001', 'título');
    redirect_to('entries/');
  }

  if (empty($content)) {
    server_says('e001', 'contenido');
    redirect_to('entries/');
  }

  if (empty($category)) {
    server_says('e001', 'categoría');
    redirect_to('entries/');
  }

  if (exist_term($title, 'title', 'entries')) {
    server_says('e004', 'título');
    redirect_to();
  }

  if (!exist_term($user_id, 'id', 'users')) {
    server_says('custom', 'Algo ha salido mal, por favor cierra sesión y vuelve a ingresar.');
    redirect_to();
  }

  if (!exist_term($category, 'id', 'categories')) {
    server_says('custom', 'Parece que esta categoría no existe, por favor inténtalo de nuevo.');
    redirect_to('entries/');
  }

  try {
    create_entry([
      'category_id' => $category,
      'user_id' => $user_id,
      'title' => $title,
      'slug' => $slug,
      'content' => $content
    ]);
    server_says('custom', "La entrada <b>$title</b> ha sido creada correctamente.");
  } catch (\Throwable $e) {
    server_says('e000');
  }

  redirect_to('entries/');

}

if (isset($_POST['EditEntry'])) {

  $id = $_POST['EntryId'];
  $title = trim($_POST['EntryTitle']);
  $slug = create_slug($title);
  $content = trim($_POST['EntryContent']);
  $user_id = $_SESSION['user']['id'];
  $category = $_POST['EntryCategory'];

  $data = ['id' => $id, 'values' => []];

  if (empty($title)) {
    server_says('e001', 'título');
    redirect_to("entries/$id/");
  }

  if (empty($content)) {
    server_says('e001', 'contenido');
    redirect_to("entries/$id/");
  }

  if (empty($category)) {
    server_says('e001', 'categoría');
    redirect_to("entries/$id/");
  }

  if ( ! exist_term($title, 'title', 'entries', $id) && exist_term($title, 'title', 'entries')) {
    server_says('e004', 'título');
    redirect_to("entries/$id/");
  }
  
  if (!exist_term($user_id, 'id', 'users')) {
    server_says('custom', 'Algo ha salido mal, por favor cierra sesión y vuelve a ingresar.');
    redirect_to("entries/$id/");
  }
  
  if (!exist_term($category, 'id', 'categories')) {
    server_says('custom', 'Parece que esta categoría no existe, por favor inténtalo de nuevo.');
    redirect_to("entries/$id/");
  }
  
  $data['values']['title'] = $title;
  $data['values']['slug'] = $slug;
  $data['values']['content'] = $content;
  $data['values']['category_id'] = $category;

  try {
    update_entry($data);
    server_says('custom', "La entrada <b>$title</b> ha sido modificada correctamente.");
    redirect_to("entry/$slug/");

  } catch (\Throwable $e) {
    server_says('e000');
  }

  redirect_to("entries/$id/");

}

redirect_to();