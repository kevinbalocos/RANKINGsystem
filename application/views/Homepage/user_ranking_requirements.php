<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER RANKING REQUIREMENTS</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>

    <style>
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

<body>

    <div class="grid-container">
        <!-- Current logged-in user (your profile) -->
        <div class="bg-white card">
            <div class=" card-header">
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



</body>

</html>