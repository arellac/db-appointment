<?php
        session_start();
        include("../connection.php");
        include '../components/nav.php';


        if(isset($_SESSION["user"])){
            if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
                header("location: ../login.php");
            }

        }else{
            header("location: ../login.php");
        }

        $useremail=$_SESSION["user"];
        $sqlmain= "select * from client where c_email=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$useremail);
        $stmt->execute();
        $userrow = $stmt->get_result();
        $userfetch=$userrow->fetch_assoc();
        $client_id= $userfetch["c_id"];

        // 3. Upcoming Appointments
        $query = "
        SELECT 
            a.appoid, a.c_id, c.c_name, a.scheduledate, a.scheduletime, 
            a.service_id, s.service_name, s.service_price, a.payment_method
        FROM appointment a
        LEFT JOIN services s ON a.service_id = s.service_id
        LEFT JOIN client c ON a.c_id = c.c_id
        WHERE a.c_id = ? AND a.scheduledate >= CURRENT_DATE
        ORDER BY a.scheduledate, a.scheduletime";
        $stmt = $database->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        $upcoming_appointments = $result->fetch_all(MYSQLI_ASSOC);

        $query = "
        SELECT 
            a.appoid, a.c_id, c.c_name, a.scheduledate, a.scheduletime, 
            a.service_id, s.service_name, s.service_price, a.payment_method
        FROM appointment a
        LEFT JOIN services s ON a.service_id = s.service_id
        LEFT JOIN client c ON a.c_id = c.c_id
        WHERE a.c_id = ? AND a.scheduledate < CURRENT_DATE
        ORDER BY a.scheduledate, a.scheduletime";
        $stmt = $database->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        $past_appointments = $result->fetch_all(MYSQLI_ASSOC);
    ?>
<html>
    <head>

    </head>
    <body class="">
    

      
      
      <!-- Tabs -->
      
      
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-example" role="tablist">
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active" id="profile-tab-example" type="button" role="tab" aria-controls="profile-example" aria-selected="true">Upcoming Appointments</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab-example" type="button" role="tab" aria-controls="dashboard-example" aria-selected="false">Past Appointments</button>
          </li>

        </ul>
      </div>
      <div id="tabcontentExample" class="w-full max-w-8xl mx-auto">
        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile-example" role="tabpanel" aria-labelledby="profile-tab-example">
          <p class="text-sm text-gray-500 dark:text-gray-400">
          <?php include("./api/fetch_appointments.php"); ?>

           </p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard-example" role="tabpanel" aria-labelledby="dashboard-tab-example">
            <?php include("./api/fetch_past_app.php"); ?>
        </div>

      </div>

</body>
<script src="https://cdn.tailwindcss.com"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('[role="tab"]');
    const tabContents = document.querySelectorAll('[role="tabpanel"]');

    // Activate the first tab and its content by default
    tabs[0].classList.add('active');
    tabContents[0].classList.remove('hidden');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            // Remove current active classes
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.add('hidden'));

            // Add active class to the clicked tab
            e.currentTarget.classList.add('active');

            // Show associated tab content
            const contentId = e.currentTarget.getAttribute('aria-controls');
            document.getElementById(contentId).classList.remove('hidden');
        });
    });
});

</script>
<style>
    @font-face {
        font-family: Geist;
        src: url(../Geist-Regular.otf);
    }
    * {
    font-family: Geist;
    }
    .active {
        color: #ff6600; 
        border-bottom-color: #ff6600;
    }
</style>
</html>