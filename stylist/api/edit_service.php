<?php
session_start();

include("../../connection.php");
$useremail = $_SESSION["user"];

// Initialize the response array
$response = [];

$inputJSON = file_get_contents('php://input');
echo $inputJSON; // Print the received JSON string

$input = json_decode($inputJSON, TRUE); // Convert JSON into array

// Check if necessary data is received
if (isset($input['service_id'], $input['service_name'], $input['service_details'], $input['service_price'])) {
    $serviceId = $input['service_id'];
    $serviceName = $input['service_name'];
    $serviceDetails = $input['service_details'];
    $servicePrice = $input['service_price'];

    // For debugging
    // echo json_encode($_POST);
    // exit;

    // Update the database record
    $stmt = $database->prepare("UPDATE services SET service_name = ?, service_details = ?, service_price = ? WHERE service_id = ?");
    $stmt->bind_param("ssii", $serviceName, $serviceDetails, $servicePrice, $serviceId);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Service updated successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating service in database.';
    }
}

echo json_encode($response);
?>
