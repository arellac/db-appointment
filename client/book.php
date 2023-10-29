<?php
// Include your database connection code here
session_start();
$useremail=$_SESSION["user"];

// if(isset($_SESSION["user"])){
//     if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
//         // header("location: ../login.php");
//     }else{
//         $useremail=$_SESSION["user"];
//     }

// }else{
//     // header("location: ../login.php");
// }


//import database
include("../connection.php");
$sqlmain= "select * from client where c_email=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s",$useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch=$userrow->fetch_assoc();
$userid= 7;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    
    $selectedDay = $data->selectedDay;
    $selectedHour = $data->selectedHour;
    $stylistId = $data->stylistId;
    $serviceId = $data->serviceId;
    $payment_method = 0;

    $sql = "INSERT INTO appointment (c_id, scheduledate, scheduletime, s_id, service_id, payment_method) VALUES (?, ?, ?, ?, ?, ?)";
    

    $pid = $userid; 
    $apponum = 1; 
    $scheduleid = 1; 
    
    $appodate = date("Y-m-d", strtotime($selectedDay));
    $scheduletime = date("H:i:s", strtotime($selectedHour));

    $stmt = $database->prepare($sql);
    $stmt->bind_param("issiii", $userid, $appodate, $scheduletime, $stylistId,$serviceId, $payment_method);
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
