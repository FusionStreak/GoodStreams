<nav>
    <div id="sideNav" class="side-nav">
        <li><a href='?page=home'>Home</a></li>
        <?php if (!$_SESSION['token']) : ?>
            <li><a href='?page=login'>Login</a></li>
        <?php else : ?>
            <li><a href='?page=watched'>Already Watched</a></li>
            <li><a href='?page=wanttowatch'>Want to Watch</a></li>
        <?php endif ?>
    </div>
</nav>