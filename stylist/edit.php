<main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
    <div id="response" class="hidden p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"></div>

      <div class="rounded-lg border border-zinc-200 dark:border-zinc-800 p-4">

        <h2 class="font-semibold text-xl">Salon Name</h2>
        <form class="ajaxForm" action="edit_profile.php">

        <div class="editProfile__account">
            <label for="sln_name"></label>
            <input
                type="text"
                name="sln_name"
                id="name"
                placeholder="Edit your Salon Name"
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
          <h2 class="font-semibold text-xl">Name</h2>
          <form class="ajaxForm" action="edit_profile.php">
        <div class="editProfile__account">
            <label for="s_name"></label>
            <input
                placeholder="Edit your Name"
                type="text"
                name="s_name"
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
          <h2 class="font-semibold text-xl">Info</h2>
          <form method="post" action="edit_profile.php">
        <div class="editProfile__account">
            <label for="sln_name"></label>
            <textarea
                type="text"
                name="sln_name"
                id="name"
                placeholder="Salon Name"
                autocomplete="off"
                class="w-full h-32 mt-2 border border-zinc-200 dark:border-zinc-800 rounded"
            ></textarea>
            </div>
            <div class="editProfile__right--updateBtn">
                <input type="submit" value="Update" class="inline-flex bg-black text-white items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 mt-4">
            </div>        
            </form>
        </div>
      </div>

    </main>