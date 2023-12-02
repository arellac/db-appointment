<?php



session_start();

$_SESSION["user"]="";
// $_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");


if($_POST){

    $result= $database->query("select * from members");

    $fname=$_SESSION['personal']['fname'];
    $lname=$_SESSION['personal']['lname'];
    $name=$fname." ".$lname;
    $email=$_POST['newemail'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];
    $utype = $_SESSION["usertype"];
    $tele = "123456789";
    if ($newpassword==$cpassword){
        $sqlmain= "select * from members where m_email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows==1){
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        }else{
            $database->query("insert into members(m_email,m_number,m_name, m_password,role) values('$email','$tele','$name','$newpassword', '$utype');");
            $lastInsertedId = $database->insert_id;


            $_SESSION["user"]=$email;
            $_SESSION['user_id'] = $lastInsertedId;
            $_SESSION["username"]=$fname;
            if($utype=='S'){
                $database->query("insert into stylist(s_id) values('$lastInsertedId');");
                header('Location: stylist/dashboard.php');
                
            }
            elseif($utype=='C'){
                $database->query("insert into client(c_id) values('$lastInsertedId');");
                header('Location: index.php');
            }
            // header('Location: client/index.php');

            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
        
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>';
    }



    
}else{
    //header('location: signup.php');
    $error='<label for="promter" class="form-label"></label>';
}
include './components/nav.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>



    <center>
    <div class="__layout">
             
             <div class="text-black flex items-start md:items-center justify-center h-auto	mt-10 bg-image px-4 py-8 md:pt-0 bg-[#FAF6F4]">
                 <div class="flex items-center justify-center flex-col">
                 <h1 class="text-lg font-bold border p-2 bg-white border-[#ff8100]">BookLook</h1>
                     <div class="flex items-start content-start justify-start h-full overflow-hidden bg-white rounded-lg shadow card mt-4 rounded-lg shadow max-w-md p-8 w-full">
                     <div class="w-full">
                             <div class="text-center w-full min-w-[300px]">

                        <p class="text-sm text-gray-700 mb-4">
                            Login or create an account to get started
                        </p>
                        <div class="w-full">
                        <table class="space-y-3">

            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="newemail" class="block text-sm font-medium leading-5 text-gray-900 text-gray-700">Email: </label>
                </td>
            </tr>
            <tr>
            <td class="relative rounded-md shadow-sm">
                    <input type="email" name="newemail" class="form-input block w-full rounded border p-2 sm:text-sm sm:leading-5 border-black/20 opacity-100 bg-dark/10 border-black/20 text-black" placeholder="Email Address" required>
                </td>
                
            </tr>
            <tr>
                <td class="flex space-x-4">
                    <!-- Create Password Input -->
                    <div class="w-1/2">
                        <label for="newpassword" class="text-left pt-4 block text-sm font-medium leading-5 text-gray-900 text-gray-700">Create New Password:</label>
                        <input type="password" name="newpassword" class="form-input block w-full rounded border p-2 sm:text-sm sm:leading-5 border-black/20 opacity-100 bg-dark/10 border-black/20 text-black" placeholder="New Password" required>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="w-1/2">
                        <label for="cpassword" class="text-left pt-4 block text-sm font-medium leading-5 text-gray-900 text-gray-700">Confirm Password:</label>
                        <input type="password" name="cpassword" class="form-input block w-full rounded border p-2 sm:text-sm sm:leading-5 border-black/20 opacity-100 bg-dark/10 border-black/20 text-black" placeholder="Confirm Password" required>
                    </div>
</td>
            </tr>
            

     
            <tr>
                
                <td colspan="2">
                    <?php echo $error ?>

                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <br>
                    <div>
                        <input type="submit" value="Sign Up" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-black px-6 py-4 text-sm font-bold text-white transition-all duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">

                    </div> 
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>

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