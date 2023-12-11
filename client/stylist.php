<?php

    session_start();
    include("../connection.php");

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
            // header("location: ../login.php");
        }else{
            $userid=$_SESSION["user_id"];
            // $sqlmain= "select * from client where c-id=?";
            // $stmt = $database->prepare($sqlmain);
            // $stmt->bind_param("i",$useremail);
            // $stmt->execute();
            // $userrow = $stmt->get_result();
            // $userfetch=$userrow->fetch_assoc();
            // $userid= $userfetch["c_id"];
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
        
        if ($stylistCount <= 0) {
            header("Location: error.php"); 
            exit(); 
        }
        
        $query = "SELECT s.service_id AS service_id, s.service_name, s.service_price, s.service_details
            FROM services s
            WHERE s.s_id = ?";
        $stmt = $database->prepare($query);
        $stmt->bind_param("i", $stylistId);
        $stmt->execute();
        $result = $stmt->get_result();

        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }

    } else {
        header("Location: error.php"); 
        exit(); 
    }
    
    $query = "SELECT sln_info FROM stylist WHERE s_id = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param("i", $stylistId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $sln_info = $result->fetch_assoc();

    $sql = "SELECT card_number FROM client WHERE c_id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
?>

<html>
    <head>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="">

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
                            
                            <div id="paymentModal" class="hidden">
                                <h3 class="mt-5 text-lg font-normal text-gray-500 dark:text-gray-400">Choose your payment method</h3>
                                <div>
                                    <input type="radio" id="payInStore" name="paymentMethod" value="inStore" checked>
                                    <label for="payInStore">Pay in Store</label><br>
                                    <input type="radio" id="payOnline" name="paymentMethod" value="online" <?php echo !empty($client['card_number']) ? '' : 'disabled'; ?>>
                                    <label for="payOnline"><?php echo !empty($client['card_number']) ? 'Pay Online' : 'Set Card Details in Profile'; ?></label><br>
                                </div>
                                <button id="paymentConfirmButton" type="button" class="mt-5 text-white bg-green-400 hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                    Confirm Payment Method
                                </button>
                            </div>

                    </div>
                </div>
            </div>

    </div>



  <section class="w-full py-12 md:py-16 lg:py-312">
  
  <div class="container mx-auto max-w-screen-xl flex items-start gap-8 px-4 md:px-6">

    
    <div class="space-y-6">
    <div class="breadcrumb">
    <?php
        $stmt = $database->prepare("SELECT stylist.s_id, stylist.image_url, stylist.sln_name, members.m_name 
        FROM stylist 
        JOIN members ON stylist.s_id = members.m_id 
        WHERE stylist.s_id = ?");
        $stmt->bind_param("i", $stylistId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stylist_name = $row['m_name'];
            $sln_name = $row['sln_name'];

            echo '<a class="text-gray-500" href="/db-project/index.php">Home</a>  &gt; ' . $stylist_name .'';
        }
    ?>
    </div>
    <div class="flex items-center"> 
    
        <?php
            $stmt = $database->prepare("SELECT members.m_name, stylist.image_url
            FROM stylist 
            JOIN members ON stylist.s_id = members.m_id 
            WHERE stylist.s_id = ?");

            $stmt->bind_param("i", $stylistId); 
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $type = 'image/png'; 
                $base64 = base64_encode($row['image_url']);
                $dataURL = "data:$type;base64,$base64";

                echo '<img src="' . $dataURL  . '" alt="image" class="object-cover rounded-full object-center w-16 h-16">';
            }
        ?>

      <div class="ml-4"> <!-- New container for the texts -->
          <?php 
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h1 class="text-4xl font-bold tracking-tighter">'.$stylist_name .'</h1>';
                echo '<p class="text-lg text-gray-500">@'.$sln_name .'</p>';
            }
          ?>
      </div>
        </div>
    <!-- sTaRs -->
      <?php
        // Assuming you have already established a PDO connection as $pdo

        // Prepare the SQL statement
        $stmt = $database->prepare("SELECT AVG(rating) as average_rating FROM reviews WHERE s_id = ?");

        // Bind the stylist ID parameter
        $stmt->bind_param("i", $stylistId); 
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $averageRating = round($row['average_rating'], 1);  // Rounding off to 1 decimal place

        $fullStars = floor($averageRating);
        $halfStar = 0;
        $emptyStars = 5 - $fullStars;
        
        if (($averageRating - $fullStars) >= 0.5) {
            $halfStar = 1;
            $emptyStars -= 1;  // since we're adding a half star, we should reduce one empty star
        }
        ?>

    <div class="flex space-x-1 ">
        <?php for ($i = 0; $i < $fullStars; $i++): ?>
            <!-- Full Star -->
