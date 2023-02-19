<div class="user_info">
    <?php
    echo '<img src="/server/images/avatars/' . $_COOKIE['avatar'] . '" width="80px" alt="">';
    echo '<br>';
    ?>
    <h2>Ваш Id: <?php print_r($_COOKIE['id']); ?> </h2>
    <h2>Логин: <?php print_r($_COOKIE['login']); ?> </h2>
    <h2>Пароль: <?php print_r($_COOKIE['password']); ?> </h2>
</div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/profile.css';
$aplication['js'][] = '/src/js/profile.js';
$aplication['title'] = 'Профиль';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
?>
<main>
    <div class="wrapper"></div>
</main>
</body>

</html>