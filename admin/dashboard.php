<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/admin.css">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    <title>Dashboard</title>
</head>
<body class="bg-slate-500">

    <h1 >Dashboard</h1>

    <?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }


    include("../connection.php");

    try {

        $result = $database->query("select * from one_time_links");

        if ($result->num_rows > 0) {
            echo "<h2>All One-Time Links:</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "User ID: " . $row['user_id'] . "<br>";
                echo "Link: " . $row['link'] . "<br>";
                echo "Expiration Date: " . $row['expiration_date'] . "<br>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No one-time links found.</p>";
        }

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }

    
    ?>
    <?php include('index.php'); ?>


    
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>