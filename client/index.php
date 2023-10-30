
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" >

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />


    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


</head>


<main id="main">
  <?php 
      session_start();
      include("../connection.php");

      if(isset($_SESSION["user"])){
          if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
              // header("location: ../login.php");
          }else{
              $useremail=$_SESSION["user"];
              $sqlmain= "select * from client where c_email=?";
              $stmt = $database->prepare($sqlmain);
              $stmt->bind_param("s",$useremail);
              $stmt->execute();
              $userrow = $stmt->get_result();
              $userfetch=$userrow->fetch_assoc();
              $userid= $userfetch["c_id"];
          }
      
      }
      
      include '../components/nav.php';
      // include '../components/hero.php';


      $query = "SELECT appointment.*, stylist.s_name AS stylist_name 
          FROM appointment 
          JOIN stylist ON appointment.s_id = stylist.s_id 
          WHERE appointment.c_id = ? AND appointment.scheduledate >= CURDATE() 
          ORDER BY appointment.scheduledate ASC
          LIMIT 3";

      $stmt = $database->prepare($query);
      $stmt->bind_param("i", $userid);
      $stmt->execute();


      $result = $stmt->get_result();
      $appointments = $result->fetch_all(MYSQLI_ASSOC);


  ?>
  <div style="z-index: 1000" class="bg-[#FAF6F4]" id="preloader">
    <div id="loader"></div>
  </div>

  <?php if (count($appointments) > 0): ?>
    <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md m-4" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M2 2v16h16V2H2zm4 4h3v3H6V6zm5 0h3v3h-3V6zM6 11h3v3H6v-3zm5 0h3v3h-3v-3zm-5 5h3v3H6v-3zm5 0h3v3h-3v-3zm5-10h3v3h-3V6zm0 5h3v3h-3v-3zm0 5h3v3h-3v-3z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold">You have upcoming appointments:</p>
                <ul>
                    <?php foreach($appointments as $appointment): ?>
                        <li class="text-sm mt-1">
                            - <?php echo date("F j, Y, g:i a", strtotime($appointment['scheduledate'])); ?> with <?php echo $appointment['stylist_name']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
  <?php endif; ?>


  <div class="bg-gray-25 dark:bg-gray-900 relative bg-[#FAF6F4]">

    <div class="container mx-auto pt-12 pb-[100px]">
      <div>
        <div id="grid-view" class="grid-content">

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mt-7 mb-12 ">
            
            <?php

              $result = $database->query("select * from stylist");

              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $type = 'image/png';
                    $base64 = base64_encode($row['image_url']);
                    $dataURL = "data:$type;base64,$base64";


                    echo '<div class="group p-4 relative bg-[#FDFBFA] dark:bg-dark border border-gray-300 dark:border-gray-800 rounded-lg shadow-outline hover:shadow-hover hover:outline hover:outline-2 hover:outline-primary-300">';
                    echo '<form method="get" action="stylist.php" class="relative group">';
                    echo '<input type="hidden" name="id" value="' . $row['s_id'] . '">';
                    
                    echo '<button class="opacity-0 group-hover:opacity-100 absolute top-7 left-7 px-4 py-1 rounded-md font-light text-base flex items-center justify-center bg-orange-500 text-white hover:bg-orange-600 transition-all duration-200 z-10"> Book </button>';
                    echo '</form>';
                    

                    echo '<button class="w-9 h-9 p-2 absolute top-7 right-7 flex items-center justify-center bg-gray-700/5 hover:bg-gray-700/10 rounded-full z-10">';
                    echo '<svg width="18" height="18" viewBox="0 0 18 18">';
                    echo '<path d="M0 6.71134V6.50744C0 4.05002 1.77609 1.954 4.19766 1.55041C5.76914 1.28357 7.43203 1.80599 8.57812 2.95384L9 3.37502L9.39023 2.95384C10.568 1.80599 12.1992 1.28357 13.8023 1.55041C16.2246 1.954 18 4.05002 18 6.50744V6.71134C18 8.17033 17.3953 9.56603 16.3266 10.561L9.97383 16.4918C9.71016 16.7379 9.36211 16.875 9 16.875C8.63789 16.875 8.28984 16.7379 8.02617 16.4918L1.67309 10.561C0.605742 9.56603 1.05469e-05 8.17033 1.05469e-05 6.71134H0Z" fill="#585C7B" />';
                    echo '</svg>';
                    echo '</button>';
                    echo '<a href="stylist.php?id=' . $row['s_id'] . '">' . '</a>';
                    echo '<img src="' . $dataURL . '" class="w-full h-56 object-cover rounded-lg mb-4 flex items-end justify-center" alt="" />';
                    echo '</a>';
                    echo '<div class="flex items-center justify-between">';
                    echo '<div class="flex items-center">';
                    echo '<p class="font-normal text-gray-700 dark:text-white mr-2">' . $row['s_name'] . '</p>';
                    echo '<svg width="12" height="12" viewBox="0 0 16 16" class="fill-primary-400">';
                    echo '<path d="M8 0C9.15 0 10.15 0.646875 10.6531 1.59687C11.6812 1.25312 12.8156 1.53 13.6562 2.34313C14.4688 3.15625 14.6906 4.31875 14.4031 5.34688C15.3531 5.85 16 6.85 16 8C16 9.15 15.3531 10.15 14.4031 10.6531C14.7187 11.6812 14.4688 12.8156 13.6562 13.6562C12.8156 14.4688 11.6812 14.6906 10.6531 14.4031C10.15 15.3531 9.15 16 8 16C6.85 16 5.85 15.3531 5.34688 14.4031C4.31875 14.7187 3.15625 14.4688 2.34313 13.6562C1.53 12.8156 1.28125 11.6812 1.59687 10.6531C0.646875 10.15 0 9.15 0 8C0 6.85 0.646875 5.85 1.59687 5.34688C1.25312 4.31875 1.53 3.15625 2.34313 2.34313C3.15625 1.53 4.31875 1.28125 5.34688 1.59687C5.85 0.646875 6.85 0 8 0ZM11.0031 7.00313C11.3219 6.7375 11.3219 6.2625 11.0031 5.96875C10.7375 5.67812 10.2625 5.67812 9.96875 5.96875L7 8.94063L5.75313 7.71875C5.4875 7.42812 5.0125 7.42812 4.71875 7.71875C4.42812 8.0125 4.42812 8.4875 4.71875 8.75313L6.46875 10.5031C6.7625 10.8219 7.2375 10.8219 7.50313 10.5031L11.0031 7.00313Z" />';
                    echo '</svg>';
                    echo '</div>';
                    echo '<button class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">';
                    echo '<svg width="14" height="14" viewBox="0 0 16 16" class="fill-gray-600 dark:fill-gray-300">';
                    echo '<path d="M4.62963 8C4.62963 9.03 3.81718 9.86666 2.81481 9.86666C1.81245 9.86666 1 9.03 1 8C1 6.97 1.81245 6.13333 2.81481 6.13333C3.81718 6.13333 4.62963 6.97 4.62963 8ZM9.81481 8C9.81481 9.03 9.00139 9.86666 8 9.86666C6.99861 9.86666 6.18519 9.03 6.18519 8C6.18519 6.97 6.99861 6.13333 8 6.13333C9.00139 6.13333 9.81481 6.97 9.81481 8ZM11.3704 8C11.3704 6.97 12.1838 6.13333 13.1852 6.13333C14.1866 6.13333 15 6.97 15 8C15 9.03 14.1866 9.86666 13.1852 9.86666C12.1838 9.86666 11.3704 9.03 11.3704 8Z" />';
                    echo '</svg>';
                    echo '</button>';
                    echo '</div>';

                    echo '<a href="/#" class="group-hover:text-orange-600 font-medium text-orange-500 dark:text-white">' . $row['sln_name'] . '</a>';
                    echo '</div>';

                  }
              }

            ?>


          </div>
        
        </div>
      </div>
    </div>
  </div>
  <div id="scroll--top">
            <i class="fa-solid fa-angle-up"></i>
        </div>
  <script src="https://cdn.tailwindcss.com"></script>
</body>


</html>