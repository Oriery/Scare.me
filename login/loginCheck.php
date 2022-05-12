<?php
session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
    //$login = mysql_real_escape_string($_POST['login']); Если бы была бд
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    //проверка пароля и логина
    if (($login == 'admin') && (md5($password) == '21232f297a57a5a743894a0e4a801fc3')) { // Пароль admin
        //echo ("логин и пароль верны");
        $_SESSION['Name'] = $login;

        // идем на страницу для авторизованного пользователя
        header("Location: /adminOnly.php");
    } else {
        header("Location: /relogin.php");
    }
}
