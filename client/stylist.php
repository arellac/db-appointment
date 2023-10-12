<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" >

<head>
    <meta charset="utf-8">

    <meta name="author" content="themesflat.com">
    <link rel="stylesheet" type="text/css" href="main.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


</head>

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

//import database
include("../connection.php");

$sqlmain= "select * from client where cemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s",$useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["cid"];

if (isset($_GET['id'])) {
    $stylistId = $_GET['id'];
    echo '<script>';
    echo 'const stylistId = ' . json_encode($stylistId) . ';';
    echo '</script>';
    $sqlmain = "SELECT COUNT(*) FROM stylist WHERE sid = ?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("i", $stylistId); 
    $stmt->execute();
    $stmt->bind_result($stylistCount);
    $stmt->fetch();
    $stmt->close();

    if ($stylistCount <= 0) {

        header("Location: error.php"); 
        exit(); 
    }
} else {

    header("Location: error.php"); 
    exit(); 
}
?>
<body>
    
<div class="min-h-screen flex justify-center items-center bg-[#FAF6F4]">
    <div class="max-w-3xl w-full">
        <?php
        $stmt = $database->prepare("SELECT sname,sid,image_url FROM stylist WHERE sid = ?");
        $stmt->bind_param("i", $stylistId); // bind the integer parameter
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stylist_name = $row['sname'];
            echo '<div class=" flex pb-5 items-center justify-center">
            <a class="flex items-center justify-center" href="stylist.php?id=' . $row['sid'] . '">' . '</a>
            <img src="' . $row['image_url'] . '" class="w-56 h-56 object-cover rounded-lg  " alt="" />
            </a>
            </div>';
            
            
            echo '<div class=" flex pb-5 items-center justify-center">
                <span class="text-center">Stylist\'s Name: ' . $stylist_name . '</span>
            </div>';

        } else {
            echo "No stylist found with the provided ID.";
        }

        $stmt = $database->prepare("SELECT s.service_name, s.id
                                    FROM services s
                                    JOIN stylist_services ss ON s.id = ss.service_id
                                    WHERE ss.stylist_id = ?");
        $stmt->bind_param("i", $stylistId);
        $stmt->execute();
    

        echo '<ul class="flex justify-center items-center gap-x-4">';  // Open the ul tag outside the loop

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
                echo '<li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ml-px sm:mt-0 sm:first:rounded-tr-none sm:first:rounded-bl-lg sm:last:rounded-bl-none sm:last:rounded-tr-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        <div class="relative flex items-start w-full">
                            <div class="flex items-center h-5">
                                <input value=' .$row['id'].' id="hs-horizontal-list-group-item-radio-1" name="hs-horizontal-list-group-item-radio" type="radio" class="border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" checked>
                            </div>
                            <label for="hs-horizontal-list-group-item-radio-1" class="ml-3 block w-full text-sm text-gray-600 dark:text-gray-500">'
                                . $row['service_name'] .
                            '</label>
                        </div>
                    </li>';
        }
        echo '</ul>';
        ?>
        <div id="confirmationModal" tabindex="-1" class="hidden fixed inset-0 flex items-center justify-center z-10">
        <div class="fixed inset-0 bg-black opacity-40"></div>

                <div class="modal-content relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-center">
                        <p id="selectedHour">This will be replaced with the selected date.</p>
                        <p id="selectedDay">This will be replaced with the selected date.</p>

                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to select this date?</h3>
                            <button  id="confirmButton"  type="button" class="text-white bg-green-400 hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Yes, I'm sure
                            </button>
                            <button id="cancelButton" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                        </div>
                    </div>
                </div>
        </div>

        
        <div class="p-4 border-t mx-8 mt-2">
            
            <div class="relative">
                <!-- Calendar Carousel -->
                <div class="carousel-container flex items-center justify-center relative overflow-hidden">

                <!-- HTML for the day carousel -->
                <div class="day-carousel-container flex items-center justify-center">
                    <div class="day-carousel flex overflow-x-hidden border rounded-lg p-2 space-x-2">

                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    $today = strtotime('today');
                    $fourWeeksLater = strtotime('+4 weeks', $today);

                    while ($today <= $fourWeeksLater) {
                        $currentWeek = date('M d, Y', $today);
                        $currentDate = date('Y-m-d', $today);
                        $dayOfWeek = date('l', $today); // Get the day of the week

                        // Make each day clickable
                        echo '<div class="flex-shrink-0 w-20">';
                        echo '<div class="text-xs text-gray-500">' . $dayOfWeek . '</div>';
                        echo '<a href="#" class="block bg-gray-100 p-2 rounded-lg cursor-pointer transition hover:bg-gray-200 select-day" data-date="' . $currentDate . '">';
                        echo $currentWeek;
                        echo '</a>';
                        echo '</div>';
                        $today = strtotime('+1 day', $today);
  
                    }
                    ?>
                </div>
                </div>
                <button class="prev-button absolute top-1/2 left-0 transform -translate-y-1/2 w-10 h-10 rounded-md bg-gray-900 hover:shadow-lg font-semibold text-white">
                    &lt;
                </button>
                <button class="next-button absolute top-1/2 right-0 transform -translate-y-1/2 w-10 h-10 rounded-md bg-gray-900 hover:shadow-lg font-semibold text-white">
                    &gt;
                </button>
                </div>
                    <div class="hour-carousel flex overflow-x-auto border rounded-lg p-2 space-x-2">
                        <!-- The hours will be loaded here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dayCarousel = document.querySelector(".day-carousel");
        const nextButton = document.querySelector(".next-button");
        const prevButton = document.querySelector(".prev-button");

        let currentIndex = 0;
        const numVisibleDays = 7; // Change this to the desired number of visible days

        function updateDayVisibility() {
            const days = dayCarousel.children;
            for (let i = 0; i < days.length; i++) {
                if (i >= currentIndex && i < currentIndex + numVisibleDays) {
                    days[i].style.display = "block";
                } else {
                    days[i].style.display = "none";
                }
            }
        }

        nextButton.addEventListener("click", () => {
            if (currentIndex < dayCarousel.children.length - numVisibleDays) {
                currentIndex++;
                updateDayVisibility();
            }
        });

        prevButton.addEventListener("click", () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateDayVisibility();
            }
        });

        // Initialize visibility
        updateDayVisibility();
    });



