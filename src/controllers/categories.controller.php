<?php

require_once '../db.php';
require_once '../functions.php';

if ( isset( $_POST['CreateCategory'] ) ){
 
  $name = trim($_POST['CategoryName']);
  $slug = trim($_POST['CategorySlug']);

  $slug = empty( $slug ) ? create_slug( $name ) : create_slug( $slug );
  
  if( empty( $slug) ){
    server_says( 'custom', "No se ha podido crear la categoría, intenta utilizar otro nombre y/u otro slug." );
    redirect_to( 'categories/' );
  }

  if (exist_term( $name, 'name', 'categories' )){
    server_says( 'e004', "nombre de categoría" );
    redirect_to( 'categories/' );
  }

  if (exist_term( $slug, 'slug', 'categories' )){
    server_says( 'e004', "slug" );
    redirect_to( 'categories/' );
  }

  try {
    create_category( ['name' => $name, 'slug' => $slug] );
  } catch (\Throwable $th) {
    server_says( 'e000' );
  }

  redirect_to( 'categories/' );
}

redirect_to();