<?php
session_start();
require __DIR__ . '\..\models\give-statistics-model.php';


$path = parse_url($_SERVER['REQUEST_URI'])['path'];

$pieces = explode('/', $path);

function showFromStatistics($form_id){

        $response = getForm($form_id);

        $formular = json_decode($response['data']);
        $error = $response['error'];
    require __DIR__ . '\..\views\give-statistics-view.php';
}

function downloadFormat($form_id,$format,$query){
            parse_str($query, $params);
            $responses = array();

            $responses['emotions'] = json_decode(getEmotions($form_id,$query)['data']);
            $responses['responses'] = json_decode(getResponses($form_id,$query)['data']);
            $result = json_encode($responses,JSON_PRETTY_PRINT);
            if($format === 'json')
            {
                header('Content-Description: File Transfer');
                header('Content-Type: application/json');
                header('Content-Disposition: attachment; filename=export-statistics.json');
                echo $result;
            }
            else if($format === 'csv')
            {
                ob_start();

// Open output stream
                $f = fopen('php://output', 'w');
                $dataDecoded = json_decode($result,true);
                foreach($dataDecoded as $reportPart => $reportValue)
                {
                    if($reportPart === 'emotions'){
                        foreach($reportValue as $innerArray) {

                            foreach ($innerArray as $componentPart => $componentValue)
                            {
                                foreach ($componentValue as $secondInnerArray) {

                                    foreach($secondInnerArray as $key => $value){
                                        $line=[$reportPart,$componentPart,$key,$value];
                                        fputcsv($f,$line);
                                    }

                                }
                            }
                        }
                    }
                    else if($reportPart === 'responses'){
                        foreach($reportValue as $innerArray) {

                            foreach ($innerArray as $componentPart => $componentValue)
                            {
                                foreach ($componentValue as $secondInnerArray) {
                                    $line=[$reportPart,$componentPart,'username',$secondInnerArray['username'],'emotion',$secondInnerArray['emotion'],'description',$secondInnerArray['description']];
                                    fputcsv($f,$line);
                                }
                            }
                        }
                    }

                }

                $csvData = ob_get_clean();

                header('Content-Description: File Transfer');
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=data.csv');

                echo $csvData;
            }

}

?>