<svg height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.853 512.853" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g transform="translate(0 1)"> <g> <path style="fill:#000000;" d="M358.827,380.44L275.2,278.893l-36.693,17.92c2.56,0.853,5.973,2.56,7.68,5.12l86.187,100.693 C337.493,393.24,348.587,385.56,358.827,380.44"></path> <path style="fill:#000000;" d="M116.48,511.853c-37.547,0-68.267-30.72-68.267-68.267s30.72-68.267,68.267-68.267 s68.267,30.72,68.267,68.267S154.027,511.853,116.48,511.853z M116.48,392.387c-28.16,0-51.2,23.04-51.2,51.2 s23.04,51.2,51.2,51.2s51.2-23.04,51.2-51.2S144.64,392.387,116.48,392.387z"></path> <path style="fill:#000000;" d="M483.413,503.32c-33.28,0-59.733-26.453-59.733-59.733c0-5.12,3.413-8.533,8.533-8.533 c5.12,0,8.533,3.413,8.533,8.533c0,23.893,18.773,42.667,42.667,42.667c5.12,0,8.533,3.413,8.533,8.533 C491.947,499.907,488.533,503.32,483.413,503.32z"></path> <path style="fill:#000000;" d="M372.48,511.853c-37.547,0-68.267-30.72-68.267-68.267s30.72-68.267,68.267-68.267 s68.267,30.72,68.267,68.267S410.027,511.853,372.48,511.853z M372.48,392.387c-28.16,0-51.2,23.04-51.2,51.2 s23.04,51.2,51.2,51.2c28.16,0,51.2-23.04,51.2-51.2S400.64,392.387,372.48,392.387z"></path> <path style="fill:#000000;" d="M342.613,387.267l-84.48-101.547c-5.12-6.827-5.973-15.36-1.707-23.04 c4.267-7.68,3.413-16.213-1.707-23.04L90.027,44.227L32,10.093c0,0-0.853,0-0.853,0.853c7.68,29.867,22.187,58.027,40.107,83.627 l244.053,312.32C322.133,397.507,331.52,391.533,342.613,387.267"></path> </g> <path style="fill:#000000;" d="M96,94.573c-14.507-20.48-26.453-42.667-34.987-66.56l-29.867-17.92c0,0-0.853,0-0.853,0.853 C38.827,40.813,52.48,68.973,70.4,94.573l244.053,312.32c4.267-5.12,0.853-1.707,6.827-5.12L96,94.573z"></path> <path style="fill:#000000;" d="M241.067,229.4c5.12,6.827,5.973,15.36,1.707,23.04c-2.56,4.267-2.56,14.507-1.707,14.507 L383.573,84.333C402.347,58.733,416,47.64,423.68,16.92c0,0,0-0.853-0.853-0.853L364.8,49.347L220.587,221.72L241.067,229.4z"></path> <path style="fill:#000000;" d="M435.627,10.093l-12.8,7.68c-8.533,29.867-21.333,41.813-40.107,66.56 c0,0-87.893,112.64-125.44,160.427c2.56,5.973,1.707,11.947-1.707,17.92c-2.56,4.267-2.56,14.507-2.56,14.507L395.52,94.573 C414.293,68.973,427.947,40.813,435.627,10.093C436.48,10.093,435.627,10.093,435.627,10.093"></path> <g> <path style="fill:#000000;" d="M448.427,23.747l-12.8,7.68c-8.533,29.867-21.333,41.813-40.107,66.56 c0,0-87.893,112.64-125.44,160.427c2.56,5.973-13.653,11.947-17.067,17.92c-2.56,4.267,12.8,14.507,13.653,14.507l142.507-182.613 C427.093,82.627,441.6,53.613,448.427,23.747C449.28,23.747,449.28,22.893,448.427,23.747"></path> <path style="fill:#000000;" d="M153.173,406.893l81.067-104.107l-19.627-25.6c-0.853,3.413-1.707,5.973-3.413,8.533 l-84.48,101.547C136.96,391.533,146.347,397.507,153.173,406.893"></path> </g> <path d="M255.573,288.28l-5.973-4.267c-7.68-5.12-1.707-23.04,0-25.6c2.56-4.267,1.707-9.387-0.853-13.653L224,214.893L372.48,37.4 l64.853-37.547l9.387,6.827l-1.707,5.973c-8.533,31.573-22.187,60.587-41.813,87.04 C260.693,282.307,260.693,282.307,260.693,283.16L255.573,288.28z M245.333,215.747l16.213,18.773c2.56,3.413,5.12,7.68,5.973,12.8 c38.4-50.347,122.027-157.013,122.88-157.867c13.653-18.773,24.747-39.253,32.427-61.44L383.573,50.2L245.333,215.747z"></path> <path d="M153.173,420.547l-6.827-8.533c-5.973-7.68-13.653-13.653-23.04-16.213l-11.947-4.267L203.52,280.6 c0.853-0.853,1.707-2.56,1.707-5.12l3.413-17.92l35.84,45.227L153.173,420.547z M139.52,384.707c4.267,2.56,8.533,5.973,12.8,9.387 l70.827-91.307l-7.68-10.24L139.52,384.707z"></path> <path d="M229.973,260.12c-2.56,0-4.267-0.853-5.973-2.56l-12.8-12.8c-3.413-3.413-3.413-8.533,0-11.947s8.533-3.413,11.947,0 l12.8,12.8c3.413,3.413,3.413,8.533,0,11.947C234.24,259.267,231.68,260.12,229.973,260.12z"></path> <path d="M106.24,511.853c-37.547,0-68.267-30.72-68.267-68.267s30.72-68.267,68.267-68.267s68.267,30.72,68.267,68.267 S143.787,511.853,106.24,511.853z M106.24,392.387c-28.16,0-51.2,23.04-51.2,51.2s23.04,51.2,51.2,51.2s51.2-23.04,51.2-51.2 S134.4,392.387,106.24,392.387z"></path> <path d="M362.24,511.853c-37.547,0-68.267-30.72-68.267-68.267s30.72-68.267,68.267-68.267s68.267,30.72,68.267,68.267 S399.787,511.853,362.24,511.853z M362.24,392.387c-28.16,0-51.2,23.04-51.2,51.2s23.04,51.2,51.2,51.2s51.2-23.04,51.2-51.2 S390.4,392.387,362.24,392.387z"></path> <path d="M315.307,420.547L64.427,99.693c-18.773-26.453-33.28-55.467-41.813-87.04L20.907,6.68L30.293-1l5.12,2.56l59.733,34.133 l166.4,198.827c7.68,9.387,8.533,22.187,2.56,32.427c-2.56,4.267-1.707,9.387,0.853,13.653l92.16,110.933l-11.947,4.267 c-9.387,3.413-17.067,8.533-23.04,16.213L315.307,420.547z M45.653,28.013C53.333,50.2,64.427,70.68,78.08,89.453L316.16,393.24 c4.267-3.413,8.533-6.827,12.8-9.387l-77.653-93.013c-7.68-9.387-8.533-22.187-2.56-32.427c2.56-4.267,1.707-9.387-0.853-13.653 L84.053,50.2L45.653,28.013z"></path> <path d="M473.173,503.32c-33.28,0-59.733-26.453-59.733-59.733c0-5.12,3.413-8.533,8.533-8.533s8.533,3.413,8.533,8.533 c0,23.893,18.773,42.667,42.667,42.667c5.12,0,8.533,3.413,8.533,8.533C481.707,499.907,477.44,503.32,473.173,503.32z"></path> </g> </g></svg>

        <?php endfor; ?>

        <?php if ($halfStar): ?>
