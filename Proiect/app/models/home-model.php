<?php

function getAllForms()
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/forms/');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE); // Get the HTTP status code
    curl_close($c);

    $response = array(
        'data' => null,
        'error' => null
    );

    if ($httpCode == 200) {
        // Successful response
        $response['data'] = $result;
    } elseif ($httpCode == 404) {
        // No forms found
        $response['error'] = 'No forms found';
    } else {
        // Error occurred
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}

function getFormsByQuery($query)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/forms/?' . $query);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($c);

    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE); // Get the HTTP status code
    curl_close($c);

    $response = array(
        'data' => null,
        'error' => null
    );

    if ($httpCode == 200) {
        // Successful response
        $response['data'] = $result;
    } elseif ($httpCode == 404) {
        // No forms found
        $response['error'] = 'No forms found';
    } else {
        // Error occurred
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}
function getAllTags()
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/tags/');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE); // Get the HTTP status code
    curl_close($c);
    $response = array(
        'data' => null,
        'error' => null
    );

    if ($httpCode == 200) {
        // Successful response
        $response['data'] = $result;
    } elseif ($httpCode == 404) {
        // No forms found
        $response['error'] = 'No tags found';
    } else {
        // Error occurred
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}
