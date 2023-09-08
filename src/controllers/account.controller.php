<?php

require_once '../db.php';
require_once '../functions.php';

if (isset($_GET['a']) && $_GET['a'] === "logout") {

  custom_session_start();

  if (isset($_SESSION['user'])) {
    unset( $_SESSION['user']);
  }
}

if (isset($_POST['Login'])) {

  $form_input_names = [
    'loginEmail' => 'Correo electrónico',
    'loginPassword' => 'Contraseña'
  ];

  foreach ($_POST as $name => $content) {
    $input_name = $form_input_names[$name] ?? $name;

    if (empty(trim($content))) {
      server_says('e001', $input_name);
      redirect_to();
    }
  }

  $email = trim($_POST['loginEmail']);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $password = $_POST['loginPassword'];

  $errors = [];

  if (!$email)
    $errors[] = "e002";

  if (!validate_input($password, 'password'))
    $errors[] = "e005";

  $user = login_user(['email' => $email, 'password' => $password]);

  if (empty($user)) {
    server_says('e007');
    redirect_to();
  }

  $user['logged'] = true;

  custom_session_start();

  if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $user;
  }
}

if (isset($_POST['SignIn'])) {

  $form_input_names = [
    'SignInUsername' => 'Nombre de usuario',
    'SignInEmail' => 'Correo electrónico',
    'SignInPassword' => 'Contraseña',
    'SignInPasswordRp' => 'Repetir contraseña'
  ];

  foreach ($_POST as $name => $content) {
    $input_name = $form_input_names[$name] ?? $name;

    if (empty(trim($content))) {
      server_says('e001', $input_name);
      redirect_to();
    }
  }

  $username = trim($_POST['signInUsername']);
  $email = trim($_POST['signInEmail']);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $password = $_POST['signInPassword'];
  $password_rep = $_POST['signInPasswordRep'];

  $errors = [];

  # Validate user inputs

  if (!validate_input($username, 'username'))
    $errors[] = "e005";

  if (!$email)
    $errors[] = "e002";

  if (!validate_input($password, 'password'))
    $errors[] = "e006";

  if ($password !== $password_rep)
    $errors[] = "e003";

  if (!empty($errors)) {
    set_server_msg($errors);
    redirect_to();
  }

  # Hash the user password

  $secure_password = password_hash($password, PASSWORD_BCRYPT);

  # Verify the user exists in the db

  if (exist_term($username, 'username', 'users')) {
    server_says('e004', 'nombre de usuario');
    redirect_to();
  }

  if (exist_term($email, 'email', 'users')) {
    server_says('e004', 'email');
    redirect_to();
  }

  # Try create the new user account

  try {
    create_user([
      'username' => $username,
      'email' => $email,
      "password" => $secure_password
    ]);
    server_says('custom', 'La cuenta se ha creado exitosamente');
    redirect_to();

  } catch (\Throwable $e) {
    print_r($e);
  }
}

if (isset($_POST['Update'])) {
  custom_session_start();

  $id = $_SESSION['user']['id'];
  $username = trim($_POST['UpdateUsername']);
  $email = trim($_POST['UpdateEmail']);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $current_password = trim($_POST['UpdateCurrentPassword']);
  $new_password = trim($_POST['UpdatePassword']);
  $new_password_rep = trim($_POST['UpdatePasswordRep']);

  $data = ['id' => $id, 'values' => []];

  if ($username !== $_SESSION['user']['username']) {

    if (exist_term($username, 'username', 'users')) {
      server_says('e004', 'nombre de usuario');
      redirect_to('account/');
    }

    if (!validate_input($username, 'username')) {
      server_says('e005');
      redirect_to('account/');
    }

    $data['values']['username'] = $username;
  }

  if ($email !== $_SESSION['user']['email']) {

    if (exist_term($email, 'email', 'users')) {
      server_says('e004', 'correo electrónico');
      redirect_to('account/');
    }

    $data['values']['email'] = $email;
  }
  
  if (!empty($current_password)) {

    if (!check_password($current_password, ['trigger' => 'id', 'value' => $id])) {
      server_says('e007');
      redirect_to('account/');
    }

    if (!validate_input($new_password, 'password')) {
      server_says('e006');
      redirect_to('account/');
    }

    if ($new_password !== $new_password_rep) {
      server_says('e003');
      redirect_to('account/');
    }

    $secure_password = password_hash($new_password, PASSWORD_BCRYPT);

    $data['values']['password'] = $secure_password;
  }

  if ( ! update_user( $data ) ){
    server_says( 'e000' );
    redirect_to( 'account/' );
  }

  if( key_exists('username', $data['values'] ) ){
    $_SESSION['user']['username'] = $data['values']['username'];
  }

  if( key_exists('email', $data['values'] ) ){
    $_SESSION['user']['email'] = $data['values']['email'];
  }

  server_says( 'custom', 'Los datos se han actualizado correctamente.' );
  redirect_to( 'account/' );

}

redirect_to();