<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet"
    href="<?php echo base_url('assets/css/authcommon.css?v=' . filemtime('assets/css/authcommon.css')); ?>">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <div class="auth-container" id="auth-container">
    <div class="form-container">
      <h2>Login</h2>
      <form id="login-form" method="post" action="<?= base_url('auth/viewlogin'); ?>">
        <div class="input-group">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="input-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>

    <div class="image-container">
      <img src="<?= base_url('/design/images/SPClogo.png') ?>" alt="Authentication Image">
    </div>
  </div>

  <script>
    <?php if ($this->session->flashdata('message')) { ?>
      Swal.fire({
        icon: 'error', // Use 'error' for rejection
        title: 'Rejected', // Title for rejection
        text: "<?= $this->session->flashdata('message'); ?>", // Display rejection message here
        timer: 3000,
        showConfirmButton: false
      });
    <?php } ?>

    <?php if (isset($error) && $error != '') { ?>
      Swal.fire({
        icon: 'warning',
        title: 'Warning',
        text: "<?= $error; ?>",
        timer: 3000,
        showConfirmButton: false
      });
    <?php } ?>
  </script>



</body>

</html>