<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'math';
            background-color: #101010;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            text-align: center;
        }

        h2 {
            background-color: #33006F;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 0;
        }

        table {
            width: 100%;
        }

        th,
        td {
            text-align: center;
        }

        td {
            background-color: #ecf0f1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>USER INFORMATION</h2>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $user['id']; ?>
                    </td>
                    <td>
                        <?php echo $user['username']; ?>
                    </td>
                    <td>
                        <?php echo $user['email']; ?>
                    </td>
                    <td>
                        <?php echo $user['address']; ?>
                    </td>
                    <td>
                        <?php echo $user['phoneNo']; ?>
                    </td>
                    <td>
                        <?php echo $user['gender']; ?>
                    </td>
                    <td>
                        <?php echo $user['birth_date']; ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-X48Ez8HByfB5a9pvTkv85QDY4H3tEQlJRO6ZnuQbL8EZbYYUq7ZSvboflzG4fD5L"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>