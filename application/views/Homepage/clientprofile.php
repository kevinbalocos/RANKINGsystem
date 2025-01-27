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
        <div class="left-section">
            <!-- Profile Header -->
            <div class="flex items-center space-x-4">
                <img class="w-20 h-20 rounded-full border-2 border-gray-300"
                    src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                    alt="Profile Image">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700"><?= htmlspecialchars($user['username']); ?></h2>
                    <p class="text-gray-500"><?= htmlspecialchars($user['email']); ?></p>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mt-4">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mt-4">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Progress Bar -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">Profile Completion</label>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 80%;"></div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Address</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['address']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['phoneNo']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Gender</label>
                    <p class="text-gray-700"><?= htmlspecialchars($user['gender']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Birth Date</label>
                    <p class="text-gray-700"><?= date("F j, Y", strtotime($user['birth_date'])); ?></p>
                </div>



                <!-- Upload Profile Image -->
                <div class="mt-6">
                    <form method="post" action="<?= base_url('Home/uploadProfileImage'); ?>"
                        enctype="multipart/form-data">
                        <label for="profile_image" class="block text-sm font-medium text-gray-600 mb-2">Upload Profile
                            Picture</label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                            class="block w-full text-gray-600">
                        <button type="submit"
                            class="w-full mt-4 py-2 px-4 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">
                            Upload
                        </button>
                    </form>
                </div>
            </div>


        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h3 class="text-lg font-medium text-gray-700">Quick Actions</h3>
        </div>
    </div>




</body>

</html>