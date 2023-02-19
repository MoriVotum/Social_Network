<?php 
    setcookie('id', null, time() - 60 * 60 * 24 * 30, "/");
    setcookie('login', null, time() - 60 * 60 * 24 * 30, "/");
    setcookie('password', null, time() - 60 * 60 * 24 * 30, "/");

    header('Location: /');
    