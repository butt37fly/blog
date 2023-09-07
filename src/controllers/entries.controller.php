<?php 

require_once '../db.php';
require_once '../functions.php';

custom_session_start();

if( isset( $_POST['CreateEntry'] )){

  $title = trim($_POST['EntryTitle']);
  $content = trim($_POST['EntryContent']);
  $user_id = $_SESSION['user']['id'];
  $category = $_POST['EntryCategory'];

  if( empty( $title ) ){
    server_says( 'e001', 'título' );
    redirect_to('entries/');
  }

  if( empty( $content ) ){
    server_says( 'e001', 'contenido' );
    redirect_to('entries/');
  }
  
  if( empty( $category ) ){
    server_says( 'e001', 'categoría' );
    redirect_to('entries/');
  }
  
  if( exist_term( $title, 'title', 'entries' ) ){
    server_says( 'e004', 'título' );
    redirect_to();
  }
  
  if( ! exist_term( $user_id, 'id', 'users' ) ){
    server_says( 'custom', 'Algo ha salido mal, por favor cierra sesión y vuelve a ingresar.');
    redirect_to();
  }

  if( ! exist_term( $category, 'id', 'categories' ) ){
    server_says( 'custom', 'Parece que esta categoría no existe, por favor inténtalo de nuevo.');
    redirect_to('entries/');
  }

  try{
    create_entry([
      'category_id' => $category,
      'user_id' => $user_id,
      'title' => $title,
      'content' => $content
    ]);
    server_says( 'custom', "La entrada $title ha sido creada correctamente." );
  } catch ( \Throwable ){
    server_says( 'e000' );
  }

  redirect_to( 'entries/' );

}

redirect_to();