<?php
session_start();

//если пользователь не авторизован
if (!(isset($_SESSION['Name']))) {
    //идем на страницу авторизации
    header("Location: login.php");
    exit;
};

// если пользователь не админ
if (!(isset($_SESSION['isAdmin']))) {
    //идем на страницу пользователя
    header("Location: /"); // TODO можно например сделать страницу пользователя или хз что
    exit;
};
