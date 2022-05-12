<?php
//Запуск сессий;
session_start();

//если пользователь не авторизован
if (!(isset($_SESSION['Name']))) {
    //идем на страницу авторизации
    header("Location: login.html");
    exit;
};

//Выводим саму страницу для авторизованных пользователей
$nm = $_SESSION['Name'];
echo ("<div style=\"text-align: center; margin-top: 10px;\">");
print "Пользователь системы $nm <br>";
print "Вы на секретной странице<br>";
