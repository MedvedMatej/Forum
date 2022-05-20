<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL. "style-forum.css"?>">
    <title>Forum Registration</title>
</head>
<body>
<?php include("templates/header.php"); ?>

<div class="content">
    <div class="register-Form">
         <?php if (!empty($errorMessage)): ?>
            <p class="important" style="font-size:20px; margin-bottom:20px;"><?= $errorMessage ?></p>
        <?php endif; ?>
        <form action="<?= BASE_URL . "user/register" ?>" method="post">
        <div class="login-form-inner">
                <label>Username: <input type="text" name="username" autocomplete="off" 
                required autofocus /></label>
                <label>Password: <input type="password" name="password" required /></label>
            
            <button>Sign up</button>
            <p>
                Already have an account? <a href="<?= BASE_URL. "user/login" ?>">SIGN IN</a>
            </p>
            </div>
        </form>
    </div>
</div>

<?php include("templates/footer.php"); ?>
</body>
</html>