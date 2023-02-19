<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/includes/config.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$connection = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['database']);

// $connection = mysqli_connect('localhost', 'root', '5926', 'socialnetwork');

if ($connection == false) {
    echo "Failed to connect: ";
} 