<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>

<body>
    <div class="container-fluid">
        <h1>ORDER LISTS</h1>

        <!-- Search Bar -->
        <div class="mb-3">
            <input type="text" class="form-control" id="searchInput" placeholder="Search for products">
        </div>

        <form method="post" action="<?php echo base_url('home/submitOrder'); ?>">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Add Order</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($products as $product): ?>
                        <?php if($product['availability'] == 'Active'): ?>
                            <tr class="product-row">
                                <td>
                                    <?php echo $product['product_name']; ?>
                                </td>
                                <td>₱
                                    <?php echo $product['price']; ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('home/addorder/'.$product['product_id']); ?>" class="btn">Add
                                        to Order</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

    <script>
        function filterProducts() {
            var searchInput = $('#searchInput').val().toLowerCase();
            $('.product-row').each(function () {
                var productName = $(this).find('td:first').text().toLowerCase();
                if (productName.indexOf(searchInput) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        $('#searchInput').on('input', function () {
            filterProducts();
        });
    </script>
</body>

</html>