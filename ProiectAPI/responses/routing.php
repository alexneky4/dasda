<?php

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

require 'responses-service.php';
if(sizeof($pieces) === 3 || $pieces[3] === ''){
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo json_encode(get_all_responses());
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo json_encode(create_form_response());
    }
}
else if(sizeof($pieces) === 4 || $pieces[4] === ''){
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $formId = $pieces[3];
        if(empty($_SERVER['QUERY_STRING'])) {
            echo json_encode(get_responses_for_form($formId));
        }
        else
        {
            $query = $_SERVER['QUERY_STRING'];
            parse_str($query, $params);

            $components = [];
            $ages = [];
            $date;
            foreach ($params as $key => $value) {
                if (strpos($key, 'component') === 0) {
                    $components[] = $value;
                } elseif (strpos($key, 'age') === 0) {
                    $ages[] = $value;
                } elseif (strpos($key, 'date') === 0) {
                    $date = $value;
                }
            }
            $result = array();
            foreach($components as $component) {
                if(intval($component) === -1)
                    $result['form'] = get_responses_for_component($formId, $component, $ages, $date);
                else
                    $result['component-id: ' .$component] = get_responses_for_component($formId, $component, $ages, $date);
            }
            echo json_encode($result);
        }
    }
}
else if(sizeof($pieces) === 4 || $pieces[4] === ''){
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $formId = $pieces[3];
        $userId = $pieces[4];
        echo json_encode(get_response_form_user($formId,$userId));
    }
}