<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Choosing Everlasting Roofing Center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add a custom font from Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <style>
        body {
            background-color: #101010;
            font-family: 'Fancy-Font', cursive;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .message h1 {
            color: #662d91;
            font-size: 28px;
            font-family: 'Courier New', monospace;

        }

        .message p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn-custom {
            display: inline-block;
            background-color: #662d91;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            width: 200px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: transparent;
            color: #662d91;
        }

        #fblink {
            text-decoration: none;
            color: #800080;

        }

        #fblink:hover {
            text-decoration: underline;
            color: #800080;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">
            <h1>Thank You for Choosing Everlasting Roofing Center</h1>
            <a id="fblink" href="https://www.facebook.com/everlastingroofingcenter">"EVERLASTING ROOFING CENTER"</a>

            <p>Your purchase has been successfully completed. We appreciate your business.</p>

            <a href="<?php echo base_url('Home'); ?>" class="btn-custom">Okay</a>
        </div>
    </div>
    <script>

    </script>
</body>

</html>