<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/style.css';
$aplication['title'] = 'Главная';
$aplication['js'][] = '/src/js/index.js';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
?>
<main>
  <div class="interesting-cart">
    <h2 class="h2-interesting">Интересное</h2>
    <div class="wrapper-interested"></div>
  </div>
  <div class="wrapper"></div>
</main>
</body>
</html>