</script>



<script>
    // JavaScript to handle day selection
    const dayCarousel = document.querySelector(".day-carousel");
    const hourCarousel = document.querySelector(".hour-carousel");

    dayCarousel.addEventListener("click", async (e) => {
        if (e.target.classList.contains("select-day")) {
            const selectedDayButton = e.target.closest(".select-day");

            const allDayButtons = document.querySelectorAll(".select-day");
            allDayButtons.forEach((button) => {
                button.classList.remove("bg-blue-800", "text-white");
            });

            // Add the 'bg-blue-800' and 'text-white' classes to the clicked day button
            selectedDayButton.classList.add("bg-blue-800", "text-white");

            // Set the selected day variable
            selectedDay = selectedDayButton.textContent;
            const selectedDate = e.target.dataset.date;
            loadHours(selectedDate);
        }
    });

    async function loadHours(selectedDate) {
    // Clear the existing hours
    hourCarousel.innerHTML = '';

    const startTime = new Date(selectedDate + 'T09:00:00');
    const endTime = new Date(selectedDate + 'T17:00:00');
    const timeSlotInterval = 60 * 60 * 1000; // 1 hour in milliseconds

    while (startTime < endTime) {
        const timeSlot = new Date(startTime);
        const formattedTime = timeSlot.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });


        if (await isAppointmentBooked(stylistId, selectedDate, formattedTime)) {
            const timeSlotElement = document.createElement('button'); // Change this to a button element
            timeSlotElement.type = 'button'; // Set the button type
            timeSlotElement.classList.add('block', 'bg-gray-300', 'p-2', 'rounded-lg', 'cursor-not-allowed', 'select-hour'); // Add 'select-hour' class
            timeSlotElement.textContent = formattedTime;
            timeSlotElement.disabled = true;
            hourCarousel.appendChild(timeSlotElement);
        } else {
            // Create a clickable element for each time slot
            const timeSlotElement = document.createElement('a');
            timeSlotElement.href = '#'; // Add the link behavior you need
            timeSlotElement.classList.add('block', 'bg-gray-100', 'p-2', 'rounded-lg', 'cursor-pointer', 'transition', 'hover:bg-gray-200', 'select-hour'); // Add 'select-hour' class
            timeSlotElement.textContent = formattedTime;
            hourCarousel.appendChild(timeSlotElement);
        }

        
        // Increment the time slot by 1 hour
        startTime.setTime(startTime.getTime() + timeSlotInterval);
    }

}
    async function isAppointmentBooked(stylistId, selectedDate, selectedTime) {
            // Make an API request to check if the appointment is booked
            try {
                const response = await fetch('check-appointment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        stylistId: stylistId,
                        date: selectedDate,
                        time: selectedTime,
                    }),
                });

                if (response.ok) {
                    const data = await response.json();
                    return data.isBooked; // Assuming the response includes a boolean indicating if the slot is booked
                } else {
                    throw new Error('Failed to fetch appointment data');
                }
            } catch (error) {
                console.error('Error checking appointment:', error);
                return false; // Assume the slot is not booked in case of an error
            }
        }
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Add a click event listener to each hour element
    hourCarousel.addEventListener("click", (e) => {
        if (e.target.classList.contains("select-hour")) {
            const allHourButtons = document.querySelectorAll(".select-hour");
            allHourButtons.forEach((button) => {
                button.classList.remove("bg-blue-800", "text-white");
            });

            // Add the 'bg-blue-800' and 'text-white' classes to the clicked hour button
            e.target.classList.add("bg-blue-800", "text-white");

            const selectedHour = e.target.innerText;
            openConfirmationModal(selectedDay, selectedHour);
        }
    });

    // Function to open the confirmation modal
    function openConfirmationModal(selectedDay, selectedHour) {
        const modal = document.getElementById("confirmationModal");
        const confirmButton = document.getElementById("confirmButton");
        const cancelButton = document.getElementById("cancelButton");
        const selectedDayElement = document.getElementById("selectedDay");
        const selectedHourElement = document.getElementById("selectedHour");
        const selectedService = document.querySelector('input[name="hs-horizontal-list-group-item-radio"]:checked').value;

        // Set the selected day and hour in the modal
        selectedDayElement.textContent = selectedDay;
        selectedHourElement.textContent = selectedHour;

        // Show the modal
        modal.classList.remove("hidden");

        // Handle confirmation button click
        function onConfirmButtonClick() {
            const data = {
                selectedDay: selectedDay,
                selectedHour: selectedHour,
                stylistId: stylistId,
                serviceId: selectedService // Include the selected service here
            };

            fetch('book.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data); // Log the server response
                // Close the modal
                modal.classList.add("hidden");
                
                // Remove the event listener to prevent duplicates
                confirmButton.removeEventListener("click", onConfirmButtonClick);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        confirmButton.addEventListener("click", onConfirmButtonClick);

        cancelButton.addEventListener("click", () => {
            modal.classList.add("hidden");
            // Remove the event listener to prevent duplicates
            confirmButton.removeEventListener("click", onConfirmButtonClick);
        });
    }

    function closeModal() {
        const modal = document.getElementById("confirmationModal");
        modal.classList.add("hidden");
    }
});

</script>
<script src="https://cdn.tailwindcss.com"></script>

</body>


</html>