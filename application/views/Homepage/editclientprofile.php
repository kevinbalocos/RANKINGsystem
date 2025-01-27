<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hidden {
            display: none;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-800">Edit Client Profile</h1>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Profile Update Form -->
        <form method="post" action="<?= base_url('Home/updateClientProfile'); ?>" enctype="multipart/form-data"
            class="space-y-6">
            <!-- Profile Image Section -->
            <div class="flex items-center space-x-4">
                <img class="w-20 h-20 rounded-full border-2 border-gray-300"
                    src="<?= base_url($user['uploaded_profile_image'] ?? 'path/to/default-avatar.png'); ?>"
                    alt="Profile Image">
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-600">Upload New Profile
                        Image</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="block w-full">
                </div>
            </div>

            <!-- Username Section -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
                <input type="text" id="username" name="username"
                    value="<?= set_value('username', $user['username']); ?>"
                    class="block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <!-- Email Section -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" value="<?= set_value('email', $user['email']); ?>"
                    class="block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <!-- Address Section -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                <textarea id="address" name="address"
                    class="block w-full p-2 border border-gray-300 rounded-md"><?= set_value('address', $user['address']); ?></textarea>
            </div>

            <!-- Phone Section -->
            <div>
                <label for="phoneNo" class="block text-sm font-medium text-gray-600">Phone Number</label>
                <input type="text" id="phoneNo" name="phoneNo" value="<?= set_value('phoneNo', $user['phoneNo']); ?>"
                    class="block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <!-- Gender Section -->
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-600">Gender</label>
                <select id="gender" name="gender" class="block w-full p-2 border border-gray-300 rounded-md">
                    <option value="Male" <?= set_select('gender', 'Male', ($user['gender'] === 'Male')); ?>>Male</option>
                    <option value="Female" <?= set_select('gender', 'Female', ($user['gender'] === 'Female')); ?>>Female
                    </option>
                    <option value="Other" <?= set_select('gender', 'Other', ($user['gender'] === 'Other')); ?>>Other
                    </option>
                </select>
            </div>

            <!-- Birth Date Section -->
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-600">Birth Date</label>
                <input type="date" id="birth_date" name="birth_date"
                    value="<?= set_value('birth_date', $user['birth_date']); ?>"
                    class="block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <button type="submit" name="update_profile"
                class="w-full py-2 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Save
                Changes</button>
        </form>

    </div>

</body>

</html>