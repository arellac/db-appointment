<?php
// Include your database connection code here
session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$sqlmain= "select * from client where cemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s",$useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["cid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $selectedDay = $data->selectedDay;
    $selectedHour = $data->selectedHour;
    $stylistId = $data->stylistId;
    $serviceId = $data->serviceId;


    $sql = "INSERT INTO appointment (pid, apponum, scheduleid, appodate, scheduletime, sid,service_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    

    $pid = $userid; 
    $apponum = 1; 
    $scheduleid = 1; 
    
    $appodate = date("Y-m-d", strtotime($selectedDay));
    $scheduletime = date("H:i:s", strtotime($selectedHour));

    $stmt = $database->prepare($sql);
    $stmt->bind_param("iiissss", $pid, $apponum, $scheduleid, $appodate, $scheduletime, $stylistId,$serviceId);
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
