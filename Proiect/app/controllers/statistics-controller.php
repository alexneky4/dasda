<?php
//require __DIR__ . '\..\views\statistics-view.php';
session_start();

require __DIR__ . '\..\models\statistics-model.php';

function statisticView(){
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }
        else $id = -1;
        $response = get_forms($id);
        $forms = json_decode($response['data']);
        $error = $response['error'];

        require __DIR__ . '\..\..\core\timer.php';
        require __DIR__ . '\..\views\statistics-view.php';
}

?>