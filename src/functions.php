<?php

############# Constants

define('SITE_URI', 'http://localhost/blog/');

############# General

function custom_session_start()
{
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
}

function redirect_to($page = "home/")
{
  $url = SITE_URI . "$page";

  header("Location: $url");
  die();
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

  if ($type == "slug") {
    $is_slug = preg_match('/^([a-z(0-9)-]){3,}$/', $input);

    return $is_slug;
  }

}

function exist_term($input, $term, $table)
{
  global $pdo;

  $query = "SELECT $term FROM $table WHERE $term = :input";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':input', $input);
  $sth->execute();
  $result = $sth->fetch();

  return $result ?? false;
}

function is_user_logged()
{
  custom_session_start();

  return isset($_SESSION['user']) && isset($_SESSION['user']['logged']);
}

function remove_accents($term)
{
  $term = str_replace(
    array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
    array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
    $term
  );

  $term = str_replace(
    array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
    array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
    $term
  );

  $term = str_replace(
    array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
    array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
    $term
  );

  $term = str_replace(
    array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
    array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
    $term
  );

  $term = str_replace(
    array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
    array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
    $term
  );

  $term = str_replace(
    array('ñ', 'Ñ', 'ç', 'Ç'),
    array('n', 'N', 'c', 'C'),
    $term
  );

  return $term;
}

function check_password($password, $data)
{
  global $pdo;

  $query = "SELECT password FROM users WHERE $data[trigger] = :param";
  $sth = $pdo->prepare($query);
  $sth->bindParam('param', $data['value']);
  $sth->execute();

  $result = $sth->fetch();
  $hash = $result->password;

  if (!$hash)
    return false;

  return password_verify($password, $hash);
}

############# Get

function get_categories()
{
  global $pdo;

  $query = "SELECT * FROM categories";
  $sth = $pdo->prepare($query);
  $sth->execute();
  $result = $sth->fetchAll();

  return $result;
}

function get_entries($limit = null, $category = null)
{
  global $pdo;

  $query = "SELECT c.name as 'category', c.slug as 'slug', u.username as 'author', e.title, e.content, e.post_date as 'date'
  FROM entries e
  INNER JOIN categories c
  ON c.id = e.category_id
  INNER JOIN users u
  ON u.id = e.user_id";

  if ($category != null && !empty($category))
    $query .= " WHERE c.slug = '$category'";

  $query .= " ORDER BY e.post_date DESC";

  if ($limit != null && $limit > 0)
    $query .= " LIMIT $limit";

  $sth = $pdo->prepare($query);
  $sth->execute();
  $result = $sth->fetchAll();

  return $result;
}

############# Create 

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

function create_slug($term)
{

  $slug = trim($term);
  $slug = remove_accents($slug);
  $slug = strtolower($slug);
  $slug = preg_replace('/([^a-z0-9-\s])+/', '', $slug);
  $slug = preg_replace('/\s+/', '-', $slug);

  return $slug;
}

function create_category($data)
{
  global $pdo;

  $query = "INSERT INTO categories ( name, slug ) VALUES (:name, :slug)";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':name', $data['name']);
  $sth->bindValue(':slug', $data['slug']);
  $sth->execute();
}

function create_entry($data)
{
  global $pdo;

  $query = "INSERT INTO entries (category_id, user_id, title, content, post_date) VALUES (:category, :user, :title, :content, curdate())";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':category', $data['category_id']);
  $sth->bindValue(':user', $data['user_id']);
  $sth->bindValue(':title', $data['title']);
  $sth->bindValue(':content', $data['content']);
  $sth->execute();

}

############# Set

function login_user($data)
{
  global $pdo;

  $output = [];

  $query = "SELECT id, username, email, password FROM users WHERE email = :email";
  $sth = $pdo->prepare($query);
  $sth->bindValue(':email', $data['email']);

  try {
    $sth->execute();
    $result = $sth->fetch();
    $is_correct_password = password_verify($data['password'], $result->password);

    if ($is_correct_password) {
      $output = [
        'id' => $result->id,
        'username' => $result->username,
        'email' => $result->email
      ];
    }

    return $output;

  } catch (\Throwable $e) {

    print_r($e);
  }
}

############# Update

function update_user($data)
{
  global $pdo;

  $params = "";
  $count = 0;

  foreach ($data['values'] as $key => $value) {
    $count += 1;

    $params .= "$key = :$key";

    if ($count < count($data['values'])) {
      $params .= ", ";
    }
  }

  $params = trim($params);
  $query = "UPDATE users SET $params WHERE id = $data[id]";
  $sth = $pdo->prepare($query);

  foreach ($data['values'] as $key => $value) {
    $sth->bindParam(":$key", $data['values'][$key]);
  }

  try {
    $sth->execute();
    return true;

  } catch (\Throwable $e) {

    return false;
  }
}

############# Display 

function display_categories()
{
  $categories = get_categories();
  $html = "";

  if (empty($categories))
    return;

  foreach ($categories as $category) {
    $html .= "<li class='Nav__item'><a href='" . SITE_URI . "category/$category->slug/' class='Link'>$category->name</a></li>";
  }

  return $html;
}

############# server_says

function server_says($code, $value = "")
{
  $server_codes = array(
    "e000" => "Algo ha salido mal, inténtalo de nuevo.",
    "e001" => "El campo <b>$value</b> está vacío.",
    "e002" => "Debe ingresar un email válido.",
    "e003" => "Las contraseñas no coinciden.",
    "e004" => "Este <b>$value</b> ya se encuentra registrado.",
    "e005" => "El nombre de usuario debe contener entre <b>6 y 15 carácteres</b>, sólo puedes usar letras, números y los símbolos: '@', '_'.",
    "e006" => "La contraseña debe contener mínimo <b>6</b> carácteres, sólo puedes usar letras, números y los símbolos: '.', '-', '_', '@', '!', '#', '$'.",
    "e007" => "El correo y la contraseña no coinciden."
  );

  $msg = $server_codes[$code] ?? $value;

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