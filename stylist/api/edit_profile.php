<?php
// Start a session (if not already started)
session_start();

include("../../connection.php");
$useremail = $_SESSION["user"];

$sqlmain = "SELECT * FROM stylist WHERE s_email=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["s_id"];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables to hold query and parameters
    $updateQuery = "UPDATE stylist SET ";
    $bindTypes = "";
    $bindValues = [];

    // Get user input from the form
    if (!empty($_POST['sln_name'])) {
        $updateQuery .= "sln_name=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['sln_name'];
    }

    // Check if an image has been uploaded
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $photo = fopen($_FILES['image_url']["tmp_name"], 'rb');
        $updateQuery .= "image_url=?, ";
        $bindTypes .= "b";  // Use 'b' for blob data
        $bindValues[] = $photo; 
        fclose($photo);
    }

    if (!empty($_POST['s_name'])) {
        $updateQuery .= "s_name=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['s_name'];
    }
    if (!empty($_POST['sln_info'])) {
        $updateQuery .= "sln_info=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['sln_info'];
    }
    if (!empty($_POST['sln_address'])) {
        $updateQuery .= "sln_address=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['sln_address'];
    }
    // Check if any fields were provided in the POST request
    if (!empty($bindValues)) {
        // Remove the trailing comma and space from the query
        $updateQuery = rtrim($updateQuery, ', ');

        // Add the WHERE clause
        $updateQuery .= " WHERE s_id=?";

        // Append the user ID to the bind values and types
        $bindTypes .= "i";
        $bindValues[] = $userid;

        // Prepare and execute the dynamic SQL query
        $stmt = $database->prepare($updateQuery);
        if ($imageIndex = array_search("b", str_split($bindTypes))) {
            $stmt->send_long_data($imageIndex, $bindValues[$imageIndex]);
            unset($bindValues[$imageIndex]);
        }
        // Bind values to the placeholders
        $stmt->bind_param($bindTypes, ...$bindValues);
        // echo $updateQuery;
        // echo "<br>";
        // var_dump($_FILES);
        // echo "<br>";
        // print_r($bindValues);
        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile.";
        }
    } else {
        // No non-empty fields provided in the POST request, no update required
        // You can add a message here if needed
    }
}

// Include your HTML template for the profile editing form
// include 'dashboard.php'; // Adjust the path as needed
?>
