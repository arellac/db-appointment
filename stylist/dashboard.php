<?php

session_start();

include("../connection.php");
$useremail = $_SESSION["user"];
$stylistId = $_SESSION["user_id"];

$sqlmain = "SELECT stylist.*, members.m_name FROM stylist JOIN members on stylist.s_id = members.m_id WHERE s_id=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("i", $stylistId);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();

// 1. Total Revenue
$query1 = "SELECT SUM(a.booking_price) AS total_revenue
            FROM appointment a
            WHERE a.s_id = ? AND scheduledate < CURRENT_DATE";
$stmt1 = $database->prepare($query1);
$stmt1->bind_param("i", $stylistId);
$stmt1->execute();
$result = $stmt1->get_result();
$row = $result->fetch_assoc();
$total_revenue = $row['total_revenue'];

// 2. Total Appointments Made
$query2 = "SELECT COUNT(*) AS total_appointments FROM appointment WHERE s_id = ? AND scheduledate > CURRENT_DATE";
$stmt = $database->prepare($query2);
$stmt->bind_param("i", $stylistId);
$stmt->execute();
$result = $stmt->get_result();
$total_appointments = $result->fetch_assoc();

// 3. Upcoming Appointments
$query3 = "
SELECT 
    a.appoid, a.c_id, m.m_name, a.scheduledate, a.scheduletime, 
    a.booking_price, a.booking_name, a.payment_method
FROM appointment a
LEFT JOIN members m ON a.c_id = m.m_id
WHERE a.s_id = ? AND a.scheduledate >= CURRENT_DATE
ORDER BY a.scheduledate, a.scheduletime
";
$stmt3 = $database->prepare($query3);
$stmt3->bind_param("i", $stylistId);
$stmt3->execute();
$result = $stmt3->get_result();
$upcoming_appointments = $result->fetch_all(MYSQLI_ASSOC);

// 4. Most Popular Appointment
// $query4 = "SELECT service_id, COUNT(*) AS service_count
//             FROM appointment 
//             WHERE s_id = ?
//             GROUP BY service_id
//             ORDER BY service_count DESC
//             LIMIT 1";
// $stmt4 = $database->prepare($query4);
// $stmt4->bind_param("i", $stylistId);
// $stmt4->execute();
// $result = $stmt4->get_result();
// $most_popular_service = $result->fetch_assoc();

// 5. Past Appointments
$query5 = "
SELECT 
    a.appoid, a.c_id, m.m_name, a.scheduledate, a.scheduletime, 
    a.booking_price, a.booking_name, a.payment_method
FROM appointment a
LEFT JOIN members m ON a.c_id = m.m_id
WHERE a.s_id = ? AND a.scheduledate < CURRENT_DATE
ORDER BY a.scheduledate, a.scheduletime
";
$stmt5 = $database->prepare($query5);
$stmt5->bind_param("i", $stylistId);
$stmt5->execute();
$result = $stmt5->get_result();
$past_appointments = $result->fetch_all(MYSQLI_ASSOC);

// 6. Services
$query = "SELECT service_id, service_name, service_price, service_details
            FROM services
            WHERE s_id = ?";
$stmt = $database->prepare($query);
$stmt->bind_param("i", $stylistId);
$stmt->execute();
$result = $stmt->get_result();

$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}
date_default_timezone_set('America/Chicago');

// Closest Appointment
if (!empty($upcoming_appointments)) {
    // 1. Check the first element for the soonest appointment
    $soonest_appointment = $upcoming_appointments[0];

    // Extract date and time
    $appoDate = new DateTime($soonest_appointment['scheduledate'] . ' ' . $soonest_appointment['scheduletime']);
    $now = new DateTime();

    // 2. Calculate the time difference
    $interval = $now->diff($appoDate);
    $hours = $interval->h;
    $hours = $hours + ($interval->days * 24); // Convert days to hours

    // 3. Store the result in a variable
    if ($interval->days > 0) {
        $appointment_time_difference = "in " . $interval->days . " days";
    } else {
        $appointment_time_difference = "in " . $hours . " hours";
    }
} else {
    $appointment_time_difference = "No upcoming appointments";
}

$json_total_app = json_encode($total_appointments);
$json_total_rev = json_encode($total_revenue);
$json_upcoming = json_encode($upcoming_appointments);
$json_past = json_encode($past_appointments);
$json_services = json_encode($services);
$json_user_info = json_encode($userfetch);
$stylistName = $userfetch["m_name"];
$slnName = $userfetch["sln_name"];
$stylistAddr = $userfetch["sln_address"];

echo "<script>console.log($json_total_rev);</script>";
echo "<script>console.log($json_total_app);</script>";
echo "<script>console.log($json_upcoming);</script>";
echo "<script>console.log($json_past);</script>";
echo "<script>console.log($json_services);</script>";
echo "<script>console.log($json_user_info);</script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

<div class="grid h-screen min-h-screen w-full overflow-hidden lg:grid-cols-[280px_1fr]">
  <div class="hidden border-r bg-zinc-100/40 lg:block">
    <div class="flex flex-col gap-3">
    <div class="flex h-[70px] justify-between items-center px-6">
    <a class="flex items-center gap-3 font-semibold" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" h-7 w-7">
            <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
            <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
            <path d="M12 3v6"></path>
        </svg>
        <span class=""> BookLook </span>
    </a>
    <button onclick="window.location.href='../logout.php'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        Logout
    </button>
