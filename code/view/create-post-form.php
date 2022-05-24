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

    <div class="post-Form">
        <?php if (!empty($errorMessage)): ?>
            <p class="important"><?= $errorMessage ?></p>
        <?php endif; ?>
        <h2>Create Post</h2>
        <form action="<?= BASE_URL . "post/create" ?>" method="post" id="post-form" enctype="multipart/form-data">
            <div class="post-form-inner">
                <span>Select theme: <select name="tid" id="tselect" form="post-form"></select> <a href="<?= BASE_URL . "theme/create" ?>"><span id="create-button">Create new</span></a> </span>
                <input type="hidden" name="uid" value="<?= $_SESSION["id"] ?>">
                <input type="text" name="title" placeholder="Title..." required autofocus /> </br>
                <textarea name="text" cols="30" rows="10" placeholder="Text..." form="post-form"></textarea> </br>
                <input type="file" name="imgf" id="imgf" accept=".gif,.jpg,.jpeg,.png"/> </br>
                <input type="submit">
            </div>
        </form>
    </div>


</div>

<?php include("templates/footer.php"); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    $(document).ready(function () {
        $.get("<?= BASE_URL . "api/theme/get/" ?>",
            {query: ""},
            function (data) {
                $("#tselect").html("");
                for (el of data){
                    $("#tselect").append(
                        `<option value="`+el["tid"]+`">` + escapeHtml(el["name"])+ `</option>`
                    );
                }
        });
    });
    </script>
</body>
</html>