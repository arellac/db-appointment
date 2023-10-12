
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" >

<head>
    <meta charset="utf-8">

    <meta name="author" content="themesflat.com">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="../css/layout.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/hero.css" />
    <link rel="stylesheet" href="../css/auction.css" />
    <link rel="stylesheet" href="../css/item.css" />
    <link rel="stylesheet" href="../css/profile.css" />
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

      if(isset($_SESSION["user"])){
          if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
              header("location: ../login.php");
          }else{
              $useremail=$_SESSION["user"];
          }
      
      }else{
          header("location: ../login.php");
      }
      
      include("../connection.php");
      include '../components/navbar.php';
      include '../components/hero.php';

      $sqlmain= "select * from client where cemail=?";
      $stmt = $database->prepare($sqlmain);
      $stmt->bind_param("s",$useremail);
      $stmt->execute();
      $userrow = $stmt->get_result();
      $userfetch=$userrow->fetch_assoc();
      $userid= $userfetch["cid"];      
  ?>
  <div style="z-index: 1000" class="bg-[#FAF6F4]" id="preloader">
    <div id="loader"></div>
  </div>

  <div class="bg-gray-25 dark:bg-gray-900 relative bg-[#FAF6F4]">

    <div class="container mx-auto pt-12 pb-[100px]">
      <div>
        <div id="grid-view" class="grid-content">
          <div class="flex items-center justify-end">
            <div class="relative ml-3 md:ml-[30px] max-w-[176px] w-full">
              <svg class="w-[10px] h-[10px] absolute top-0 bottom-0 right-3 my-auto fill-gray-600 dark:fill-gray-400" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.99953 13C7.74367 13 7.48768 12.9023 7.29269 12.707L1.29296 6.70703C0.902348 6.31641 0.902348 5.68359 1.29296 5.29297C1.68356 4.90234 2.31635 4.90234 2.70696 5.29297L7.99953 10.5875L13.293 5.29375C13.6837 4.90312 14.3164 4.90312 14.707 5.29375C15.0977 5.68437 15.0977 6.31719 14.707 6.70781L8.70731 12.7078C8.51201 12.9031 8.25577 13 7.99953 13Z" />
              </svg>
              <select name="select" class="py-2 px-3 dark:text-white rounded-md w-full bg-white dark:bg-dark border border-gray-300 dark:border-gray-900 focus:outline-none appearance-none text-xs">
                <option selected disabled value="" class="hidden">Sort by</option>
                <option value="value1">Ascending</option>
                <option value="value2">Descending</option>
              </select>
            </div>
            <button data-target-grid="grid-view" class="grid-button grid-active group max-w-[32px] h-8 w-full mx-3 flex items-center justify-center rounded-full bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 dark:hover:border-gray-800">
              <svg class="w-[14px] h-[14px] fill-gray-600 group-hover:fill-gray-900 dark:fill-gray-400 dark:group-hover:fill-white" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 1C14.1031 1 15 1.89531 15 3V13C15 14.1031 14.1031 15 13 15H3C1.89531 15 1 14.1031 1 13V3C1 1.89531 1.89531 1 3 1H13ZM13 2.5H8.75V7.25H13.5V3C13.5 2.72375 13.275 2.5 13 2.5ZM13.5 8.75H8.75V13.5H13C13.275 13.5 13.5 13.275 13.5 13V8.75ZM7.25 7.25V2.5H3C2.72375 2.5 2.5 2.72375 2.5 3V7.25H7.25ZM2.5 13C2.5 13.275 2.72375 13.5 3 13.5H7.25V8.75H2.5V13Z" />
              </svg>
            </button>
            <button data-target-grid="list-view" class="grid-button group max-w-[32px] h-8 w-full flex items-center justify-center rounded-full bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 dark:hover:border-gray-800">
              <svg class="w-[14px] h-[14px] fill-gray-600 group-hover:fill-gray-900 dark:fill-gray-400 dark:group-hover:fill-white" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 3.35484C1 2.60657 1.60657 2 2.35484 2C3.1031 2 3.70968 2.60657 3.70968 3.35484C3.70968 4.10282 3.1031 4.70968 2.35484 4.70968C1.60657 4.70968 1 4.10282 1 3.35484ZM14.0968 2.45161C14.5964 2.45161 15 2.85609 15 3.35484C15 3.85444 14.5964 4.25806 14.0968 4.25806H5.96774C5.46815 4.25806 5.06452 3.85444 5.06452 3.35484C5.06452 2.85609 5.46815 2.45161 5.96774 2.45161H14.0968ZM14.0968 6.96774C14.5964 6.96774 15 7.37137 15 7.87097C15 8.37056 14.5964 8.77419 14.0968 8.77419H5.96774C5.46815 8.77419 5.06452 8.37056 5.06452 7.87097C5.06452 7.37137 5.46815 6.96774 5.96774 6.96774H14.0968ZM14.0968 11.4839C14.5964 11.4839 15 11.8875 15 12.3871C15 12.8867 14.5964 13.2903 14.0968 13.2903H5.96774C5.46815 13.2903 5.06452 12.8867 5.06452 12.3871C5.06452 11.8875 5.46815 11.4839 5.96774 11.4839H14.0968ZM1 12.3871C1 11.6391 1.60657 11.0323 2.35484 11.0323C3.1031 11.0323 3.70968 11.6391 3.70968 12.3871C3.70968 13.1351 3.1031 13.7419 2.35484 13.7419C1.60657 13.7419 1 13.1351 1 12.3871ZM3.70968 7.87097C3.70968 8.61895 3.1031 9.22581 2.35484 9.22581C1.60657 9.22581 1 8.61895 1 7.87097C1 7.12298 1.60657 6.51613 2.35484 6.51613C3.1031 6.51613 3.70968 7.12298 3.70968 7.87097Z" />
              </svg>
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mt-7 mb-12 ">
            
            <?php

              $result = $database->query("select * from stylist");

              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<div class="group p-4 relative bg-[#FDFBFA] dark:bg-dark border border-gray-300 dark:border-gray-800 rounded-lg shadow-outline hover:shadow-hover hover:outline hover:outline-2 hover:outline-primary-300">';
                    echo '<form method="get" action="stylist.php" class="relative group">';
                    echo '<input type="hidden" name="id" value="' . $row['sid'] . '">';
                    
                    echo '<button class="opacity-0 group-hover:opacity-100 absolute top-7 left-7 px-4 py-1 rounded-md font-light text-base flex items-center justify-center bg-orange-500 text-white hover:bg-orange-600 transition-all duration-200 z-10"> Book </button>';
                    echo '</form>';
                    

                    echo '<button class="w-9 h-9 p-2 absolute top-7 right-7 flex items-center justify-center bg-gray-700/5 hover:bg-gray-700/10 rounded-full z-10">';
                    echo '<svg width="18" height="18" viewBox="0 0 18 18">';
                    echo '<path d="M0 6.71134V6.50744C0 4.05002 1.77609 1.954 4.19766 1.55041C5.76914 1.28357 7.43203 1.80599 8.57812 2.95384L9 3.37502L9.39023 2.95384C10.568 1.80599 12.1992 1.28357 13.8023 1.55041C16.2246 1.954 18 4.05002 18 6.50744V6.71134C18 8.17033 17.3953 9.56603 16.3266 10.561L9.97383 16.4918C9.71016 16.7379 9.36211 16.875 9 16.875C8.63789 16.875 8.28984 16.7379 8.02617 16.4918L1.67309 10.561C0.605742 9.56603 1.05469e-05 8.17033 1.05469e-05 6.71134H0Z" fill="#585C7B" />';
                    echo '</svg>';
                    echo '</button>';
                    echo '<a href="stylist.php?id=' . $row['sid'] . '">' . '</a>';
                    echo '<img src="' . $row['image_url'] . '" class="w-full h-56 object-cover rounded-lg mb-4 flex items-end justify-center" alt="" />';
                    echo '</a>';
                    echo '<div class="flex items-center justify-between">';
                    echo '<div class="flex items-center">';
                    echo '<p class="font-normal text-gray-700 dark:text-white mr-2">' . $row['sname'] . '</p>';
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