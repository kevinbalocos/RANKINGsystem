<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/authcommon.css?v=' . filemtime('assets/css/authcommon.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>

    <title>Register</title>
</head>

<body>

    <div class="auth-container" id="auth-container">
        <div class="form-container">
            <div id="register" class="auth-form">
                <h2>REGISTER</h2>
                <form method="post" action="<?php echo base_url('auth/register'); ?>">
                    <div class="input-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirm_password" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>
                    <div class="input-group">
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="input-group">
                        <input type="tel" name="phoneNo" class="form-control" placeholder="Phone Number" required>
                    </div>
                    <div class="input-group">
                        <select name="gender" class="form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="date" name="birth_date" class="form-control" placeholder="Birth Date" required>
                    </div>
                    <button class="bn5" type="submit">Register</button>
                </form>

                <div class="login-link">
                    Already Have an Account? <a class="bn5" id="login" href="<?php echo base_url('auth'); ?>">Login</a>
                </div>
            </div>
        </div>

        <div class="image-container">
            <img src="<?= base_url('/design/images/SPClogo.png') ?>" alt="Authentication Image">
        </div>
    </div>

   

</body>

</html>