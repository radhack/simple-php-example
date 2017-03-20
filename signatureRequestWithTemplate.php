<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Embedded Signing with Template</title>
        <script type="text/javascript" src="//s3.amazonaws.com/cdn.hellosign.com/public/js/hellosign-embedded.LATEST.min.js"></script>
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
        // Get your credentials from environment variables
        $api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
        $client_id = getenv('HS_CLIENT_ID_PROD') ? getenv('HS_CLIENT_ID_PROD') : '';

        // Instance of a client for you to use for calls
        $client = new HelloSign\Client($api_key);
        // Example call with logging for embedded requests
        $request = new HelloSign\TemplateSignatureRequest;
        $request->enableTestMode();
        $request->setTitle("Testing");
        $request->setSubject('Embedded Signing With Template');
        $request->setMessage('Awesome, right?');
        $request->setSigner('Role1', 'jack@example.com', 'Jack');
        $request->setSigner('Role2', 'jack@example.com', 'and Jill');
        $request->setSigner('Role3', 'jack@example.com', 'Went');
        $request->setSigner('Role4', 'jack@example.com', 'Up The');
        $request->setSigner('Role5', 'jack@example.com', 'Hill');
        $request->setCustomFieldValue('Cost', '$100,000,000');
        $request->setTemplateId('5f5650f1cbfd497393cfa426d7d8d81e2a62a1f4');

        // Turn it into an embedded request
        $embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);

        // Send it to HelloSign
        $response = $client->createEmbeddedSignatureRequest($embedded_request);

        // wait for callback with signature_request_sent
        // 
        // Grab the signature ID for the signature page that will be embedded in the page
        $signatures = $response->getSignatures();
        $signature_id = $signatures[0]->getId();

        // Retrieve the URL to sign the document
        $response = $client->getEmbeddedSignUrl($signature_id);

        // Store it to use with the embedded.js HelloSign.open() call
        $sign_url = $response->getSignUrl();

        // call the html page with the embedded.js lib and HelloSign.open()
        include('signerpage.php');
        ?>
    </body>
</html>

