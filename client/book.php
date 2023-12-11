<?php
session_start();
$useremail=$_SESSION["user"];

include("../connection.php");

if (!isset($_SESSION["user_id"])) {
    http_response_code(401); 
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$userid = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    
    $selectedDay = $data->selectedDay;
    $selectedHour = $data->selectedHour;
    $stylistId = $data->stylistId;
    $serviceId = $data->serviceId;
    $payMethod = $data->payMethod;

    $stmt = $database->prepare("SELECT service_name, service_price FROM services WHERE service_id = ?");
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $price = $row['service_price'];
        $name = $row['service_name'];
    }

    $sql = "INSERT INTO appointment (c_id, scheduledate, scheduletime, s_id, booking_price, booking_name, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $pid = $userid; 
    
    $appodate = date("Y-m-d", strtotime($selectedDay));
    $scheduletime = date("H:i:s", strtotime($selectedHour));

    $stmt = $database->prepare($sql);
    $stmt->bind_param("issiiss", $userid, $appodate, $scheduletime, $stylistId, $price, $name, $payMethod);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(["message" => "Appointment booked successfully"]);
    } else {
        echo json_encode(["error" => "Failed to book appointment"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
