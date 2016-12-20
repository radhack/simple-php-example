<?php

echo '<a href="index.php">GO HOME YOU ARE DRUNK<br /></a>';

$data = json_decode($_POST['json']);
require_once 'vendor/autoload.php';
//require_once 'vendor/sendgrid/sendgrid/lib/SendGrid.php';

$api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
$sendgrid_apikey = getenv('SENDGRID_PHP_APIKEY') ? getenv('SENDGRID_PHP_APIKEY') : '';

// Get the event type.
$event_type = $data->event->event_type;
$reported_app = $data->event->event_metadata->reported_for_app_id;

// The signature_request_all_signed event is called whenever the signature
// request is completely signed by all signees, HelloSign has processed
// the document and has it available for download.
while ($reported_app === 'd7219512693825facdd9241f458decf2') {
    if ($event_type === 'signature_request_all_signed') {
        $client = new HelloSign\Client($api_key);
        $signature_request_id = $data->signature_request->signature_request_id;
        // Here you define where the file should download to. This should be
        // customized to your app's needs.
        $file_path = "/tmp/{$signature_request_id}.pdf";
        $client->getFiles($signature_request_id, $file_path, 'pdf');

        // also trigger an email 
        // right now I'm just hardcoding the receipient, but
        // this could be updated to work with a database
        // to make the receipient smart
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Signature Request All Signed",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'html' => "<strong>$signature_request_id</strong><br />Is the signature_request_id<br />$event_type was received at $event_time<br />",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    } elseif ($event_type === 'callback_test') {
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Callback Test",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'text' => "$event_type was received at $event_time",
            'html' => "<strong>I'm HTML!</strong><br />And I like pudding!<br />$event_type was received at $event_time",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    } elseif ($event_type === 'signature_request_sent') {
        $signature_request_id = $data->signature_request->signature_request_id;
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Signature Request Sent",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'html' => "<strong>$signature_request_id</strong><br />Is the signature_request_id<br />$event_type was received at $event_time<br />",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    } elseif ($event_type === 'file_error') {
        $signature_request_id = $data->signature_request->signature_request_id;
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Signature Request Sent",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'html' => "<strong>$signature_request_id</strong><br />Is the signature_request_id<br />$event_type was received at $event_time<br />",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    }

    if ($event_type === 'unknown_error') {
        $signature_request_id = $data->signature_request->signature_request_id;
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Signature Request Sent",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'html' => "<strong>$signature_request_id</strong><br />Is the signature_request_id<br />$event_type was received at $event_time<br />",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    } elseif ($event_type === 'signature_request_email_bounce') {
        $signature_request_id = $data->signature_request->signature_request_id;
        $event_time = $data->event->event_time;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+$event_type@gmail.com",
            'toname' => "Signature Request Sent",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "$event_type received",
            'html' => "<strong>$signature_request_id</strong><br />Is the signature_request_id<br />$event_type was received at $event_time<br />",
        );

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        print_r($response);
    } else {
        end;
    }
}

// Always be sure to return this response so that HelloSign knows
// that your app processed the event successfully. Otherwise, HelloSign
// will assume it failed and will retry a few more times.
echo 'Hello API Event Received';
?>
