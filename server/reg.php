<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

// print_r($_POST);

// print_r($_FILES['avatar']);

$login = $_POST['login'];
$password = $_POST['password'];
$role = "user";
$mail = $_POST['mail'];
$avatar = $_POST['avatar'];
$image = $_FILES['avatar'];
$fileName = $_FILES['avatar']['name'];

$query = "SELECT * FROM `client` WHERE `login` = '{$login}'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $errors = array(
        'error' => "Пользователь с таким логином уже существует",
    );

    setcookie('errors', json_encode($errors), time() + 15, "/");

    header('Location: /auntification/');
    // print_r("Wrong login or password");
}

if (!file_exists(dirname(__DIR__) . '\server\images\avatars\\' . $fileName))
    if (!move_uploaded_file($image['tmp_name'], dirname(__DIR__) . '\server\images\avatars\\' . $fileName))
        return false;

$query = "INSERT INTO `client` (`login`, `password`, `role`, `mail`, `avatar`) VALUES ('{$login}',
'{$password}', '{$role}', '{$mail}', '{$fileName}')";

$result = mysqli_query($connection, $query);

if ($result > 0) {
    $query = "SELECT * FROM `client` WHERE `login` = '$login' AND `password` = '$password'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    setcookie('id', $row['id'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('login', $row['login'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('password', $row['password'], time() + 60 * 60 * 24 * 30, "/");
    setcookie('avatar', $row['avatar'], time() + 60 * 60 * 24 * 30, "/");

    header('Location: /');
} else {

    $errors = array(
        'error' => "Ошибка регистрации",
    );

    setcookie('errors', json_encode($errors), time() + 15, "/");

    header('Location: /auntification/');
    // print_r("Wrong login or password");
}

unset($_POST);
