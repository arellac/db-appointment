<?php
session_start();
include("../../connection.php");
$useremail = "";

if (isset($_SESSION["user_id"])) {
    $userid = $_SESSION["user_id"];
}
else{
    $userid = 0;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $w = floor($diff->d / 7);
    $diff->d -= $w * 7;
    $string = ['y' => 'year','m' => 'month','w' => 'week','d' => 'day','h' => 'hour','i' => 'minute','s' => 'second'];
    foreach ($string as $k => &$v) {
        if ($k == 'w' && $w) {
            $v = $w . ' week' . ($w > 1 ? 's' : '');
        } else if (isset($diff->$k) && $diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (!isset($_GET['s_id'])) {
    exit('Please provide the page ID.');
}

if (isset($_POST['c_id'], $_POST['rating'], $_POST['content'])) {
    $stmt = $database->prepare('INSERT INTO reviews (s_id, c_id, content, rating, date) VALUES (?,?,?,?,NOW())');
    $stmt or exit("Prepare failed: " . $database->error);
    $stmt->bind_param("iiss", $_GET['s_id'], $_POST['c_id'], $_POST['content'], $_POST['rating']);
    $stmt->execute() or exit("Execute failed: " . $stmt->error);
    $stmt->close();
    exit('Your review has been submitted!');
}

$stmt = $database->prepare('SELECT * FROM reviews WHERE s_id = ? ORDER BY date DESC');
$stmt or exit("Prepare failed: " . $database->error);
$stmt->bind_param("i", $_GET['s_id']);
$stmt->execute() or exit("Execute failed: " . $stmt->error);
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $database->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM reviews WHERE s_id = ?');
$stmt or exit("Prepare failed: " . $database->error);
$stmt->bind_param("i", $_GET['s_id']);
$stmt->execute() or exit("Execute failed: " . $stmt->error);
$reviews_info = $stmt->get_result()->fetch_assoc();
$stmt->close();


$clientNames = [];
$allClientIDs = array_column($reviews, 'c_id');
if(!empty($allClientIDs)) {
    $placeholders = implode(',', array_fill(0, count($allClientIDs), '?'));
    $stmt = $database->prepare('SELECT m_id, m_name FROM members WHERE m_id IN (' . $placeholders . ')');
    $stmt->bind_param(str_repeat('i', count($allClientIDs)), ...$allClientIDs);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $clientNames[$row['m_id']] = $row['m_name'];
    }
    $stmt->close();
}


$remainingReviews = 0;

// Get the current date
$currentDate = date('Y-m-d'); 

// SQL to count the number of past appointments with the given c_id and s_id
$sqlAppointments = "SELECT COUNT(*) as appointment_count FROM appointment WHERE c_id=? AND s_id=? AND scheduledate < ?";
$stmtAppointments = $database->prepare($sqlAppointments);
$stmtAppointments->bind_param("iis", $userid, $_GET['s_id'], $currentDate);
$stmtAppointments->execute();
$resultAppointments = $stmtAppointments->get_result();
$rowAppointments = $resultAppointments->fetch_assoc();
$appointmentCount = $rowAppointments['appointment_count'];

// SQL to count the number of reviews written by the user for the stylist
$sqlReviews = "SELECT COUNT(*) as review_count FROM reviews WHERE c_id=? AND s_id=?";
$stmtReviews = $database->prepare($sqlReviews);
$stmtReviews->bind_param("ii", $userid, $_GET['s_id']);
$stmtReviews->execute();
$resultReviews = $stmtReviews->get_result();
$rowReviews = $resultReviews->fetch_assoc();
$reviewCount = $rowReviews['review_count'];

// Determine how many reviews the user can still write
$remainingReviews = $appointmentCount - $reviewCount;
$canWriteReview = $remainingReviews > 0; // If remainingReviews is more than 0, the user can write a review

$stmtAppointments->close();
$stmtReviews->close();

if ($canWriteReview):
    ?>
        <a href="#" class="write_review_btn inline-flex items-center justify-center text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/80 active:bg-primary/100 px-4 py-2 w-full h-12 rounded-md bg-zinc-900 text-zinc-50 shadow-md hover:shadow-lg dark:bg-zinc-50 dark:text-zinc-900">Write Review</a>
    <?php
    else:
    ?>
        <a href="#" class="write_review_btn inline-flex items-center justify-center text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/80 active:bg-primary/100 px-4 py-2 w-full h-12 rounded-md bg-zinc-900 text-zinc-50 shadow-md hover:shadow-lg dark:bg-zinc-50 dark:text-zinc-900" style="pointer-events: none; background-color: grey; cursor: not-allowed;">Write Review</a>    <?php
    endif;

?>
<div class="write_review hidden bg-white p-6 rounded-md shadow-md">
    <form class="flex items-center space-x-4">
        <input name="c_id" type="hidden" value="<?= $userid ?>">
        <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required class="w-24 p-2 border rounded-md focus:outline-none focus:border-blue-500">
        <textarea name="content" placeholder="Write your review here..." required class="flex-2 p-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-blue-700">Submit</button>
    </form>
</div>
<?php foreach ($reviews as $review): ?>
    <article>
        <div class="flex items-center mb-4 space-x-4">
            <div class="space-y-1 font-medium dark:text-white">
                <!-- <p><?=htmlspecialchars($review['c_id'], ENT_QUOTES)?> <time datetime="<?=$review['date']?>" class="block text-sm text-gray-500 dark:text-gray-400"></time></p> -->
            </div>
        </div>
        <div class="flex items-center mb-1">
            <?=str_repeat('<svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"><path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/></svg>', $review['rating'])?>
            <?php
            $c_name = $clientNames[$review['c_id']] ?? "Unknown Client";
        ?>
                <h3 class="ml-2 text-sm font-semibold text-gray-900 dark:text-white"><?=htmlspecialchars($c_name, ENT_QUOTES)?></h3>

        </div>
        <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
            <p>Reviewed on <time datetime="<?=$review['date']?>"><?=date("F j, Y", strtotime($review['date']))?></time></p>
        </footer>
        <p class="mb-3 text-gray-500 dark:text-gray-400"><?=htmlspecialchars($review['content'], ENT_QUOTES)?></p>

    </article>
<?php endforeach ?>



