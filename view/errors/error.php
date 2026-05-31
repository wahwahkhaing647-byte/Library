<?php $code = http_response_code(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Error <?= $code ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
            border-top: 5px solid #e74c3c;
        }

        .error-code {
            font-size: 50px;
            font-weight: bold;
            color: #e74c3c;
        }

        .error-title {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }

        .error-message {
            margin-top: 10px;
            color: #666;
            font-size: 14px;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 15px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>

<div class="error-box">

    <div class="error-code">
        <?= $code ?>
    </div>

    <div class="error-title">
        <?php if ($code == 404): ?>
            Page Not Found
        <?php else: ?>
            Something Went Wrong
        <?php endif; ?>
    </div>

    <div class="error-message">
        <?php if ($code == 404): ?>
            The page you are looking for does not exist or has been moved.
        <?php else: ?>
            An unexpected error occurred. Please try again later.
        <?php endif; ?>
    </div>

    <a class="btn" href="<?= BASE_URL ?>/Public/index.php?page=home">
        Go Home
    </a>

</div>

</body>
</html>