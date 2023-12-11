<?php

session_start();

include("../../connection.php");

$userid = $_SESSION["user_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateQuery = "UPDATE client SET ";
    $bindTypes = "";
    $bindValues = [];

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
    if (!empty($bindValues)) {
        $updateQuery = rtrim($updateQuery, ', ');

        $updateQuery .= " WHERE c_id=?";

        $bindTypes .= "i";
        $bindValues[] = $userid;

        $stmt = $database->prepare($updateQuery);
        if ($imageIndex = array_search("b", str_split($bindTypes))) {
            $stmt->send_long_data($imageIndex, $bindValues[$imageIndex]);
            unset($bindValues[$imageIndex]);
        }
        $stmt->bind_param($bindTypes, ...$bindValues);

        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile.";
        }
    } else {
        echo "issue here";
    }
}

?>
