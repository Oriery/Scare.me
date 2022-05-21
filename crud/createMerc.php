<?php

if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['desc'])) {
    require_once '../service/DatabaseService.php';
    $dbService = new DatabaseService();
    $dbService->createMercenary($_POST['name'], $_POST['price'], $_POST['desc']);
    header("Location: /adminOnly.php");
}