<nav>
    <div id="genres-nav">
        <li><a href='?page=results&method=top'>Top 50</a></li>
        <?php
        $genres = ['Action', 'Adventure', 'Animation', 'Comedy', 'Documentary', 'Fantasy', 'History', 'Horror', 'Musical', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller', 'War'];

        foreach ($genres as $genre): ?>
            <li><a href='?page=results&method=genre&genre=<?php print $genre; ?>' class='<?php if (isset($_GET['genre'])) {
                   print $_GET['genre'] == $genre ? 'selected' : '';
               } ?>'><?php print $genre; ?></a></li>
        <?php endforeach; ?>
    </div>
</nav>