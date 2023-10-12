<?php

//import database

// Stylist ID, date, and time from the POST request
$data = json_decode(file_get_contents("php://input"));

if (isset($data->stylistId) && isset($data->date) && isset($data->time)) {
    $stylistId = $data->stylistId;
    $date = $data->date;
    $time = $data->time;

    $dateTime = DateTime::createFromFormat('h:i A', $time);
    $formattedTime = $dateTime->format('H:i:s'); // Format as "14:00:00"

    // Check if the appointment is booked
    $isBooked = isAppointmentBooked($stylistId, $date, $formattedTime);

    // Send a JSON response with the result
    echo json_encode(['isBooked' => $isBooked]);

    // Close the database connection
} else {
    // Handle invalid or missing data
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid data']);
}

// Function to check if the appointment is booked
function isAppointmentBooked($stylistId, $date, $time)
{
    // Modify this function to query your database and check if the appointment exists
    // Sample query assuming you have a 'appointments' table with 'stylist_id', 'date', and 'time' columns
    include("../connection.php");

    $query = "SELECT COUNT(*) AS count FROM appointment WHERE sid = ? AND appodate = ? AND scheduletime = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param("iss", $stylistId, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}
?>
