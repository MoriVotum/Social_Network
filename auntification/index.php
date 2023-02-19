<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/includes/config.php';

// setcookie('id', 1, strtotime("+90 days")); 

setcookie('id', null, time() + 60 * 60 * 24 * 30, "/");
setcookie('login', null, time() + 60 * 60 * 24 * 30, "/");
setcookie('password', null, time() + 60 * 60 * 24 * 30, "/");

// echo json_encode(isset($_COOKIE['id']));
// echo json_encode($_COOKIE['id']);

?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/cart-style.css';
$aplication['css'][] = '/src/css/post.css';
$aplication['css'][] = '/src/css/auntification.css';
$aplication['js'][] = '/src/js/auntification.js';
$aplication['title'] = 'Авторизация';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
?>
<main>
    <h1>
        Авторизация
    </h1>

    <?php
    print_r(json_decode($_COOKIE['errors'], true)['error']);
    ?>

    <form action="/server/auth.php" method="POST" class="auth_form form">
        <input name="login" type="login" placeholder="Логин"><label for="login"></label>
        <input name="password" type="password" placeholder="Пароль" class="pswd"><label for="password"></label>
        <button type="submit" class="go_enter">
            Войти
        </button>
    </form>

    <form action="/server/reg.php" method="POST" class="reg_form form hidden" enctype="multipart/form-data">
        <input name="login" type="login" placeholder="Логин"><label for="login"></label>
        <input name="password" type="password" placeholder="Пароль" class="pswd"><label for="password"></label>
        <input name="mail" type="mail" placeholder="почта" id="mail"><label for="mail"></label>
        <button type="submit" class="go_reg">
            Зарегистрироваться
        </button>
        <input name="avatar" type="file" id="avatar">
    </form>

    <button class="show_pswd">
        Показать пароль
    </button>

    <button id="registration">
        Зарегистрироваться
    </button>
</main>
</body>

</html>