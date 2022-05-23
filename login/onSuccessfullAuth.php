<?php

$_SESSION['Name'] = $login;

if ($dbService->checkIfAdmin($login)) {
    $_SESSION['isAdmin'] = true;
}

header("Location: /");