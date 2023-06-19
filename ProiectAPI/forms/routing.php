<?php

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

require 'forms-service.php';

if(sizeof($pieces) === 3 || $pieces[3] === '')
{
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (empty($_SERVER['QUERY_STRING'])) {
            echo json_encode(get_display_forms());
        }
        else
        {
            $query = parse_url($_SERVER['REQUEST_URI'])['query'];
            if(preg_match('/^tag\d+=\d+(&tag\d+=\d+)*$/',$query)) {
                parse_str($query, $params);
                echo json_encode(get_forms_with_tags($params));
            }
            else if (preg_match('/^creator-id=(\d+)&nr-forms=(\d+)$/', $query, $matches)) {
                $creatorId = intval($matches[1]);
                $numberForms = intval($matches[2]);
                echo json_encode(get_forms_by_user($creatorId,$numberForms));
            }
            else if(preg_match('/^user-id=(\d+)&nr-forms=(\d+)$/', $query, $matches)){
                $userId = intval($matches[1]);
                $numberForms = intval($matches[2]);
                echo json_encode(get_forms_responded_by_user($userId,$numberForms));
            }
            else if(preg_match('/^user-statistics-id=(-?\d+)$/', $query, $matches)){
                $userId = intval($matches[1]);
                echo json_encode(get_statistic_forms($userId));
            }
            else {
                // The query does not match the expected format
                echo "Invalid query";
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo json_encode(create_form());
    }
}
else
{
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo json_encode(get_form(intval($pieces[3])));
    }
}

