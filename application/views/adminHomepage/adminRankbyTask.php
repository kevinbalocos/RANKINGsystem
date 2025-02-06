<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Admin Rank By Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 4rem);
            /* Adjust for header height */
        }

        .left-section,
        .right-section {
            overflow-y: auto;
            padding: 1rem;
        }

        .left-section {
            flex: 3;
        }

        .right-section {
            flex: 1;
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">User Rankings by Completed Tasks</h1>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-6">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    <p class="font-medium"><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p class="font-medium"><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            <?php endif; ?>




            <!-- Manually Add Points and Reset Rank Points Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex space-x-6">
                    <!-- Manually Add Points -->
                    <div class="darkmode bg-gray-100 p-4 rounded-md shadow-md flex-1">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Manually Add Points</h2>
                        <form method="POST" action="<?= base_url('conAdmin/addPointsToUser') ?>" class="space-y-4">
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-600">Select
                                    User:</label>
                                <select name="user_id" id="user_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Select User --</option>
                                    <option value="all">All Users</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="points" class="block text-sm font-medium text-gray-600">Points to
                                    Add:</label>
                                <input type="number" name="points" id="points" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn">
                                    Add Points
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Reset Specific Points -->
                    <div class="darkmode bg-gray-100 p-4 rounded-md shadow-md flex-1">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Reset Specific Points</h2>
                        <form method="POST" action="<?= base_url('conAdmin/resetSpecificPoints') ?>" class="space-y-4">
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-600">Select
                                    User:</label>
                                <select name="user_id" id="user_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Select User --</option>
                                    <option value="all">All Users</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="points_to_reset" class="block text-sm font-medium text-gray-600">Points to
                                    Reset:</label>
                                <input type="number" name="points_to_reset" id="points_to_reset" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-yellow-200 px-4 py-2 rounded hover:bg-yellow-300 transition filter-btn">
                                    Reset Specific Points
                                </button>
                            </div>
                        </form>
                    </div>


                    <!-- Reset Rank Points -->
                    <div class="darkmode bg-gray-100 p-4 rounded-md shadow-md flex-1">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Reset Rank Points</h2>
                        <form method="POST" action="<?= base_url('conAdmin/resetRankPoints') ?>" class="space-y-4"
                            id="resetRankPointsForm">
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-600">Select
                                    User:</label>
                                <select name="user_id" id="user_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Select User --</option>
                                    <option value="all">All Users</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-red-200 px-4 py-2 rounded hover:bg-red-300 transition filter-btn">
                                    Reset Points
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>




            <!-- User Rankings Table -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">User Rankings</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Rank
                            </th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Username
                            </th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Completed Tasks
                            </th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Points
                            </th>
                        </tr>
                    </thead>
                    <tbody id="userTable" class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($rankings)): ?>
                            <?php
                            $rank = 1;
                            foreach ($rankings as $user):
                                // Combine completed tasks and total points
                                $total_score = $user['completed_tasks'] + $user['total_points'];
                                $progress_percentage = ($total_score / 50000) * 100;
                                ?>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= $rank++; ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($user['username']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full"
                                                    style="width: <?= min($progress_percentage, 100); ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= $user['total_points']; ?> Points</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-500 text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>



        <!-- Right Section - Notifications -->
        <div class="right-section">
            <!-- Delete All Notifications Button -->
            <div class="mb-4">

            </div>

            <h2 class="text-md text-gray-800 mb-4 flex uppercase justify-between">Notifications <form method="POST"
                    action="<?= base_url('conAdmin/deleteAllNotifications'); ?>">
                    <button type="submit" class="text-red-500 px-2 text-md uppercase hover:line-through">
                        Delete All Notifications
                    </button>
                </form>
            </h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">

                <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <li>
                            <p><?= htmlspecialchars($notification['message']); ?></p>
                            <small class="text-gray-500"><?= $notification['created_at']; ?></small>
                        </li>
                        <form method="POST" action="<?= base_url('conAdmin/deleteNotification/' . $notification['id']); ?>">
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                        </form>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-gray-500">No notifications available.</li>
                <?php endif; ?>
            </ul>
        </div>



        <!-- Add SweetAlert2 Script -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Attach event listener to the "Add Points" form
            const addPointsForm = document.querySelector('form[action="<?= base_url('conAdmin/addPointsToUser') ?>"]');
            const pointsInput = document.getElementById('points');

            addPointsForm.addEventListener('submit', function (e) {
                const points = parseInt(pointsInput.value, 10);

                // Check if points exceed 10,000
                if (points > 10000) {
                    e.preventDefault(); // Prevent form submission
                    Swal.fire({
                        title: 'Error',
                        text: 'You cannot add more than 10,000 points!',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'
                        }
                    });
                }
            });
        </script>
        <script>
            // SweetAlert2 for "Delete Notification"
            document.querySelectorAll('form[action^="<?= base_url('conAdmin/deleteNotification/') ?>"]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Prevent default form submission

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This notification will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // Submit the form after confirmation
                        }
                    });
                });
            });

            // SweetAlert2 for "Delete All Notifications"
            document.querySelector('form[action="<?= base_url('conAdmin/deleteAllNotifications'); ?>"]').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "All notifications will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the form after confirmation
                    }
                });
            });
        </script>
        <script>
            // SweetAlert2 confirmation for resetting rank points
            document.getElementById('resetRankPointsForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will reset the rank points for the selected user(s). This cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reset points!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the form if the user confirms
                    }
                });
            });
        </script>





</body>

</html>