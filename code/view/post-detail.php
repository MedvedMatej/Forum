<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL. "style-forum.css"?>">
    <title>Post detail</title>
</head>
<body>
<div class="container">

    <?php include("templates/header.php"); ?>
    
    <div class="content">
        <div class="posts">
            <div class="card">
                <p>Published by <b><?=$post["username"]?></b> at <?= $post["date"] ?></p>
                <h2><?=$post["title"]?></h2>
                <p><?=$post["text"]?></p>
                <?php if (!is_null($post["image"])) echo '<img src="'.IMAGES_URL.$post["image"].'">' ?>
                
                <?php if (isset($_SESSION["user"])): ?>
                    <div class="comments">
                        
                        <div class="card-comment">
                            <form action="<?= BASE_URL . "comment/create" ?>" method="post" id="comment-form">
                                <div class="comment-form-inner">
                                    <input type="hidden" name="uid" value="<?= $_SESSION["id"] ?>">
                                    <input type="hidden" name="pid" value="<?= $post["pid"] ?>">
                                    <input type="hidden" name="fid" value="-1">
                                    <input type="text" name="comment" placeholder="Comment..." required/>
                                    <button>Post comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="comments" id="comments">
                    <!-- LOAD FROM DATABASE -->
                    No comments yet...
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("templates/footer.php"); ?>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {
    $.get("<?= BASE_URL . "api/comment/get/" ?>",
        {query: "<?= $post["pid"] ?>"},
        function (data) {
            if(data.length == 0) return;
            $("#comments").html("");
            for (el of data){
                let form = "";
                if (<?php if (isset($_SESSION["id"])) echo 1; else{ echo 0;}?> ==1){
                    form = `
                    <form style="" action="<?= BASE_URL . "comment/create" ?>" method="post" id="comment-form">
                        <div class="comment-form-inner">
                            <input type="hidden" name="uid" value="<?php if (isset($_SESSION["id"])) echo $_SESSION["id"]?>">
                            <input type="hidden" name="pid" value="<?= $post["pid"] ?>">
                            <input type="hidden" name="fid" value="`+el["cid"]+`">
                            <input type="text" name="comment" placeholder="Comment..." required/>
                            <button>Post comment</button>
                        </div>
                    </form>`;
                }
                                    
                if(el["fid"] != null){
                    $("#c-" + el["fid"]).append(
                        `<div class="card-comment-child" id="c-`+el["cid"]+`">
                                <p><b>` + el["username"]+ `</b> at ` + el["date"] +`</p>
                                <p>` + el["text"] + `</p>
                                `+form+`
                        </div>`
                    );
                }
                else{
                    $("#comments").append(
                        `<div class="card-comment" id="c-`+el["cid"]+`">
                                <p><b>` + el["username"]+ `</b> at ` + el["date"] +`</p>
                                <p>` + el["text"] + `</p>
                                `+form+`
                        </div>`
                    );
                }
            }
    });
});
</script>
</body>
</html>