<svg fill="#000000" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.991 511.991" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M477.538,486.391c-23.526,0-42.667-19.14-42.667-42.667c0-37.641-30.626-68.267-68.267-68.267 c-5.752,0-11.298,0.794-16.64,2.133l-80.802-97.374c-0.384-0.486-0.606-1.05-0.904-1.57 c7.859-10.035,36.275-46.37,140.006-179.072c19.285-26.146,33.314-55.313,41.702-86.707l1.331-5.905L441.818,0l-64.529,37.308 L238.682,202.069L100.066,37.308L40.418,2.833l-5.359-2.782L25.92,7.39l1.468,5.487c8.388,31.386,22.417,60.553,41.847,86.895 l139.878,178.884c-0.256,0.512-0.503,1.041-0.794,1.408l-80.956,97.562c-5.376-1.365-10.965-2.167-16.759-2.167 c-37.641,0-68.267,30.626-68.267,68.267c0,37.641,30.626,68.267,68.267,68.267c37.641,0,68.267-30.626,68.267-68.267 c0-13.568-4.028-26.197-10.88-36.838l70.69-90.411l70.605,90.3c-6.895,10.667-10.948,23.33-10.948,36.949 c0,37.641,30.626,68.267,68.267,68.267c26.197,0,48.964-14.848,60.399-36.557c10.59,16.802,29.252,28.023,50.534,28.023 c4.71,0,8.533-3.823,8.533-8.533S482.249,486.391,477.538,486.391z M110.605,494.925c-28.237,0-51.2-22.963-51.2-51.2 c0-28.237,22.963-51.2,51.2-51.2c5.197,0,10.206,0.794,14.933,2.236l1.903,0.666c0.034,0.009,0.06,0.026,0.094,0.034 c4.506,1.579,8.73,3.78,12.587,6.502c0.145,0.102,0.282,0.213,0.418,0.316c1.715,1.229,3.337,2.577,4.89,4.019 c0.179,0.171,0.375,0.333,0.555,0.503c1.638,1.57,3.183,3.243,4.608,5.026c6.997,8.764,11.213,19.84,11.213,31.898 C161.805,471.962,138.842,494.925,110.605,494.925z M156.787,393.506c-0.307-0.273-0.649-0.503-0.947-0.777 c-1.365-1.203-2.765-2.347-4.224-3.448c-0.512-0.392-1.024-0.785-1.553-1.16c-1.826-1.306-3.721-2.517-5.675-3.644 c-0.12-0.068-0.23-0.154-0.35-0.222l76.015-91.605l7.791,9.975L156.787,393.506z M240.371,257.758 c-1.664,1.664-3.849,2.5-6.033,2.5c-2.185,0-4.369-0.836-6.033-2.5l-12.8-12.8c-3.336-3.337-3.336-8.73,0-12.066 c3.337-3.337,8.73-3.337,12.066,0l12.8,12.8C243.708,249.028,243.708,254.421,240.371,257.758z M265.741,234.231l-0.128-0.145 c-0.009-0.009-0.009-0.017-0.009-0.017l-6.315-7.501l-9.463-11.255L388.425,50.586l38.912-22.494 c-7.885,21.897-18.85,42.436-32.657,61.167c-1.092,1.391-84.369,107.913-123.11,157.466c-0.034-0.154-0.111-0.29-0.145-0.435 c-0.393-1.818-0.99-3.593-1.732-5.333c-0.239-0.555-0.521-1.084-0.794-1.621c-0.828-1.647-1.783-3.234-2.935-4.745 C265.869,234.479,265.826,234.342,265.741,234.231z M366.605,494.925c-28.237,0-51.2-22.963-51.2-51.2 c0-12.117,4.25-23.245,11.307-32.017c1.399-1.741,2.91-3.371,4.506-4.898c0.247-0.239,0.512-0.461,0.759-0.691 c1.502-1.374,3.063-2.671,4.71-3.857c0.171-0.128,0.333-0.256,0.503-0.375c1.903-1.34,3.891-2.551,5.956-3.618l0.017-0.009 c2.099-1.084,4.284-2.022,6.536-2.807c0.12-0.043,0.239-0.085,0.358-0.128l1.613-0.563c4.727-1.442,9.737-2.236,14.933-2.236 c28.237,0,51.2,22.963,51.2,51.2C417.805,471.962,394.842,494.925,366.605,494.925z"></path> </g> </g> </g></svg>

        </svg>

        <?php endif; ?>

        <?php for ($i = 0; $i < $emptyStars; $i++): ?>
            <!-- Empty Star -->
