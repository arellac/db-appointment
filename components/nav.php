<header class="w-full bg-[#ff6600] p-2 text-white flex justify-between items-center">
    <div class="flex items-center">
        <h1 class="text-lg font-bold border p-2">BookLook</h1>
        <nav class="ml-4">
          <ul class="flex space-x-4">
            <li>
              <a class="text-white hover:underline" href="/db-project/index.php">
                Home
              </a>
            </li>

            <li>
              <a class="text-white hover:underline" href="/db-project/client/appointments.php">
                Appointments
              </a>
            </li>
          </ul>
        </nav>
    </div>

    <?php
      if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='C'){
          echo '<a href="/db-project/logout.php" class="px-4 py-2 bg-white text-[#ff6600] font-bold rounded hover:bg-[#ddd]">Login</a>';
        }else{
          $useremail=$_SESSION["user"];
          echo '<a href="/db-project/logout.php" class="px-4 py-2 bg-white text-[#ff6600] font-bold rounded hover:bg-[#ddd]">Logout</a>';
        }
      }else{
        echo '<a href="#" class="px-4 py-2 bg-white text-[#ff6600] font-bold rounded hover:bg-[#ddd]">Login</a>';
      }
    ?>
</header>
