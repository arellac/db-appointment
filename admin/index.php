<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <?php

    //learn from w3schools.com

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
    // Include the generateRandomToken() function
    function generateRandomToken($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $token;
    }

    if ($_POST) {
        // Handle the form submission here
        $user_id = $_POST['user_id']; // You should sanitize and validate this input
        $expiration_date = $_POST['expiration_date']; // You should validate and format this input

        // Generate a random token
        $token = generateRandomToken();

        // Create a one-time link
        $base_url = "https://localhost/scheduler/register?token=";
        $one_time_link = $base_url . $token;

        // Store the link in the database
        try {
            // Include your database connection code here (e.g., using PDO or mysqli)
            // Example using PDO:
            // $pdo = new PDO("mysql:host=localhost;dbname=your_db", "username", "password");
            
            // Insert the link into the database

            $database->query("insert into one_time_links (user_id, link, expiration_date) values('$user_id', '$one_time_link', '$expiration_date');");


            // $query = "insert into one_time_links (user_id, link, expiration_date) values (?, ?, ?)";
            // $stmt = $database->prepare($query);
            // $stmt->execute();

            // Redirect to a success page or display a success message
            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Database Error: " . $e->getMessage();
        }
    }

    ?>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Generate One-Time Link</h2>
    <form action="" method="POST" >
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required><br>
        
        <label for="expiration_date">Expiration Date:</label>
        <input type="date" name="expiration_date" required><br>
        
        <input type="submit" value="Generate Link">
    </form>
</body>
</body>
</html>