<svg fill="#000000" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.853 512.853" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g transform="translate(1 1)"> <g> <g> <path d="M227.267,232.813c-3.413-3.413-8.533-3.413-11.947,0s-3.413,8.533,0,11.947l12.8,12.8c1.707,1.707,3.413,2.56,5.973,2.56 c1.707,0,4.267-0.853,5.973-2.56c3.413-3.413,3.413-8.533,0-11.947L227.267,232.813z"></path> <path d="M477.293,486.253c-23.893,0-42.667-18.773-42.667-42.667c0-37.547-30.72-68.267-68.267-68.267 c-5.803,0-11.442,0.738-16.83,2.117L269.08,280.6c-0.403-0.672-0.758-1.367-1.07-2.074 c8.137-10.743,36.991-47.718,139.31-178.833c19.627-26.453,33.28-55.467,41.813-87.04l1.707-5.973l-9.387-6.827L376.6,37.4 L238.678,202.272L99.267,35.693L39.533,1.56L34.413-1l-9.387,7.68l1.707,5.973c8.533,31.573,23.04,60.587,41.813,87.04 l140.155,179.246c-0.305,0.72-0.681,1.28-1.062,1.661l-80.45,96.837c-5.389-1.379-11.027-2.117-16.83-2.117 c-37.547,0-68.267,30.72-68.267,68.267c0,37.547,30.72,68.267,68.267,68.267c37.547,0,68.267-30.72,68.267-68.267 c0-13.47-3.97-26.049-10.774-36.659l70.166-90.495l70.808,90.557c-6.779,10.596-10.734,23.153-10.734,36.596 c0,37.547,30.72,68.267,68.267,68.267c26.041,0,48.787-14.783,60.289-36.366c10.51,16.786,29.147,27.833,50.644,27.833 c4.267,0,8.533-3.413,8.533-8.533S482.413,486.253,477.293,486.253z M387.693,50.2l39.253-22.187 c-7.68,22.187-18.773,42.667-32.427,61.44c-0.853,0.853-84.48,107.52-122.88,157.867c-0.001-0.007-0.003-0.014-0.005-0.021 c-0.092-0.488-0.19-0.976-0.308-1.46c-0.102-0.432-0.22-0.855-0.345-1.274c-0.062-0.211-0.121-0.423-0.189-0.634 c-0.099-0.302-0.207-0.597-0.317-0.893c-1.08-3.017-2.67-5.903-4.81-8.518l-15.963-19.073L387.693,50.2z M49.773,28.013 l38.4,22.187l163.84,194.56c2.56,4.267,3.413,9.387,0.853,13.653c-5.973,10.24-5.12,23.04,2.56,32.427l77.653,93.013 c-1.38,0.828-2.761,1.752-4.141,2.73c-2.637,1.741-5.145,3.661-7.512,5.74c-0.382,0.305-0.765,0.611-1.147,0.917L82.2,89.453 C68.547,70.68,57.453,50.2,49.773,28.013z M110.36,494.787c-28.16,0-51.2-23.04-51.2-51.2c0-28.16,23.04-51.2,51.2-51.2 c3.673,0,7.256,0.401,10.715,1.145l6.351,2.268c2.773,0.756,5.393,1.817,7.868,3.125c3.857,2.168,7.405,4.82,10.567,7.874 c1.633,1.625,3.169,3.369,4.605,5.214l1.665,2.081c5.926,8.353,9.429,18.531,9.429,29.493 C161.56,471.747,138.52,494.787,110.36,494.787z M227.267,302.787l-70.49,90.873c-3.87-3.602-8.156-6.756-12.774-9.393 l75.458-91.567l5.887,7.528L227.267,302.787z M366.36,494.787c-28.16,0-51.2-23.04-51.2-51.2c0-10.962,3.503-21.14,9.429-29.493 l1.664-2.08c5.973-7.68,13.653-12.8,23.04-16.213l6.351-2.268c3.459-0.744,7.042-1.145,10.715-1.145 c28.16,0,51.2,23.04,51.2,51.2C417.56,471.747,394.52,494.787,366.36,494.787z"></path> </g> </g> </g> </g></svg>

        <?php endfor; ?>
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
                <span class="ml-2">

                <?php 
                $stmt = $database->prepare("SELECT m_number FROM members WHERE m_id = ?");
                $stmt->bind_param("i", $stylistId); // bind the integer parameter
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['m_number'];
                }
            ?>

                </span>
      </div>
      <!-- Tabs -->
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" id="tabs-example" role="tablist">
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active" id="profile-tab-example" type="button" role="tab" aria-controls="profile-example" aria-selected="true">info</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab-example" type="button" role="tab" aria-controls="dashboard-example" aria-selected="false">reviews</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab-example" type="button" role="tab" aria-controls="settings-example" aria-selected="false">services</button>
          </li>

        </ul>
      </div>

      <div id="tabcontentExample" class="w-full max-w-8xl mx-auto flex">
      <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 w-full" id="profile-example" role="tabpanel" aria-labelledby="profile-tab-example">
    <?php
        $sln_info = nl2br(htmlspecialchars($sln_info['sln_info']));
        $sln_info = preg_replace('#(http|https|ftp|ftps)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(/\S*)?#', '<a href="$0" target="_blank">$0</a>', $sln_info);
        echo "<p class='text-sm text-gray-500 dark:text-gray-400'>" . $sln_info . "</p>";
    ?>        
    <p class="text-sm text-gray-500 dark:text-gray-400 opacity-0">this is some placeholder content. blaah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah </p>
