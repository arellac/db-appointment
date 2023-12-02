<?php
session_start();

include("../../connection.php");
$useremail = $_SESSION["user"];
$userid = $_SESSION["user_id"];

// $sqlmain = "SELECT * FROM stylist WHERE s_email=?";
// $stmt = $database->prepare($sqlmain);
// $stmt->bind_param("s", $useremail);
// $stmt->execute();
// $userrow = $stmt->get_result();
// $userfetch = $userrow->fetch_assoc();
// $userid = $userfetch["s_id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert into services table
    $stmt = $database->prepare("INSERT INTO services (service_name, service_details, service_price, s_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $_POST['service_name'], $_POST['service_details'], $_POST['service_price'], $userid);
    $stmt->execute();
    // if ($stmt->execute()) {
    //     // Get the ID of the last inserted service
    //     $service_id = $database->insert_id;

    //     // Insert into stylist_services
    //     $stmt2 = $database->prepare("INSERT INTO stylist_services (service_id, s_id) VALUES (?, ?)");
    //     $stmt2->bind_param("ii", $service_id, $userid);

    //     $stmt2->execute();
    // }
}
?>