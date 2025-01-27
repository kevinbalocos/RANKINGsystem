<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .main-container {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
        }

        .left-section,
        .right-section {
            padding: 2rem;
        }

        .left-section {
            flex: 2;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
        }

        .right-section {
            background-color: #f9fafb;
            width: 300px;
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

        .table-container {
            overflow-y: auto;
            max-height: 800px;
            scrollbar-width: thin;
            scrollbar-color: #66cdaa #f1f1f1;
        }

        .table-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #66cdaa;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-800">Your Attendance</h1>
    </header>

    <div class="main-container">
        <!-- Left Section -->
        <div class="darkmode left-section m-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Assigned Shift</h2>
            <?php if ($shift): ?>
                <p><strong>Shift Start:</strong> <?= date('h:i A', strtotime($shift['shift_start'])) ?></p>
                <p><strong>Shift End:</strong> <?= date('h:i A', strtotime($shift['shift_end'])) ?></p>
            <?php else: ?>
                <p>No shift assigned yet.</p>
            <?php endif; ?>

            <h2 class="text-xl font-semibold text-gray-700 mt-8">Attendance Records</h2>
            <?php if ($attendance): ?>
                <div class="table-container bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Day</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Check-In</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Check-Out</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($attendance as $entry): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <?= date('F j, Y', strtotime($entry['check_in_time'])) ?> <!-- Updated format here -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <?= date('l', strtotime($entry['check_in_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('h:i A', strtotime($entry['check_in_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $entry['check_out_time'] ? date('h:i A', strtotime($entry['check_out_time'])) : 'Still Working' ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $entry['status'] ?></td>
                                    <?php if ($entry['status'] == 'Early'): ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Early by
                                            <?= $entry['early_minutes'] ?> minutes and <?= $entry['early_seconds'] ?> seconds
                                        </td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No attendance records found.</p>
            <?php endif; ?>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h3 class="text-lg font-medium text-gray-700">Notifications</h3>

            <div class="mt-4">
                <?php if ($attendance && !$attendance[0]['check_out_time']): ?>
                    <form action="<?= site_url('controllerAttendance/checkOut') ?>" method="POST">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 w-full">Check-Out</button>
                    </form>
                <?php elseif ($attendance && $attendance[0]['check_out_time']): ?>
                    <form action="<?= site_url('controllerAttendance/checkIn') ?>" method="POST">
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-700 w-full">Check-In</button>
                    </form>
                <?php else: ?>
                    <form action="<?= site_url('controllerAttendance/checkIn') ?>" method="POST">
                        <button type="submit"
                            class="bg-yellow-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-yellow-700 w-full">Check-In</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>