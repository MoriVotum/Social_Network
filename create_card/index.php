<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/cart-style.css';
$aplication['title'] = 'Создать пост';
$aplication['js'][] = '/src/js/cart.js';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
?>
<main>
  <div class="cart-create">
    <input type="file" id="file-cart" />
    <img id="preview-cart" width="30vw" src="/src/img/utility/download-img.svg" alt="preview-cart" />
    <div class="info-about-cart">
      <textarea name="" id="name-of-cart" placeholder="Название"></textarea>
      <textarea name="" id="about-main-cart" placeholder="Краткое описание"></textarea>
      <textarea name="" id="main-cart-text" placeholder="Основной текст"></textarea>
      <button id="create-cart">Создать</button>
    </div>
  </div>
</main>
</body>
</html>