<nav>
    <div id="genres-nav">
        <li><a href='?page=top'>Top 50</a></li>
        <?php
        $genres = ['Action', 'Adventure', 'Animation', 'Comedy', 'Documentary', 'Fantasy', 'History', 'Horror', 'Musical', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller', 'War'];

        foreach ($genres as $genre) {
            print("<li><a href='?page=genre&genre=" . $genre . "'>" . $genre . "</a></li>");
        }
        ?>
    </div>
</nav>