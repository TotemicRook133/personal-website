<?php
require __DIR__ . '/vendor/autoload.php'; // Include the Google API client library

// Get the form data
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];
$comments = $_POST["comments"];
$referrer = $_POST["referrer"];

// Authenticate with the Google Sheets API using the credentials file
$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->addScope(Google_Service_Sheets::SPREADSHEETS);
$service = new Google_Service_Sheets($client);

// Set the ID of the spreadsheet and the name of the worksheet
$spreadsheetId = 'YOUR_SPREADSHEET_ID';
$worksheetName = 'Sheet1';

// Set the values to be inserted into the new row
$values = [
  [$firstName, $lastName, $email, $phone, $message, $comments, $referrer] 
];

// Create a new row in the worksheet
$requestBody = new Google_Service_Sheets_ValueRange([
  'values' => $values
]);
$options = [
  'valueInputOption' => 'USER_ENTERED'
];
$response = $service->spreadsheets_values->append($spreadsheetId, $worksheetName, $requestBody, $options);

// Check if the row was inserted successfully
if ($response->getUpdates()->getUpdatedCells() > 0) {
  echo "Form data stored successfully";
} else {
  echo "Error storing form data";
}
?>