<?php include("templates/SessionInit.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL."style-forum.css"?>">
    <title>Forum</title>
</head>
<body>
    <div class="container">

        <?php include("templates/header.php"); ?>
        
        <div class="content">
            
            <?php if (isset($_SESSION["user"])): ?>
                <div class="addPost">
                    <input type="text" placeholder="Create post...">
                </div>
                <?php endif; ?>
                
                <div class="sort" style="display:none">
                    <div class="likes">TOP</div>
                    <div class="date">NEW</div>
                    <div class="ascending">ASCENDING</div>
                </div>
                
                <!-- LOAD FROM DATABASE -->
                <div class="posts col-s-8 col-7"></div>
        </div>
                
        <?php include("templates/footer.php"); ?>
    </div>

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
        $(".addPost").click(function(){
            window.location.href='<?= BASE_URL . "post/create"?>';
        });

        $.get("<?= BASE_URL . "api/post/search/" ?>",
            {query: $("#search").val()},
            function (data) {
              
                $(".posts").html("");
                for (el of data){
                    $(".posts").append(
                        `<div class="card">
                            <a href="<?= BASE_URL?>post?id=`+el["pid"]+`">
                                <p>Posted by <b>` + escapeHtml(el["username"]) +`</b> at `+el["date"]+` </p>
                                <h2>` + escapeHtml(el["title"]) + `</h2>
                                <p>` + escapeHtml(el["text"]) + `</p>
                                ` + ((el["image"] == null) ? `` : `<img src="<?= IMAGES_URL?>`+el["image"]+`">`) + `
                            </a>
                        </div>`
                    );
                }
        });


        $("#search").keyup(function(){
            $.get("<?= BASE_URL . "api/post/search/" ?>",
            {query: $("#search").val()},
            function (data) {
                
                $(".posts").html("");
                for (el of data){
                    $(".posts").append(
                        `<div class="card">
                            <a href="<?= BASE_URL?>post?id=`+el["pid"]+`">
                                <p>` + escapeHtml(el["username"]) +`</p>
                                <h2>` + escapeHtml(el["title"]) + `</h2>
                                <p>` + escapeHtml(el["text"]) + `</p>
                                ` + ((el["image"] == null) ? `` : `<img src="<?= IMAGES_URL?>`+el["image"]+`">`) + `
                            </a>
                        </div>`
                    );
                }
            });
        });
    });
    </script>
</body>
</html>
