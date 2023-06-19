<?php

session_start();

include __DIR__ . '/../models/give-feedback-model.php';
function showGiveFeedback($form_id)
{
    if($form_id === null) {
        $form_id = 0;
    }

    $form = getFormById($form_id);

    if(isset($form['error'])) {
        include __DIR__ . '/../views/give-feedback-view.php';
        exit;
    }

    $success = isset($_GET['success']) ? $_GET['success'] : '';
    $edit = isset($_GET['edit']) ? $_GET['edit'] : '';
    $formName = $form['name'];
    $formDescription = $form['description'];
    $tags = $form['tags'];
    $images = [];
    $images[] = $form['main_image'];
    $images = array_merge($images, $form['images']);
    $components = $form['components'];

    include __DIR__ . '/../views/give-feedback-view.php';
}

function giveFeedback($form_id)
{
    date_default_timezone_set('Europe/Bucharest');

    if($form_id === null) {
        $form_id = 0;
    }

    $form = getFormById($form_id);

    if(isset($form['error'])) {
        include __DIR__ . '/../views/give-feedback-view.php';
        exit;
    }

    $errors = [];

    if(isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    } else {
        $user_id = 0;
    }
    $emotion_main = isset($_POST['choose-emotion-main']) ? $_POST['choose-emotion-main'] : '';
    if($emotion_main === '') {
        $errors['emotion-main-error'] = ['Please choose an emotion'];
    }
    $description_main = isset($_POST['explain-emotion']) ? $_POST['explain-emotion'] : '';
    $response_date = date("Y-m-d H:i:s");

    $components_responses = [];

    for($i = 0; $i < count($form['components']); $i++) {
        $component_id = $form['components'][$i]['id'];
        $emotion = isset($_POST['choose-emotion-component-' . $component_id]) ? $_POST['choose-emotion-component-' . $component_id] : '';
        if($emotion === '') {
            $errors['emotion-component-' . $component_id . '-error'] = ['Please choose an emotion'];
        }
        $description = isset($_POST['explain-emotion-component-' . $component_id]) ? $_POST['explain-emotion-component-' . $component_id] : '';
        $components_response = array(
            'component_id' => $component_id,
            'emotion' => $emotion,
            'description' => $description,
            'response_date' => $response_date,
        );
        $components_responses[] = $components_response;
    }

    if(count($errors) > 0) {
        $refillData = [];
        $refillData['emotion-main'] = $emotion_main;
        $refillData['description-main'] = $description_main;

        for($i = 0; $i < count($form['components']); $i++) {
            $component_id = $form['components'][$i]['id'];
            $emotion = isset($_POST['choose-emotion-component-' . $component_id]) ? $_POST['choose-emotion-' . $component_id] : '';
            $description = isset($_POST['explain-emotion-component-' . $component_id]) ? $_POST['explain-emotion-' . $component_id] : '';
            $refillData['emotion-component-' . $component_id] = $emotion;
            $refillData['description-component-' . $component_id] = $description;
        }

        $queryString = http_build_query($errors + $refillData);
        HEADER("Location: /Proiect/give-feedback/$form_id?$queryString");
        exit;
    }

    $data = array(
        'user_id' => $user_id,
        'form_id' => $form_id,
        'emotion_main' => $emotion_main,
        'description_main' => $description_main,
        'response_date' => $response_date,
        'components_responses' => $components_responses,
    );

    $result = saveResponse($data);

    if(isset($result['errors'])) {
        $refillData = [];
        $refillData['emotion-main'] = $emotion_main;
        $refillData['description-main'] = $description_main;

        for($i = 0; $i < count($form['components']); $i++) {
            $component_id = $form['components'][$i]['id'];
            $emotion = isset($_POST['choose-emotion-component-' . $component_id]) ? $_POST['choose-emotion-component-' . $component_id] : '';
            $description = isset($_POST['explain-emotion-component-' . $component_id]) ? $_POST['explain-emotion-component-' . $component_id] : '';
            $refillData['choose-emotion-component-' . $component_id] = $emotion;
            $refillData['explain-description-component-' . $component_id] = $description;
        }

        $queryString = http_build_query($result['errors'] + $refillData);
        HEADER("Location: /Proiect/give-feedback/$form_id?$queryString");
        exit;
    }

    $queryArray = ['success' => true];
    if(isset($result['edit']) && $result['edit'] === true) {
        $queryArray['edit'] = true;
    }
    $query = http_build_query($queryArray);
    HEADER("Location: /Proiect/give-feedback/$form_id?$query");
    exit;
}
