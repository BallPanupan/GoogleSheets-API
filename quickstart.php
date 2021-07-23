<?php

require 'vendor/autoload.php';
require_once __DIR__ . "/API/API.php";


$client = new \Google_Client();
$client -> setApplicationName('Google Sheets and PHP');
$client -> setScopes(Google_Service_Sheets::SPREADSHEETS);
$client -> setAccessType('offline');
$client -> setAuthConfig('credentials.json');
$service = new Google_service_Sheets($client);

$spreadsheetId = '15-wJkhwP_vg8vcqtqcGR8YJuyenDd0HqaA0zUMeClFc';
$range = 'sheet_1!11:11';


// //check all row active
//count_row($service, $spreadsheetId);


// insert new row
//new_row($service, $spreadsheetId, 'A:A');

//Create a new sheet
// new_sheet($service, $spreadsheetId);

// Appending values
insert_row_down($service, $spreadsheetId, $range);