<?php
    session_start();
    include("../connection.php");

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }

    $useremail=$_SESSION["user"];
    // $sqlmain= "select * from client where c_email=?";
    // $stmt = $database->prepare($sqlmain);
    // $stmt->bind_param("s",$useremail);
    // $stmt->execute();
    // $userrow = $stmt->get_result();
    // $userfetch=$userrow->fetch_assoc();
    // $client_id= $userfetch["c_id"];
    $userid=$_SESSION["user_id"];

    // 3. Upcoming Appointments
    $query = "
    SELECT 
        a.appoid, a.c_id, m.m_name, a.scheduledate, a.scheduletime, 
        a.booking_name, a.booking_price, a.payment_method
    FROM appointment a
    LEFT JOIN client c ON a.c_id = c.c_id
    LEFT JOIN stylist st ON a.s_id = st.s_id
    LEFT JOIN members m ON st.s_id = m.m_id
    WHERE a.c_id = ? AND a.scheduledate >= CURRENT_DATE
    ORDER BY a.scheduledate, a.scheduletime";
    $stmt = $database->prepare($query);
    $stmt->bind_param("i", $userid);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $upcoming_appointments = $result->fetch_all(MYSQLI_ASSOC);

    $query = "
    SELECT 
        a.appoid, a.c_id, m.m_name, a.scheduledate, a.scheduletime, 
        a.booking_name, a.booking_price, a.payment_method
    FROM appointment a
    LEFT JOIN client c ON a.c_id = c.c_id
    LEFT JOIN stylist st ON a.s_id = st.s_id
    LEFT JOIN members m ON st.s_id = m.m_id
    WHERE a.c_id = ? AND a.scheduledate < CURRENT_DATE
    ORDER BY a.scheduledate, a.scheduletime";
    $stmt = $database->prepare($query);
    $stmt->bind_param("i", $userid);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $past_appointments = $result->fetch_all(MYSQLI_ASSOC);

    $stmt = $database->prepare("SELECT card_number, card_ccv, card_exp FROM client WHERE c_id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $card_number = $row['card_number']; 
        $cvv = $row['card_ccv'];
        $exp_date = $row['card_exp']; 
    
    } else {
        echo "No client found with the given ID.";
    }
    
    $stmt->close();
    

?>

<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <body class="">
      <?php     include '../components/nav.php'; ?>

      
      
      <!-- Tabs -->
      
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-example" role="tablist">
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active" id="profile-tab-example" type="button" role="tab" aria-controls="profile-example" aria-selected="true">Upcoming Appointments</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab-example" type="button" role="tab" aria-controls="dashboard-example" aria-selected="false">Past Appointments</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="profile2-tab-example" type="button" role="tab" aria-controls="profile2-example" aria-selected="false">Profile</button>
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
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile2-example" role="tabpanel" aria-labelledby="profile2-tab-example">
            <?php include("./edit.php"); ?>
        </div>
      </div>

</body>
<script src="https://cdn.tailwindcss.com"></script>
<script>
$(document).ready(function() {
    $('.ajaxForm').submit(function(e) {
        e.preventDefault();

        let $form = $(this); // The form being submitted
        $.ajax({
            type: 'POST',
            url: $form.attr('action'), // Gets the action attribute value of the form
            data: $form.serialize(),
            success: function(response) {
                $('#response').html(response).removeClass('hidden');
            },
            error: function() {
                $('#response').html('Error in request.');
            }
        });
    });
});
</script>
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