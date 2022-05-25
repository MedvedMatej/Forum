<div class="header">
    <div class="start">
        <h1><a href="<?= BASE_URL?>">FORUM</a></h1>
    </div>
    <?php if ($_SERVER["PATH_INFO"] == "/forum"): ?>
        <div class="center">
            <div class="search">
                <input type="search" class="col-s-12 col-12" id="search" placeholder="Search...">
            </div>
        </div>
    <?php endif; ?>
    <?php if (!isset($_SESSION["user"])): ?>
        <div class="end">
            <a href="<?= BASE_URL. "user/login"?>">Login</a>
            <a href="<?= BASE_URL. "user/register"?>">Register</a>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION["user"])): ?>
        <div class="end">
            <a href="<?= BASE_URL. "user/logout"?>">Logout</a>
        </div>
    <?php endif; ?>
</div>
