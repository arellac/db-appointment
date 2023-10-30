<?php
   // check if an image file was uploaded
   include("../connection.php");

   $userid = 8;
   if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $imageInfo = getimagesize($_FILES['image_url']['tmp_name']);
        var_dump($imageInfo);


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