<?php

require __DIR__ . '\..\models\create-form-model.php';

session_start();
if(empty($_SESSION["username"]))
{
    HEADER("Location: /Proiect/login");
    exit;
}

function showCreateFormPage()
{
    $tags = getAllTags()['data'];
    $error = isset($_GET['error']) ? $_GET['error'] : '';
    $success = isset($_GET['success']) ? $_GET['success'] : '';
    $formName = isset($_GET['form-name']) ? $_GET['form-name'] : '';
    $formId = isset($_GET['form-id']) ? $_GET['form-id'] : '';
    $errorFormName = isset($_GET['error-form-name']) ? $_GET['error-form-name'] : '';
    $formName = isset($_GET['form-name']) ? $_GET['form-name'] : '';

    require __DIR__ . '\..\views\create-form-view.php';
}

function createForm()
{
    $formName = isset($_POST['form-name']) ? $_POST['form-name'] : '';
    $formDescription = isset($_POST['form-description']) ? $_POST['form-description'] : '';

    $formExpirationDate = isset($_POST['expiration-date']) ? $_POST['expiration-date'] : '';

    $statisticsPublicOrPrivate = $_POST['statistics-public-or-private'];
    $hideAfterExpiration = $_POST['hide-after-expiration'];

    $statisticsPublicOrPrivate = intval($statisticsPublicOrPrivate);
    $hideAfterExpiration = intval($hideAfterExpiration);

    $data = array(
        'form-name' => $formName,
        'user_id' => $_SESSION['id'],
        'form-description' => $formDescription,
        'form-expiration-date' => $formExpirationDate,
        'statistics-public-or-private' => $statisticsPublicOrPrivate,
        'hide-after-expiration' => $hideAfterExpiration,
    );

    $userId = $_SESSION['id'];

    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $tags_id = [];

    for($i = 0; $i < count($tags); $i++) {
        $response = tagNameToId($tags[$i]);
        if(isset($response['data'])) {
            $tags_id[] = $response['data']['id'];
        }
    }

    $data['tags_id'] = $tags_id;

    $dir = __DIR__ . '\..\..\public\resources\images\forms';

    if (!file_exists($dir) && !is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $mainImageName = $formName . '-main-image';
    $mainImage = $_FILES['main-image'];
    $temp = $mainImage['tmp_name'];
    $file_extension = pathinfo($mainImage['name'], PATHINFO_EXTENSION);

    move_uploaded_file($temp, "$dir\\$userId-$mainImageName.$file_extension");
    $data['main-image'] = "$userId-$mainImageName.$file_extension";

    $images = [];

    $formImages = $_FILES['images']['tmp_name'];
    if($formImages) {
        for ($i = 0; $i < count($formImages); $i++) {
            if($formImages[$i] == null)
                continue;
            $image = $formImages[$i];
            $imageName = $formName . "-image-$i";
            $file_extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
            move_uploaded_file($image, "$dir\\$userId-$imageName.$file_extension");
            $images[] = "$userId-$imageName.$file_extension";
        }
    }

    $data['images'] = $images;

    $components = [];
    $i = 1;

    while(isset($_POST["component-{$i}"])) {
        $component = [
            'name' => $_POST["component-{$i}"],
            'description' => $_POST["component-{$i}-description"],
        ];
        $componentImages = $_FILES["component-{$i}-images"]['tmp_name'];
        if($componentImages) {
            $images = [];

            for ($j = 0; $j < count($componentImages); $j++) {
                if($componentImages[$j] == null)
                    continue;
                $image = $componentImages[$j];
                $file_extension = pathinfo($_FILES["component-{$i}-images"]['name'][$j], PATHINFO_EXTENSION);
                $imageName = $formName . "-component-$i-image-$j";
                move_uploaded_file($image, "$dir\\$userId-$imageName.$file_extension");
                $images[] = "$userId-$imageName.$file_extension";
            }

            $component['images'] = $images;
        }
        $components[] = $component;
        $i++;
    }

    $data['components'] = $components;

    $result = saveForm($data);

    if(isset($result['errors'])) {
        $queryString = http_build_query($result['errors']);
        HEADER("Location: ?$queryString");
        exit;
    }

    HEADER("Location: ?success=true&form-name=$formName&form-id={$result['form']['id']}");
    exit;
}