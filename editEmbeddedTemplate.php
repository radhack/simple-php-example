<!DOCTYPE html>

<html>
    <head>
        <title>Embedded Template Editing</title>
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
        $api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
        $client_id = getenv('HS_CLIENT_ID_PROD') ? getenv('HS_CLIENT_ID_PROD') : '';

        $client = new HelloSign\Client($api_key);
        $template_id = $_POST['templateID'];
        $response = $client->getEmbeddedEditUrl("$template_id?skip_signer_roles=1&skip_subject_message=1");
        $sign_url = $response->getEditUrl(); //this will not work until issue https://github.com/HelloFax/hellosign-php-sdk/issues/37 is addressed

        include ('signerpage.php');
        ?>
    </body>
</html>