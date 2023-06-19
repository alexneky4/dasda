<?php


function get_forms_taken($user_id)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/forms/?user-id=' .$user_id. '&nr-forms=0');
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
function get_forms_created($user_id)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/forms/?creator-id=' .$user_id. '&nr-forms=0');
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