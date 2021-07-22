<?php
  require __DIR__.'/../vendor/autoload.php';

  //new record | new row
  function new_row($service, $spreadsheetId, $range){
    $values = [["New Row", "Hello", "Ball", "Panupan"]];

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW',
        'insertDataOption' => 'INSERT_ROWS'
    ];

    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    printf("%d cells appended.", $result->getUpdates()->getUpdatedCells());
  }


  //check all row active
  function count_row($service, $spreadsheetId){
    $result = $service->spreadsheets_values->get($spreadsheetId, "1:1000");
    $rowsactive = $result->getValues() != null ? count($result->getValues()) : 0;
    echo "rows retrieved : " . $rowsactive;
    $sheet_name = "sheet_1!";
    $range = $sheet_name . ($rowsactive+1) . ":" . ($rowsactive+1);
  }



  //Create a new sheet
  function new_sheet($service, $spreadsheetId, $title){
    $title = "my new sheet";
    //Create New Sheet
    $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
      array('requests' => array('addSheet' => array('properties' => array('title' => $title ))))
    );

    $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
      'title' => $title
    ]);

    $result = $service->spreadsheets->batchUpdate($spreadsheetId,$body);
  }
  


  function xxx($service, $spreadsheetId){
    $range="sheet_1!11:11";
    $values = array(
      array(
        "Tom", "Thumb", "tomthumb", "tom@thumb.com"
      )
    );
    $data = array();

    $data[] = new Google_Service_Sheets_ValueRange(array(
      'range' => $range,
      'values' => $values
      )
    );

    $body = new Google_Service_Sheets_BatchUpdateValuesRequest(array(
      'valueInputOption' => 'RAW',
      'data' => $data
      )
    );
    $result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
  }



?>