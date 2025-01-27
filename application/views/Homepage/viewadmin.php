<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/authcommon.css?v=' . filemtime('assets/css/authcommon.css')); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Add SweetAlert2 -->
</head>

<body>
    <div class="auth-container" id="auth-container">
        <div class="form-container">
            <h2>ADMIN LOGIN</h2>
            <div id="adminlogin" class="auth-form">
                <form method="post" action="<?php echo base_url('Auth/adminlogin'); ?>">
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <button type="submit" class="bn5">Login</button>
                        <a href="<?php echo base_url('Auth/'); ?>" id="loginuser" class="bn5">Login as User</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="image-container">
            <img src="<?= base_url('/design/images/SPClogo.png') ?>" alt="Authentication Image">
        </div>
    </div>

    <!-- SweetAlert2 for error -->
    <script>
        <?php if (isset($error)): ?>
            Swal.fire({
                title: 'Login Failed',
                text: "<?= $error ?>",
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
        <?php endif; ?>
    </script>
</body>

</html>