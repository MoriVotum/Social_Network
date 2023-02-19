<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
$aplication['css'][] = '/src/css/cart-style.css';
$aplication['css'][] = '/src/css/post.css';
$aplication['js'][] = '/src/js/post.js';
$aplication['title'] = 'Пост';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
?>
<main>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $urlType = explode('/', $url);
    $id = $urlType[2];
    $res = json_decode(getPost($connection, $id), true);

    if ($res['id'] != null) {
    ?>
        <div class="post">
            <?php $src = "/server/images/posts/" . $res['image']; ?>
            <div class="some_images">
                <img src=<?php echo $src ?> width="200px" alt="" class="post_image">
                <?php if ($_COOKIE['id'] == $res['id_client']) { ?>
                    <div class="some_changes">
                        <img src="/src/img/utility/add_post.svg" alt="add_post" width="35px" 
                        onclick="createPost(<?php echo $res['id'] ?>)">
                        <img src="/src/img/utility/edit_post_v2.svg" alt="change_post" width="47px" class="edite" 
                        onclick="editPost(<?php echo $res['id'] ?>)">
                        <img src="/src/img/utility/delete.svg" alt="delete_post" width="40px" 
                        onclick="deletePost(<?php echo $res['id'] ?>)">
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="post_info">
                <h1 class="post_header_info_name">
                    <?php echo $res['name']; ?>
                </h1>
                <p class="post_header_info_description">
                    <?php echo $res['description']; ?>
                </p>
                <p class="post_content_text">
                    <?php echo $res['text']; ?>
                </p>
            </div>
        </div>

        <div class="dop_info">
            <p class="dop_info_author">
                Автор:
                <?php
                echo $res['login'];
                ?>
            </p>
            <p class="dop_info_viewed">
                Количество просмотров:
                <?php echo $res['viewed']; ?>
            </p>
            <p class="dop_info_date">
                Дата создания:
                <?php echo $res['created_at']; ?>
            </p>
        </div>

        <div class="comments_create">
            <div class="comments_create_avatar">
                <img src="/server/images/avatars/<?php echo $_COOKIE['avatar'] ?>" width="80px" alt="">
            </div>
            <div class="comments_create_info">
                <textarea name="text" id="comment-text" placeholder="Напишите комментарий"></textarea>
                <button id="create-comment" onclick="sendComment( <?php echo $res['id'] ?> )"> Отправить </button>
            </div>
        </div>

        <?php
        $commentsList = json_decode(getComments($connection, $id), true);
        if ($commentsList[0]['id'] != null) {
        ?>
            <div class="comments">
                <?php
                foreach ($commentsList as $comment) {
                ?>
                    <div class="comments_item">
                        <div class="comments_item_avatar">
                            <img class="client_avatar" src="/server/images/avatars/<?php echo $comment['avatar']; ?>" width="80px" alt="">
                        </div>
                        <div class="comments_item_info">
                            <h2 class="comments_item_info_name">
                                <?php
                                $client = json_decode(getClient($connection, $comment['client_com_id']), true);
                                echo $client['login'];
                                ?>
                            </h2>
                            <p class="comments_item_info_text">
                                <?php echo $comment['text']; ?>
                            </p>
                            <p class="commented_at">
                                <?php echo $comment['commented_at']; ?>
                            </p>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        <?php
        }
        ?>
    <?php
    } else {
    ?>
        <h1>
            <?php echo $res['error']; ?>
        </h1>
    <?php
    }
    ?>
</main>
</body>

</html>