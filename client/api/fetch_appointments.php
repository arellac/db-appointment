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
              </tr>
            </thead>
            <tbody> <?php foreach($upcoming_appointments as $appointment): ?> <tr>
                <td class="border px-4 py-2"> <?= $appointment['appoid'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['c_name'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['service_name'] ?> </td>
                <td class="border px-4 py-2"> $<?= $appointment['service_price'] ?> </td>
                <td class="border px-4 py-2"> <?= $appointment['scheduledate']?> @ <?=$appointment['scheduletime']  ?> </td>
                <td class="border px-4 py-2"> <?= ($appointment['payment_method'] == 0) ? 'In-Store' : 'Card' ?> </td>

              </tr> <?php endforeach; ?> </tbody>
          </table>
        </div>
      </div>