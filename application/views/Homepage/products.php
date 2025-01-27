<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
            font-family: math;
        }

        .container-fluid {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
        }

        .container-fluid.modal-open {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #695CFE;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ccc;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #662d91;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
        }

        #addproduct {
            padding: 3px 2px;
            border-radius: 75px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;


        }

        #addproduct:hover {
            background-color: #1d1160;
            border-radius: 75px;
            padding: 3px 2px;

        }

        #editbtn {
            background-color: #FEBE10;
        }

        #editbtn:hover {
            background-color: #F0E68C;
        }

        #deletebtn {
            background-color: #BA0021;
        }

        #deletebtn:hover {
            background-color: #660000;
        }

        .product-css {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <table>
            <h1>Products</h1>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Availability</th>
                    <th>
                        <a href="javascript:void(0);" id="addproduct" onclick="openModal()">ADD PRODUCT</a>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                    <tr>
                        <td>
                            <?php echo $product['product_id']; ?>
                        </td>
                        <td>
                            <?php echo $product['product_name']; ?>
                        </td>
                        <td>
                            <?php echo $product['price']; ?>
                        </td>
                        <td>
                            <?php echo $product['stock']; ?>
                        </td>
                        <td>
                            <?php echo $product['availability']; ?>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="openEditModal(<?php echo $product['product_id']; ?>)"
                                id="editbtn" class="btn">Edit</a>

                            <a onclick="deleter()"
                                href="<?php echo base_url('conAdmin/deleteProduct/').$product['product_id']; ?>"
                                id="deletebtn" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <iframe id="modalFrame" src="<?php echo base_url('conAdmin/addproduct'); ?>"
                    class="modal-frame"></iframe>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <iframe id="editModalFrame" src="" class="modal-frame"></iframe>
        </div>
    </div>

    <head>
        <style>
            //! ADD PRODUCT MODAL
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.7);
            }

            .modal-content {
                background-color: var(--sidebar-color);
                margin: 10% auto;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                transition: var(--tran-03);
                width: 40%;
                max-width: 800px;
                height: 70%;
            }

            .close {
                color: var(--primary-color);
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: var(--text-color);
                text-decoration: none;
                cursor: pointer;
            }

            .modal-frame {
                width: 100%;
                height: 100%;
                border: none;
            }

            #editModal {
                display: none;
            }

            #editModal .modal-content {}
        </style>
    </head>

    <script>
        //! ADD PRODUCT MODAL
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
            document.getElementById('modalFrame').contentWindow.location.reload();
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        //! EDIT PRODUCT MODAL
        function openEditModal(product_id) {
            document.getElementById('editModal').style.display = 'block';
            var editModalFrame = document.getElementById('editModalFrame');
            editModalFrame.src = "<?php echo base_url('conAdmin/editProduct/'); ?>" + product_id;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            var editModalFrame = document.getElementById('editModalFrame');
        }
    </script>


    <script>




        function checker() {
            var result = confirm('Are you sure na gusto mo kong iwan?');
            if (result == false) {
                event.preventDefault();
            }
        }
        function deleter() {
            var result = confirm('Are you sure you want to delete this product?');
            if (result == false) {
                event.preventDefault();
            }
        }
    </script>
</body>

</html>