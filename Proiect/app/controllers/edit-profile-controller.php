<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(302);
    header('Location: /login');
    exit();
}
require __DIR__ . '\..\models\edit-profile-model.php';
require __DIR__ . '\..\..\core\utils.php';

function showEditPage()
{
    if (isset($_SESSION['profile_picture_path']) && $_SESSION['profile_picture_path']) {
        $profile_picture_path = "/Proiect/public/resources/images/users/" . $_SESSION['profile_picture_path'];
    } else {
        $profile_picture_path = '/Proiect/public/resources/images/no-profile-picture.jpg';
    }

    $formValues = array(
        'username' => isset($_GET['username']) ? $_GET['username'] : $_SESSION['username'],
        'email' => isset($_GET['email']) ? $_GET['email'] : $_SESSION['email'],
        'date-of-birth' => isset($_GET['date-of-birth']) ? $_GET['date-of-birth'] : $_SESSION['date_of_birth'],
        'gender' => isset($_GET['gender']) ? $_GET['gender'] : $_SESSION['gender'],
        'phone' => isset($_GET['phone-number']) ? $_GET['phone-number'] : $_SESSION['phone_number'],
        'country' => isset($_GET['country']) ? $_GET['country'] : $_SESSION['country'],
    );
    $errors = array(
        'general' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'dateOfBirth' => null,
        'gender' => null,
        'phone' => null,
        'country' => null
    );

    if (isset($_GET['error-general'])) {
        $errors['general'] = $_GET['error-general'];
    }

    foreach ($errors as $errorType => &$errorValue) {
        if (isset($_GET['error-' . $errorType])) {
            $errorValue = $_GET['error-' . $errorType];
        }
    }

    require __DIR__ . '\..\views\edit-profile-view.php';
}

function updateUser()
{
    $username = isset($_POST['username']) ? $_POST['username'] : $_SESSION['username'];
    $email = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dateOfBirth = isset($_POST['date-of-birth']) ? $_POST['date-of-birth'] : $_SESSION['date_of_birth'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : $_SESSION['gender'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : $_SESSION['phone_number'];
    $country = isset($_POST['country']) ? $_POST['country'] : $_SESSION['country'];
    $dir = __DIR__ . '\..\..\public\resources\images\users';

    if (!file_exists($dir) && !is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $imageName = 'none';
    if(isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $file_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = $_SESSION['id'] . '_' . 'profile_picture' . '.' . $file_extension;
        $temp = $image['tmp_name'];

        move_uploaded_file($temp, $dir . '\\' . $imageName);
    }

    $data = [];

    if (strlen($username) === 0) {
        $data['error-username'] = 'Username is required';
    }

    if (strlen($email) === 0) {
        $data['error-email'] = 'Email is required';
    }

//    if (strlen($password) === 0) {
//        $data['error-password'] = 'Password is required';
//    }

    if (strlen($dateOfBirth) === 0) {
        $data['error-dateOfBirth'] = 'Date of birth is required';
    }

    if (strlen($gender) === 0) {
        $data['error-gender'] = 'Gender is required';
    }
    if (strlen($country) === 0) {
        $data['error-country'] = 'Country is required';
    }

    if (!isset($data['error-country']) && Utils::isValidCountry($country) === false) {
        $data['error-country'] = 'Country is invalid';
    }

    if (count($data) > 0) {
        $formData = array('username' => $username, 'email' => $email, 'date-of-birth' => $dateOfBirth, 'phone' => $phone, 'gender' => $gender, 'country' => $country);
        $queryString = http_build_query($data + $formData);
        header("Location: ?$queryString");
        exit();
    }

    $result = sendUpdateUserRequest($_SESSION['id'], $username, $email, $password, $dateOfBirth, $gender, $phone, $country, $imageName);

    if ($result['status'] === 'error') {
        $formData = array('username' => $username, 'email' => $email, 'date-of-birth' => $dateOfBirth, 'gender' => $gender, 'country' => $country);
        $queryString = http_build_query($result + $formData);
        header("Location: ?$queryString");
        exit();
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['date_of_birth'] = $dateOfBirth;
        $_SESSION['gender'] = $gender;
        $_SESSION['phone_number'] = $phone;
        $_SESSION['country'] = $country;
        $_SESSION['profile_picture_path'] = $imageName;
        http_response_code(302);
        header("Location: /Proiect/profile");
        exit();
    }
}