<html>

<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
    <div class="container">
        <!-- notification message -->
        <?php if (isset($mess)) : ?>
            <div class="error success" style="text-align: center;">
                <h3>
                    <?php
                    echo $mess;
                    ?>
                </h3>
            </div>
        <?php endif ?>
    </div>
</body>
</html>