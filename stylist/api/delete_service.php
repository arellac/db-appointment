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
    
    // First, let's check if the service is associated with a stylist. 
    // If it is, delete that association first.
    $stmt1 = $database->prepare("DELETE FROM services WHERE service_id = ?");
    $stmt1->bind_param("i", $_POST['service_id']);
    
    $stmt1->execute();
}
?>