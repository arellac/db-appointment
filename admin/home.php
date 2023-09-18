<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/admin.css">  

    <title>Dashboard</title>
</head>
<body>

<div class="flex h-screen bg-gray-200 font-roboto">
    <?php include 'html/sidebar.php'; ?>
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container mx-auto px-6 py-8">

                        <?php include 'html/body.php'; ?>

                    </div>
        </main>
    </div>

</div>

</body>
<script src="https://cdn.tailwindcss.com"></script>

</html>