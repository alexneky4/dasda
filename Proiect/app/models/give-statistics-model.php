<?php
function getForm($id) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/forms/' . $id);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $code = curl_getinfo($c, CURLINFO_HTTP_CODE); 
    curl_close($c);
    
    $response = array(
        'data' => null,
        'error' => null
    );

    if ($code == 200) {
        $response['data'] = $result;
    } 
    else if ($code == 404) {
        $response['error'] = 'No forms found';
    } 
    else {
        $response['error'] = 'An error occurred during the request';
    }

    return $response;
}

function getEmotions($form_id,$query) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/statistics/'.$form_id.'/?' . $query);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $code = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);
    $response = array (
        'data' => null,
        'error' => null
    );
    if($code == 200) {
        $response['data'] = $result;
    }
    else if($code == 404) {
        $response['error'] = 'No emotions available for this selection';
    }
    else {
        $response['error'] = 'An error occured during the request';
    }
    return $response;
}

function getResponses($form_id,$query)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'localhost/ProiectAPI/responses/'.$form_id.'/?' . $query);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    $code = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);
    $response = array (
        'data' => null,
        'error' => null
    );
    if($code == 200) {
        $response['data'] = $result;
    }
    else if($code == 404) {
        $response['error'] = 'No emotions available for this selection';
    }
    else {
        $response['error'] = 'An error occured during the request';
    }
    return $response;
}


?>