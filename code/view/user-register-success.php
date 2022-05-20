<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL. "style-forum.css"?>">
    <title>Forum Registration Successful</title>
</head>
<body>
<?php include("templates/header.php"); ?>

<div class="content">
    <p style="margin:auto;font-size:20px;">
        Your account has been created successfully. Continue to <a href="<?= BASE_URL."user/login"?>">login</a>.
    </p>
</div>

<?php include("templates/footer.php"); ?>
</body>
</html>