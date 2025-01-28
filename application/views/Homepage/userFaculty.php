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
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            align-items: center;
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
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">RANK REQUIREMENTS</h1>
    </header>

    <div class="main-container">
        <div class="left-section space-y-8">
            <div class="card-header">
                <img class="image_size"
                    src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                    alt="Profile Image">
                <div>
                    <h3><?= htmlspecialchars($user['username']); ?></h3>
                    <p><strong>Rank:</strong> <?= htmlspecialchars($user['rank'] ?: 'Not Yet Assigned'); ?></p>
                    <p><strong>Rank Label:</strong> <?= htmlspecialchars($rank_label); ?></p>
                    <p><strong>Faculty:</strong> <?= htmlspecialchars($user['faculty'] ?: 'Not Yet Assigned'); ?></p>
                </div>
            </div>

            <!-- Next Rank Requirement -->
            <div>
                <h3 class="font-semibold text-lg">Next Rank Requirements:</h3>
                <p><strong>To be <?= htmlspecialchars($next_rank_order); ?>, submit:</strong></p>
                <p><?= htmlspecialchars($next_rank_label); ?></p>
            </div>

            <form method="POST" enctype="multipart/form-data" action="<?= base_url('controllerFaculty/submitFile') ?>">
                <input type="file" name="file" required>
                <button type="submit">Submit File</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($file_submissions) && count($file_submissions) > 0): ?>
                        <?php foreach ($file_submissions as $submission): ?>
                            <tr>
                                <td><a href="<?= base_url($submission['file_path']); ?>">View File</a></td>
                                <td><?= $submission['approved'] ? 'Approved' : 'Pending'; ?></td>
                                <td>
                                    <?php if (!$submission['approved']): ?>
                                        <a href="<?= base_url('controllerFaculty/approveFile/' . $submission['id']); ?>">Approve</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No file submissions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>