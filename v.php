<?php
    header('Content-Type: application/json');

    $data = array(
        'requests' => array(
            'insertDimension' => array(
                'range' => array(
                    'sheetId' => '0',
                    'dimension' => 'COLUMNS',
                    'startIndex' => '2',
                    'endIndex' => '4'
                ),'inheritFromBefore' => true)
              )
      );


    echo json_encode($data);


?>

{
    "majorDimension": null,
    "range": "sheet_1!11:11",
    "values": [
        ["1", "2", "3", "4"]
    ]
}