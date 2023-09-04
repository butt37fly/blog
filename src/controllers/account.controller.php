<?php

require_once '../db.php';
require_once '../functions.php';

if (isset($_GET['a']) && $_GET['a'] === "logout") {

  custom_session_start();

  if (isset($_SESSION['user'])) {
    session_destroy();
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

  if (exist_term($username, 'username'))
    $errors[] = "e004";

  if (exist_term($email, 'email'))
    $errors[] = "e004";

  if (!empty($errors)) {
    set_server_msg($errors);
    redirect_to();
  }

  # Try create the new user account

  try {
    create_user([
      'username' => $username,
      'email' => $email,
      "password" => $secure_password
    ]);
    redirect_to();

  } catch (\Throwable $e) {
    print_r($e);
  }
}

redirect_to();