<?php
header('Content-Type: application/json');

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

require 'auth-service.php';

//cateodata se pune automat / la final de url, cateodata nu
if(sizeof($pieces) === 3 || $pieces[3] === '') {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(login_user());
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}