</div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard-example" role="tabpanel" aria-labelledby="dashboard-tab-example">

        <p class="text-sm text-gray-500 dark:text-gray-400 opacity-0">this is some placeholder content. blaah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah </p>

        <div class="reviews"></div>
        <script>
            const reviews_page_id = stylistId;
            fetch("./api/fetch_reviews.php?s_id=" + reviews_page_id).then(response => response.text()).then(data => {
                document.querySelector(".reviews").innerHTML = data;

                let writeReviewBtn = document.querySelector(".reviews .write_review_btn");
                let writeReviewForm = document.querySelector(".reviews .write_review form");
                let writeReviewDiv = document.querySelector(".reviews .write_review");

                writeReviewBtn.onclick = event => {
                    event.preventDefault();
                    writeReviewDiv.classList.remove('hidden'); // Remove the hidden class to display the form
                    document.querySelector(".reviews .write_review input[name='rating']").focus();  // focus on rating now
                };

                writeReviewForm.onsubmit = event => {
                    event.preventDefault();
                    fetch("./api/fetch_reviews.php?s_id=" + reviews_page_id, {
                        method: 'POST',
                        body: new FormData(writeReviewForm)
                    }).then(response => response.text()).then(data => {
                        document.querySelector(".reviews .write_review").innerHTML = data;
                    });
                };
            });
        </script>

        </div>

