<?php


$db = new mysqli (
    'localhost',
    'root',
    '',
    'emof'
);

if (mysqli_connect_errno()) {
    die ('Conexiunea a esuat...');
}

header("Content-Type: application/json");

function get_tags()
{
    global $db;

    $rez = $db->execute_query("SELECT id,name FROM tags");

    if (!$rez) {
        http_response_code(500);
        die ("A survenit o eroare la interogare");
    }

    $tags = array();

    while ($inreq = $rez->fetch_assoc()) {
        $tags[] = $inreq;
    }

    if (empty($tags)) {
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        $response = $tags;
    }

    return $response;
}

function get_tag_by_name($name)
{
    global $db;
    $stmt = $db ->prepare("SELECT id,name FROM tags WHERE name = ?");
    $stmt -> bind_param("s", $name);
    $stmt -> execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die ('A survenit o eroare la interogare');
    }

    $form = $rez->fetch_assoc();

    if ($form === null) {
        // Return 404 Not Found if the form with the given ID doesn't exist
        http_response_code(404);
        return array('error' => 'Form not found');;
    }

    return $form;
}

function delete_tag($name)
{
    $name = urldecode($name);

    global $db;

    $body = json_decode(file_get_contents('php://input'), true);
    if(!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $stmt = $db->prepare("SELECT id, name FROM tags WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();


    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $tag = $rez->fetch_assoc();
    if($tag === null) {
        http_response_code(404);
        return ['error' => 'Tag not found'];
    }

    $stmt = $db->prepare("DELETE FROM form_tags WHERE tag_id = ?");
    $stmt->bind_param("i", $tag['id']);
    $stmt->execute();


    $stmt = $db ->prepare("DELETE FROM tags WHERE name = ?");
    $stmt -> bind_param("s", $name);
    $stmt -> execute();

    return ['status' => 'success'];
}

function create_tag()
{
    global $db;

    $body = json_decode(file_get_contents('php://input'), true);
    if(!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        http_response_code(403);
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    if(!isset($body['tag_name'])) {
        http_response_code(400);
        return ['error' => 'Missing name'];
    }

    $stmt = $db->prepare("SELECT id, name FROM tags WHERE name = ?");
    $stmt->bind_param("s", $body['tag_name']);
    $stmt->execute();

    $rez = $stmt->get_result();

    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $tag = $rez->fetch_assoc();
    if($tag !== null) {
        http_response_code(409);
        return ['error' => 'Tag already exists'];
    }

    $stmt = $db->prepare("INSERT INTO tags (name) VALUES (?)");
    $stmt->bind_param("s", $body['tag_name']);
    $stmt->execute();

    return ['status' => 'success', 'tag_id' => $stmt->insert_id, 'tag_name' => $body['tag_name']];
}