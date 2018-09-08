<?php
/**
 * Created by PhpStorm.
 * User: David Fernandes
 * Date: 2/23/2017
 * Time: 3:00 PM
 */

function query_db($command, $sources="songs"){
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $sources);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = $command;
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function conn_db($sources="songs"){
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $sources);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>
