<main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
    <div id="response" class="hidden p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"></div>



      <div class="rounded-lg border border-zinc-200 dark:border-zinc-800 p-4">

        <h2 class="font-semibold text-xl">Card Number: <?php echo $card_number; ?></h2>
        <form class="ajaxForm" action="api/edit_profile.php">

        <div class="editProfile__account">
            <label for="card_number"></label>
            <input
                type="text"
                name="card_number"
                id="name"
                placeholder="Edit your Card Number"
                autocomplete="off"
                class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full mt-2"
            />
            </div>
            <div class="editProfile__right--updateBtn">
                <input type="submit" value="Update" class="inline-flex bg-black text-white items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 mt-4">
            </div>        
            </form>

      </div>
      <div class="grid gap-4">

        <div class="rounded-lg border border-zinc-200 dark:border-zinc-800 p-4">
          <h2 class="font-semibold text-xl">CardCVV: <?php echo $cvv; ?> </h2>

          <form class="ajaxForm" action="api/edit_profile.php">
        <div class="editProfile__account">
            <label for="card_ccv"></label>
            <input
                placeholder="Change your Card CVV"
                type="text"
                name="card_ccv"
                id="name"
                autocomplete="off"
                class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full mt-2"
            />
            </div>
            <div class="editProfile__right--updateBtn">
                <input type="submit" value="Update" class="inline-flex bg-black text-white items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 mt-4">
            </div>        
            </form>
        </div>

        <div class="rounded-lg border border-zinc-200 dark:border-zinc-800 p-4">
          <h2 class="font-semibold text-xl">CardEXP: <?php echo $exp_date; ?> </h2>

          <form class="ajaxForm" action="api/edit_profile.php">
        <div class="editProfile__account">
            <label for="card_exp"></label>
            <input
                placeholder="Change your Card EXP"
                type="date"
                name="card_exp"
                id="name"
                autocomplete="off"
                class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full mt-2"
            />
            </div>
            <div class="editProfile__right--updateBtn">
                <input type="submit" value="Update" class="inline-flex bg-black text-white items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 mt-4">
            </div>        
            </form>
        </div>


      </div>

    </main>