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
            padding: 1.5rem;
            max-width: 350px;
            display: flex;
            flex-direction: column;
        }

        .right-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .right-section p {
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #374151;
        }

        .right-section .button-container {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .right-section .button-container form {
            width: 100%;
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
        <h1 class="text-2xl font-bold text-gray-800">Your Attendance</h1>
    </header>

    <div class="main-container">
        <!-- Left Section -->
        <div class="darkmode left-section m-6 rounded-lg">
            <?php if ($attendance): ?>
                <div class="table-container bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                    <h2 class="text-xl uppercase text-center font-semibold text-gray-700">Attendance Records</h2>

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
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Time Count</th>
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
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Assigned Shift</h2>
            <?php if ($shift): ?>
                <p><strong>Shift Start:</strong> <?= date('h:i A', strtotime($shift['shift_start'])) ?></p>
                <p><strong>Shift End:</strong> <?= date('h:i A', strtotime($shift['shift_end'])) ?></p>
            <?php else: ?>
                <p>No shift assigned yet.</p>
            <?php endif; ?>

            <div class="button-container mt-4">
                <?php if ($attendance && !$attendance[0]['check_out_time']): ?>
                    <form action="<?= site_url('controllerAttendance/checkOut') ?>" method="POST">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 w-full">Check-Out</button>
                    </form>
                <?php elseif ($attendance && $attendance[0]['check_out_time']): ?>
                    <form id="checkInForm" action="<?= site_url('controllerAttendance/checkIn') ?>" method="POST">
                        <button type="button" onclick="checkShift()"
                            class="bg-green-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-700 w-full">Check-In</button>
                    </form>
                <?php else: ?>
                    <form id="checkInForm" action="<?= site_url('controllerAttendance/checkIn') ?>" method="POST">
                        <button type="button" onclick="checkShift()"
                            class="bg-yellow-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-yellow-700 w-full">Check-In</button>
                    </form>
                <?php endif; ?>
            </div>

            <script>
                function checkShift() {
                    <?php if (!$shift): ?>
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Assigned Shift',
                            text: 'You cannot check in because no shift has been assigned yet.',
                            confirmButtonColor: '#f59e0b'
                        });
                    <?php else: ?>
                        document.getElementById("checkInForm").submit();
                    <?php endif; ?>
                }
            </script>

        </div>
    </div>

</body>

</html>