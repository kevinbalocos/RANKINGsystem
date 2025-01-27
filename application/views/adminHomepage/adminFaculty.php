<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN FACULTY</title>
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

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">FACULTY</h1>
    </header>

    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll()">
                            </th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Username</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Rank</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Faculty</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <input type="checkbox" class="user-checkbox" value="<?= $user['id']; ?>"
                                        onchange="toggleUserSelection(this)">
                                </td>

                                <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($user['username']); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <select name="rank" class="border border-gray-300 rounded-md px-2 py-1"
                                        onchange="updateRank(<?= $user['id']; ?>, this.value)">
                                        <option value="">-- Select Rank --</option>
                                        <?php foreach ($ranks as $rank): ?>
                                            <option value="<?= $rank['name']; ?>" <?= $user['rank'] == $rank['name'] ? 'selected' : ''; ?>>
                                                <?= $rank['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <select name="faculty" class="border border-gray-300 rounded-md px-2 py-1"
                                        onchange="updateFaculty(<?= $user['id']; ?>, this.value)">
                                        <option value="">-- Select Faculty --</option>
                                        <?php foreach ($faculties as $faculty): ?>
                                            <option value="<?= $faculty['name']; ?>" <?= $user['faculty'] == $faculty['name'] ? 'selected' : ''; ?>>
                                                <?= $faculty['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section w-1/3 bg-white border-l px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Quick Actions</h3>
            <div class="space-y-4">
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                    onclick="bulkRemoveRank()">
                    Remove Rank
                </button>
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                    onclick="bulkRemoveFaculty()">
                    Remove Faculty
                </button>
                <div>
                    <select id="bulk-rank" class="w-full px-3 py-2 border rounded-md mb-2">
                        <option value="">-- Select Rank --</option>
                        <option value="Professor">Professor</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                        <option value="Lecturer">Lecturer</option>
                        <option value="Dean">Dean</option>
                    </select>
                    <button class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        onclick="bulkAssignRank()">
                        Assign Rank
                    </button>
                </div>
                <div>
                    <select id="bulk-faculty" class="w-full px-3 py-2 border rounded-md mb-2">
                        <option value="">-- Select Faculty --</option>
                        <option value="Faculty of CSS">Faculty of CSS</option>
                        <option value="Faculty of Engineering">Faculty of Engineering</option>
                        <option value="Faculty of Arts">Faculty of Arts</option>
                        <option value="Faculty of Science">Faculty of Science</option>
                    </select>
                    <button class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                        onclick="bulkAssignFaculty()">
                        Assign Faculty
                    </button>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Add New</h3>
                        <form action="<?= base_url('controllerFaculty/addRank'); ?>" method="POST" class="space-y-2">
                            <input type="text" name="rank" placeholder="Enter new rank"
                                class="w-full px-3 py-2 border rounded-md" required>
                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Add Rank
                            </button>
                        </form>
                        <form action="<?= base_url('controllerFaculty/addFaculty'); ?>" method="POST" class="space-y-2">
                            <input type="text" name="faculty" placeholder="Enter new faculty"
                                class="w-full px-3 py-2 border rounded-md" required>
                            <button type="submit"
                                class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Add Faculty
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        let selectedUsers = [];

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.user-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                toggleUserSelection(checkbox);
            });
        }

        function toggleUserSelection(checkbox) {
            const userId = checkbox.value;

            if (checkbox.checked) {
                if (!selectedUsers.includes(userId)) {
                    selectedUsers.push(userId);
                }
            } else {
                const index = selectedUsers.indexOf(userId);
                if (index !== -1) {
                    selectedUsers.splice(index, 1);
                }
            }
        }

        function bulkRemoveRank() {
            if (confirm('Are you sure you want to remove the rank for selected users?')) {
                fetch('<?= base_url('controllerFaculty/bulkRemoveRank'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Ranks removed successfully!');
                        } else {
                            alert('Failed to remove ranks.');
                        }
                    });
            }
        }

        function bulkRemoveFaculty() {
            if (confirm('Are you sure you want to remove the faculty for selected users?')) {
                fetch('<?= base_url('controllerFaculty/bulkRemoveFaculty'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Faculties removed successfully!');
                        } else {
                            alert('Failed to remove faculties.');
                        }
                    });
            }
        }

        function bulkAssignRank() {
            const selectedRank = document.getElementById('bulk-rank').value;

            if (selectedRank && selectedUsers.length > 0) {
                fetch('<?= base_url('controllerFaculty/bulkAssignRank'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers, rank: selectedRank })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Ranks assigned successfully!');
                        } else {
                            alert('Failed to assign ranks.');
                        }
                    });
            } else {
                alert('Please select a rank and select at least one user.');
            }
        }

        function bulkAssignFaculty() {
            const selectedFaculty = document.getElementById('bulk-faculty').value;

            if (selectedFaculty && selectedUsers.length > 0) {
                fetch('<?= base_url('controllerFaculty/bulkAssignFaculty'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers, faculty: selectedFaculty })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Faculties assigned successfully!');
                        } else {
                            alert('Failed to assign faculties.');
                        }
                    });
            } else {
                alert('Please select a faculty and select at least one user.');
            }
        }

        function updateRank(userId, rank) {
            fetch('<?= base_url('controllerFaculty/updateRank'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ user_id: userId, rank: rank })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Rank updated successfully!');
                    } else {
                        alert('Failed to update rank.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateFaculty(userId, faculty) {
            fetch('<?= base_url('controllerFaculty/updateFaculty'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ user_id: userId, faculty: faculty })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Faculty updated successfully!');
                    } else {
                        alert('Failed to update faculty.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>