<?php

require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';

$database = new DB;
$movieAPI = new Movie;

$movie = $movieAPI->get_by_id($_GET['movie']);

?>
<h2>
    <?php print $movie['title']; ?>
</h2>
<img src="<?php print $movie['img']; ?>" style='margin:auto;'>
<p>Release date:
    <?php print $movie['date']; ?>
</p>
<h4>Cast:</h4>
<ul>
    <?php foreach ($movie['cast'] as $cast): ?>
        <li>
            <?php print $cast; ?>
        </li>
    <?php endforeach; ?>
</ul>