<?php

echo '<a href="index.php">GO HOME YOU ARE DRUNK<br /></a>';

$data = json_decode($_POST['json']);
require_once 'vendor/autoload.php';
$api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
// Get the event type.
$event_type = $data->event->event_type;
$signature_request_id = $data->signature_request->signature_request_id;

// The signature_request_all_signed event is called whenever the signature
// request is completely signed by all signees, HelloSign has processed
// the document and has it available for download.
if ($event_type == 'signature_request_all_signed') {
    $client = new HelloSign\Client($api_key);
// Here you define where the file should download to. This should be
// customized to your app's needs.
    $file_path = "/tmp/{$signature_request_id}.pdf";
    $client->getFiles($signature_request_id, $file_path, 'pdf');
}

// Always be sure to return this response so that HelloSign knows
// that your app processed the event successfully. Otherwise, HelloSign
// will assume it failed and will retry a few more times.
echo 'Hello API Event Received';
?>