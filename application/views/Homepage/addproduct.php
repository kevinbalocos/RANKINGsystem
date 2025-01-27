<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        :root {
            /* -----COLORS------ */
            --body-color: #E4E9f7;
            --sidebar-color: #FFF;
            --primary-color: #695CFE;
            --primary-color-light: #F6F5FF;
            --toggle-color: #DDD;
            --text-color: #707070;

            /*T ----TRANSITIONS----*/
            --tran-02: all 0.2s ease;
            --tran-03: all 0.3s ease;
            --tran-04: all 0.4s ease;
            --tran-05: all 0.5s ease;
        }

        body {
            height: 10vh;
            background: var(--body-color);
            transition: var(--tran-05);
            color: var(--text-color);
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: var(--sidebar-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: var(--tran-03);
            width: 470px;
            height: 90%;
            max-height: 500px;
        }

        h2 {
            color: var(--primary-color);
        }

        label {
            color: var(--primary-color);
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid var(--toggle-color);
            border-radius: 5px;
            background-color: var(--primary-color-light);
            color: var(--text-color);
        }

        button {
            padding: 10px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--tran-02);
        }

        button:hover {
            background-color: black;
        }

        body.dark {
            --body-color: #18191A;
            --sidebar-color: #242526;
            --primary-color: #ccc;
            --primary-color-light: #3A3B3C;
            --toggle-color: #FFF;
            --text-color: white;
        }
    </style>
</head>

<body>

    <form method="post" action="<?php echo base_url('conAdmin/saveproduct'); ?>" enctype="multipart/form-data">
        <h2>Add Product</h2>

        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" class="form-control" required>

        <label for="price">Price:</label>
        <input type="number" name="price" class="form-control" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" class="form-control" required>

        <label for="product_image">Product Image:</label>
        <input type="file" name="product_image" class="form-control" accept="image/*" required>

        <label for="availability">Availability:</label>
        <select name="availability" class="form-select" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>

        <div class="container">
            <div class="row">
                <button type="submit" class="btn btn-primary m-3">Add Product</button>
            </div>
        </div>
    </form>

    <script>
        // Toggle dark mode with Alt + 1
        const body = document.body;
        document.addEventListener('keydown', (e) => {
            if (e.altKey && e.key === '1') {
                body.classList.toggle('dark');
            }
        });
    </script>
</body>

</html>