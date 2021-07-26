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


  // print_r($_POST);
  // echo "<br/>";
  
  // if(isset($_POST)){
  //   new_row($service, $spreadsheetId, $range, $_POST);
  // }

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

    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    //count row active
    check_insert($service, $spreadsheetId, count_row($service, $spreadsheetId));
  }


  //check all row active
  function count_row($service, $spreadsheetId){
    $result = $service->spreadsheets_values->get($spreadsheetId, "1:1000");
    $rowsactive = $result->getValues() != null ? count($result->getValues()) : 0;
    echo "<br/>";
    echo "rows retrieved : " . $rowsactive;
    return $rowsactive;
  }

  //check data after insert new row
  function check_insert($service, $spreadsheetId, $sheets_row){
    $range = 'sheet_1!'.$sheets_row . ":" . $sheets_row;

    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    echo "<br/>";
    print_r($values);
  }


  //Create a new sheet
  function new_sheet($service, $spreadsheetId){
    $title = "my new sheet2";
    //Create New Sheet
    $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
      array('requests' => array('addSheet' => array('properties' => array('title' => $title ))))
    );

    $result = $service->spreadsheets->batchUpdate($spreadsheetId,$body);
  }
  

  //Create a new sheet and add color
  function new_sheet_color($service, $spreadsheetId, $range){
    $title = "my new sheet2";
    //Create New Sheet

    $array_x = array('requests' => array('addSheet' => array('properties' => array(
      'title' => "new_sheets", 
      'tabColor' => array(
        'red' => '1.0',
        'green' => '0.3',
        'blue' => '0.4'
      )
    ))));

    print_r(json_encode($array_x));

    $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest($array_x);
    $result = $service->spreadsheets->batchUpdate($spreadsheetId,$body);
  }

  //
  function add_newrow2($service, $spreadsheetId, $range){
    $data = new Google_Service_Sheets_ValueRange(array(
      'range' => 'sheet_1!11:11',
      'values' => array(['1','2','3','4'])
    ));

    $requestBody = new Google_Service_Sheets_BatchUpdateValuesRequest(array(
      'valueInputOption' => "RAW",
      'data' => $data
    ));

    $response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $requestBody);
  }

  //change name of sheets
  function change_sheet_name($service, $spreadsheetId, $range){
    $requestBody = [
      new Google_Service_Sheets_Request([
          'updateSheetProperties' => [
              'properties' => [
                  'sheetId' => 1116031513,
                  'title' => 'New_sheetX',
              ],
              'fields' => 'title'
          ]
      ])
  ];

  $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
    'requests' => $requestBody
  ]);

  $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

  }



  //insert between row
  function insert_row_down($service, $spreadsheetId, $range){
    $requestBody = 
      new Google_Service_Sheets_Request(
        array(
          'insertDimension' => array(
              'range' => array(
                  'sheetId' => 0,
                  'dimension' => "ROWS",
                  'startIndex' => 2,
                  'endIndex' => 3,
              ),
            
          )
      )
      );


  $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
    'requests' => $requestBody
  ]);

  $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

  //print_r($response);
  }

?>