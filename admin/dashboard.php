<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>

    <?php
    // Include your database connection code here
    // For example, you can include a config.php file with database connection details.
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");

    try {
        // Replace with your database connection details

        // Execute the query
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
        // Handle database errors
        echo "Database Error: " . $e->getMessage();
    }
    ?>

</body>
</html>