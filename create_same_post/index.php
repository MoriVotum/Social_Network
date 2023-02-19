<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/cart-style.css';
$aplication['title'] = 'Создать пост';
$aplication['js'][] = '/src/js/create_same_post.js';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
// Get post data

$url = $_SERVER['REQUEST_URI'];
$urlType = explode('/', $url);
$id = $urlType[2];
$res = json_decode(getPost($connection, $id), true);

// delete spaces from the beginning and end of the string
$res['name'] = trim($res['name']);
$res['description'] = trim($res['description']);
$res['text'] = trim($res['text']);

?>
<main>
    <div class="cart-create">
        <input type="file" id="file-cart" />
        <?php $src = "/server/images/posts/" . $res['image']; ?>
        <img id="preview-cart" src=<?php echo $src ?> alt="preview-cart" />
        <div class="info-about-cart">
            <textarea name="" id="name-of-cart" placeholder="Название"><?php echo $res['name'] ?></textarea>
            <textarea name="" id="about-main-cart" placeholder="Краткое описание"><?php echo $res['description'] ?></textarea>
            <textarea name="" id="main-cart-text" placeholder="Основной текст"><?php echo $res['text'] ?></textarea>
            <button id="create-cart">Создать</button>
        </div>
    </div>
</main>
</body>

</html>