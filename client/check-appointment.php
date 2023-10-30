<?php

//import database

$data = json_decode(file_get_contents("php://input"));

if (isset($data->stylistId) && isset($data->date) && isset($data->time)) {
    $stylistId = $data->stylistId;
    $date = $data->date;
    $time = $data->time;

    $dateTime = DateTime::createFromFormat('h:i A', $time);
    $formattedTime = $dateTime->format('H:i:s'); // Format as "14:00:00"

    $isBooked = isAppointmentBooked($stylistId, $date, $formattedTime);

    echo json_encode(['isBooked' => $isBooked]);

} else {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid data']);
}

function isAppointmentBooked($stylistId, $date, $time)
{
    include("../connection.php");

    $query = "SELECT COUNT(*) AS count FROM appointment WHERE s_id = ? AND scheduledate = ? AND scheduletime = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param("iss", $stylistId, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}
?>
