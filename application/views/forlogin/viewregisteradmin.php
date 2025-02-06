<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h2>Admin Registration</h2>

    <form id="adminRegisterForm">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit">Register</button>
    </form>

    <script>
        $("#adminRegisterForm").submit(function (e) {
            e.preventDefault();
            $.post("<?php echo base_url('auth/register_admin'); ?>", $(this).serialize(), function (response) {
                alert(response.message);
            }, "json");
        });
    </script>

</body>

</html>