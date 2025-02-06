<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen p-6 space-x-6">

        <!-- Left Section -->
        <div class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Pending Users</h2>
            <table class="min-w-full table-auto text-left border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-600">Username</th>
                        <th class="px-4 py-2 text-sm font-medium text-gray-600">Email</th>
                        <th class="px-4 py-2 text-sm font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_users as $user): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= $user['username'] ?></td>
                            <td class="px-4 py-2"><?= $user['email'] ?></td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="<?= base_url('auth/approve_user/' . $user['id']) ?>"
                                    class="text-green-500 hover:text-green-700 font-medium">Approve</a>
                                |
                                <a href="<?= base_url('auth/reject_user/' . $user['id']) ?>"
                                    class="text-red-500 hover:text-red-700 font-medium">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Right Section -->
        <div class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Approved Users</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-left border-collapse mb-6">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-sm font-medium text-gray-600">Username</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-600">Email</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-600">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approved_users as $user): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $user['username'] ?></td>
                                <td class="px-4 py-2"><?= $user['email'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2 class="text-xl font-semibold mb-4">Rejected Users</h2>
                <table class="min-w-full table-auto text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-sm font-medium text-gray-600">Username</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-600">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rejected_users as $user): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $user['username'] ?></td>
                                <td class="px-4 py-2"><?= $user['email'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>