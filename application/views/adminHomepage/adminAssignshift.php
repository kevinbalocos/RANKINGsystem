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
                    <form method="POST" action="<?= site_url('controllerAttendance/bulkDeleteAttendance') ?>">
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
                <script>
                    function deleteShift(attendance_id) {
                        if (confirm("Are you sure you want to delete this record?")) {
                            // Send AJAX request to delete attendance
                            fetch('<?= site_url('controllerAttendance/deleteAttendanceRecords') ?>/' + attendance_id, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert("Record deleted successfully.");
                                        location.reload();  // Reload the page after deletion
                                    } else {
                                        alert("Failed to delete record.");
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }
                    }
                    // Handling the bulk selection of checkboxes
                    document.getElementById('select_all').addEventListener('click', function (e) {
                        const checkboxes = document.querySelectorAll('.attendance-checkbox');
                        checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
                    });

                    document.querySelector("#bulkDeleteForm").addEventListener("submit", function (event) {
                        const selectedIds = [];
                        document.querySelectorAll(".attendance-checkbox:checked").forEach(function (checkbox) {
                            selectedIds.push(checkbox.value);
                        });

                        if (selectedIds.length === 0) {
                            event.preventDefault();  // Prevent form submission if no checkboxes are selected
                            alert("Please select at least one attendance record.");
                        } else {
                            // Append the selected IDs to the form
                            const input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "attendance_ids";  // Name of the form field to hold the IDs
                            input.value = JSON.stringify(selectedIds);  // Send the selected IDs as a JSON string
                            document.querySelector("#bulkDeleteForm").appendChild(input);
                        }
                    });

                </script>

            <?php else: ?>
                <p class="mt-6 text-gray-600">No attendance records found.</p>
            <?php endif; ?>
            </form>

        </div>

        <!-- Right Section -->
        <div class="right-section">

            <h3 class="text-lg font-medium text-gray-700">NOTIFICATIONS</h3>

            <?php if ($notifications): ?>
                <form method="POST" action="<?= site_url('controllerAttendance/deleteAllNotifications') ?>">
                    <button type="submit" class="text-red-500 hover:underline text-md mb-4">
                        Delete All Notifications
                    </button>
                </form>

                <ul class="space-y-4 mt-4">
                    <?php foreach (array_slice($notifications, 0, 8) as $notification): ?>
                        <li class="bg-white p-4 rounded-md shadow flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-800"><?= htmlspecialchars($notification['message']) ?></p>
                                <span
                                    class="text-xs text-gray-500"><?= date('Y-m-d h:i A', strtotime($notification['created_at'])) ?></span>
                            </div>
                            <form method="POST"
                                action="<?= site_url('controllerAttendance/deleteNotification/' . $notification['id']) ?>"
                                class="ml-2">
                                <button type="submit" class="text-black-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-6 text-gray-600">No notifications.</p>
            <?php endif; ?>
        </div>


    </div>

</body>

</html>