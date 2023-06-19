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

function get_forms()
{
    global $db;

    $rez = $db->execute_query("SELECT id,name,description,user_id,ending_date,
            public_stats,show_after_exp,main_image FROM forms");

    if(!$rez) {
        http_response_code(500);
        die ("A survenit o eroare la interogare");
    }

    $forms = array();

    while($inreq = $rez ->fetch_assoc())
    {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}

function get_display_forms()
{
    global $db;

    $rez = $db->execute_query("SELECT id,name,description,user_id,ending_date,
            public_stats,show_after_exp,main_image FROM forms WHERE (ending_date > NOW() OR show_after_exp > 0) ORDER BY ending_date ASC");

    if(!$rez) {
        http_response_code(500);
        die ("A survenit o eroare la interogare");
    }

    $forms = array();

    while($inreq = $rez ->fetch_assoc())
    {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}
function get_forms_with_tags($params)
{
    global $db;

    $placeholders = implode(', ', array_fill(0, count($params), '?'));

    $sql_existence = "SELECT COUNT(*) FROM tags WHERE id IN ($placeholders)";

    $stmt = $db->prepare($sql_existence);

    // Extract the parameter values from the associative array
    $paramValues = array_values($params);

    // Bind the array values to the positional parameters
    $stmt->bind_param(str_repeat('i', count($paramValues)), ...$paramValues);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $count = $rez->fetch_assoc()['COUNT(*)'];

    if ($count !== count($params)) {
        http_response_code(404);
        return array('error' => 'One or more tags do not exists');
    }

    $sql_forms = "SELECT DISTINCT id, name, description, user_id, ending_date, public_stats, show_after_exp, main_image 
                  FROM forms f 
                  JOIN form_tags t ON f.id = t.form_id 
                  WHERE t.tag_id IN ($placeholders) AND (f.ending_date > NOW() OR f.show_after_exp > 0) ORDER BY ending_date ASC";

    $stmt = $db->prepare($sql_forms);

    // Extract the parameter values from the associative array
    $paramValues = array_values($params);

    // Bind the array values to the positional parameters
    $stmt->bind_param(str_repeat('i', count($paramValues)), ...$paramValues);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $forms = array();

    while ($inreq = $rez->fetch_assoc()) {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}


function get_forms_by_user($creatorId,$numberForms)
{
    global $db;
    $stmt = $db ->prepare("SELECT id,name,description,user_id,ending_date,
            public_stats,show_after_exp,main_image FROM forms WHERE user_id = ? ORDER BY ending_date ASC LIMIT 3
                     OFFSET ?");
    $offset = $numberForms * 3;
    $stmt -> bind_param("ii", $creatorId,$offset);
    $stmt -> execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die ('A survenit o eroare la interogare');
    }

    $forms = array();

    while ($inreq = $rez->fetch_assoc()) {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}

function get_form($id)
{
    global $db;
    $stmt = $db ->prepare("SELECT id,name,description,user_id,ending_date,
            public_stats,show_after_exp,main_image FROM forms WHERE id = ?");
    $stmt -> bind_param("i", $id);
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

    $stmt = $db->prepare("SELECT path FROM `form-images` WHERE form_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $imagesResult = $stmt->get_result();

    if (!$imagesResult) {
        http_response_code(500);
        return array('error' => 'Database error');
    }

    $images = [];
    while ($image = $imagesResult->fetch_assoc()) {
        $images[] = $image['path'];
    }

    $form['images'] = $images;

    $stmt = $db->prepare("SELECT id, name, description FROM `form_components` WHERE form_id = ? ORDER BY id ASC");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $componentsResult = $stmt->get_result();

    if (!$componentsResult) {
        http_response_code(500);
        return array('error' => 'Database error');
    }

    $components = [];

    while ($component = $componentsResult->fetch_assoc()) {
        $images = [];
        $stmt = $db->prepare("SELECT path FROM `components-images` WHERE component_id = ?");
        $stmt->bind_param("i", $component['id']);

        $stmt->execute();
        $imagesResult = $stmt->get_result();

        if (!$imagesResult) {
            http_response_code(500);
            return array('error' => 'Database error');
        }

        while ($image = $imagesResult->fetch_assoc()) {
            $images[] = $image['path'];
        }

        $component['images'] = $images;

        $components[] = $component;
    }

    // Add the components to the form data
    $form['components'] = $components;

    $stmt = $db->prepare("SELECT t.id, t.name FROM tags t JOIN form_tags ft ON t.id = ft.tag_id WHERE ft.form_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $tagsResult = $stmt->get_result();

    if (!$tagsResult) {
        http_response_code(500);
        die('A survenit o eroare la interogare');
    }

    $tags = [];
    while ($tag = $tagsResult->fetch_assoc()) {
        $tags[] = $tag;
    }

    $form['tags'] = $tags;
    return $form;
}

function get_forms_responded_by_user($userId,$numberForms)
{
    global $db;
    $stmt = $db ->prepare("SELECT f.id, f.name, f.description, f.user_id, f.ending_date, f.public_stats, f.show_after_exp, f.main_image,
    (COUNT(DISTINCT cr.component_id) + 1) / (COUNT(DISTINCT fc.id) + 1) AS division
FROM `forms` f
JOIN `form-responses` r ON f.id = r.form_id
LEFT JOIN `form_components` fc ON f.id = fc.form_id
LEFT JOIN `component-responses` cr ON fc.id = cr.component_id AND r.user_id = cr.user_id
WHERE r.user_id = ?
GROUP BY f.id, f.name, f.description, f.user_id, f.ending_date, f.public_stats, f.show_after_exp, f.main_image
LIMIT 3 OFFSET ?;
");
    $offset = $numberForms * 3;
    $stmt -> bind_param("ii", $userId,$offset);
    $stmt -> execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        die ('A survenit o eroare la interogare');
    }

    $forms = array();

    while ($inreq = $rez->fetch_assoc()) {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}

function create_form()
{
    global $db;

    $body = json_decode(file_get_contents('php://input'), true);

    if(!isset($body['key']) || $body['key'] != 'bvs8dgfy2etf72gfywasxfc721twe108yew20812y3jdsbfcjhnzxbczxyc8293eg2bd27zzx') {
        return ['error' => 'Invalid key! This API is only for internal use!'];
    }

    $stmt = $db->prepare('SELECT COUNT(*) FROM forms WHERE user_id = ? AND name = ?');
    $stmt->bind_param('is', $body['user_id'], $body['form-name']);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $count = $rez->fetch_assoc()['COUNT(*)'];

    if ($count !== 0) {
        http_response_code(409);
        return ['error-form-name' => 'A form with this name already exists', 'form-name' => $body['form-name']];
    }

    if (!isset($body['form-name'], $body['form-description'], $body['user_id'], $body['form-expiration-date'], $body['statistics-public-or-private'], $body['hide-after-expiration'], $body['main-image'])) {
        http_response_code(400);
        return ['error' => 'One or more required fields are missing'];
    }

    $name = $body['form-name'];
    $description = $body['form-description'];
    $user_id = $body['user_id'];
    $ending_date = $body['form-expiration-date'];
    $public_stats = $body['statistics-public-or-private'];
    $show_after_exp = $body['hide-after-expiration'];
    $main_image = $body['main-image'];
    $tags_id = isset($body['tags_id']) ? $body['tags_id'] : [];

    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    $rez = $stmt->get_result();
    if (!$rez) {
        http_response_code(500);
        return ['error' => 'Database error'];
    }

    $count = $rez->fetch_assoc()['COUNT(*)'];

    if ($count === 0) {
        http_response_code(404);
        return ['error' => 'User not found'];
    }

    $stmt = $db->prepare('INSERT INTO forms (name, description, user_id, ending_date, public_stats, show_after_exp, main_image) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssisiis', $name, $description, $user_id, $ending_date, $public_stats, $show_after_exp, $main_image);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(500);
        return ['error' => 'Database insert error'];
    }

    $formId = $stmt->insert_id;

    if(isset($body['images'])) {
        for ($i = 0; $i < count($body['images']); $i++) {
            $path = $body['images'][$i];
            $stmt = $db->prepare('INSERT INTO `form-images` (form_id, path) VALUES (?, ?)');
            $stmt->bind_param('is', $formId, $path);
            $stmt->execute();
            if ($stmt->affected_rows === 0) {
                http_response_code(500);
                return ['error' => 'Database insert error'];
            }
        }
    }

    if(isset($body['components'])) {
        for ($i = 0; $i < count($body['components']); $i++) {
            $component = $body['components'][$i];

            $stmt = $db->prepare('INSERT INTO `form_components` (form_id, name, description) VALUES (?, ?, ?)');
            $stmt->bind_param('iss', $formId, $component['name'], $component['description']);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                http_response_code(500);
                return ['error' => 'Database insert error'];
            }

            $componentId = $stmt->insert_id;

            if(isset($component['images'])) {
                for ($j = 0; $j < count($component['images']); $j++) {
                    $path = $component['images'][$j];
                    $stmt = $db->prepare('INSERT INTO `components-images` (component_id, path) VALUES (?, ?)');
                    $stmt->bind_param('is', $componentId, $path);
                    $stmt->execute();
                    if ($stmt->affected_rows === 0) {
                        http_response_code(500);
                        return ['error' => 'Database insert error'];
                    }
                }
            }
        }
    }

    for($i = 0; $i < count($tags_id); $i++) {
        $tag_id = $tags_id[$i];
        $stmt = $db->prepare('INSERT INTO `form_tags` (form_id, tag_id) VALUES (?, ?)');
        $stmt->bind_param('ii', $formId, $tag_id);
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            http_response_code(500);
            return ['error' => 'Database insert error'];
        }
    }

    $response = [];
    $response['status'] = 'success';
    $response['form'] = get_form($formId);
    return $response;
}

function get_statistic_forms($userId)
{
    global $db;

    $stmt = $db->prepare("SELECT id,name,description,user_id,ending_date,
            public_stats,show_after_exp,main_image FROM `forms` WHERE user_id = ? OR public_stats > 0");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $rez = $stmt->get_result();
    if(!$rez) {
        http_response_code(500);
        die ("A survenit o eroare la interogare");
    }

    $forms = array();

    while($inreq = $rez ->fetch_assoc())
    {
        $forms[] = $inreq;
    }

    if (empty($forms)) {
        // Return 404 Not Found if no forms are found
        http_response_code(404);
        $response = array('error' => 'No forms found');
    } else {
        // Return 200 OK with the forms data if found
        $response = $forms;
    }

    return $response;
}