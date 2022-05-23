<?php
session_start();

require_once '../service/DatabaseService.php';
$dbService = new DatabaseService();
$login;
$email;
$password1;
$password2;

if (isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['email'])) {
    global $login, $email, $password1, $password2;

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    
    if (strlen($email) == 0) 
        cancelWithError("Email не задан");

    if (strlen($login) < 3) 
        cancelWithError("Логин слишком короткий (мин 3 символа)");
    
    if (strlen($email) > 50) 
        cancelWithError("Email слишком длинный (макс 50 символов)");

    if (strlen($login) > 16) 
        cancelWithError("Логин слишком длинный (макс 16 символов)");

    if ($password1 != $password2) 
        cancelWithError("Пароли не совпадают");

    if (strlen($password1) < 12) 
        cancelWithError("Пароль слишком короткий (мин 12 символов)");

    if ($dbService->checkIfLoginExists($login)) 
        cancelWithError("Этот логин уже используется");

    $dbService->signupUser($login, md5($password1));
    $keyForEmailValid = $dbService->getKeyForEmailValidation($login, $email);
    $url = $_SERVER["SERVER_NAME"] . "/login/emailValidate.php?login=$login&email=$email&key=$keyForEmailValid";

    require_once("../service/mailService.php");
    sendEmail($email, "Scare.me - Подтвердите Ваш email", $url);

    echo "На ваш email отправлено сообщение для подтверждения адреса электронной почты";
} else {
    header('HTTP/1.1 400 Bad Request');
}

function cancelWithError(string $errMes) {
    global $login, $email, $password1;

    header("Location: /signup.php");
    setcookie("errMes", $errMes, time() + 5, "/");
    setcookie("login", $login, time() + 5, "/");
    setcookie("email", $email, time() + 5, "/");
    setcookie("password1", $password1, time() + 5, "/");
    exit();
}
