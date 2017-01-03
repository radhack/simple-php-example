<?php

//if people find their way here, give them a way to get back home
echo '<a href="index.php">GO HOME YOU ARE DRUNK<br /></a>';

require_once 'vendor/autoload.php';

$data = json_decode($_POST['json']);
$sendgrid_apikey = getenv('SENDGRID_PHP_APIKEY') ? getenv('SENDGRID_PHP_APIKEY') : '';


// The signature_request_all_signed event is called whenever the signature
// request is completely signed by all signees, HelloSign has processed
// the document and has it available for download.
// if ($reported_app === 'afedad951b68dc42bfbd930e81d97175') {
if ($data->Transaction->IsInbound === TRUE ) {

// right now I'm just hardcoding the receipient, but
// this could be updated to work with a database
// to make the receipient smart
        $event_time = $data->Transaction->CreatedAt;
        $fax_guid = $data->Transaction->Guid;
        $num_pages_billed = $data->Transaction->NumPagesBilled;
        $from = $data->Transaction->From;
        $to = $data->Transaction->To;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+faxsent@gmail.com",
            'toname' => "Signature Request All Signed",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "Inbound Fax received",
            'html' => "<strong>$fax_guid</strong><br />Is the fax guid<br />$num_pages_billed is the number of pages billed, and it was received at $event_time.<br />$from is the sending number, and the fax was sent to $to<br />",
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
    } elseif ($data->Transaction->IsInbound === FALSE) {
        // right now I'm just hardcoding the receipient, but
// this could be updated to work with a database
// to make the receipient smart
        $event_time = $data->Transaction->CreatedAt;
        $fax_guid = $data->Transaction->Guid;
        $num_pages_billed = $data->Transaction->NumPagesBilled;
        $from = $data->Transaction->From;
        $to = $data->Transaction->To;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+faxreceived@gmail.com",
            'toname' => "Signature Request All Signed",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "Outbound Fax sent",
            'html' => "<strong>$fax_guid</strong><br />Is the fax guid<br />$num_pages_billed is the number of pages billed, and it was received at $event_time<br />$from is the sending number, and the fax was sent to $to<br />",
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
        $event_time = $data->Transaction->CreatedAt;
        $fax_guid = $data->Transaction->Guid;
        $from = $data->Transaction->From;
        $to = $data->Transaction->To;
        $sendgrid = new SendGrid($sendgrid_apikey);
        $url = 'https://api.sendgrid.com/';
        $pass = $sendgrid_apikey;

        $params = array(
            'to' => "radhack242+faxunknown@gmail.com",
            'toname' => "Event Not Setup",
            'from' => "radhack242@gmail.com",
            'fromname' => "Simple PHP",
            'subject' => "Unknown HelloFax Callback event received",
            'html' => "The event was received at $event_time and $fax_guid is the guid<br />$from is the sending number, and the fax was sent to $to<br />",
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

// Always be sure to return this response so that HelloSign knows
// that your app processed the event successfully. Otherwise, HelloSign
// will assume it failed and will retry a few more times.
echo 'Hello API Event Received';
?>
