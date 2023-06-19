<?php

require 'statistics-service.php';

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);
//echo $path;
//echo '<br>';
//var_dump($segments);
//echo '<br>';
//echo sizeof($segments);

if(sizeof($pieces) == 4 || $pieces[4] == '') {
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $form_id = $pieces[3];
        if(!empty($_SERVER['QUERY_STRING'])) {
            $query = parse_url($_SERVER['REQUEST_URI'])['query'];
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
                $result[] = cat_sort($form_id, $component, $ages, $date);
            }
            echo json_encode($result);

        }
        //echo "Buna";
    }
}
?>