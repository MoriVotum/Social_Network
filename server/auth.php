<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

// print_r($_POST);

$query = "SELECT * FROM `client` WHERE `login` = '{$_POST['login']}' AND `password` = '{$_POST['password']}'";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);

    setcookie('id', $row['id'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('login', $row['login'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('password', $row['password'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('avatar', $row['avatar'], time() + 60 * 60 * 24 * 30, "/");

    header('Location: /');
} else {
    $errors = array(
        'error' => "Wrong login or password",
    );

    setcookie('errors', json_encode($errors), time() + 15, "/");

    header('Location: /auntification/');
    // print_r("Wrong login or password");
}
// print_r($row);

unset($_POST);
