<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User's Info</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  </style>
</head>

<body class="bg-gray-50">

  <!-- Header -->
  <header class="bg-white shadow px-6 py-3">
    <h1 class="text-2xl font-bold text-gray-800">User Info</h1>
  </header>

  <!-- Main Content -->
  <div class="main-container">
    <!-- Left Section -->
    <div class="left-section">


      <!-- User Info Table -->
      <div class="bg-white shadow-lg rounded-lg p-6 scrollable-container">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User ID</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Address</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone No</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gender</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Birth Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamically generated rows -->
            <?php if (isset($users) && is_array($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['id']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['username']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['email']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['address']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['phoneNo']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $user['gender']; ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <?php echo date("F j, Y", strtotime($user['birth_date'])); ?>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <!-- View Button with Icon -->
                    <button
                      onclick="openModal('<?php echo $user['id']; ?>', '<?php echo $user['username']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['address']; ?>', '<?php echo $user['phoneNo']; ?>', '<?php echo $user['gender']; ?>', '<?php echo $user['birth_date']; ?>')"
                      class="text-blue-400 hover:text-blue-500">
                      <i class="fas fa-eye"></i> <!-- Eye icon for View -->
                    </button>

                    <!-- Edit Button with Icon -->
                    <a href="javascript:void(0);" onclick="editUserInfo('<?php echo $user['id']; ?>')"
                      class="text-green-400 hover:text-green-500 ml-2">
                      <i class="fas fa-edit"></i> <!-- Pencil icon for Edit -->
                    </a>

                    <!-- Delete Button with Icon -->
                    <a href="javascript:void(0);"
                      onclick="confirmDelete('<?php echo base_url('conAdmin/deleteuserinfo/') . $user['id']; ?>')"
                      class="text-red-400 hover:text-red-500 ml-2">
                      <i class="fas fa-trash"></i> <!-- Trash icon for Delete -->
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No users found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Right Section -->
    <div class="right-section bg-white">
      <div id="editUserForm" class="mt-6"></div>
      <ul class="space-y-4 mt-4">
      </ul>
    </div>
  </div>


  <!-- Modal -->
  <div id="userModal" class="modal" style="display: none;">
    <div class="modal-content">
      <h2 class="text-xl font-bold mb-4">User Details</h2>
      <p><strong>User ID:</strong> <span id="modalUserId"></span></p>
      <p><strong>Username:</strong> <span id="modalUsername"></span></p>
      <p><strong>Email:</strong> <span id="modalEmail"></span></p>
      <p><strong>Address:</strong> <span id="modalAddress"></span></p>
      <p><strong>Phone Number:</strong> <span id="modalPhoneNo"></span></p>
      <p><strong>Gender:</strong> <span id="modalGender"></span></p>
      <p><strong>Birthday:</strong> <span id="modalBirthday"></span></p>
      <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow">Close</button>
    </div>
  </div>


  <script>


    function openModal(userId, username, email, address, phoneNo, gender, birthDate) {
      // Update modal content with user details
      document.getElementById('modalUserId').innerText = userId;
      document.getElementById('modalUsername').innerText = username;
      document.getElementById('modalEmail').innerText = email;
      document.getElementById('modalAddress').innerText = address;
      document.getElementById('modalPhoneNo').innerText = phoneNo;
      document.getElementById('modalGender').innerText = gender;
      document.getElementById('modalBirthday').innerText = birthDate;

      // Show the modal
      document.getElementById('userModal').style.display = 'flex';
    }

    function closeModal() {
      // Hide the modal
      document.getElementById('userModal').style.display = 'none';
    }

  </script>

  <script>
    function editUserInfo(userId) {
      // Fetch the edit form dynamically via AJAX
      fetch(`<?php echo base_url('conAdmin/edituserinfo/'); ?>${userId}`)
        .then(response => response.text())
        .then(data => {
          // Insert the form into the right section
          document.getElementById('editUserForm').innerHTML = data;
        })
        .catch(error => console.error('Error fetching edit form:', error));
    }
  </script>
  <script>
    function confirmDelete(deleteUrl) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          // Show success message before redirecting
          Swal.fire({
            title: 'Deleted!',
            text: 'User has been deleted successfully.',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            // Redirect after the success message
            window.location.href = deleteUrl;
          });
        }
      });
    }
  </script>

</body>

</html>