<?php
$url = $_SERVER['REQUEST_URI'];

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);
//cateodata se pune automat / la final de url, cateodata nu
if (sizeof($pieces) === 2 || $pieces[2] == '') {
    require __DIR__ . '/app/controllers/index-controller.php';
} else {
    $page = $pieces[2];

    switch ($page) {
        case 'register':
            require __DIR__ . '/app/controllers/register-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                showRegisterPage();
            } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
                registerUser();
            }
            break;

        case 'login':
            require __DIR__ . '/app/controllers/login-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                showLoginPage();
            } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
                loginUser();
            }
            break;

        case 'about':
            require __DIR__ . '/app/controllers/about-controller.php';
            break;

        case 'home':
            require __DIR__ . '/app/controllers/home-controller.php';
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!empty($_SERVER['QUERY_STRING'])) {
                    $query = parse_url($_SERVER['REQUEST_URI'])['query'];
                    formsWithQuery($query);
                }
                else {
                    formsWithoutQuery();
                }
            }
            break;

        case 'create-form':
            require __DIR__ . '/app/controllers/create-form-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                showCreateFormPage();
            } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
                createForm();
            }
            break;

        case 'profile':
            require __DIR__ . '/app/controllers/profile-controller.php';
            break;

        case 'give-feedback':
            require __DIR__ . '/app/controllers/give-feedback-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                if(sizeof($pieces) === 3) {
                    $form_id = null;
                } else {
                    $form_id = $pieces[3];
                }
                showGiveFeedback($form_id);
            } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(sizeof($pieces) === 3) {
                    $form_id = null;
                } else {
                    $form_id = $pieces[3];
                }
                giveFeedback($form_id);
            }
            break;

        case 'give-statistics':
            require __DIR__ . '/app/controllers/give-statistics-controller.php';
            if(sizeof($pieces) === 4 || $pieces[4] === '') {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $form_id = $pieces[3];
                    showFromStatistics($form_id);
                }
            }
            else if(sizeof($pieces) === 5 || $pieces[5] === '') {
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if (!empty($_SERVER['QUERY_STRING'])) {
                        $form_id = $pieces[3];
                        $format = $pieces[4];
                        $query = parse_url($_SERVER['REQUEST_URI'])['query'];
                        downloadFormat($form_id,$format,$query);
                    }
                }
            }
            break;

        case 'documentation':
            require __DIR__ . '/app/controllers/documentation-controller.php';
            break;

        case 'logout':
            require __DIR__ . '/app/controllers/logout-controller.php';
            break;

        case 'statistics':
            require __DIR__ . '/app/controllers/statistics-controller.php';
            if(sizeof($pieces) === 3 || $pieces[3] === '') {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    statisticView();
                }
            }
            break;

        case 'edit-profile':
            require __DIR__ . '/app/controllers/edit-profile-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                showEditPage();
            } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
                updateUser();
            }
            break;

        case 'admin':
            require __DIR__ . '/app/controllers/admin-controller.php';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                showAdminPage();
            }
            break;

        default:
            http_response_code(404);
            break;
    }
}