<?php
session_start();

require_once '../service/DatabaseService.php';
$dbService = new DatabaseService();

if (isset($_POST['login']) && isset($_POST['password'])) {
    //$login = mysql_real_escape_string($_POST['login']); Если бы была бд
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    //проверка пароля и логина
    if ($dbService->checkIfValidAuth($login, md5($password))) {
        //echo ("логин и пароль верны");
        $_SESSION['Name'] = $login;
        
        if ($dbService->checkIfAdmin($login)) {
            $_SESSION['isAdmin'] = true;
            header("Location: /adminOnly.php");
        } else {
            header("Location: /");
        }
    } else {
        header("Location: /login.php");
        setcookie("unsuccessfullLogin", true, time() + 5, "/");
    }
}
