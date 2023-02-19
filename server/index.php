<?php

header('Content-Type: application/json');

require './database.php';
require './functions.php';

$method = $_SERVER['REQUEST_METHOD'];

$url = $_SERVER['REQUEST_URI'];
$urlType = explode('/', $url);

$type = $urlType[3];
$id = $urlType[4];

// echo json_encode($type);

if ($method == 'GET') {
    $limit = explode('?', $type);
    $q = $limit[1];
    // echo json_encode($limit[1]);

    if (($type == 'posts' || $limit[0] == 'posts') && $id == null) {
        if ($q != null)
        {
            $postCol = explode('=', $q);
            getPosts($connection, $postCol[1]);
        }
        else
            getPosts($connection);
    }  else if ($limit[0] == 'postsbyname' && $id == null) {
        $postCol = explode('=', $limit[1]);
        $postSort = explode('=', $limit[2]);
        $limitPostSearch = explode('=', $limit[3]);

        // echo json_encode($postCol[1]);
        // echo json_encode($postSort[1]);

        getPostsByName($connection, $postCol[1], $postSort[1], $limitPostSearch[1]);
    }

    if ($type == 'post' && $id != null)
        getPost($connection, $id);

    if ($type == 'interestingposts') {
        $count = 5;
        getInterestingPosts($connection, $count);
    }

} else if ($method == 'POST') {
    if ($type == 'post')
        createPost($connection, array_merge($_POST, $_FILES));
    else if ($type == 'comment')
        // echo json_encode($_POST);
        createComment($connection, $_POST);
    else if ($type == 'editpost')
        editPost($connection, array_merge($_POST, $_FILES));
    else if ($type == 'createsamepost')
        createSamePost($connection, array_merge($_POST, $_FILES));
        
} else if ($method == 'DELETE') {
    if ($type == 'deletepost' && $id != null)
        deletePost($connection, $id);

        // editPost($connection, $_POST);
}
