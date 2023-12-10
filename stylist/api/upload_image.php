<?php
// check if an image file was uploaded
session_start();

include("../../connection.php");
$userid = $_SESSION["user_id"];

if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
    $imageType = $_FILES['image_url']['type'];

    // Check if the file is an image
    if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
        // Create an image resource from the uploaded file
        if ($imageType == 'image/jpeg') {
            $imageResource = imagecreatefromjpeg($_FILES['image_url']['tmp_name']);
        } else {
            $imageResource = imagecreatefrompng($_FILES['image_url']['tmp_name']);
        }

        if ($imageResource !== false) {
            // Start buffering
            ob_start();

            // Compress and output the image to the buffer
            // Adjust the quality parameter as needed (0 - worst quality, 100 - best quality)
            if ($imageType == 'image/jpeg') {
                imagejpeg($imageResource, null, 50); // For JPEG
            } else {
                imagepng($imageResource, null, 6); // For PNG (0 - no compression, 9 - maximum)
            }

            // Get the compressed image data from the buffer
            $compressedImage = ob_get_contents();

            // End buffering and clean up
            ob_end_clean();
            imagedestroy($imageResource);

            // Prepare the SQL statement
            $stmt = $database->prepare("UPDATE stylist SET image_url=? WHERE s_id=?");

            // Bind the file data and the user ID to the prepared statement
            $stmt->bind_param("bi", $compressedImage, $userid);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Profile updated successfully!";
            } else {
                echo "Error updating profile: " . $stmt->error;
            }
        } else {
            echo "Error processing image.";
        }
    } else {
        echo "Invalid file type.";
    }
}
?>
