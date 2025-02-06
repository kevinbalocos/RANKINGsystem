<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <title>USER DASHBOARD</title>
</head>

<body>

    <!-- Approval Progress -->
    <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
        <h3 class="text-xl font-bold mb-4">OVERALL PROGRESS</h3>
        <div class="w-full bg-gray-200 rounded-full h-6">
            <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm" style="width: <?= $progress ?>%;">
                <?= round($progress, 2) ?>%
            </div>
        </div>
    </div>

    <!-- Dashboard Statistics -->
    <div class="upload grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Uploaded Files</h2>
            <p class="text-2xl text-blue-500 font-bold"><?= $totalUploaded ?> Files</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Pending Approval</h2>
            <p class="text-2xl text-yellow-500 font-bold"><?= $pendingFiles ?> Files</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Approved Files</h2>
            <p class="text-2xl text-green-500 font-bold"><?= $approvedFiles ?> Files</p>
        </div>
    </div>
</body>

</html>