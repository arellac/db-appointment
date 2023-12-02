<?php
   // check if an image file was uploaded
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
   
   if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $imageInfo = getimagesize($_FILES['image_url']['tmp_name']);


       $stmt = $database->prepare("UPDATE stylist SET image_url=? WHERE s_id=?");
              
       // Read the entire file into a variable
       $photoData = file_get_contents($_FILES['image_url']['tmp_name']);
    //    var_dump($photoData);
       $binaryPhotoData = b"$photoData";
    //    var_dump($photoData);

       // Close the file handle
       
       // bind the file data and the user ID to the prepared statement
       $stmt->bind_param("si", $photoData, $userid);
   
       // Execute the statement
       if ($stmt->execute()) {
           echo "Profile updated successfully!";
       } else {
           echo "Error updating profile: " . $stmt->error;
       }
   }
?>