<?php
header('Content-Type: application/json');
$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

require 'tags-service.php';


if(sizeof($pieces) === 3 || $pieces[3] === '')
{
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo json_encode(get_tags());
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo json_encode(create_tag());
    }
}
else
{
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo json_encode(get_tag_by_name($pieces[3]));
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE')
    {
        echo json_encode(delete_tag($pieces[3]));
    }
}