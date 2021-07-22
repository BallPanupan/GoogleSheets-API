<?php
  require __DIR__.'/../vendor/autoload.php';

  $client = new \Google_Client();
  $client -> setApplicationName('Google Sheets and PHP');
  $client -> setScopes(Google_Service_Sheets::SPREADSHEETS);
  $client -> setAccessType('offline');
  $client -> setAuthConfig('credentials.json');
  $service = new Google_service_Sheets($client);

  $spreadsheetId = '15-wJkhwP_vg8vcqtqcGR8YJuyenDd0HqaA0zUMeClFc';
  $range = 'sheet_1!11:11';


  print_r($_POST);
  echo "<br/>";
  
  if(isset($_POST)){
    new_row($service, $spreadsheetId, $range, $_POST);
  }

  //new record | new row
  function new_row($service, $spreadsheetId, $range, $new_record){

    $values = [$new_record];
    print_r($values);

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW',
        'insertDataOption' => 'INSERT_ROWS'
    ];

    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    echo "<br/>";
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