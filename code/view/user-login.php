<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL. "style-forum.css"?>">
    <title>Forum Login</title>
</head>
<body>
<?php include("templates/header.php"); ?>

<div class="content">
    <div class="login-Form col-s-7 col-4">
        <?php if (!empty($errorMessage)): ?>
            <p class="important" style="font-size:20px; margin-bottom:20px;"><?= $errorMessage ?></p>
        <?php endif; ?>
        <form action="<?= BASE_URL . "user/login" ?>" method="post">
            <div class="login-form-inner">
                <label>Username: <input type="text" name="username" autocomplete="off" required autofocus /></label>
                <label>Password: <input type="password" name="password" required /></label>
                <button>Login</button>
                <p>New to Forum? <a href="<?= BASE_URL. "user/register" ?>">SIGN UP</a></p>
            </div>
        </form>
    </div>
    
</div>

<?php include("templates/footer.php"); ?>
</body>
</html>