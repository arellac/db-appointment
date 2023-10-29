<?php
session_start();

include("../connection.php");
$useremail = $_SESSION["user"];

$sqlmain = "SELECT * FROM stylist WHERE s_email=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["s_id"];

// Assuming you have $userid as the logged-in stylist ID, you may need to fetch it if not already.
// $userid = ... ; // Your method to fetch the stylist's ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert into services table
    $stmt = $database->prepare("INSERT INTO services (service_name, service_details, service_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $_POST['service_name'], $_POST['service_details'], $_POST['service_price']);
    
    if ($stmt->execute()) {
        // Get the ID of the last inserted service
        $service_id = $database->insert_id;

        // Insert into stylist_services
        $stmt2 = $database->prepare("INSERT INTO stylist_services (service_id, s_id) VALUES (?, ?)");
        $stmt2->bind_param("ii", $service_id, $userid);

        if ($stmt2->execute()) {
            echo "Service added and associated with stylist successfully!";
        } else {
            echo "Error associating service with stylist.";
        }
    } else {
        echo "Error adding service.";
    }
}
?>