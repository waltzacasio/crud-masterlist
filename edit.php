<?php
session_start();
include_once('includes/dbh.inc.php');

if(isset($_POST['updateData'])) {

    $id= $_POST['id'];

    //Old Input
    $oldFirstName = strtoupper($_POST['oldFirstName']);
    $oldLastName = strtoupper($_POST['oldLastName']);
    $oldAddressLocation = $_POST['oldAddressLocation'];
    $oldBoxNumber = $_POST['oldBoxNumber'];
    $oldRemarks = $_POST['oldRemarks'];
    $oldDateOfPurchase = $_POST['oldDateOfPurchase'];
    $oldContact = $_POST['oldContact'];
    $oldInstaller = $_POST['oldInstaller'];

    //New Input
    $firstName = strtoupper($_POST['firstName']);
    $lastName = strtoupper($_POST['lastName']);
    $addressLocation = $_POST['addressLocation'];
    //$boxNumber = $_POST['boxNumber'];
    $remarks = $_POST['remarks'];
    $dateOfPurchase = $_POST['dateOfPurchase'];
    $contact = $_POST['contact'];
    $installer = $_POST['installer'];
    $userName = $_SESSION["username"];

if ($oldFirstName !==  $firstName || $oldLastName !==  $lastName || $oldAddressLocation !==  $addressLocation /*|| $oldBoxNumber !==  $boxNumber */|| $oldRemarks !==  $remarks || $oldDateOfPurchase !==  $dateOfPurchase || $oldContact !==  $contact || $oldInstaller !==  $installer ) {    

    //Get the column data in the array. Before update.
    $sql = "SELECT *  from gpinoy where id=$id limit 1";
    $prev = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    //update the masterlist
    $stmt = $conn->prepare("UPDATE gpinoy SET lastName=?, firstName=?, addressLocation=?, remarks=?, dateOfPurchase=?, contact=?, installer=? WHERE id=?");
    $stmt->bind_param("sssssssi", $lastName, $firstName, $addressLocation, $remarks, $dateOfPurchase, $contact, $installer, $id);
    $stmt->execute();
    $stmt->close();

    // Again run the select command to get updated data.
    $sql = "SELECT *  from gpinoy where id=$id limit 1";
    $updated = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $UpdatedColumns=array_diff_assoc($prev,$updated);
    print_r($UpdatedColumns);

    if ($stmt = $conn->prepare("INSERT INTO editlogs (masterlistID, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer, dateAndTime, userName)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?);"))
    {
        $stmt->bind_param("isssssssss", $id, $UpdatedColumns["lastName"], $UpdatedColumns["firstName"], $UpdatedColumns["addressLocation"], $oldBoxNumber, $UpdatedColumns["remarks"], $UpdatedColumns["dateOfPurchase"], $UpdatedColumns["contact"], $UpdatedColumns["installer"], $userName);
        $stmt->execute();
        $stmt->close();
    }

    }

 }
/*

    if ($oldFirstName !== $firstName) {
        if ($stmt = $conn->prepare("INSERT INTO editlogs (masterlistID, firstName)
        SELECT id, firstName FROM gpinoy WHERE id = ?;"))
        {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Insert timestamp and username
    if ($stmt = $conn->prepare("UPDATE editlogs SET dateAndTime=now(), userName=? WHERE masterlistID=?"))
    {
        $stmt->bind_param("si", $userName, $id);	
        $stmt->execute();
        $stmt->close();
    }
    
    //update the masterlist
    $stmt = $conn->prepare("UPDATE gpinoy SET firstName=? WHERE id=?");

    $stmt->bind_param("si", $firstName, $id);
    $stmt->execute();
    $stmt->close();
*/
   


/*
    if ($oldFirstName !==  $firstName || $oldLastName !==  $lastName || $oldAddressLocation !==  $addressLocation || $oldBoxNumber !==  $boxNumber || $oldRemarks !==  $remarks || $oldDateOfPurchase !==  $dateOfPurchase || $oldContact !==  $contact || $oldInstaller !==  $installer ) {

    // Copy old record to edit logs
    // need to copy only those edited to edit logs
    if ($stmt = $conn->prepare("INSERT INTO editlogs (masterlistID, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer)
    SELECT id, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer
    FROM gpinoy
    WHERE id = ?;"))
    {
        $stmt->bind_param("i",$id);	
        $stmt->execute();
        $stmt->close();
    }

    // Insert timestamp and username
    if ($stmt = $conn->prepare("UPDATE editlogs SET dateAndTime=now(), userName=? WHERE masterlistID=?"))
    {
        $stmt->bind_param("si", $userName, $id);	
        $stmt->execute();
        $stmt->close();
    }

    //update the masterlist
    $stmt = $conn->prepare("UPDATE gpinoy SET lastName=?, firstName=?, addressLocation=?, boxNumber=?, remarks=?, dateOfPurchase=?, contact=?, installer=? WHERE id=?");
    
    /*$query = "UPDATE gpinoy SET lastName='$lastName', firstName='$firstName', addressLocation='$addressLocation', boxNumber='$boxNumber', remarks='$remarks', dateOfPurchase='$dateOfPurchase', contact='$contact', installer='$installer' WHERE id='$id'";*/
/*
    $stmt->bind_param("ssssssssi", $lastName, $firstName, $addressLocation, $boxNumber, $remarks, $dateOfPurchase, $contact, $installer, $id);
    $stmt->execute();
    $stmt->close();

    }
*/


    //$last_id = $mysqli->insert_id;

    /*header('Location: index.php');
    echo '<script> alert("Data Saved"); </script>';
    
} else {
    echo '<script> alert("Data Not Saved"); </script>';
}*/

/*	

	*/