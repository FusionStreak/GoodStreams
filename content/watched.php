<?php

require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';

$databse = new DB;
$movieAPI = new Movie;

$reviewed = $databse->get_user_reviews($_SESSION['email']);

for ($i = 0; $i < sizeof($reviewed); $i++) {
    $reviewed[$i][1] = $movieAPI->get_by_id($reviewed[$i][1]);
    $reviewed[$i][4] = explode('-', $reviewed[$i][4]);
    $reviewed[$i][4] = ['year' => $reviewed[$i][4][0], 'month' => $reviewed[$i][4][1], 'day' => $reviewed[$i][4][2]];
    $reviewed[$i][4] = gen_date($reviewed[$i][4]);
}
?>

<ul class="movie-list">
    <?php foreach ($reviewed as $movie): ?>
        <li>
            <img src="<?php print $movie[1]['img']; ?>" loading="lazy">
            <div>
                <h3>
                    <?php print $movie[1]['title']; ?>
                </h3>
                <h4>Released:
                    <?php print $movie[1]['date']; ?>
                </h4>
                <h4>Reviewed:
                    <?php print $movie[4]; ?>
                </h4>
                <h4>Rating:
                    <?php print $movie[2]; ?>
                </h4>
                <p style="grid-area: Review; text-align: left;">
                    <?php print $movie[3]; ?>
                </p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>