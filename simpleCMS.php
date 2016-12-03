<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title>Simple CMS with PHP</title>

        <link rel="stylesheet" type="text/css" href="newcss.css" />
        <style type="text/css">
            body {
            background-color: #aaa;
            margin: 0;
            padding: 0;

            }
            div {
                width: 815px;
                margin: 5em auto;
                padding: 10px;
                background-color: #f0f0f2;
                border-radius: 1em;
                box-shadow: 1px 1px 1px #00B3E6;
            }
            @media (max-width: 800px) {
                body {
                    background-color: #fff;
                }
                div {
                    width: auto;
                    margin: 0 auto;
                    border-radius: 0;
                    padding: 0px;
                }
            }
            </style>
    </head>
    <body>
        <div class="entry-content">
            <h1>Have a look at these <i>crazy</i> embedded examples!</h1>
        <!-- this is an embedded template page -->
        <form action="/embeddedTemplate.php" method="post" enctype="multipart/form-data">        
            <fieldset>
                <br />
                <input type="submit" value="Template Creation"/>
                <br />
                <input type="file" name="uploadedTemplateFile" id="uploadedTemplateFile"/>
                <p>Create a template</p>
            </fieldset>
        </form>
        <!-- this is creating an embedded signature request using text tags -->
        <form action="/signatureRequestTextTags.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <br />
                <input type="submit" value="Text Tags are cool"/>
                <br />
                <input type="file" name="uploadedTextTags" id="uploadedTextTags"/>
                <p>Sign a signature request that uses text tags</p>
                <p>NOTE - use a text tags pdf with only one signer!</p>
            </fieldset>
        </form>
        <!-- this is a standard sig request with an appended signature page -->
        <form action="/AppendedSignaturePage.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <br />
                <input type="submit" value="Easy as easy gets"/>
                <br /> 
                <input type="file" name="uploadedfile" id="uploadedfile"/>   
                <p>Sign a signature request that uses an appended signature page</p>
            </fieldset>
        </form>
        <!-- this is an embedded requesting page -->
        <form action="/embeddedRequesting.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <br />
                <input type="submit" value="Requesting"/>
                <br />
                <input type="file" name="requestingFile" id="requestingFile"/>
            </fieldset>
            <p>Create a signature request that'll send a HelloSign email to the signer(s)</p>
        </form>
        <!-- this is an embedded requesting page with embedded signing -->
        <form action="/embeddedRequestingEmbeddedSigning.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <br />
                <input type="submit" value="Requesting for Embedded Signing"/>
                <br />
                <input type="file" name="requestingFileEmbSig" id="requestingFileEmbSig"/>
            </fieldset>            
            <p>Create a signature request that'll be used for embedded signing</p>
        </form>
        <!-- this for testing bugs -->
        <form action="/bugstesting.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <br />
                <input type="submit" value="Bug Testing Only"/>
                <br />
                <input type="file" name="BugTestingOnly" id="BugTestingOnly"/>
            </fieldset> 
            <p>Use For Bug Testing Only - setup for bug</p>
        </form>
    </div>
        <p><br /><br /><small>Thanks for playing!</small></p>
    </body>
</html>