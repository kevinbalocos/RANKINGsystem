<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .progress-bar {
            position: relative;
        }

        .progress-bar span {
            position: absolute;
            top: -25px;
            right: 5px;
            font-size: 0.75rem;
            color: #4b5563;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-800">Client Profile</h1>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <!-- Left Section -->
        <div class="left-section">
            <!-- Profile Header -->
            <div class="bg-white shadow-xl rounded-lg p-6 flex items-center space-x-6 border border-gray-200">
                <img class="w-24 h-24 rounded-full border-4 border-gray-300"
                    src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                    alt="Profile Image">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800"><?= htmlspecialchars($user['username']); ?></h2>
                    <p class="text-gray-500"><?= htmlspecialchars($user['email']); ?></p>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded-lg shadow-lg mt-4">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow-lg mt-4">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Profile Completion Progress Bar -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Approval Progress</h3>
                <div class="w-full bg-gray-200 rounded-full h-6">
                    <div class="bg-green-500 h-6 rounded-full text-white text-center text-sm"
                        style="width: <?= $progress ?>%;">
                        <?= round($progress, 2) ?>%
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['address']); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['phoneNo']); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Gender</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['gender']); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Birth Date</label>
                    <p class="text-gray-700"><?= date("F j, Y", strtotime($user['birth_date'])); ?></p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 col-span-2">
                    <p><strong>Rank:</strong> <?= htmlspecialchars($user['rank'] ?: 'Not Yet Assigned'); ?></p>
                    <p><strong>Faculty:</strong> <?= htmlspecialchars($user['faculty'] ?: 'Not Yet Assigned'); ?></p>
                </div>
            </div>

            <!-- Upload Profile Image -->
            <div class="bg-white shadow-lg rounded-lg p-6 mt-6 border border-gray-200">
                <form method="post" action="<?= base_url('Home/uploadProfileImage'); ?>" enctype="multipart/form-data">
                    <label for="profile_image" class="block text-sm font-medium text-gray-600 mb-2">Upload Profile
                        Picture</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                        class="block w-full text-gray-600 border-gray-300 rounded-md p-2 mb-4 transition-all focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all ease-in-out duration-200">
                        Upload
                    </button>
                </form>
            </div>
        </div>



        <!-- Right Section -->
        <div class="right-section">
            <h3 class="text-lg font-medium text-gray-700">Quick Actions</h3>
        </div>
    </div>




</body>

</html>