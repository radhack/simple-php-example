<!DOCTYPE html>
<head>
    <title>Callback Handler</title>
    <link rel="stylesheet" type="text/css" href="newcss.css" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" href="/favicon-32x32.png"/>
    <link rel="icon" type="image/png" href="/favicon-16x16.png"/>
    <link rel="manifest" href="/manifest.json" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg"/>
</head>
<body>
    <!--if people find their way here, give them a way to get back home-->
    <p>WARNING: YOU ARE IN DANGER OF BEING BORED<br /></p>
    <p>PROCEED TO THE <a href="index.php">HOMEPAGE</a> TO AVOID BOREDOM</p>
    <?php
    require_once 'vendor/autoload.php';
    include('auth.php');


    // ******************
    // HelloWorks section
    // ******************
     if (isset($_SERVER['HTTP_X_HELLOWORKS_SIGNATURE'])) {
    echo"HelloWorks started";
    $json = json_decode(file_get_contents('php://input'));
    $json_pretty = json_encode($json, JSON_PRETTY_PRINT);
    $raw_json_for_sendgrid = file_get_contents('php://input');
    $status = $json->status; // works in v3
    // echo("$status is the status");
    // $identity = $json->identity;
    $workflow_id = $json->workflow_id; // for v3 only
//    echo("$workflow_id is the workflow_id");
    $hw_id = $json->id;
    $form_name = "signer_step.Form-nRJ3Vpnhm7";

    // GET the JWT
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.helloworks.com/v3/token/KSTV1feBmhOc5fSm", // Ram's v3 demo account
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer hIt7SweEw46TR8iDQZgYjZcTBC8NF4qjKi4y3pKq", // Ram's v3 demo account
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    // print_r($response);
    $err = curl_error($curl);
    curl_close($curl);

    $parsed = json_decode($response);
    // print_r($parsed);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
//            echo $parsed->object->value;
        echo "<br />";
    }

    // $bearer = $parsed->object->value;
    $bearer = $parsed->data->token;
    // echo("$bearer is the Bearer value");

    

//        form0 section, or v3 document section
    $curl0url = "https://api.helloworks.com/v3/workflow_instances/" . "$hw_id" . "/documents/" . "$form_name";  // v3
    print_r($curl0url);
    $curl0 = curl_init();
    curl_setopt_array($curl0, array(
        // CURLOPT_URL => "$form0_url", // v2
        CURLOPT_URL => "$curl0url", // v3
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $bearer",
            "cache-control: no-cache"
        ),
    ));

    $response_pdf0 = curl_exec($curl0);
    $err = curl_error($curl0);

    curl_close($curl0);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response_pdf0;
    }

//        form1 section, or v3 Audit Trail section
    $curl1 = curl_init();

    curl_setopt_array($curl1, array(
        // CURLOPT_URL => "$form1_url", // v2
        CURLOPT_URL => "https://api.helloworks.com/v3/workflow_instances/" . "$hw_id" . "/audit_trail", // v3 audit trail
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $bearer",
            "cache-control: no-cache"
        ),
    ));

    $response_pdf1 = curl_exec($curl1);
    $err = curl_error($curl1);

    curl_close($curl1);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response_pdf1;
    }

//    //        form2 section
//    $curl2 = curl_init();
//
//    curl_setopt_array($curl2, array(
//        CURLOPT_URL => "$form2_url",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "GET",
//        CURLOPT_HTTPHEADER => array(
//            "authorization: Bearer $bearer",
//            "cache-control: no-cache"
//        ),
//    ));
//
//    $response_pdf2 = curl_exec($curl2);
//    $err = curl_error($curl2);
//
//    curl_close($curl2);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response_pdf2;
//    }
//
//    //        form3 section
//    $curl3 = curl_init();
//
//    curl_setopt_array($curl3, array(
//        CURLOPT_URL => "$form3_url",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "GET",
//        CURLOPT_HTTPHEADER => array(
//            "authorization: Bearer $bearer",
//            "cache-control: no-cache"
//        ),
//    ));
//
//    $response_pdf3 = curl_exec($curl3);
//    $err = curl_error($curl3);
//
//    curl_close($curl3);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response_pdf3;
//    }
//
//    //        form4 section
//    $curl4 = curl_init();
//
//    curl_setopt_array($curl4, array(
//        CURLOPT_URL => "$form4_url",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "GET",
//        CURLOPT_HTTPHEADER => array(
//            "authorization: Bearer $bearer",
//            "cache-control: no-cache"
//        ),
//    ));
//
//    $response_pdf4 = curl_exec($curl4);
//    $err = curl_error($curl4);
//
//    curl_close($curl4);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response_pdf4;
//    }

    $target_file0 = "$hw_id 0.pdf";
    file_put_contents("downloaded_files/" . $target_file0, $response_pdf0);
    $target_file1 = "$hw_id 1.pdf";
    file_put_contents("downloaded_files/" . $target_file1, $response_pdf1);
//    $target_file2 = "$hw_id 2.pdf";
//    file_put_contents("downloaded_files/" . $target_file2, $response_pdf2);
//    $target_file3 = "$hw_id 3.pdf";
//    file_put_contents("downloaded_files/" . $target_file3, $response_pdf3);
//    $target_file4 = "$hw_id 4.pdf";
//    file_put_contents("downloaded_files/" . $target_file4, $response_pdf4);
    $file0_encoded = base64_encode($response_pdf0);
    $file1_encoded = base64_encode($response_pdf1);
//    $file2_encoded = base64_encode($response_pdf2);
//    $file3_encoded = base64_encode($response_pdf3);
//    $file4_encoded = base64_encode($response_pdf4);
//    $callback_body = base64_encode($raw_json_for_sendgrid);
//    $file0_encoded = base64_encode("downloaded_files/" . $target_file0);
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("radhack242@gmail.com", "HelloWorks Platform");
    $email->setSubject("HelloWorks callback received");
    $email->addTo("ram.muthukrishnan@hellosign.com", "Ram Rammuthukrishnan");
    $email->addBcc("radhack242@gmail.com", "Alex Griffen");
//    $email->addContent(
//            "text/plain", "and easy to do anywhere, even with PHP"
//    );
    $body = "<p>Here's the JSON in the HelloWorks callback for $hw_id</p><br /><br />$json_pretty";
    $email->addContent(
            "text/html", "$body"
    );
//    $email->addContent(
//            "application/json", "$json_pretty"
//    );
    $email->addAttachment($file0_encoded, "application/pdf", "Costco Wholesale.pdf");
//    $email->addAttachment($curl0url, $form_name, $filename);
    $email->addAttachment($file1_encoded, "application/pdf", "Costco Wholesale - audit_trail.pdf");
    $sendgrid = new \SendGrid("$sendgrid_api_key");
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

// print everything out
    print_r($response);
     }
?>
</body>
</html>