<?php

require 'vendor/autoload.php';

$client = new \Google_Client();
$client -> setApplicationName('Google Sheets and PHP');
$client -> setScopes(Google_Service_Sheets::SPREADSHEETS);
$client -> setAccessType('offline');
$client -> setAuthConfig('credentials.json');
$service = new Google_service_Sheets($client);


// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '15-wJkhwP_vg8vcqtqcGR8YJuyenDd0HqaA0zUMeClFc';
$range = 'sheet_1!A4:F4';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

//count all row
$numRows = $response->getValues() != null ? count($response->getValues()) : 0;
printf("%d rows retrieved.", $numRows);
echo "\n";

if (empty($values)) {
    print "No data found.\n";
} else {
    for ($i=0; $i < count($values[0]) ; $i++) { 
        echo $values[0][$i] . " ";
    }
}
echo "\n";

//update in sheet
$range = 'sheet_1!A4:F4';
$values = [["Hello", "Ball", "Panupan"]];
$body = new Google_Service_Sheets_ValueRange([
    'values' => $values
]);
$params = [
    'valueInputOption' => "RAW"
];
$result = $service->spreadsheets_values->update($spreadsheetId, $range,
$body, $params);
printf("%d cells updated.", $result->getUpdatedCells());


///////////////////////////////////
$values = [["Hello", "Ball", "Panupan"]];
$data = [];
$data[0] = new Google_Service_Sheets_ValueRange([
    'range' => 'sheet_1!A8:F8',
    'values' => $values
]);
$data[1] = new Google_Service_Sheets_ValueRange([
    'range' => 'sheet_1!A9:E9',
    'values' => $values
]);
$data[2] = new Google_Service_Sheets_ValueRange([
    'range' => 'sheet_1!A10:E10',
    'values' => $values
]);
$data[3] = new Google_Service_Sheets_ValueRange([
    'range' => 'sheet_1!A11:E11',
    'values' => $values
]);


// Additional ranges to update ...
$body = new Google_Service_Sheets_BatchUpdateValuesRequest([
    'valueInputOption' => "RAW",
    'data' => $data
]);
$result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
printf("%d cells updated.", $result->getTotalUpdatedCells());