<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings-example" role="tabpanel" aria-labelledby="settings-tab-example">
            <?php
            if (count($services) == 0) {
                
                echo "<p class='text-sm text-gray-500 dark:text-gray-400'>No services found for this stylist.</p>";
                echo "<p class='text-sm text-gray-500 dark:text-gray-400 opacity-0'>this is some placeholder content. blaah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah </p>";
            } else {
                echo "<p class='text-sm text-gray-500 dark:text-gray-400 opacity-0'>this is some placeholder content. blaah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah blaah blah </p>";
                echo "<table class='min-w-full bg-white'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th class='px-4 py-2 border'>Service Name</th>";
                echo "<th class='px-4 py-2 border'>Price</th>";
                echo "<th class='px-4 py-2 border'>Details</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($services as $service) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($service['service_name']) . "</td>";
                    echo "<td class='px-4 py-2 border'>$" . number_format($service['service_price'], 2) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($service['service_details']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            }
            ?>
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
                                    date_default_timezone_set('America/Chicago');
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
                $stmt = $database->prepare("SELECT s.service_name, s.service_id, s.service_price
                                            FROM services s
                                            WHERE s.s_id = ?");
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
                                    . $row['service_name'] . " : $" . $row['service_price'] .
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
    const numVisibleDays = 14; 

    function updateDayVisibility() {
        const days = dayCarousel.children;
        let mostVisibleDay = days[currentIndex]; 
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
    function openConfirmationModal(selectedDay, selectedHour, selectedService) {
        const modal = document.getElementById("confirmationModal");
        const confirmButton = document.getElementById("confirmButton");
        const cancelButton = document.getElementById("cancelButton");
        const selectedDayElement = document.getElementById("selectedDay");
        const selectedHourElement = document.getElementById("selectedHour");

        // Set the selected day and hour in the modal
        selectedDayElement.textContent = selectedDay;
        selectedHourElement.textContent = selectedHour;

        // Show the modal
        modal.classList.remove("hidden");
        openPaymentModal();

        function openPaymentModal() {
            const paymentModal = document.getElementById("paymentModal");
            const paymentConfirmButton = document.getElementById("paymentConfirmButton");

            // Show the payment modal
            paymentModal.classList.remove("hidden");

            // Handle confirmation button click
            paymentConfirmButton.addEventListener("click", () => {
                const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

                // Hide the payment modal
                paymentModal.classList.add("hidden");

                // Handle confirmation button click
                function onConfirmButtonClick() {
                    const data = {
                        selectedDay: selectedDay,
                        selectedHour: selectedHour,
                        stylistId: stylistId,
                        serviceId: selectedService,
                        payMethod: selectedPaymentMethod
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

                        // Show SweetAlert confirmation
                        Swal.fire({
                            title: 'Success!',
                            text: 'Booking Confirmed',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Redirect to home page after clicking OK on the alert
                            if (result.isConfirmed) {
                                window.location.href = '/db-project/index.php';
                            }
                        });

                        // Remove the event listener to prevent duplicates
                        confirmButton.removeEventListener("click", onConfirmButtonClick);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        modal.classList.add("hidden");

                        Swal.fire({
                            title: 'Error!',
                            text: 'Booking Failed, You Must Be Signed In To Book An Appointment.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Redirect to home page after clicking OK on the alert
                            if (result.isConfirmed) {
                                window.location.href = '/db-project/index.php';
                            }
                        });
                        confirmButton.removeEventListener("click", onConfirmButtonClick);
                    });
                }

                confirmButton.addEventListener("click", onConfirmButtonClick);
            });
        }

        cancelButton.addEventListener("click", () => {
            modal.classList.add("hidden");
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
        color: #ff6600; 
        border-bottom-color: #ff6600;
    }
</style>
</body>


</html>