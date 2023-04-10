<?php

require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';

$databse = new DB;
$movieAPI = new Movie;

$wishlist = $databse->get_user_wishlist($_SESSION['email']);

for ($i = 0; $i < sizeof($wishlist); $i++) {
    $wishlist[$i] = $movieAPI->get_by_id($wishlist[$i]);
}
?>

<ul class="movie-list">
    <?php foreach ($wishlist as $movie): ?>
        <li>
            <img src="<?php print $movie['img']; ?>" loading="lazy">
            <div>
                <h3>
                    <?php print $movie['title']; ?>
                </h3>
                <p>Released:
                    <?php print $movie['date']; ?>
                    </p? </div>
        </li>
    <?php endforeach; ?>
</ul>