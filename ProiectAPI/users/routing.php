<?php
header('Content-Type: application/json');

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

require 'users-service.php';

//cateodata se pune automat / la final de url, cateodata nu
if(sizeof($pieces) === 3 || $pieces[3] === '') {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode(get_users());
    }
    else if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(post_user());
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}
else {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode(get_user($pieces[3]));
    }
    else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        echo json_encode(delete_user($pieces[3]));
    }
    else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
        echo json_encode(put_user($pieces[3]));
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}