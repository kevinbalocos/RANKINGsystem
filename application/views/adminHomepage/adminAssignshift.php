<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Shift</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 3rem);
            /* Adjusting for header height */
            overflow: hidden;
        }

        .left-section,
        .right-section {
            overflow-y: auto;
            padding: 1rem;
        }

        .left-section {
            flex: 2;
        }

        .right-section {
            flex: 1;
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb;
            max-width: 350px;
        }



        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                height: auto;
            }

            .left-section,
            .right-section {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }

        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-800">Assign Shift to Teachers</h1>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section m-6 rounded-lg">
            <div class="flex space x-6 darkmode bg-gray-100 p-4 rounded-md shadow-md flex-1">

                <?php echo form_open('controllerAttendance/saveShift', ['class' => 'space-y-6']); ?>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-600 mb-2">Select
                        User:</label>
                    <select name="user_id" id="user_id"
                        class="py-2 px-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="shift_start" class="block text-sm font-medium text-gray-600 mb-2">Shift Start
                        Time:</label>
                    <input type="time" name="shift_start" id="shift_start"
                        class="py-2 px-2 darkmode_text block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="shift_end" class="block text-sm font-medium text-gray-600 mb-2">Shift End Time:</label>
                    <input type="time" name="shift_end" id="shift_end"
                        class="py-2 px-2 darkmode_text block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="flex m-3 justify-between space-x-4">
                    <!-- Assign Shift Button (on the left) -->
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150">
                        Assign Shift
                    </button>
                    <?php echo form_close(); ?>

                    <!-- Delete Selected Button (on the right) -->
                    <form action="<?= site_url('controllerAttendance/bulkDeleteAttendance') ?>" method="POST"
                        id="bulkDeleteForm">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150">
                            Delete Selected
                        </button>
                    </form>
                </div>


            </div>
            <?php if ($attendance): ?>
                <h2 class="mt-8 text-xl font-semibold text-gray-700">Attendance Records</h2>
                <!-- Assigned Shifts Table -->
                <div class="shift-table-container bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" id="select_all" />
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Day
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Shift Start
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Shift End
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Check-In Time
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Check-Out Time
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($attendance)): ?>
                                <?php
                                // Sort attendance records by created_at in descending order
                                usort($attendance, function ($a, $b) {
                                    return strtotime($b['check_in_time']) - strtotime($a['check_in_time']);
                                });
                                ?>
                                <?php foreach ($attendance as $entry): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <input type="checkbox" class="attendance-checkbox" name="attendance_ids[]"
                                                value="<?= $entry['id'] ?>" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <?= date('F j, Y', strtotime($entry['check_in_time'])) ?>
                                            <!-- Updated format here -->
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <?= date('l', strtotime($entry['check_in_time'])) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <?php
                                            // Fetch teacher's name
                                            $teacher = array_filter($users, function ($u) use ($entry) {
                                                return $u['id'] == $entry['user_id'];
                                            });
                                            $teacher = reset($teacher);
                                            echo htmlspecialchars($teacher['username'] ?? 'Unknown');
                                            ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <?php
                                            // Display shift start time
                                            $shift = array_filter($shifts, function ($s) use ($entry) {
                                                return $s['user_id'] == $entry['user_id'];
                                            });
                                            $shift = reset($shift);
                                            echo $shift ? date('h:i A', strtotime($shift['shift_start'])) : 'N/A';
                                            ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <?= $shift && isset($shift['shift_end']) ? date('h:i A', strtotime($shift['shift_end'])) : 'N/A' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $entry['check_in_time'] ? date('h:i A', strtotime($entry['check_in_time'])) : 'N/A' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $entry['check_out_time'] ? date('h:i A', strtotime($entry['check_out_time'])) : 'Still Working' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($entry['status']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                            <button onclick="deleteShift(<?= $entry['id'] ?>)"
                                                class="ml-2 text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                        attendance records found.</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

            <?php else: ?>
                <p class="mt-6 text-gray-600">No attendance records found.</p>
            <?php endif; ?>

        </div>

        <!-- Right Section -->
        <div class="right-section">

            <h3 class="text-lg font-medium text-gray-700">NOTIFICATIONS</h3>

            <?php if ($notifications): ?>
                <!-- Delete All Notifications Button -->
                <button onclick="deleteAllNotifications()" class="text-red-500 hover:underline text-md mb-4">
                    Delete All Notifications
                </button>

                <ul class="space-y-4 mt-4">
                    <?php foreach (array_slice($notifications, 0, 8) as $notification): ?>
                        <li class="bg-white p-4 rounded-md shadow flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-800"><?= htmlspecialchars($notification['message']) ?></p>
                                <span
                                    class="text-xs text-gray-500"><?= date('Y-m-d h:i A', strtotime($notification['created_at'])) ?></span>
                            </div>
                            <button onclick="deleteNotification(<?= $notification['id'] ?>)"
                                class="text-black-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>



            <?php else: ?>
                <p class="mt-6 text-gray-600">No notifications.</p>
            <?php endif; ?>
        </div>


    </div>

    <script>
        function deleteShift(attendanceId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('controllerAttendance/deleteAttendanceRecords/') ?>" + attendanceId, {
                        method: "POST"
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Deleted!", "The attendance record has been deleted.", "success")
                                    .then(() => location.reload());
                            } else {
                                Swal.fire("Error!", "Failed to delete the record.", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        });
                }
            });
        }

        document.getElementById('bulkDeleteForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let selectedRecords = [];
            document.querySelectorAll('.attendance-checkbox:checked').forEach((checkbox) => {
                selectedRecords.push(checkbox.value);
            });

            if (selectedRecords.length === 0) {
                Swal.fire("No Selection", "Please select at least one record to delete.", "info");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: `You are about to delete ${selectedRecords.length} record(s). This action cannot be undone.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete them!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('controllerAttendance/bulkDeleteAttendance') ?>", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "attendance_ids=" + JSON.stringify(selectedRecords)
                    })
                        .then(response => response.text())
                        .then(() => {
                            Swal.fire("Deleted!", "The selected records have been deleted.", "success")
                                .then(() => location.reload());
                        })
                        .catch(error => {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        });
                }
            });
        });
        // Delete a single notification
        function deleteNotification(notificationId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This notification will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('controllerAttendance/deleteNotification/') ?>" + notificationId, {
                        method: "POST"
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Deleted!", "Notification has been removed.", "success")
                                    .then(() => location.reload());
                            } else {
                                Swal.fire("Error!", "Failed to delete the notification.", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        });
                }
            });
        }

        // Delete all notifications
        function deleteAllNotifications() {
            Swal.fire({
                title: "Delete All Notifications?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete all"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= site_url('controllerAttendance/deleteAllNotifications') ?>", {
                        method: "POST"
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Deleted!", "All notifications have been removed.", "success")
                                    .then(() => location.reload());
                            } else {
                                Swal.fire("Error!", "Failed to delete notifications.", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        });
                }
            });
        }
    </script>
    <script>
        document.getElementById('select_all').addEventListener('change', function () {
            let checkboxes = document.querySelectorAll('.attendance-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // Ensure if any checkbox is unchecked, uncheck "Select All"
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    document.getElementById('select_all').checked = false;
                }
            });
        });

    </script>

</body>

</html>