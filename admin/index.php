<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
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

    function generateRandomToken($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $token;
    }

    if ($_POST) {
        $user_id = $_POST['user_id']; 
        $expiration_date = $_POST['expiration_date']; 

        $token = generateRandomToken();

        $base_url = "https://localhost/db-project/register?token=";
        $one_time_link = $token;

        try {
            $database->query("insert into one_time_links (user_id, link, expiration_date) values('$user_id', '$one_time_link', '$expiration_date');");

            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
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
