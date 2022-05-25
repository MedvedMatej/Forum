<?php include("templates/SessionInit.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL."style-forum.css"?>">
    <title>Create post</title>
</head>
<body>
<?php include("templates/header.php"); ?>

<div class="content">

    <div class="theme-Form  col-s-8 col-7">
        <?php if (!empty($errorMessage)): ?>
            <p class="important" style="font-size:20px; margin-bottom:20px;"><?= $errorMessage ?></p>
        <?php endif; ?>
        <h2>Create Theme</h2>
        <form action="<?= BASE_URL . "theme/create" ?>" method="post" id="post-form">
        <div class="theme-form-inner">

            <input type="text" name="name" placeholder="Name..." required>
            <textarea name="desc" placeholder="Theme description..." cols="30" rows="10"></textarea>
            <button>Submit</button>
        </div>
    </form>
    </div>


</div>

<?php include("templates/footer.php"); ?>
</body>
</html>