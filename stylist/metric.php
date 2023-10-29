<main class="grid grid-cols-1 gap-4 p-4 md:gap-8 md:p-6 lg:grid-cols-1 font-mono">
      <div class="rounded-lg border border-zinc-200 border-dashed dark:border-zinc-800 flex flex-col gap-4 p-4">
        <h2 class="text-lg font-semibold flex justify-between items-center"> Key Metrics
        </h2>
        <div class="grid grid-cols-4 gap-4">
          <div class="bg-green-100 text-green-800 rounded-lg p-4 dark:bg-zinc-800 flex justify-between items-start">
            <div>
              <h3 class="text-md font-semibold"> Appointments </h3>
              <p class="text-4xl"> <?php echo $total_appointments['total_appointments']; ?> </p>
            </div>

          </div>
          <div class="bg-blue-100 text-blue-800 rounded-lg p-4 dark:bg-zinc-800 flex justify-between items-start">
            <div>
              <h3 class="text-md font-semibold"> Next Appointment </h3>
              <p class="text-4xl"> <?php echo $appointment_time_difference ; ?> </p>
            </div>

          </div>
          <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 dark:bg-zinc-800 flex justify-between items-start">
            <div>
              <h3 class="text-md font-semibold"> Total Rev </h3>
              <p class="text-4xl"> $ <?php echo $total_revenue; ?> </p>
            </div>

          </div>

        </div>
      </div>
      <div class="rounded-lg border border-zinc-200 border-dashed dark:border-zinc-800 flex flex-col p-4 h-screen">
        <h2 class="text-lg font-semibold"> Upcoming Appointments </h2>
        <div class="bg-white rounded-lg p-4 dark:bg-zinc-800 overflow-auto">
          <table class="w-full text-left table-auto text-sm font-mono">
            <thead>
              <tr>
                <th class="px-4 py-2"> Appointment ID </th>
                <th class="px-4 py-2"> User </th>
                <th class="px-4 py-2"> Service </th>
                <th class="px-4 py-2"> Price </th>
                <th class="px-4 py-2"> Date </th>
                <th class="px-4 py-2"> Payment </th>
                <th class="px-4 py-2"> Actions </th>
              </tr>
            </thead>
            <tbody> <?php foreach($upcoming_appointments as $appointment): ?> <tr>
                <td class="border px-4 py-2"> <?= $appointment['appoid'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['c_name'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['service_name'] ?> </td>
                <td class="border px-4 py-2"> $<?= $appointment['service_price'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['scheduledate'] ?> </td>
                <td class="border px-4 py-2"> <?= ($appointment['payment_method'] == 0) ? 'In-Store' : 'Card' ?> </td>
                <td class="border px-4 py-2">
                  <button class="inline-flex items-center justify-center ..."> Confirm </button>
                </td>
              </tr> <?php endforeach; ?> </tbody>
          </table>
        </div>
      </div>
    </main>