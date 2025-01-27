<!DOCTYPE html>
<html lang="en">

<head>
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
      height: 88%;
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
      padding: 15px;
      background-color: #111;
      color: #fff;
      border: none;
      outline: none;
      /* Added outline */
      border-radius: 5px;
      cursor: pointer;
      position: relative;
      z-index: 0;
      align-items: center;
      justify-content: center;
      width: 40%;
      text-decoration: none;
      text-align: center;
      margin-top: 10px;
    }

    button:before {
      content: "";
      background: linear-gradient(45deg,
          #DDA0DD,
          #800080,
          #33006F,
          #DDA0DD,
          #E6E6FA,
          #DDA0DD,
          #7a00ff,
          #1d1160,
          #33006F);
      position: absolute;
      top: -2px;
      left: -2px;
      background-size: 400%;
      z-index: -1;
      filter: blur(5px);
      width: calc(100% + 4px);
      height: calc(100% + 4px);
      animation: glowingbn5 20s linear infinite;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
      border-radius: 5px;
    }

    @keyframes glowingbn5 {
      0% {
        background-position: 0 0;
      }

      50% {
        background-position: 400% 0;
      }

      100% {
        background-position: 0 0;
      }
    }

    button:active {
      color: #000;
    }

    button:active:after {
      background: transparent;
    }

    button:hover {
      color: white;
    }

    button:hover:before {
      opacity: 1;
    }

    button:after {
      z-index: -1;
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      background: #191919;
      left: 0;
      top: 0;
      border-radius: 5px;
    }

    body.dark {
      --body-color: #18191A;
      --sidebar-color: #242526;
      --primary-color: #ccc;
      --primary-color-light: #3A3B3C;
      --toggle-color: #FFF;
      --text-color: #CCC;
    }
  </style>
</head>

<body>
  <div class="container">
    <form method="post" action="<?php echo base_url('conAdmin/updateProduct/' . $product['product_id']); ?>">
      <h2>Edit Product</h2>
      <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>
      <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
      <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

      <label for="availability">Availability</label>
      <select name="availability" required>
        <option value="Active" <?php echo ($product['availability'] === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($product['availability'] === 'Inactive') ? 'selected' : ''; ?>>Inactive
        </option>
      </select>
      <button type="submit">Update</button>
    </form>
  </div>
  <script>
    document.addEventListener('keydown', (e) => {
      if (e.altKey && e.key === '1') {
        document.body.classList.toggle('dark');
      }
    });
  </script>
</body>

</html>