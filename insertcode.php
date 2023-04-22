<?php

include_once('includes/dbh.inc.php');

if(isset($_POST['insertData'])) {

    $firstName = strtoupper($_POST['firstName']);
    $lastName = strtoupper($_POST['lastName']);
    $addressLocation = $_POST['addressLocation'];
    $boxNumber = $_POST['boxNumber'];
    $remarks = $_POST['remarks'];
    $dateOfPurchase = $_POST['dateOfPurchase'];
    $contact = $_POST['contact'];
    $installer = $_POST['installer'];

    $stmt = $conn->prepare("INSERT INTO gpinoy (lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", $lastName, $firstName, $addressLocation, $boxNumber, $remarks, $dateOfPurchase, $contact, $installer);
    $stmt->execute();
    $stmt->close();

    //$query_run = mysqli_query($mysqli, $query);

     
    $last_id = $mysqli->insert_id;
    header('Location: index.php?');
    
} else {
    echo '<script> alert("Data Not Saved"); </script>';
}