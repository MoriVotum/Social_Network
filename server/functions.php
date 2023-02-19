<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/includes/config.php';

function getPosts($connection, $count = "", $offset = "")
{
    $query = "SELECT post.id, post.id_client, post.name, post.description, post.text, post.image, post.viewed,
    post.created_at, client.login, COUNT(comment.id) AS comments_count FROM post INNER JOIN client ON post.id_client = client.id
    LEFT JOIN comment ON post.id = comment.post_id GROUP BY post.id";

    if ($count != "") {
        $query .= " LIMIT $count";
        // if ($offset != "")
        //     $query .= " OFFSET $offset";
    }
    $query .= ";";
    // echo json_encode($query);
    $posts = mysqli_query($connection, $query);
    $postsList = [];

    while ($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
    }

    echo json_encode($postsList);
}

function getInterestingPosts($connection, $count)
{
    // $query = "SELECT * FROM post ORDER BY viewed DESC LIMIT $count;";

    // $query = "SELECT post.id, post.id_client, post.name, post.description, post.text, post.image, post.viewed,
    // post.created_at, client.login FROM post INNER JOIN client ON post.id_client = client.id ORDER BY viewed DESC LIMIT $count;";

    // get posts with client login and comments count and order by viewed
    $query = "SELECT post.id, post.id_client, post.name, post.description, post.text, post.image, post.viewed,
    post.created_at, client.login, COUNT(comment.id) AS comments_count FROM post INNER JOIN client ON post.id_client = client.id
    LEFT JOIN comment ON post.id = comment.post_id GROUP BY post.id ORDER BY viewed DESC LIMIT $count;";

    $posts = mysqli_query($connection, $query);
    $postsList = [];

    while ($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
    }

    echo json_encode($postsList);
}

function getPost($connection, $id)
{
    // select post with client login and comments count
    $query = "SELECT post.id, post.id_client, post.name, post.description, post.text, post.image, post.viewed,
    post.created_at, client.login, COUNT(comment.id) AS comments_count FROM post INNER JOIN client ON post.id_client = client.id
    LEFT JOIN comment ON post.id = comment.post_id WHERE post.id = $id GROUP BY post.id;";

    // $query = "SELECT * FROM post WHERE id = $id;";
    $posts = mysqli_query($connection, $query);

    // add viewed
    $query = "UPDATE post SET viewed = viewed + 1 WHERE id = $id;";
    mysqli_query($connection, $query);

    if (mysqli_num_rows($posts) < 1) {
        http_response_code(404);
        $res = [
            'status' => 404,
            'error' => 'Post not found'
        ];
        // echo json_encode($res);
        return json_encode($res);
    } else {
        $post = mysqli_fetch_assoc($posts);
        // echo json_encode($post);
        return json_encode($post);
    }
}

function my_url_decode($s)
{
    $s = strtr($s, array(
        "%20" => " ", "%D0%B0" => "а", "%D0%90" => "А", "%D0%B1" => "б", "%D0%91" => "Б", "%D0%B2" => "в",
        "%D0%92" => "В", "%D0%B3" => "г", "%D0%93" => "Г", "%D0%B4" => "д", "%D0%94" => "Д", "%D0%B5" => "е", "%D0%95" => "Е",
        "%D1%91" => "ё", "%D0%81" => "Ё", "%D0%B6" => "ж", "%D0%96" => "Ж", "%D0%B7" => "з", "%D0%97" => "З", "%D0%B8" => "и",
        "%D0%98" => "И", "%D0%B9" => "й", "%D0%99" => "Й", "%D0%BA" => "к", "%D0%9A" => "К", "%D0%BB" => "л", "%D0%9B" => "Л",
        "%D0%BC" => "м", "%D0%9C" => "М", "%D0%BD" => "н", "%D0%9D" => "Н", "%D0%BE" => "о", "%D0%9E" => "О", "%D0%BF" => "п",
        "%D0%9F" => "П", "%D1%80" => "р", "%D0%A0" => "Р", "%D1%81" => "с", "%D0%A1" => "С", "%D1%82" => "т", "%D0%A2" => "Т",
        "%D1%83" => "у", "%D0%A3" => "У", "%D1%84" => "ф", "%D0%A4" => "Ф", "%D1%85" => "х", "%D0%A5" => "Х", "%D1%86" => "ц",
        "%D0%A6" => "Ц", "%D1%87" => "ч", "%D0%A7" => "Ч", "%D1%88" => "ш", "%D0%A8" => "Ш", "%D1%89" => "щ", "%D0%A9" => "Щ",
        "%D1%8A" => "ъ", "%D0%AA" => "Ъ", "%D1%8B" => "ы", "%D0%AB" => "Ы", "%D1%8C" => "ь", "%D0%AC" => "Ь", "%D1%8D" => "э",
        "%D0%AD" => "Э", "%D1%8E" => "ю", "%D0%AE" => "Ю", "%D1%8F" => "я", "%D0%AF" => "Я"
    ));
    return $s;
}

