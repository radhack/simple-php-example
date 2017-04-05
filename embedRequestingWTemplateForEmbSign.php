<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Embedded Requesting for Embedded Signing</title>
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

        $baseReq = new HelloSign\TemplateSignatureRequest();
        $baseReq->setTemplateId("5f5650f1cbfd497393cfa426d7d8d81e2a62a1f4");
        $baseReq->setSigner('Role1', 'radhack242@gmail.com', 'Bob');
//        $request->setSigner('Role2', 'jack@example.com', 'and Jill');
//        $request->setSigner('Role3', 'jack@example.com', 'Went');
//        $request->setSigner('Role4', 'jack@example.com', 'Up The');
//        $request->setSigner('Role5', 'jack@example.com', 'Hill');
//        $request->setCustomFieldValue('Cost', '$100,000,000', "Role1");
//        $request->setCustomFieldValue('Amount', "There's not much", "Role1");
//        $request->setCustomFieldValue("Applicant", "Bobs's the name", "Role1");
        $baseReq->setCustomFieldValue('Cost', '$100,000,000');
        $baseReq->setCustomFieldValue('Amount', "There's not much");
        $baseReq->setCustomFieldValue("Applicant", "Bobs's the name");
        $baseReq->setRequesterEmailAddress('alex@hellosign.com');
        $baseReq->addMetadata('custom_id', '1234');
        $baseReq->enableTestMode(); // documentaton says to put this in the EmbeddedSignatureRequest method
        // but that doesn't work - it's not passed to HS when you do that, so moving it here
        // where I know it works.

        $request = new HelloSign\EmbeddedSignatureRequest($baseReq, $client_id);
        $request->setEmbeddedSigning(); 

        $response = $client->createUnclaimedDraftEmbeddedWithTemplate($request);
        $sign_url = $response->getClaimUrl();

        // call the html page with the embedded.js lib and HelloSign.open()
        include('signerpage.php');
        ?>
    </body>
</html>
