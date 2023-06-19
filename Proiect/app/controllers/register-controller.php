<?php

session_start();
if(!empty($_SESSION["username"]))
{
    HEADER("Location: /Proiect/home");
    exit;
}

require __DIR__ . '\..\models\register-model.php';
require __DIR__ . '\..\..\core\utils.php';

function showRegisterPage()
{
    $formValues = array(
        'username' => isset($_GET['username']) ? $_GET['username'] : '',
        'email' => isset($_GET['email']) ? $_GET['email'] : '',
        'date-of-birth' => isset($_GET['date-of-birth']) ? $_GET['date-of-birth'] : '',
        'gender' => isset($_GET['gender']) ? $_GET['gender'] : '',
        'country' => isset($_GET['country']) ? $_GET['country'] : '',
    );

    $errors = array(
        'general' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'dateOfBirth' => null,
        'gender' => null,
        'country' => null
    );

    if(isset($_GET['error-general'])) {
        $errors['general'] = $_GET['error-general'];
    }

    foreach ($errors as $errorType => &$errorValue) {
        if (isset($_GET['error-' . $errorType])) {
            $errorValue = $_GET['error-' . $errorType];
        }
    }

    require __DIR__ . '\..\views\register-view.php';
}

function registerUser()
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dateOfBirth = isset($_POST['date-of-birth']) ? $_POST['date-of-birth'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';

    $data = [];

    if (strlen($username) === 0) {
        $data['error-username'] = 'Username is required';
    }

    if (strlen($email) === 0) {
        $data['error-email'] = 'Email is required';
    }

    if (strlen($password) === 0) {
        $data['error-password'] = 'Password is required';
    }

    if (strlen($dateOfBirth) === 0) {
        $data['error-dateOfBirth'] = 'Date of birth is required';
    }

    if (strlen($gender) === 0) {
        $data['error-gender'] = 'Gender is required';
    }

    if (strlen($country) === 0) {
        $data['error-country'] = 'Country is required';
    }

    if(!isset($data['error-country']) && Utils::isValidCountry($country) === false) {
        $data['error-country'] = 'Country is invalid';
    }

    if (count($data) > 0) {
        $formData = array('username' => $username, 'email' => $email, 'date-of-birth' => $dateOfBirth, 'gender' => $gender, 'country' => $country);
        $queryString = http_build_query($data + $formData);
        header("Location: ?$queryString");
        exit();
    }

    $result = sendRegisterUserRequest($username, $email, $password, $dateOfBirth, $gender, $country);

    if($result['status'] === 'error') {
        $formData = array('username' => $username, 'email' => $email, 'date-of-birth' => $dateOfBirth, 'gender' => $gender, 'country' => $country);
        $queryString = http_build_query($result + $formData);
        header("Location: ?$queryString");
        exit();
    } else {
        $queryString = http_build_query(['message' => 'You successfully registered! Please login!']);
        header("Location: login?$queryString");
        exit();
    }
}