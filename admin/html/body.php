<h3 class="text-gray-700 text-3xl font-medium">DASHBOARD</h3>
    <?php
        include("../connection.php");
        function generateRandomToken($length = 32) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
    
            for ($i = 0; $i < $length; $i++) {
                $token .= $characters[rand(0, strlen($characters) - 1)];
            }
    
            return $token;
        }
        if ($_POST) {
            $user_id = $_POST['user_id']; 
            $expiration_date = $_POST['expiration_date'];
    
            // Generate a random token
            $token = generateRandomToken();
    
            $base_url = "https://localhost/scheduler/register?token=";
            $one_time_link = $token;
    
            try {

    
                $database->query("insert into one_time_links (user_id, link, expiration_date) values('$user_id', '$one_time_link', '$expiration_date');");
    
    

    
            } catch (PDOException $e) {
                // Handle database errors
                echo "Database Error: " . $e->getMessage();
            }
        }
    ?>

    <div class="mt-4">
        <h4 class="text-gray-600">One Time Links</h4>
        
        <div class="mt-6">
            <div class="bg-white shadow rounded-md overflow-auto my-6">
                <table class="text-left w-full border-collapse">
                    <thead class="border-b">
                        <tr>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Date</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">StylistID</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Client</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = $database->query("SELECT a.appodate, a.scheduletime, a.sid, a.pid, c.cname, s.sname
                            FROM appointment AS a
                            INNER JOIN client AS c ON a.pid = c.cid
                            INNER JOIN stylist AS s ON a.sid = s.sid");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr class="hover:bg-gray-200">';
                                    echo '<td class="py-4 px-6 border-b text-gray-700 text-lg">' . $row['appodate'] . ' ' . $row['scheduletime'] . '</td>';
                                    echo '<td class="py-4 px-6 border-b text-gray-500">' . $row['sname'] . '</td>';
                                    echo '<td class="py-4 px-6 border-b text-gray-500">' . $row['cname'] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>

                    </tbody>
                </table>
                <table class="text-left w-full border-collapse">
                    <thead class="border-b">
                        <tr>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Link</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Expiration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = $database->query("select * from one_time_links");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr class="hover:bg-gray-200">';
                                echo '<td class="py-4 px-6 border-b text-gray-700 text-lg">' . $row['link'] . '</td>';
                                echo '<td class="py-4 px-6 border-b text-gray-500">' . $row['expiration_date'] . '</td>';
                                echo '</tr>';


                            }
                        }

                        ?>

                    </tbody>

                </table>



            </div>
        </div>
    </div>

    <div class="mt-4">

        <div class="mt-4">
            <div class="max-w-sm w-full bg-white shadow-md rounded-md overflow-hidden border">
                <form action="" method="POST" >
                    <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                        <h3 class="text-sm">Create One Time Link</h3>

                    </div>
                    
                    <div class="px-5  bg-gray-200 text-gray-700 border-b">
                        <label class="text-xs">Name</label>

                        <div class="mt-2 relative rounded-md shadow-sm">


                            <input type="text" class="form-input w-full px-12 py-2 appearance-none rounded-md focus:border-indigo-600" name="user_id" required>

                        </div>
                    </div>

                    <div class="px-5 pb-5 bg-gray-200 text-gray-700 border-b">
                        <label class="text-xs">Expiration</label>

                        <div class="mt-2 relative rounded-md shadow-sm">


                            <input type="date" class="form-input w-full px-12 py-2 appearance-none rounded-md focus:border-indigo-600" name="expiration_date" required><br>

                        </div>
                    </div>


                    <div class="flex justify-between items-center px-5 py-3">
                        <input type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500 focus:outline-none"  value="Generate Link">

                    </div>
                </form>
            </div>
        </div>
    </div>

