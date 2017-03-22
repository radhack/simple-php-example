<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Appended Signature Page</title>
        <link rel="stylesheet" type="text/css" href="newcss.css" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link rel="icon" type="image/png" href="/favicon-32x32.png"/>
        <link rel="icon" type="image/png" href="/favicon-16x16.png"/>
        <link rel="manifest" href="/manifest.json" />
        <link rel="mask-icon" href="/safari-pinned-tab.svg"/>
    </head>
    <body>
        <?php
        require_once 'vendor/autoload.php';
        $signer_email = $_POST['signeremail'];
        echo "$signer_email is the email address passed <br />"; //doing a reality check here to troubleshoot email issues with heroku and sendgrid
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["uploadedfile"]["name"]);
        $uploadOk = 1; //this is used if the other if statements are used
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        //if ($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "ppsx" && $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "tif" && $imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "txt" && $imageFileType != "html" && $imageFileType != "gif") {
        //    echo "Sorry, only doc, docx, pdf, ppsx, ppt, pptx, tif, jpg, jpeg, png, xls, <br />"
        //    . "xlsx, txt, html, and gif are allowed at this point <br />";
        //    $uploadOk = 0;
        //}
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            goto skip;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["uploadedfile"]["name"]) . " has been uploaded. <br />";
            } else {
                echo "Sorry, there was an error uploading your file. <br />";
                $uploadOk = 0;
                goto skip;
            }
        }

        // Get your credentials from environment variables
        $api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
        $client_id = getenv('HS_CLIENT_ID_PROD') ? getenv('HS_CLIENT_ID_PROD') : '';
        $sendgrid_php_apikey = getenv('SENDGRID_PHP_APIKEY');

        // Instance of a client for you to use for calls
        $client = new HelloSign\Client($api_key);

        // Example call with logging for embedded requests
        $request = new HelloSign\SignatureRequest;
        $request->enableTestMode();
        $request->setTitle('Testing');
        $request->setSubject('My First embedded signature request');
        $request->setMessage('Awesome, right?');
        $request->addSigner("$signer_email", 'Testing Signer');
        // $request->setAllowDecline(true); // uncomment this when allowDecline is built into the PHP SDK
        $request->addFile("$target_file");

        // Turn it into an embedded request
        $embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);

        // Send it to HelloSign
        $response = $client->createEmbeddedSignatureRequest($embedded_request);

        // Grab the signature ID for the signature page that will be embedded in the page
        $signatures = $response->getSignatures();
        $signature_id = $signatures[0]->getId();

        // send email region
        $from = new SendGrid\Email(null, "test@example.com");
        echo "<br />0";
        $subject = "Hello World from the SendGrid PHP Library!";
        echo "<br />1";
        $to = new SendGrid\Email("Alex", "$signer_email");
        echo "<br />2";
        $content = new SendGrid\Content("text/html", "<html><head><\/head><body><p>testing<\/p><\/body><\/html>");
        echo "<br />3";
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        echo "<br />4";

        $sg = new \SendGrid($sendgrid_php_apikey);
        echo "<br />5";

        $mailresponse = $sg->client->mail()->send()->post($mail);
        echo "<br />6";
        echo $mailresponse->statusCode();
        echo $mailresponse->body();
        echo '<br /><a href="index.php">Click here to go home</a>';

        skip:
        // skip loop so this doesn't run when skip isn't used
        if ($uploadOk === 0) {
            echo '<br /><a href="index.php">GO HOME YOU ARE DRUNK</a>';
        }
        ?>
    </body>
</html>
