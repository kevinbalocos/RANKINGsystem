<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User Information</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .edituserborder {
      border-radius: 5px;
      border: 1px solid #e5e7eb;
      /* Default border (gray) */
      background-color: #f9f9f9;
      transition: border-color 0.3s, background-color 0.3s;
      width: 200px;
    }

    .edituserborder:focus {
      border-color: #66cdaa;
      /* Green border on focus */
      outline: none;
      /* Remove default outline */
      background-color: #ffffff;
      /* Optional: Change background color to white */
    }

    .edituserborder:hover {
      border-color: #a5d6a7;
      /* Light green border on hover */
    }

    .container {
      background-color: white;
      /* Light blue background */
    }
  </style>
</head>

<body>

  <?php if (isset($user) && is_array($user)): ?>
    <div class=".darkmode mx-auto p-8 rounded-lg shadow-lg mt-10">
      <h1 class="text-white-400 text-left text-lg font-bold hover:text-red-400 uppercase tracking-wider text-center">
        EDIT
      </h1>
      <form action="<?php echo base_url('conAdmin/updateuserinfo/' . $user['id']); ?>" method="post">
        <!-- Username -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required
          class="darkmode_text edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">

        <!-- Email -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required
          class="darkmode_text edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">

        <!-- Address -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Address</label>
        <input type="text" name="address" value="<?php echo $user['address']; ?>" required
          class="darkmode_text edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">

        <!-- Phone Number -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Phone
          Number</label>
        <input type="tel" name="phoneNo" value="<?php echo $user['phoneNo']; ?>" required
          class="darkmode_text edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">

        <!-- Gender -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Gender</label>
        <select name="gender" required class="edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">
          <option value="male" <?php echo ($user['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
          <option value="female" <?php echo ($user['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
        </select>

        <!-- Birth Date -->
        <label for=""
          class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Birth
          Date</label>
        <input type="date" name="birth_date" value="<?php echo $user['birth_date']; ?>" required
          class="edituserborder block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800">

        <!-- Submit Button -->
        <button type="submit"
          class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn">Update</button>
      </form>
    </div>
  <?php endif; ?>

</body>

</html>