</div>
      <div class="flex-1">
        <nav class="grid items-start px-4 text-base font-medium">
          <a data-tab="dashboard" class="tab-btn flex items-center gap-4 rounded-lg px-4 py-3 text-zinc-500 transition-all hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-50" href="#">

            <span> Dashboard </span>
          </a>
          <a data-tab="analytics" class="tab-btn flex items-center gap-4 rounded-lg px-4 py-3 text-zinc-500 transition-all hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-50" href="#">

            <span> Profile </span>
          </a>
          <a data-tab="services" class="tab-btn flex items-center gap-4 rounded-lg px-4 py-3 text-zinc-500 transition-all hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-50" href="#">

            <span> Services </span>
          </a>


        </nav>
      </div>
    </div>
  </div>
  <div class="flex flex-col overflow-auto">

    <div>
        <!-- Content -->
        <div class="content dashboard-content" id="tab1">
            <?php include("./metric.php"); ?>
        </div>
        <div class="content analytics-content hidden" id="tab2">
            <?php include("./edit.php"); ?>
        </div>
        <div class="content services-content hidden" id="tab2">
            <?php include("./services.php"); ?>
        </div>
    </div>


  </div>
</div>
</body>
<script>
$(document).ready(function() {
    $('.tab-btn').click(function(e) {
        e.preventDefault();

        // Identify the tab that was clicked using its data attribute
        let tab = $(this).data('tab');

        // Remove the active tab style from all tabs
        $('.tab-btn').removeClass('bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-50').addClass('text-zinc-500 dark:text-zinc-400');

        // Add the active tab style to the clicked tab
        $(this).addClass('bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-50').removeClass('text-zinc-500 dark:text-zinc-400');

        // Hide all content sections
        $('.content').addClass('hidden');

        // Show the content related to the clicked tab
        $('.' + tab + '-content').removeClass('hidden');
    });
});
</script>
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
$(document).ready(function() {
    $('#serviceForm').submit(function(e) {
        e.preventDefault();
        
        swal({
            title: "Please Confirm",
            text: "Are you ready to add this service?",
            icon: "info",
            buttons: true,
            dangerMode: true,
        })
        .then((willAdd) => {
            if (willAdd) {
                $.ajax({
                    type: 'POST',
                    url: 'api/add_service.php',
                    data: $('#serviceForm').serialize(),
                    success: function(response) {
                        swal("Poof! Your service has been added!", {
                            icon: "success",
                        }).then(function() {
                            location.reload(); // reload the page
                        });
                    },
                    error: function() {
                        swal("Error in request.", {
                            icon: "error",
                        });
                    }
                });
            } else {
                swal("Your service is safe!");
            }
        });
    });

    $('#deleteService').submit(function(e) {
        e.preventDefault();
        
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this service!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'api/delete_service.php',
                    data: $('#deleteService').serialize(),
                    success: function(response) {
                        swal("Poof! Your service has been deleted!", {
                            icon: "success",
                        }).then(function() {
                            location.reload(); // reload the page
                        });
                    },
                    error: function() {
                        swal("Error in request.", {
                            icon: "error",
                        });
                    }
                });
            } else {
                swal("Your service is safe!");
            }
        });
    });
    
    $('#cancelAppointment').submit(function(e) {
        e.preventDefault();
        
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this appointment!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'api/cancel_appointment.php',
                    data: $('#cancelAppointment').serialize(),
                    success: function(response) {
                        swal("Poof! Your appointment has been deleted!", {
                            icon: "success",
                        }).then(function() {
                            location.reload(); // reload the page
                        });
                    },
                    error: function() {
                        swal("Error in request.", {
                            icon: "error",
                        });
                    }
                });
            } else {
                swal("Your service is safe!");
            }
        });
    });
});
</script>
<script>
    function editRow(buttonElement) {
    let row = buttonElement.closest('tr');
    
    row.querySelector('.service-name-text').classList.add('hidden');
    row.querySelector('.service-details-text').classList.add('hidden');
    row.querySelector('.service-price-text').classList.add('hidden');
    
    row.querySelector('.service-name-input').classList.remove('hidden');
    row.querySelector('.service-details-input').classList.remove('hidden');
    row.querySelector('.service-price-input').classList.remove('hidden');
    
    buttonElement.classList.add('hidden');
    row.querySelector('button[onclick^="saveChanges"]').classList.remove('hidden');
}

async function saveChanges(buttonElement, serviceId) {
    let row = buttonElement.closest('tr');
    
    let serviceName = row.querySelector('.service-name-input').value;
    let serviceDetails = row.querySelector('.service-details-input').value;
    let servicePrice = row.querySelector('.service-price-input').value;

    // Make an AJAX request to update the service in the database based on serviceId and the new values
    let data = {
        service_id: serviceId,
        service_name: serviceName,
        service_details: serviceDetails,
        service_price: servicePrice
    };
    console.log(data);  // Handle the result here

    try {
        let response = await fetch('api/edit_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        let result = await response.json();
        console.log(result);  // Handle the result here

    } catch (error) {
        console.error('Error:', error);
    }

    // On successful AJAX response:
    row.querySelector('.service-name-text').textContent = serviceName;
    row.querySelector('.service-details-text').textContent = serviceDetails;
    row.querySelector('.service-price-text').textContent = '$ ' + servicePrice;
    
    row.querySelector('.service-name-text').classList.remove('hidden');
    row.querySelector('.service-details-text').classList.remove('hidden');
    row.querySelector('.service-price-text').classList.remove('hidden');
    
    row.querySelector('.service-name-input').classList.add('hidden');
    row.querySelector('.service-details-input').classList.add('hidden');
    row.querySelector('.service-price-input').classList.add('hidden');
    
    buttonElement.classList.add('hidden');
    row.querySelector('button[onclick^="editRow"]').classList.remove('hidden');
}

</script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .tab-content:not(.active) {
        display: none;
    }
    @font-face {
        font-family: Geist;
        src: url(../Geist-Regular.otf);
    }
    * {
    font-family: Geist;
    }
</style>

</html>
