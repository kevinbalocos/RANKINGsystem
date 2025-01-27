<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>

    <style>
        #content-container {
            margin: 10 auto;
            margin-top: 30px;
            max-height: 1200px;
        }

        .card {
            width: 100%;
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-family: math;
            color: #1d1160;
        }

        .bn5 {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            padding-bottom: 10px;
            border: none;
            outline: none;
            color: rgb(255, 255, 255);
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
            width: 40%;
            text-decoration: none;
            text-align: center;
            margin: 1%;
        }

        .bn5:before {
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

        .bn5:active {
            color: #000;
        }

        .bn5:active:after {
            background: transparent;
        }

        .bn5:hover {
            color: white;
        }

        .bn5:hover:before {
            opacity: 1;
        }

        .bn5:after {
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

        /* Modal styles */
        .modal-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80vw;
            height: 80vw;
            max-width: 600px;
            max-height: 600px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            overflow: auto;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #555;
        }

        .modal-close:hover {
            color: #000;
        }
    </style>

</head>

<body>





    <script>
        function openModal(productId) {
            var modal = document.getElementById('modal' + productId);
            modal.style.display = 'block';
        }

        function closeModal(productId) {
            var modal = document.getElementById('modal' + productId);
            modal.style.display = 'none';
        }
    </script>

</body>

</html>