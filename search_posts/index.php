<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/style.css';
$aplication['css'][] = '/src/css/search.css';
$aplication['js'][] = '/src/js/search.js';
$aplication['title'] = 'Авторизация';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
?>
<main>
  <div class="interesting-cart">
    <h2 class="h2-interesting">Рузультаты поиска</h2>
    <div class="wrapper-interested"></div>
  </div>
  <div class="wrapper"></div>
</main>
</body>

</html>