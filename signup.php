<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Sign Up</title>
    
</head>
<body style="background-color: #FAF6F4;">
<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;
include("connection.php");
include './components/nav.php';


if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result= $database->query("select * from one_time_links where link='$token'");
    if($result){
        if($result->num_rows > 0){
            echo "WORKED 1";
            $_SESSION["usertype"]="S";

        }else{
            echo "WORKED";

        }

    }
    else{
        echo "not work";
    }

}
else{
    $_SESSION["usertype"]="S";
}

echo $_SESSION["usertype"];

if($_POST){

    

    $_SESSION["personal"]=array(
        'fname'=>$_POST['fname'],
        'lname'=>$_POST['lname']
    );


    print_r($_SESSION["personal"]);
    $result= $database->query("delete from one_time_links where link='$token'");

    header("location: create-account.php");




}

?>


    <center>
        <div class="__layout">
             
    <div class="text-black flex items-start md:items-center justify-center h-auto mt-10 bg-image px-4 py-8 md:pt-0 bg-[#FAF6F4]">
        <div class="flex items-center justify-center flex-col">
            <div class="flex items-start content-start justify-start h-full overflow-hidden bg-white rounded-lg shadow card mt-4 rounded-lg shadow max-w-md p-8 w-full">
                <div class="w-full">
                    <div class="text-center w-full min-w-[300px]">
                        <h1 class="text-lg font-bold border p-2">BookLook</h1>

                        <p class="text-sm text-gray-700 mb-4">
                            Login or create an account to get started
                        </p>
                        <div class="w-full">
                            <div>
                            <table class="space-y-3">

            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="name" class="block text-sm font-medium leading-5 text-gray-900 text-gray-700">Name: </label>
                </td>
            </tr>
            <tr>
                <td class="relative rounded-md shadow-sm">
                    <input type="text" name="fname" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="First Name" required>
                </td>
                <td class="relative rounded-md shadow-sm">
                    <input type="text" name="lname" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Last Name" required>
                </td>
            </tr>

            <tr>
                <td class="label-td" colspan="2">
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <br>
                    <div>
                        <input type="submit" value="Next" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-black px-6 py-4 text-sm font-bold text-white transition-all duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">

                    </div> 
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>

            </tr>
        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
 

    </div>
    </center>
    <script src="https://cdn.tailwindcss.com"></script>

    </body>
</html>