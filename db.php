<?php

/*
 * Copyright (C) 2017 alexgriffen
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// THIS IS THE SETUP FOR CLEARDB,
// WHICH I'LL NEED FOR THIS TO WORK WITH HEROKU

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

//$dbadmin = getenv('DB_ADMIN');
//$dbpassword = getenv('DB_PASSWORD');
//$servername = "localhost";
//$dbname = "testdb";
$time = time();

if (isset($signature_request_id)) {

    // Create connection
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($signer_email)) {
        $sql = "INSERT INTO signature_request VALUES('$signature_request_id','$createdHow','$signer_email','$time')";
    } else {
        $sql = "INSERT INTO signature_request VALUES('$signature_request_id','$createdHow',NULL,'$time')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "INSERT to signature_request successfull";
    } else {
        echo "<br />Error INSERTing (lol): " . $conn->error;
    }
} elseif (isset($template_id)) {

    // Create connection
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO template VALUES('$template_id','$createdHow','$time')";

    if ($conn->query($sql) === TRUE) {
        echo "INSERT to template successfull";
    } else {
        echo "<br />Error INSERTing (lol): " . $conn->error;
    }
} elseif (isset($_SESSION['fromEmbeddedRequesting']) && $_SESSION['fromEmbeddedRequesting'] == true) {

    // Create connection
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $converted = json_encode($signature_request_object->toArray());
    $signature_request_id = $_SESSION['signature_request_id'];

    $sql = "INSERT INTO signature_request_json VALUES('$signature_request_id','embeddedRequesting','$converted')";

    if ($conn->query($sql) === TRUE) {
        echo "INSERT to signature_request_json successfull";
    } else {
        echo "<br />Error INSERTing (lol): " . $conn->error;
    }
} elseif (isset($hw_email)) {

    // Create connection
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO helloworks VALUES('$hw_instance_id','$hw_name','$hw_email','$hw_sign_url')";

    if ($conn->query($sql) === TRUE) {
        echo "INSERT to helloworks successfull";
    } else {
        echo "<br />Error INSERTing (lol): " . $conn->error;
    }
//    TODO - setup callback server to save state of request
//    if same signer comes back to HelloWorks, serve same hw_sign_url
}

$conn->close();
