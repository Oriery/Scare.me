<?php
session_start();

require_once '../service/DatabaseService.php';
$dbService = new DatabaseService();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    //проверка пароля и логина
    if ($dbService->checkIfValidAuth($login, md5($password))) {
        require_once("./onSuccessfullAuth.php");
    } else {
        header("Location: /login.php");
        setcookie("errMes", "Неправильный логин или пароль", time() + 5, "/");
    }
}
