<?php
// Start a session (if not already started)
session_start();

include("../connection.php");
$useremail = $_SESSION["user"];

$sqlmain = "SELECT * FROM stylist WHERE semail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["sid"];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables to hold query and parameters
    $updateQuery = "UPDATE stylist SET ";
    $bindTypes = "";
    $bindValues = [];

    // Get user input from the form
    if (!empty($_POST['salon_name'])) {
        $updateQuery .= "sln_name=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['salon_name'];
    }

    if (!empty($_POST['image_url'])) {
        $updateQuery .= "image_url=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['image_url'];
    }

    if (!empty($_POST['sname'])) {
        $updateQuery .= "sname=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['sname'];
    }

    // Check if any fields were provided in the POST request
    if (!empty($bindValues)) {
        // Remove the trailing comma and space from the query
        $updateQuery = rtrim($updateQuery, ', ');

        // Add the WHERE clause
        $updateQuery .= " WHERE sid=?";

        // Append the user ID to the bind values and types
        $bindTypes .= "i";
        $bindValues[] = $userid;

        // Prepare and execute the dynamic SQL query
        $stmt = $database->prepare($updateQuery);

        // Bind values to the placeholders
        $stmt->bind_param($bindTypes, ...$bindValues);

        if ($stmt->execute()) {
            // Profile updated successfully
            // You can add a success message here if needed
            // Redirect the user to their profile page
            header('Location: profile.php');
            exit();
        } else {
            // Handle the update error
            // You can add an error message here if needed
        }
    } else {
        // No non-empty fields provided in the POST request, no update required
        // You can add a message here if needed
    }
}

// Include your HTML template for the profile editing form
include 'profile_edit_form.php'; // Adjust the path as needed
?>
