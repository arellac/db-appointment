<!DOCTYPE html>
<html lang="en">

<body style="background-color: #FAF6F4;">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    //learn from w3schools.com
    //Unset all the server side variables

    session_start();

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";

    // Set the new timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;
    

    //import database
    include("connection.php");

    ?>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/animations.css">  
      <link rel="stylesheet" href="css/login.css">
          
      <title>Login</title>
  </head>

    <?php



    if($_POST){

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from members where m_email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['role'];
            if ($utype=='C'){
                //TODO
                $checker = $database->query("select * from members where m_email='$email' and m_password='$password'");
                if ($checker->num_rows==1){


                    //   client dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='C';
                    
                    header('location: ./index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($utype=='A'){
                //TODO
                $checker = $database->query("select * from members where m_email='$email' and m_password='$password'");
                if ($checker->num_rows==1){


                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='A';
                    
                    header('location: admin/home.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($utype=='S'){
                //TODO
                $checker = $database->query("select * from members where m_email='$email' and m_password='$password'");
                if ($checker->num_rows==1){


                    //   stylist dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='S';
                    header('location: stylist/dashboard.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }






        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    include './components/nav.php';

    ?>

    <center>
      <div class="__layout">
        <div class="text-black flex items-start md:items-center justify-center h-auto mt-10 bg-image px-4 py-8 md:pt-0 bg-[#FAF6F4]">
          <div class="flex items-center justify-center flex-col">
            <!-- <h1 class="text-lg font-bold border p-2">BookLook</h1> -->
            <div class="flex items-start content-start justify-start h-full overflow-hidden bg-white rounded-lg shadow card mt-4 rounded-lg shadow max-w-md p-8 w-full">
              <div class="w-full">
                <div class=" w-full min-w-[300px]">
                <h1 class="text-lg font-bold border p-2">BookLook</h1>
                  <p class="text-sm text-gray-700 mb-4 mt-2"> Login with your details to continue </p>
                  <div class="w-full">
                    <div>
                      <table class="space-y-6">
                        <div class="space-y-5 text-left">
                          <form action="" method="POST">
                            <div class="mb-4">
                              <label for="useremail" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email: </label>
                              <div class="relative mt-2.5 text-gray-600 focus-within:text-gray-400">
                                <input type="email" name="useremail" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Email Address" required>
                              </div>
                            </div>
                            <div class="mb-4">
                              <label for="userpassword" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password: </label>
                              <div class="relative mt-2.5 text-gray-600 focus-within:text-gray-400">
                                <input type="Password" name="userpassword" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Password" required>
                              </div>
                            </div>
                            <tr>
                              <td class="mb-4"> <?php echo $error ?> </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <br>
                                <div>
                                  <input type="submit" value="Login" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-black px-6 py-4 text-sm font-bold text-white transition-all duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                </div>
                                </br>
                                <label for="" class="sub-text" style="font-weight: 280; ">Don't have an account&#63; </label>
                                <a href="signup.php" class="hover-link1 non-style-link text-orange-500	">Sign Up</a>
                                <br>
                                <br>
                                <br>
                              </td>
                            </tr>
                          </form>
                        </div>
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