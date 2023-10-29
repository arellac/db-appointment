<!--
// v0 by Vercel.
// https://v0.dev/t/Xx6DE3L
-->

<html>
    <head>

    </head>
    <body class="">
    
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

        

        if (isset($_GET['id'])) {
            $stylistId = $_GET['id'];
            echo '<script>';
            echo 'const stylistId = ' . json_encode($stylistId) . ';';
            echo '</script>';
            $sqlmain = "SELECT COUNT(*) FROM stylist WHERE s_id = ?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $stylistId); 
            $stmt->execute();
            $stmt->bind_result($stylistCount);
            $stmt->fetch();
            $stmt->close();
        
            // if ($stylistCount <= 0) {
        
            //     header("Location: error.php"); 
            //     exit(); 
            // }
        // } else {
        
        //     header("Location: error.php"); 
        //     exit(); 
        }
        

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



  <section class="w-full py-12 md:py-16 lg:py-312">
  
  <div class="container mx-auto max-w-screen-xl flex items-start gap-8 px-4 md:px-6">
    <!-- LEFT section: image -->
    <!-- adjust width and height as needed -->
    <!-- NaME -->
    
    <div class="space-y-6">
    <div class="breadcrumb">
    <?php
        $stmt = $database->prepare("SELECT s_name,s_id,image_url FROM stylist WHERE s_id = ?");
        $stmt->bind_param("i", $stylistId); // bind the integer parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stylist_name = $row['s_name'];
            echo '<a class="text-gray-500" href="/db-project/client/index.php">Home</a> &gt; <a class="text-gray-500" href="/explore">Explore</a> &gt; ' . $stylist_name .'';
        }
    ?>
    </div>
    <div class="flex items-center"> <!-- Changed to flex -->
    
        <?php
            $stmt = $database->prepare("SELECT s_name,s_id,image_url FROM stylist WHERE s_id = ?");
            $stmt->bind_param("i", $stylistId); // bind the integer parameter
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<img src="' . $row['image_url'] . '" alt="image" class="object-cover rounded-full object-center w-16 h-16">';
            }
        ?>

      <div class="ml-4"> <!-- New container for the texts -->
          <?php 
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h1 class="text-4xl font-bold tracking-tighter">'.$stylist_name .'</h1>';
                echo '<p class="text-lg text-gray-500">@'.$stylist_name .'</p>';
            }
          ?>
      </div>
        </div>
      <!-- sTaRs -->
      <div class="flex space-x-1 ">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
      </div>
      <!-- ADDRESS -->
      <div class="flex items-center text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                    <line x1="12" x2="12" y1="17" y2="22"></line>
                    <path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"></path>
                </svg>
                <span class="ml-2">

                <?php 
                $stmt = $database->prepare("SELECT sln_address FROM stylist WHERE s_id = ?");
                $stmt->bind_param("i", $stylistId); // bind the integer parameter
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['sln_address'];
                }
            ?>

                </span>
      </div>
      <!-- PHONE -->
      <div class="flex items-center mt-2 text-sm text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span class="ml-2">+0 123 456 7890</span>
      </div>
      <!-- Tabs -->
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-example" role="tablist">
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active" id="profile-tab-example" type="button" role="tab" aria-controls="profile-example" aria-selected="true">info</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab-example" type="button" role="tab" aria-controls="dashboard-example" aria-selected="false">Reviews</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab-example" type="button" role="tab" aria-controls="settings-example" aria-selected="false">services</button>
          </li>
          <li role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab-example" type="button" role="tab" aria-controls="contacts-example" aria-selected="false">directions</button>
          </li>
        </ul>
      </div>
      <div id="tabcontentExample" class="w-full max-w-8xl mx-auto">
        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile-example" role="tabpanel" aria-labelledby="profile-tab-example">
          <p class="text-sm text-gray-500 dark:text-gray-400">this is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">info tab's associated content</strong>. blaah blah  blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah </p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard-example" role="tabpanel" aria-labelledby="dashboard-tab-example">
          <p class="text-sm text-gray-500 dark:text-gray-400">this is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. the tab Javascript swaps classes to control the content visibility and styling. </p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings-example" role="tabpanel" aria-labelledby="settings-tab-example">
          <p class="text-sm text-gray-500 dark:text-gray-400">this is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. the tab Javascript swaps classes to control the content visibility and styling. </p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts-example" role="tabpanel" aria-labelledby="contacts-tab-example">
          <p class="text-sm text-gray-500 dark:text-gray-400">this is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. the tab Javascript swaps classes to control the content visibility and styling. </p>
        </div>
      </div>




      
      <div class="flex flex-col space-y-4">
        <!-- added flex column structure with vertical spacing -->
        <div class="p-4 border-t mx-8 mt-2">
          <div class="relative">
            <!-- Calendar Carousel -->
            <div class="carousel-container flex items-center justify-center relative overflow-hidden">
              <!-- html for the month carousel -->
              <div class="month-bg-label uppercase absolute top-0 left-0 right-0 bottom-0 text-7xl text-orange-300 flex items-center justify-center z-[-1] "></div>
              <!-- html for the day carousel -->
              <div class="day-carousel-container flex items-center justify-center overflow-x-auto space-x-2">
                <div class="day-carousel flex overflow-x-hidden  rounded-lg p-2 space-x-2"> <?php
                                    date_default_timezone_set('asia/Kolkata');
                                    $today = strtotime('today');
                                    $fourWeeksLater = strtotime('+4 weeks', $today);
                                    $prevMonth = date('M', $today);

                                    while ($today <= $fourWeeksLater) {

                                        $currentMonth = date('M', $today);

                                        if ($prevMonth != $currentMonth) {
                                            echo '<div class="opacity-75 w-9/12 h-7.5 bg-zinc-800"></div>';
                                            $prevMonth = $currentMonth;
                                        }
                                        
                                        $currentWeek = date('M d, Y', $today);
                                        $currentdate = date('Y-m-d', $today);

                                        echo '
										<button class="inline-flex opacity-75 items-center justify-center text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 px-4 py-2 w-12 h-12 rounded-md border border-zinc-200 text-zinc-900 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 select-day" data-date="' . $currentdate . '">';
                                        echo date('Y-m-d', $today);
                                        echo '</button>';
                                        
                                        $today = strtotime('+1 day', $today);
                                    }
                                    ?> </div>
              </div>
              <button class="prev-button absolute top-1/2 left-0 transform -translate-y-1/2 w-8 h-8 rounded-md bg-gray-500 hover:bg-gray-800 opacity-70 hover:opacity-100 font-semibold text-white transition-all duration-300"> &lt; </button>
              <button class="next-button absolute top-1/2 right-0 transform -translate-y-1/2 w-8 h-8 rounded-md bg-gray-500 hover:bg-gray-800 opacity-70 hover:opacity-100 font-semibold text-white transition-all duration-300"> &gt; </button>
            </div>
            <div class="flex flex-col items-center">

            <div class="hour-carousel flex justify-center overflow-x-auto rounded-lg p-2 space-x-2">
              <!-- the hours will be loaded here by Javascript -->
            </div>

            <div id="servicesModal" class="... your modal classes ... hidden">
            <!-- Services list here -->
            
                <?php 
                $stmt = $database->prepare("SELECT s.service_name, s.service_id
                                            FROM services s
                                            JOIN stylist_services ss ON s.service_id = ss.service_id
                                            WHERE ss.s_id = ?");
                $stmt->bind_param("i", $stylistId);
                $stmt->execute();
                $result = $stmt->get_result();


                echo '<div class="relative flex items-start w-full">';

                while ($row = $result->fetch_assoc()) {
                    echo '<li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ml-px sm:mt-0 sm:first:rounded-tr-none sm:first:rounded-bl-lg sm:last:rounded-bl-none sm:last:rounded-tr-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            <div class="relative flex items-start w-full">
                                <div class="flex items-center h-5">
                                    <input value=' .$row['service_id'].' id="hs-horizontal-list-group-item-radio-1" name="hs-horizontal-list-group-item-radio" type="radio" class="border-gray-200 rounded-full dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" checked>
                                </div>
                                <label for="hs-horizontal-list-group-item-radio-1" class="ml-3 block w-full text-sm text-gray-600 dark:text-gray-500">'
                                    . $row['service_name'] .
                                '</label>
                            </div>
                        </li>';
                }
                ?>
                            
                </div>
                <!-- <button id="selectServiceButton">Book</button> -->
            </div>
            </div>

          </div>
        </div>
      </div>

      

      <button id="selectServiceButton" disabled class="opacity-50 cursor-not-allowed inline-flex items-center justify-center text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/80 active:bg-primary/100 px-4 py-2 w-full h-12 rounded-md bg-zinc-900 text-zinc-50 shadow-md hover:shadow-lg dark:bg-zinc-50 dark:text-zinc-900">
        Book 
      </button>

      
    </div>
  </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const dayCarousel = document.querySelector(".day-carousel");
    const nextButton = document.querySelector(".next-button");
    const prevButton = document.querySelector(".prev-button");
    const monthLabel = document.querySelector('.month-bg-label');

    let currentIndex = 0;
    const numVisibleDays = 14; // Change this to the desired number of visible days

    function updateDayVisibility() {
        const days = dayCarousel.children;
        let mostVisibleDay = days[currentIndex]; // Using currentIndex to find the most visible day
        if (mostVisibleDay) {
            const dateText = mostVisibleDay.dataset.date;
            const dateObj = new Date(dateText);
            const monthName = dateObj.toLocaleString('default', { month: 'long' });
            monthLabel.textContent = monthName;
        }
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
                button.classList.remove("bg-zinc-800", "text-orange-500");
            });

            // Add the 'bg-blue-800' and 'text-white' classes to the clicked day button
            selectedDayButton.classList.add("bg-zinc-800", "text-orange-500");

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
        const timeSlotElement = document.createElement('button');
        timeSlotElement.type = 'button';
        timeSlotElement.classList.add('inline-flex', 'hidden', 'items-center', 'justify-center', 'text-sm', 'font-medium', 'ring-offset-background', 'transition-colors', 'focus-visible:outline-none', 'focus-visible:ring-2', 'focus-visible:ring-ring', 'focus-visible:ring-offset-2', 'disabled:pointer-events-none', 'disabled:opacity-50', 'hover:bg-primary/90', 'px-4', 'py-2', 'w-12', 'h-12', 'rounded-md', 'border', 'border-zinc-200', 'text-zinc-900', 'bg-white', 'shadow-sm', 'dark:border-zinc-800', 'dark:bg-zinc-950', 'dark:text-zinc-50', 'select-hour');
        timeSlotElement.textContent = formattedTime;
        timeSlotElement.disabled = true;
        hourCarousel.appendChild(timeSlotElement);
    } else {
        const timeSlotElement = document.createElement('button');
        timeSlotElement.type = 'button';
        timeSlotElement.classList.add('inline-flex', 'opacity-75', 'items-center', 'justify-center', 'text-sm', 'font-medium', 'ring-offset-background', 'transition-colors', 'focus-visible:outline-none', 'focus-visible:ring-2', 'focus-visible:ring-ring', 'focus-visible:ring-offset-2', 'disabled:pointer-events-none', 'disabled:opacity-50', 'hover:bg-primary/90', 'px-4', 'py-2', 'w-12', 'h-12', 'rounded-md', 'border', 'border-zinc-200', 'text-zinc-900', 'bg-white', 'shadow-sm', 'dark:border-zinc-800', 'dark:bg-zinc-950', 'dark:text-zinc-50', 'select-hour');
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
                    console.log(data);
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
                button.classList.remove("bg-zinc-800", "text-orange-500");
            });

            // Add the 'bg-blue-800' and 'text-white' classes to the clicked hour button
            e.target.classList.add("bg-zinc-800", "text-orange-500");

            const selectedHour = e.target.innerText;
            openServicesModal(selectedDay, selectedHour);
        }
    });
    

    function openServicesModal(selectedDay, selectedHour) {
        const servicesModal = document.getElementById("servicesModal");
        const selectServiceButton = document.getElementById("selectServiceButton");
        selectServiceButton.removeAttribute("disabled");
        selectServiceButton.classList.remove("opacity-50", "cursor-not-allowed");

        // Reset any previous event listeners to prevent accumulation
        selectServiceButton.removeEventListener("click", handleServiceSelection);

        servicesModal.classList.remove("hidden");

        selectServiceButton.addEventListener("click", handleServiceSelection);

        function handleServiceSelection() {
            const selectedServiceElement = document.querySelector('input[name="hs-horizontal-list-group-item-radio"]:checked');

            if (!selectedServiceElement) {
                // Handle case where no service is selected (e.g., show an alert)
                alert("Please select a service!");
                return;
            }

            const selectedService = selectedServiceElement.value;
            openConfirmationModal(selectedDay, selectedHour, selectedService);
            servicesModal.classList.add("hidden");
        }
    }
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
        color: #ff6600; /* Change to any desired color for the active tab text */
        border-bottom-color: #ff6600; /* Change to any desired color for the active tab border */
    }
</style>
</body>


</html>