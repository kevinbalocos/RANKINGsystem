<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Faculty</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
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

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .image_size {
            height: 180px;
            width: 180px;
            border-radius: 30px;
            object-fit: cover;
            padding: 5px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-body {
            padding: 1rem 1.5rem;
        }

        .card-body p {
            color: #4b5563;
        }

        .card-header img {
            margin-right: 1.5rem;
        }
    </style>
</head>

<body class="bg-gray-50">

    <header class="bg-white shadow px-6 py-4">
        <h1 class="text-3xl font-bold text-gray-900">Faculty Directory</h1>
    </header>

    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-8">

            <!-- Faculty Members Section -->
            <div class="text-center">
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">The Team</h2>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-lg text-gray-600">Meet the faculty members who are part
                    of
                    this great institution. They bring expertise, passion, and dedication to their roles.</p>
            </div>

            <!-- Faculty Member Cards -->
            <div class="grid-container">
                <!-- Current logged-in user (your profile) -->
                <div class="card">
                    <div class="bg-white card-header">
                        <img class="image_size"
                            src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                            alt="Profile Image">
                        <div>
                            <h3><?= htmlspecialchars($user['username']); ?>
                            </h3>
                            <p><strong>Rank:</strong> <?= htmlspecialchars($user['rank'] ?: 'Not Yet Assigned'); ?></p>
                            <p><strong>Faculty:</strong>
                                <?= htmlspecialchars($user['faculty'] ?: 'Not Yet Assigned'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Fellow faculty members -->
                <?php foreach ($fellow_faculty_members as $faculty_member): ?>
                    <?php if ($faculty_member['id'] != $user['id'] && !empty($faculty_member['faculty'])) { ?>
                        <div class="bg-white card">
                            <div class="card-header">
                                <img class="image_size"
                                    src="<?= base_url($faculty_member['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                    alt="Profile Image">
                                <div>
                                    <h3>
                                        <?= htmlspecialchars($faculty_member['username']); ?>
                                    </h3>
                                    <p><strong>Rank:</strong>
                                        <?= htmlspecialchars($faculty_member['rank'] ?: 'Not Yet Assigned'); ?></p>
                                    <p><strong>Faculty:</strong>
                                        <?= htmlspecialchars($faculty_member['faculty'] ?: 'Not Yet Assigned'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section p-6">
            <div class="bg-white shadow-md p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                <ul class="space-y-4 mt-4">
                </ul>
            </div>
        </div>
    </div>

</body>

</html>