// get posts sorted by name
function getPostsByName($connection, $name, $sort = "name", $count = "")
{
    // get posts with client login and comments count where name like $name and order by name
    $decodeName = my_url_decode($name);
    $lowerName = mb_strtolower($decodeName);
    // echo json_encode($lowerName);

    if ($sort == "name")
        $dsc = "ASC";
    else
        $dsc = "DESC";

    $query = "SELECT post.id, post.id_client, post.name, post.description, post.text, post.image, post.viewed,
    post.created_at, client.login, COUNT(comment.id) AS comments_count FROM post INNER JOIN client ON post.id_client = client.id
    LEFT JOIN comment ON post.id = comment.post_id WHERE LOWER(post.name) LIKE '%$lowerName%' GROUP BY post.id ORDER BY post.$sort $dsc LIMIT $count;";
    // echo json_encode($query);

    $posts = mysqli_query($connection, $query);
    $postsList = [];

    while ($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
    }

    echo json_encode($postsList);
}

function createPost($connection, $data)
{
    $id_client = $_COOKIE['id'];

    $name = $data['name'];
    $description = $data['description'];
    $text = $data['text'];
    $image = $data['image'];

    $fileName = $image['name'];

    if (!file_exists(dirname(__DIR__) . '\server\images\posts\\' . $fileName))
        if (!move_uploaded_file($image['tmp_name'], dirname(__DIR__) . '\server\images\posts\\' . $fileName))
            return false;


    $viewed = 0;
    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO post (id_client, name, description, text, image, viewed, created_at) 
    VALUES ('$id_client', '$name', '$description', '$text', '$fileName', '$viewed', '$created_at');";

    if (mysqli_query($connection, $query)) {
        $res = [
            'status' => 201,
            'message' => 'Post created',
        ];
    } else {
        $res = [
            'status' => 500,
            'error' => 'Post not created',
        ];
    }
    echo json_encode($res);
}

function getComments($connection, $id_post)
{
    // $query = "SELECT * FROM comment WHERE post_id = $id_post;";

    // get comments with client login and order by commented_at DESC and get client avatar
    $query = "SELECT comment.id, comment.client_com_id, comment.text, comment.commented_at, client.login, client.avatar FROM comment
    INNER JOIN client ON comment.client_com_id = client.id WHERE post_id = $id_post ORDER BY commented_at DESC;";

    $comments = mysqli_query($connection, $query);
    $commentsList = [];

    while ($comment = mysqli_fetch_assoc($comments)) {
        $commentsList[] = $comment;
    }

    return json_encode($commentsList);
}

function getClient($connection, $id)
{
    $query = "SELECT * FROM client WHERE id = $id;";

    $clients = mysqli_query($connection, $query);

    if (mysqli_num_rows($clients) < 1) {
        http_response_code(404);
        $res = [
            'status' => 404,
            'error' => 'Client not found'
        ];
        // echo json_encode($res);
        return json_encode($res);
    } else {
        $client = mysqli_fetch_assoc($clients);
        // echo json_encode($client);
        return json_encode($client);
    }
}

