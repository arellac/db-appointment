<?php
// Start a session (if not already started)
session_start();

include("../../connection.php");

$userid = $_SESSION["user_id"];
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables to hold query and parameters
    $updateQuery = "UPDATE client SET ";
    $bindTypes = "";
    $bindValues = [];
    // Get user input from the form
    if (!empty($_POST['card_number'])) {
        $updateQuery .= "card_number=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['card_number'];
    }

    if (!empty($_POST['card_ccv'])) {
        $updateQuery .= "card_ccv=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['card_ccv'];
    }
    if (!empty($_POST['card_exp'])) {
        $updateQuery .= "card_exp=?, ";
        $bindTypes .= "s";
        $bindValues[] = $_POST['card_exp'];
    }
    // Check if any fields were provided in the POST request
    if (!empty($bindValues)) {
        // Remove the trailing comma and space from the query
        $updateQuery = rtrim($updateQuery, ', ');

        // Add the WHERE clause
        $updateQuery .= " WHERE c_id=?";

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
        echo "issue here";
    }
}

// Include your HTML template for the profile editing form
// include 'dashboard.php'; // Adjust the path as needed
?>
