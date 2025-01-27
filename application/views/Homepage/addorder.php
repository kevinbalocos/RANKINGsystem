<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD ORDER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
            color: #101010;
            font-family: 'math';
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .table th {
            background-color: #101010;
            color: #fff;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #ccc;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #101010;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>ADD ORDER</h1>

        <form method="post" action="<?php echo base_url('home/submitOrder'); ?>">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- LOOP THE SELECTED PRODUCT -->
                    <?php foreach ($selectedProducts as $product): ?>
                        <tr>
                            <td>
                                <?php echo $product['product_name']; ?>
                            </td>
                            <td>$
                                <?php echo $product['price']; ?>
                            </td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product['product_id']; ?>]" min="0"
                                    value="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn">Submit Order</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>