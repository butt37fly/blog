<?php

$not_found = "<section class='Not-Found'> <h1 class='Not-Found__title Text'>No hay resultados para <b>'$_GET[search]'</b></h1></section>";

if( isset($_GET['search']) ){

  $entries = get_entries_by_search($_GET['search']);

  
  if ( ! empty($entries) ){

    include 'inc/templates/parts/feed.php';

  }  else {

    echo $not_found; 

  }

} else {

  echo $not_found;   
  
}