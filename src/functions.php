<?php

define('SITE_URI', 'http://localhost/blog/');

function custom_session_start()
{
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
}

function redirect_to($url = SITE_URI . "home/" )
{
  header("Location: $url");
  die();
}

function server_says($code, $value = "")
{
  $server_codes = array(
    "e001" => "El campo <b>$value</b> está vacío.",
    "e002" => "Debe ingresar un email válido.",
    "e003" => "Las contraseñas no coinciden.",
    "e004" => "Este <b>$value</b> ya se encuentra registrado.",
    "e005" => "El nombre de usuario debe contener entre <b>6 y 15 carácteres</b>, sólo puedes usar letras, números y los símbolos: '@', '_'.",
    "e006" => "La contraseña debe contener mínimo <b>6</b> carácteres, sólo puedes usar letras, números y los símbolos: '.', '-', '_', '@', '!', '#', '$'.",
    "e007" => "El correo y la contraseña no coinciden."
  );

  $msg = $server_codes[$code] ?? "";

  custom_session_start();

  if (!isset($_SESSION['server_says'])) {
    $_SESSION['server_says'] = [];
  }

  if (in_array($msg, $_SESSION['server_says']))
    return;

  $_SESSION['server_says'][] = $msg;

}

function set_server_msg($data)
{
  foreach ($data as $value) {
    server_says($value);
  }
}

function get_server_says()
{
  custom_session_start();
  $html = "";

  if (isset($_SESSION['server_says'])) {

    foreach ($_SESSION['server_says'] as $msg) {
      $html .= "<div class='Alerts__item'><span class='Alerts__text'>$msg</span></div>";
    }

    $_SESSION['server_says'] = [];
    return $html;
  }
}

function validate_input($input, $type)
{

  if ($type === "username") {
    $is_lengthy = strlen($input) >= 6;
    $is_valid = preg_match('/^([a-zA-Z(0-9)_@]){6,15}$/', $input);

    return $is_lengthy && $is_valid;
  }

  if ($type == "password") {
    $is_lengthy = strlen($input) >= 6;
    $is_password = preg_match('/^([a-zA-Z(0-9).-_@!#$]){6,}$/', $input);

    return $is_lengthy && $is_password;
  }

}

function exist_term($input, $term)
{
  global $pdo;

  $query = "SELECT $term FROM users WHERE $term = :input";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':input', $input);
  $sth->execute();
  $result = $sth->fetch();

  return $result ?? false;
}

function create_user($data)
{
  global $pdo;

  $query = "INSERT INTO users ( username, email, password, reg_date ) VALUES (:username, :email, :password, curdate())";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':username', $data['username'], PDO::PARAM_STR);
  $sth->bindValue(':email', $data['email'], PDO::PARAM_STR);
  $sth->bindValue(':password', $data['password'], PDO::PARAM_STR);
  $sth->execute();
}

function login_user($data)
{
  global $pdo;

  $output = [];

  $query = "SELECT username, email, password FROM users WHERE email = :email";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':email', $data['email']);

  try {
    $sth->execute();
    $result = $sth->fetch();
    $is_correct_password = password_verify($data['password'], $result->password);

    if ($is_correct_password) {
      $output = [
        'username' => $result->username,
        'email' => $result->email
      ];
    }

    return $output;

  } catch (\Throwable $e) {

    print_r($e);
  }
}

function is_user_logged()
{
  custom_session_start();

  return isset($_SESSION['user']) && isset($_SESSION['user']['logged']);
}

function display_categories()
{
  global $pdo;

  $html = "";
  $query = "SELECT * FROM categories";
  $sth = $pdo->prepare($query);
  $sth->execute();
  $result = $sth->fetchAll();

  $categories = $result ?? [];

  foreach ($categories as $category) {
    $html .= "<li class='Nav__item'><a href='" . SITE_URI . "category/$category->slug/' class='Link'>$category->name</a></li>";
  }

  return $html;
}

function get_entries($limit = null)
{
  global $pdo;

  $query = "SELECT c.name as 'category', c.slug as 'slug', u.username as 'author', e.title, e.content, e.post_date as 'date'
  FROM entries e
  INNER JOIN categories c
  ON c.id = e.category_id
  INNER JOIN users u
  ON u.id = e.user_id
  ORDER BY e.post_date DESC";

  if( $limit != null && $limit > 0 ) $query .= " LIMIT $limit";
  
  $sth = $pdo->prepare( $query );
  $sth->execute();
  $result = $sth->fetchAll();

  return $result;
}