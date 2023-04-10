<nav>
    <div id="sideNav" class="side-nav">
        <li><a href='?page=results'>Home</a></li>
        <?php if (!isset($_SESSION['token'])): ?>
            <li><a href='?page=login'>Login</a></li>
        <?php else: ?>
            <li><a href='?page=watched'>Already Watched</a></li>
            <li><a href='?page=wanttowatch'>Want to Watch</a></li>
            <li><a href='?page=login&logout=true'>Logout</a>
            <?php endif ?>
    </div>
</nav>