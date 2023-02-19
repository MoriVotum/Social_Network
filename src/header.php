<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php foreach ($aplication['css'] as $css) { ?>
        <link rel="stylesheet" href="<?= $css ?>" />
    <?php } ?>
    <link rel="icon" href="https://nntheblog.com/wp-content/uploads/2022/02/Pochita-chainsaw-man-8.jpg" />
    <title>
        <?= $aplication['title']; ?>
    </title>
    <?php foreach ($aplication['js'] as $js) { ?>
        <script src="<?= $js ?>" defer></script>
    <?php } ?>
</head>

<body onclick="bodyActive()">
    <header>
        <nav>
            <a href="/">
                <img class="logo" src="https://nntheblog.com/wp-content/uploads/2022/02/Pochita-chainsaw-man-8.jpg" width="50px" height="50px" alt="logo" />
            </a>
            <ul class="list-header">
                <li><a href="/">Главная</a></li>
                <li><a href="/create_card/">Создать</a></li>
            </ul>
            <input class="search-header" type="search" placeholder="Поиск" id="site-search" name="q" />
            <div class="drop-search">
                <button id="searchActive">
                    <img class="search-icon" src="/src/img/utility/search.svg" width="20" height="20" alt="search" />
                </button>
                <div class="search-content">
                    <button class="seacrh_by_name">По названию</button>
                    <button class="seacrh_by_views">По просмотрам</button>
                    <button class="seacrh_by_date">По дате</button>
                </div>
            </div>
            <div id="drop-settings">
                <button>
                    <img src="/src/img/utility/settings.svg" width="20" height="20" alt="settings" />
                </button>
                <div id="settings-content">
                    <?php
                    if (isset($_COOKIE['id'])) {
                    ?>
                        <a href="/profile/" class="account">
                            <img src="/server/images/avatars/<?php echo $_COOKIE['avatar'] ?>" class="avatar_img_header" width="35" height="35" alt="user" />
                            <p>
                                <?php echo $_COOKIE['login']; ?>
                            </p>
                        </a>
                        <a href="/" class="settings">Настройки</a>
                    <?php
                    } else {
                    ?>
                        <a href="/auntification/" class="account">
                            <img src="/src/img/utility/user.svg" class="avatar_img_header" width="20" height="20" alt="user" />
                            <p>Аккаунт</p>
                        </a>
                        <a href="/" class="settings">Настройки</a>
                    <?php
                    }
                    ?>

                    <!-- <a href="/" class="account">
                        <img src="/src/img/utility/user.svg" width="20" height="20" alt="user" />
                        <p>Аккаунт</p>
                    </a>
                    <a href="/" class="settings">Настройки</a> -->

                    <button id="show-interesting">Показывать интересное</button>
                    <a href="/src/logout.php" id="exit">Выйти</a>
                </div>
            </div>
        </nav>
    </header>