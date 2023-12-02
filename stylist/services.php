<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>



<main class="grid grid-cols-1 gap-4 p-4 md:gap-8 md:p-6 lg:grid-cols-1 font-mono">
<div id="response2" class="hidden p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"></div>

<div class="rounded-lg border border-zinc-200 border-dashed dark:border-zinc-800 flex flex-col p-4 h-screen">
    <h2 class="text-lg font-semibold"> Your Services </h2>
    <div class="bg-white rounded-lg p-4 dark:bg-zinc-800 overflow-auto">
        <table id="servicesTable" class="w-full text-left table-auto text-sm font-mono">
            <thead>
                <tr>
                    <th class="px-4 py-2"> Service Name </th>
                    <th class="px-4 py-2"> Service Details </th>
                    <th class="px-4 py-2"> Service Price </th>
                    <th class="px-4 py-2"> Actions </th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach($services as $service): ?>
                    <tr>
                        <td class="border px-4 py-2">
                            <span class="service-name-text"><?= htmlspecialchars($service['service_name']) ?></span>
                            <input type="text" class="service-name-input hidden" value="<?= htmlspecialchars($service['service_name']) ?>">
                        </td>
                        <td class="border px-4 py-2">
                            <span class="service-details-text"><?= htmlspecialchars($service['service_details']) ?></span>
                            <input type="text" class="service-details-input hidden" value="<?= htmlspecialchars($service['service_details']) ?>">
                        </td>
                        <td class="border px-4 py-2">
                            <span class="service-price-text">$ <?= htmlspecialchars($service['service_price']) ?></span>
                            <input type="number" class="service-price-input hidden" value="<?= htmlspecialchars($service['service_price']) ?>">
                        </td>
                        <td class="border px-4 py-2">
                            <!-- Edit Button -->
                            <button onclick="editRow(this)" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 mr-2">Edit</button>
                            
                            <!-- Save Button (Initially hidden) -->
                            <button onclick="saveChanges(this, '<?= $service['service_id'] ?>')" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mr-2 hidden">Save</button>
                            
                            <!-- Delete button remains unchanged -->
                            <form id="deleteService" method="post" action="api/delete_service.php">
                                <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">X</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <form id="serviceForm" method="post" action="api/add_service.php">
                        <td class="border px-4 py-2"><input type="text" name="service_name" placeholder="Enter Service Name" required></td>
                        <td class="border px-4 py-2"><input type="text" name="service_details" placeholder="Enter Service Details" required></td>
                        <td class="border px-4 py-2"><input type="number" name="service_price" placeholder="Enter Price" required></td>
                        <td class="border px-4 py-2">
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Add</button>
                        </td>
                    </form>
                </tr>
                <tr>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>

</main>