function checkAuthorisation($connection, $login, $password)
{
    $query = "SELECT * FROM client WHERE login = '$login' AND password = '$password';";

    $clients = mysqli_query($connection, $query);

    if (mysqli_num_rows($clients) < 1) {
        http_response_code(401);
        $res = [
            'status' => 401,
            'error' => 'Authorisation failed'
        ];
        // echo json_encode($res);
        return json_encode($res);
    } else {
        $client = mysqli_fetch_assoc($clients);
        // echo json_encode($client);
        return json_encode($client);
    }
}

function editPost($connection, $data)
{
    $id = $data['post_id'];
    $name = $data['name'];
    $description = $data['description'];
    $text = $data['text'];
    $image = $data['image'];

    // echo json_encode($image);

    if (isset($image['name'])) {
        $fileName = $image['name'];
        // echo json_encode($fileName);

        if (!file_exists(dirname(__DIR__) . '\server\images\posts\\' . $fileName))
            if (!move_uploaded_file($image['tmp_name'], dirname(__DIR__) . '\server\images\posts\\' . $fileName))
                return false;

        $query = "UPDATE post SET name = '$name', description = '$description', text = '$text', image = '$fileName' WHERE id = $id;";
    } else {
        $query = "UPDATE post SET name = '$name', description = '$description', text = '$text' WHERE id = $id;";
    }

    // echo json_encode($query);

    if (mysqli_query($connection, $query)) {
        $res = [
            'status' => 200,
            'message' => 'Post edited',
        ];
    } else {
        $res = [
            'status' => 500,
            'error' => 'Post not edited',
        ];
    }

    echo json_encode($res);

}

function createSamePost($connection, $data)
{
    $id_client = $_COOKIE['id'];

    $name = $data['name'];
    $description = $data['description'];
    $text = $data['text'];
    $image = $data['image'];

    $viewed = 0;
    $created_at = date('Y-m-d H:i:s');

    if (isset($image['name'])) {
        $fileName = $image['name'];
        // echo json_encode($fileName);

        if (!file_exists(dirname(__DIR__) . '\server\images\posts\\' . $fileName))
            if (!move_uploaded_file($image['tmp_name'], dirname(__DIR__) . '\server\images\posts\\' . $fileName))
                return false;

        $query = "INSERT INTO post (id_client, name, description, text, image, viewed, created_at)
        VALUES ('$id_client', '$name', '$description', '$text', '$fileName', '$viewed', '$created_at');";

    } else {
        $query = "INSERT INTO post (id_client, name, description, text, image, viewed, created_at)
        VALUES ('$id_client', '$name', '$description', '$text', '$image', '$viewed', '$created_at');";
    }

    // echo json_encode($query);

    if (mysqli_query($connection, $query)) {
        $res = [
            'status' => 201,
            'message' => 'Post created',
        ];
    } else {
        $res = [
            'status' => 500,
            'error' => 'Post not created',
        ];
    }
    echo json_encode($res);
}

function deletePost($connection, $id)
{

    // $query = "DELETE FROM comment WHERE post_id = $id;";

    // mysqli_query($connection, $query);

    $query = "DELETE FROM post WHERE id = $id;";

    // echo json_encode($query);

    if (mysqli_query($connection, $query)) {
        $res = [
            'status' => 200,
            'message' => 'Post deleted',
        ];
    } else {
        echo mysqli_error($connection);
        $res = [
            'status' => 500,
            'error' => 'Post not deleted',
        ];
    }
    echo json_encode($res);
}

function createComment($connection, $data)
{

    $id_client = $_COOKIE['id'];
    $id_post = $data['post_id'];
    $text = $data['comment'];
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO comment (post_id, client_com_id, text, commented_at) VALUES ('$id_post', '$id_client', '$text', '$date');";

    // echo json_encode($query);

    if (mysqli_query($connection, $query)) {
        $res = [
            'status' => 201,
            'message' => 'Comment created',
        ];
    } else {
        $res = [
            'status' => 500,
            'error' => 'Comment not created',
        ];
    }
    echo json_encode($res);
}
